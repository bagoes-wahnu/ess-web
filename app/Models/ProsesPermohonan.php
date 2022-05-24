<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use DataTables;
use App\Http\Resources\ProsesPermohonanResource;
use Wildside\Userstamps\Userstamps;

class ProsesPermohonan extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('isActive', function (Builder $builder) {
            $builder->where('status', true);
        });
    }

    protected $table = 'm_proses_permohonan';

    protected $fillable = [
        'nama', 'batas_waktu', 'jenis', 'status', 'created_by', 'updated_by', 'deleted_by',
    ];

    protected $softCascade = ['permohonan_histori_penyelesaian'];

    public function permohonan_histori_penyelesaian()
    {
        return $this->hasMany(PermohonanHistoriPenyelesaian::class, 'id_proses_permohonan', 'id');
    }

    public static function get_data($type = 'list', $params = null)
    {
        $prosesPermohonan = ProsesPermohonan::withoutGlobalScope('isActive');

        if(isset($params->jenis)) 
        {
            $prosesPermohonan = $prosesPermohonan->where('jenis', $params->jenis);
        }

        if($type == 'datatables')
        {
            return DataTables::eloquent($prosesPermohonan)->toJson();
        }
        else
        {
            $search_field = 'nama';
            $order_field = 'updated_at';
            $order_sort = 'desc';

            if(isset($params->relation)) $prosesPermohonan = $prosesPermohonan->with($params->relation);

            if(isset($params->search_field)) $search_field = $params->search_field;

            if(isset($params->order_field)) $order_field = $params->order_field;

            if(isset($params->order_sort)) $order_sort = $params->order_sort;

            if(isset($params->status)) $prosesPermohonan = $prosesPermohonan->where('status', $params->status);

            if(isset($params->search_value)) $prosesPermohonan = $prosesPermohonan->where($search_field, 'ilike', '%' . $params->search_value . '%');

            // if(isset($params->page) && isset($params->per_page)) $prosesPermohonan = $prosesPermohonan->skip(($params->page - 1) * $params->per_page)->take($params->per_page);

            $prosesPermohonan = $prosesPermohonan->orderBy($order_field, $order_sort);

            return ProsesPermohonanResource::collection($prosesPermohonan->get());
        }
    }
}
