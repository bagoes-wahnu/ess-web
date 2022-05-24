<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use DataTables;
use App\Http\Resources\KecamatanResource;
use Wildside\Userstamps\Userstamps;

class Kecamatan extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('isActive', function (Builder $builder) {
            $builder->where('status', true);
        });
    }
    
    protected $table = 'm_kecamatan';

    protected $fillable = [
        'nama', 'id_ssw', 'id_ssw_provinsi', 'id_ssw_kabupaten', 'id_arsip', 'status', 'created_by', 'updated_by', 'deleted_by',
    ];

    protected $softCascade = ['kelurahan', 'permohonan'];

    public function kelurahan()
    {
        return $this->hasMany(Kelurahan::class, 'id_kecamatan', 'id')->where('status', true);
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'm_user_kecamatan', 'id_kecamatan', 'id_user')->where('status', true);
    }

    public function permohonan()
    {
        return $this->hasMany(Permohonan::class, 'id_kecamatan', 'id');
    }

    public static function get_data($type = 'list', $params = null)
    {
        $kecamatan = Kecamatan::withoutGlobalScope('isActive');

        if($type == 'datatables')
        {
            return DataTables::eloquent($kecamatan)->toJson();
        }
        else
        {
            $search_field = 'nama';
            $order_field = 'updated_at';
            $order_sort = 'desc';

            if(isset($params->relation)) $kecamatan = $kecamatan->with($params->relation);

            if(isset($params->search_field)) $search_field = $params->search_field;

            if(isset($params->order_field)) $order_field = $params->order_field;

            if(isset($params->order_sort)) $order_sort = $params->order_sort;

            if(isset($params->status)) $kecamatan = $kecamatan->where('status', $params->status);

            if(isset($params->search_value)) $kecamatan = $kecamatan->where($search_field, 'ilike', '%' . $params->search_value . '%');

            // if(isset($params->page) && isset($params->per_page)) $kecamatan = $kecamatan->skip(($params->page - 1) * $params->per_page)->take($params->per_page);

            $kecamatan = $kecamatan->orderBy($order_field, $order_sort);

            return KecamatanResource::collection($kecamatan->get());
        }
    }
}
