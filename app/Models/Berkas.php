<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use DataTables;
use App\Http\Resources\BerkasResource;
use Wildside\Userstamps\Userstamps;

class Berkas extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('isActive', function (Builder $builder) {
            $builder->where('status', true);
        });
    }
    
    protected $table = 'm_berkas';

    protected $fillable = [
        'nama', 'urutan', 'id_ssw', 'id_arsip', 'is_bast_admin', 'is_bast_fisik', 'status', 'created_by', 'updated_by', 'deleted_by',
    ];

    protected $softCascade = ['permohonan_persyaratan_file'];

    public function permohonan_persyaratan_file()
    {
        return $this->hasMany(PermohonanPersyaratanFile::class, 'id_berkas', 'id');
    }

    public static function get_data($type = 'list', $params = null)
    {
        $berkas = Berkas::withoutGlobalScope('isActive');

        if($type == 'datatables')
        {
            return DataTables::eloquent($berkas)->toJson();
        }
        else
        {
            $search_field = 'nama';
            $order_field = 'updated_at';
            $order_sort = 'desc';

            if(isset($params->relation)) $berkas = $berkas->with($params->relation);

            if(isset($params->search_field)) $search_field = $params->search_field;

            if(isset($params->order_field)) $order_field = $params->order_field;

            if(isset($params->order_sort)) $order_sort = $params->order_sort;

            if(isset($params->status)) $berkas = $berkas->where('status', $params->status);

            if(isset($params->search_value)) $berkas = $berkas->where($search_field, 'ilike', '%' . $params->search_value . '%');

            // if(isset($params->page) && isset($params->per_page)) $berkas = $berkas->skip(($params->page - 1) * $params->per_page)->take($params->per_page);

            $berkas = $berkas->orderBy($order_field, $order_sort);

            return BerkasResource::collection($berkas->get());
        }
    }
}
