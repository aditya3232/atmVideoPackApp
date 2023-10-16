<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbLocation extends Model
{
    use HasFactory;

    protected $table = 'tb_location';

    protected $guarded = ['id'];
}