<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class Ttd extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;
    
    protected $table = 'm_ttd';

    protected $fillable = [
        'nip', 'nama_kadis', 'nama', 'path', 'ukuran', 'ext', 'is_gambar', 'nama_stempel', 'path_stempel', 'ukuran_stempel', 'ext_stempel', 'stempel_is_gambar',
        'created_by', 'updated_by', 'deleted_by',
    ];
}
