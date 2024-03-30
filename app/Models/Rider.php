<?php

namespace App\Models;

use Database\Factories\RiderFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'riders';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected static function newFactory(): Factory
    {
        return RiderFactory::new();
    }
}
