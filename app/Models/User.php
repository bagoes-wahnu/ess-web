<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use DataTables;
use App\Http\Resources\UserResource;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('isActive', function (Builder $builder) {
            $builder->where('m_user.status', true);
        });

        static::addGlobalScope('checkRelationIsActive', function (Builder $builder) {
            $builder->where(function($query) {
                $query->where(function($query) {
                    $query->whereHas('role', function($query) {
                        $query->where('status', true);
                    });
                    $query->whereHas('dinas', function($query) {
                        $query->where('status', true);
                    });
                });
                $query->orWhere(function($query) {
                    $query->whereHas('role', function($query) {
                        $query->where('status', true);
                    });
                    $query->doesntHave('dinas');
                });
            });
        });
    }
    
    protected $table = 'm_user';

    protected $fillable = [
        'nama',
        'username',
        'password',
        'email',
        'status',
        'id_role',
        'id_dinas',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'id_dinas', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id');
    }

    public function kecamatan()
    {
        return $this->belongsToMany(Kecamatan::class, 'm_user_kecamatan', 'id_user', 'id_kecamatan')->where('status', true);
    }

    public function kelurahan()
    {
        return $this->belongsToMany(Kelurahan::class, 'm_user_kelurahan', 'id_user', 'id_kelurahan')->where('status', true);
    }

    public static function get_data($type = 'list', $params = null)
    {
        $user = User::withoutGlobalScope('isActive');

        if(isset($params->id_role)) 
        {
            $user = $user->whereHas('role', function ($query) use ($params) {
                $query->where('id', $params->id_role);
            });
        }

        if(isset($params->id_dinas)) 
        {
            $user = $user->whereHas('dinas', function ($query) use ($params) {
                $query->where('id', $params->id_dinas);
            });
        }

        if(isset($params->id_kecamatan)) 
        {
            $user = $user->whereHas('kecamatan', function ($query) use ($params) {
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

        if(isset($params->id_kelurahan)) 
        {
            $user = $user->whereHas('kelurahan', function ($query) use ($params) {
                if(is_array($params->id_kelurahan) && !empty($params->id_kelurahan))
                {
                    $query->whereIn('id', $params->id_kelurahan);
                }
                elseif(!is_array($params->id_kelurahan))
                {
                    $query->where('id', $params->id_kelurahan);
                }
            });
        }

        if($type == 'datatables')
        {
            $user = $user->select([
                'm_user.id',
                'm_user.nama',
                'm_user.username',
                'm_user.status',
                'm_role.id AS id_role',
                'm_role.nama AS role',
                'm_user.created_at',
                'm_user.updated_at', 
                'm_user.deleted_at'
            ])
            ->leftJoin('m_role', 'm_role.id', 'm_user.id_role')
            ->whereNull('m_role.deleted_at');

            return DataTables::eloquent($user)->toJson();
        }
        else {
            $search_field = 'nama';
            $order_field = 'updated_at';
            $order_sort = 'desc';

            if(isset($params->relation)) $user = $user->with($params->relation);

            if(isset($params->search_field)) $search_field = $params->search_field;

            if(isset($params->order_field)) $order_field = $params->order_field;

            if(isset($params->order_sort)) $order_sort = $params->order_sort;

            if(isset($params->status)) $user = $user->where('status', $params->status);

            if(isset($params->search_value)) $user = $user->where($search_field, 'ilike', '%' . $params->search_value . '%');

            // if(isset($params->page) && isset($params->per_page)) $user = $user->skip(($params->page - 1) * $params->per_page)->take($params->per_page);

            $user = $user->orderBy($order_field, $order_sort);

            return UserResource::collection($user->get());
        }
    }
}
