<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function getCreatedAtAttribute($date)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y/m/d');
    }
    use HasFactory;
    protected $table = 'comments';
    public $timestamps = false;
    protected $fillable =[
        'content',
        'lnums',
        'owner_id',
        'created_at',
        'post_id'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clikes()
    {
        return $this->hasMany(Clike::class);
    }
}
