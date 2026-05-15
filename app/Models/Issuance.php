<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issuance extends Model
{
    use HasFactory;

    protected $primaryKey = 'issuance_id';

    protected $fillable = [
        'resident_id',
        'doc_type',
        'control_no',
        'or_no',
        'purpose',
        'is_free',
        'remarks',
        'issued_by',
        'issued_at',
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }

    public function issuer()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
}
