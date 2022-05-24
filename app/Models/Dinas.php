<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use DataTables;
use App\Http\Resources\DinasResource;
use Wildside\Userstamps\Userstamps;

class Dinas extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('isActive', function (Builder $builder) {
            $builder->where('status', true);
        });
    }
    
    protected $table = 'm_dinas';

    protected $fillable = [
        'nama', 'telepon', 'alamat', 'id_ssw', 'id_arsip', 'status', 'created_by',
        'updated_by', 'deleted_by',
    ];

    protected $softCascade = ['user', 'permohonan_verifikasi', 'permohonan_koreksi_konsep',
    'permohonan_survey', 'permohonan_evaluasi_survey'];

    public function user()
    {
        return $this->hasMany(User::class, 'id_dinas', 'id')->where('status', true);
    }

    public function permohonan_verifikasi()
    {
        return $this->hasMany(PermohonanVerifikasi::class, 'id_dinas', 'id');
    }

    public function permohonan_koreksi_konsep()
    {
        return $this->hasMany(PermohonanKoreksiKonsep::class, 'id_dinas', 'id');
    }

    public function permohonan_survey()
    {
        return $this->hasMany(PermohonanSurvey::class, 'id_dinas', 'id');
    }

    public function permohonan_evaluasi_survey()
    {
        return $this->hasMany(PermohonanEvaluasiSurvey::class, 'id_dinas', 'id');
    }

    public static function get_data($type = 'list', $params = null)
    {
        $dinas = Dinas::withoutGlobalScope('isActive');

        if($type == 'datatables')
        {
            return DataTables::eloquent($dinas)->toJson();
        }
        else
        {
            $search_field = 'nama';
            $order_field = 'updated_at';
            $order_sort = 'desc';

            if(isset($params->relation)) $dinas = $dinas->with($params->relation);

            if(isset($params->search_field)) $search_field = $params->search_field;

            if(isset($params->order_field)) $order_field = $params->order_field;

            if(isset($params->order_sort)) $order_sort = $params->order_sort;

            if(isset($params->status)) $dinas = $dinas->where('status', $params->status);

            if(isset($params->search_value)) $dinas = $dinas->where($search_field, 'ilike', '%' . $params->search_value . '%');

            // if(isset($params->page) && isset($params->per_page)) $dinas = $dinas->skip(($params->page - 1) * $params->per_page)->take($params->per_page);

            $dinas = $dinas->orderBy($order_field, $order_sort);

            return DinasResource::collection($dinas->get());
        }
    }
}
