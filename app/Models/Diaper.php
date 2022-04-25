<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diaper extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'diapers';

    protected $fillable =[
        'time',
        'states'
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
