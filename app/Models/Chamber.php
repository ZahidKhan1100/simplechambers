<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\News;



class Chamber extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'logo',
        'name',
        'zip',
        'state'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }
}
