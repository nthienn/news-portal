<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivedMail extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'subject', 'message', 'seen', 'replied'];
}