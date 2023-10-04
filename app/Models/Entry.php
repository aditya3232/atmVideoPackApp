<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{

    // define table
    protected $table = 'tb_entry';
    // define restrict id
    protected $guarded = ['id'];
    
    use HasFactory;
}