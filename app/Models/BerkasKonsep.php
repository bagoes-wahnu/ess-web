<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use DataTables;
use App\Http\Resources\BerkasKonsepResource;
use Wildside\Userstamps\Userstamps;

class BerkasKonsep extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('isActive', function (Builder $builder) {
            $builder->where('status', true);
        });
    }
    
    protected $table = 'm_berkas_konsep';

    protected $fillable = [
        'nama', 'is_bast_admin', 'is_bast_fisik', 'status', 'created_by', 'updated_by', 'deleted_by',
    ];

    protected $softCascade = ['permohonan_konsep_file', 'permohonan_konsep_timeline', 'permohonan_koreksi_konsep_detail'];

    public function permohonan_konsep_file()
    {
        return $this->hasMany(PermohonanKonsepFile::class, 'id_berkas_konsep', 'id');
    }

    public function permohonan_konsep_timeline()
    {
        return $this->hasMany(PermohonanKonsepTimeline::class, 'id_berkas_konsep', 'id');
    }

    public function permohonan_koreksi_konsep_detail()
    {
        return $this->hasMany(PermohonanKoreksiKonsepDetail::class, 'id_berkas_konsep', 'id');
    }

    public static function get_data($type = 'list', $params = null)
    {
        $berkasKonsep = BerkasKonsep::withoutGlobalScope('isActive');

        if($type == 'datatables')
        {
            return DataTables::eloquent($berkasKonsep)->toJson();
        }
        else
        {
            $search_field = 'nama';
            $order_field = 'updated_at';
            $order_sort = 'desc';

            if(isset($params->relation)) $berkasKonsep = $berkasKonsep->with($params->relation);

            if(isset($params->search_field)) $search_field = $params->search_field;

            if(isset($params->order_field)) $order_field = $params->order_field;

            if(isset($params->order_sort)) $order_sort = $params->order_sort;

            if(isset($params->status)) $berkasKonsep = $berkasKonsep->where('status', $params->status);

            if(isset($params->search_value)) $berkasKonsep = $berkasKonsep->where($search_field, 'ilike', '%' . $params->search_value . '%');

            // if(isset($params->page) && isset($params->per_page)) $berkasKonsep = $berkasKonsep->skip(($params->page - 1) * $params->per_page)->take($params->per_page);

            $berkasKonsep = $berkasKonsep->orderBy($order_field, $order_sort);

            return BerkasKonsepResource::collection($berkasKonsep->get());
        }
    }
}
