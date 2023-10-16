<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbVandalDetection extends Model
{
    use HasFactory;

    protected $table = 'tb_vandal_detection';

    protected $guarded = ['id'];
}