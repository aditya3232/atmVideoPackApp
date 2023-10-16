<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbRegionalOffice extends Model
{
    use HasFactory;

    protected $table = 'tb_regional_office';

    protected $guarded = ['id'];
}