<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbKcSupervisi extends Model
{
    use HasFactory;

    protected $table = 'tb_kc_supervisi';

    protected $guarded = ['id'];
}