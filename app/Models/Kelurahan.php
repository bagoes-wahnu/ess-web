<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use DataTables;
use App\Http\Resources\KelurahanResource;
use Wildside\Userstamps\Userstamps;

class Kelurahan extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('isActive', function (Builder $builder) {
            $builder->where('status', true);
        });

        static::addGlobalScope('checkRelationIsActive', function (Builder $builder) {
            $builder->where(function($query) {
                $query->whereHas('kecamatan', function($query) {
                    $query->where('status', true);
                });
            });
        });
    }
    
    protected $table = 'm_kelurahan';

    protected $fillable = [
        'nama', 'id_kecamatan', 'id_ssw', 'id_ssw_provinsi', 'id_ssw_kabupaten', 'id_ssw_kecamatan', 'id_arsip', 'status', 'created_by', 'updated_by', 'deleted_by',
    ];

    protected $softCascade = ['permohonan'];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id');
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'm_user_kelurahan', 'id_kelurahan', 'id_user')->where('status', true);
    }

    public function permohonan()
    {
        return $this->hasMany(Permohonan::class, 'id_kelurahan', 'id');
    }

    public static function get_data($type = 'list', $params = null)
    {
        $kelurahan = Kelurahan::withoutGlobalScope('isActive');
        
        if(isset($params->id_kecamatan)) 
        {
            $kelurahan = $kelurahan->whereHas('kecamatan', function ($query) use ($params) {
                if(is_array($params->id_kecamatan) && !empty($params->id_kecamatan))
                {
                    $query->whereIn('id', $params->id_kecamatan);
                }
                elseif(!is_array($params->id_kecamatan))
                {
                    $query->where('id', $params->id_kecamatan);
                }
            });
        }

        if($type == 'datatables')
        {
            return DataTables::eloquent($kelurahan)->toJson();
        }
        else
        {
            $search_field = 'nama';
            $order_field = 'updated_at';
            $order_sort = 'desc';

            if(isset($params->relation)) $kelurahan = $kelurahan->with($params->relation);

            if(isset($params->search_field)) $search_field = $params->search_field;

            if(isset($params->order_field)) $order_field = $params->order_field;

            if(isset($params->order_sort)) $order_sort = $params->order_sort;

            if(isset($params->status)) $kelurahan = $kelurahan->where('status', $params->status);

            if(isset($params->search_value)) $kelurahan = $kelurahan->where($search_field, 'ilike', '%' . $params->search_value . '%');

            // if(isset($params->page) && isset($params->per_page)) $kelurahan = $kelurahan->skip(($params->page - 1) * $params->per_page)->take($params->per_page);

            $kelurahan = $kelurahan->orderBy($order_field, $order_sort);

            return KelurahanResource::collection($kelurahan->get());
        }
    }
}
