<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalCardMcu extends Model
{
    use HasFactory;

    // define table
    protected $table = 'view_total_card_mcu';
    // define restrict id
    // protected $guarded = ['id'];
}