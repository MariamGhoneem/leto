<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sleep extends Model
{
    use HasFactory;
    protected $table = 'sleeps';
    public $timestamps = false;

    public $fillable =[
        'start_time',
        'end_time'
    ];

    public function baby()
    {
        return $this->belongsTo(Baby::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
