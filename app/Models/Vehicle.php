<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vehicle extends Model
{
    use HasFactory;
    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
    public function certificate()
    {
        return $this->hasMany( Certificate::class);
    }

    public static function getByLicensePlate($plate)
    {
        return self::query()
            ->where('license_plate', $plate) 
            ->first();
    }
}
