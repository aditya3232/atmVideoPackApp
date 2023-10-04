<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    // define table
    protected $table = 'tb_office';

    // define guarded
    protected $guarded = ['id'];
}