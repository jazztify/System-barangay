<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlotterSummon extends Model
{
    use HasFactory;

    protected $primaryKey = 'summon_id';

    protected $fillable = [
        'blotter_id',
        'summon_date',
        'summon_type',
        'notes',
    ];

    public function blotter()
    {
        return $this->belongsTo(BlotterRecord::class, 'blotter_id');
    }
}
