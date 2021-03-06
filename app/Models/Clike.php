<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clike extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'clikes';
    protected $fillable =[
        'liker_id',
        'comment_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
