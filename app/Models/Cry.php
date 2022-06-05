<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cry extends Model
{
    use HasFactory;
    protected $table = 'cries';
    public $timestamps = false;
    protected $casts = [
        'label' => 'array'
    ];
    protected $fillable =[
    ];

    public function baby()
    {
        return $this->belongsTo(Baby::class);
    }
}
