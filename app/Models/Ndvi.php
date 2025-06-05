<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ndvi extends Model
{
    protected $table = 'ndvi';

    protected $fillable = [
        'url',
        'avg_ndvi',
        'healthy_percentage',
        'alert_count',
    ];

}
