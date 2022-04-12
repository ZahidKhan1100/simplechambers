<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Chamber extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'logo',
        'phone',
        'events',
        'news',
        'logo'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
