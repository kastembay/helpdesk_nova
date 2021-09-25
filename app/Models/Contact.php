<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }
}
