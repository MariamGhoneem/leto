<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baby extends Model
{
    use HasFactory;
    protected $table = 'babies';

    protected $fillable =[
        'name',
        'birthdate',
        'gender'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feedings()
    {
        return $this->hasMany(Feeding::class);
    }

    public function sleeps()
    {
        return $this->hasMany(Sleep::class);
    }

    public function diapers()
    {
        return $this->hasMany(Diaper::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }
  
    public function cries()
    {
        return $this->hasMany(Cry::class);
    }
}
