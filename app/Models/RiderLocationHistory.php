<?php

namespace App\Models;

use Database\Factories\RiderLocationHistoryFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderLocationHistory extends Model
{
    use HasFactory;

    protected $table = 'rider_location_histories';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected static function newFactory(): Factory
    {
        return RiderLocationHistoryFactory::new();
    }
}
