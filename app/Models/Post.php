<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $fillable =[
        'content',
        'cnums',
        'lnums',
        'owner_id',
        'cat_id'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function plikes()
    {
        return $this->hasMany(Plike::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cat()
    {
        return $this->belongsTo(Category::class);
    }
}
