<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Household extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'household_id';

    protected $fillable = [
        'household_no',
        'purok_sitio',
        'address',
        'head_name',
    ];

    public function residents()
    {
        return $this->hasMany(Resident::class, 'household_id');
    }
}
