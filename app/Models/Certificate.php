<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Certificate extends Model
{
    use HasFactory;

    
    protected $casts = [
        'start_date' => 'date',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function findById($id) {
        return self::query()
            ->where('id', $id) 
            ->first();
    }
}
