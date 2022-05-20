<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable =[
        'babyname',
        'docname',
        'diagnose',
        'r',
        'time',
    ];
    
    public function baby()
    {
        return $this->belongsTo(Baby::class);
    }
}
