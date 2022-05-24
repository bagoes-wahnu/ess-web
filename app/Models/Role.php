<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use DataTables;
use App\Http\Resources\RoleResource;
use Wildside\Userstamps\Userstamps;

class Role extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('isActive', function (Builder $builder) {
            $builder->where('status', true);
        });
    }
    
    protected $table = 'm_role';

    protected $fillable = [
        'nama', 'status', 'created_by', 'updated_by', 'deleted_by',
    ];

    protected $softCascade = ['user'];

    public function user()
    {
        return $this->hasMany(User::class, 'id_role', 'id')->where('status', true);
    }

    public static function get_data($type = 'list', $params = null)
    {
        $role = Role::withoutGlobalScope('isActive');

        if($type == 'datatables')
        {
            return DataTables::eloquent($role)->toJson();
        }
        else
        {
            $search_field = 'nama';
            $order_field = 'updated_at';
            $order_sort = 'desc';

            if(isset($params->relation)) $role = $role->with($params->relation);

            if(isset($params->search_field)) $search_field = $params->search_field;

            if(isset($params->order_field)) $order_field = $params->order_field;

            if(isset($params->order_sort)) $order_sort = $params->order_sort;

            if(isset($params->status)) $role = $role->where('status', $params->status);

            if(isset($params->search_value)) $role = $role->where($search_field, 'ilike', '%' . $params->search_value . '%');

            // if(isset($params->page) && isset($params->per_page)) $role = $role->skip(($params->page - 1) * $params->per_page)->take($params->per_page);

            $role = $role->orderBy($order_field, $order_sort);

            return RoleResource::collection($role->get());
        }
    }
}
