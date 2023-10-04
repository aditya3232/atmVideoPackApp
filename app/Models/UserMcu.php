<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMcu extends Model
{
    use HasFactory;

    // define table
    protected $table = 'tb_user_mcu';
    // define restrict id
    protected $guarded = ['id'];
}