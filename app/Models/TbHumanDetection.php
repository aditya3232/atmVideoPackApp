<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbHumanDetection extends Model
{
    use HasFactory;

    protected $table = 'tb_human_detection';

    protected $guarded = ['id'];
}