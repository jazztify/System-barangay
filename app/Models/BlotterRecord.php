<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlotterRecord extends Model
{
    use HasFactory;

    protected $primaryKey = 'blotter_id';

    protected $fillable = [
        'case_no',
        'complainant_id',
        'respondent_id',
        'incident_type',
        'incident_date',
        'incident_location',
        'narrative',
        'status',
        'resolution_date',
        'resolution_notes',
        'filed_by',
    ];

    public function complainant()
    {
        return $this->belongsTo(Resident::class, 'complainant_id');
    }

    public function respondent()
    {
        return $this->belongsTo(Resident::class, 'respondent_id');
    }

    public function filer()
    {
        return $this->belongsTo(User::class, 'filed_by');
    }

    public function summons()
    {
        return $this->hasMany(BlotterSummon::class, 'blotter_id');
    }
}
