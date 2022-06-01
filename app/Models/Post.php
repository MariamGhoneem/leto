<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Post extends Model
{
    /*

    public function getCreatedAtAttribute($date)
{
    return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y/m/d');
}

public function getUpdatedAtAttribute($date)
{
    return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y/m/d');
}
    */
    use HasFactory;
    protected $table = 'posts';
    protected $fillable =[
        'title',
        'content',
        'cnums',
        'lnums',
        'owner_id',
        'cat_id',
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
        return $this->belongsTo(User::class,'owner_id')->select(['id','name']);
    }

    public function cat()
    {
        return $this->belongsTo(Category::class);
    }
}
