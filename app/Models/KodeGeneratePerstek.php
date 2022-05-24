<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Wildside\Userstamps\Userstamps;

class KodeGeneratePerstek extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait, Userstamps;

    protected $table = 'kode_generate_perstek';

    protected $fillable = [
        'template_utama', 'template_no_seq', 'no_seq', 'no_tahun', 'jenis_bast', 'created_by', 'updated_by', 'deleted_by',
    ];
}
