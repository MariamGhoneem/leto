<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feeding extends Model
{
    use HasFactory;
    protected $table = 'feedings';
    public $timestamps = false;


    protected $fillable =[
        'quantity',
        'created_at',
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
