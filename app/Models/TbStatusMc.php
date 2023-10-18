<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbStatusMc extends Model
{
    use HasFactory;

    protected $table = 'tb_status_mc';

    protected $guarded = ['id'];
}