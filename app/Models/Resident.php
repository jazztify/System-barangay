<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resident extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'resident_id';

    protected $fillable = [
        'household_id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'date_of_birth',
        'sex',
        'civil_status',
        'nationality',
        'occupation',
        'contact_no',
        'email',
        'resident_since',
        'is_voter',
        'is_pwd',
        'is_senior_citizen',
        'is_solo_parent',
        'is_4ps',
        'is_active',
        'photo_path',
    ];

    public function household()
    {
        return $this->belongsTo(Household::class, 'household_id');
    }

    public function issuances()
    {
        return $this->hasMany(Issuance::class, 'resident_id');
    }

    public function complainant_blotters()
    {
        return $this->hasMany(BlotterRecord::class, 'complainant_id');
    }

    public function respondent_blotters()
    {
        return $this->hasMany(BlotterRecord::class, 'respondent_id');
    }

    public function getFullNameAttribute()
    {
        return $this->last_name . ', ' . $this->first_name . ($this->middle_name ? ' ' . $this->middle_name : '') . ($this->suffix ? ' ' . $this->suffix : '');
    }

    public function getAgeAttribute()
    {
        return \Carbon\Carbon::parse($this->date_of_birth)->age;
    }
}
