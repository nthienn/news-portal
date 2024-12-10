<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertise extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'top_bar_ad',
        'top_bar_ad_url',
        'top_bar_ad_status',
        'middle_ad',
        'middle_ad_url',
        'middle_ad_status',
        'bottom_bar_ad',
        'bottom_bar_ad_url',
        'bottom_bar_ad_status',
        'sidebar_ad',
        'sidebar_ad_url',
        'sidebar_ad_status',
    ];
}