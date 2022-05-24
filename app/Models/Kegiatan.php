<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use DataTables;
use App\Http\Resources\BerkasResource;
use Wildside\Userstamps\Userstamps;

class Kegiatan extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;
    
    protected $table = 'm_kegiatan';

    protected $fillable = [
        'nama',  'id_ssw', 'status', 'created_by', 'updated_by', 'deleted_by',
    ];

    public static function get_data($type = 'list', $params = null)
    {
        $kegiatan = Kegiatan::query();

        if($type == 'datatables')
        {
            return DataTables::eloquent($kegiatan)->toJson();
        }
        else
        {
            $search_field = 'nama';
            $order_field = 'updated_at';
            $order_sort = 'desc';

            if(isset($params->relation)) $kegiatan = $kegiatan->with($params->relation);

            if(isset($params->search_field)) $search_field = $params->search_field;

            if(isset($params->order_field)) $order_field = $params->order_field;

            if(isset($params->order_sort)) $order_sort = $params->order_sort;

            if(isset($params->status)) $kegiatan = $kegiatan->where('status', $params->status);

            if(isset($params->search_value)) $kegiatan = $kegiatan->where($search_field, 'ilike', '%' . $params->search_value . '%');

            // if(isset($params->page) && isset($params->per_page)) $kegiatan = $kegiatan->skip(($params->page - 1) * $params->per_page)->take($params->per_page);

            $kegiatan = $kegiatan->orderBy($order_field, $order_sort);

            return KegiatanResource::collection($kegiatan->get());
        }
    }
}
