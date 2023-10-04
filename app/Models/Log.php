<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    // define table
    protected $table = 'tb_log';
    // define restrict id
    protected $guarded = ['id'];
}