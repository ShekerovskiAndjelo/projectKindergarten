<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'kid_id',
        'group_id',
        'kindergarten_id',
        'date',
        'status',
    ];

    /**
     * Get the kid associated with the attendance record.
     */
    public function kid()
    {
        return $this->belongsTo(Kid::class);
    }

    /**
     * Get the group associated with the attendance record.
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the kindergarten associated with the attendance record.
     */
    public function kindergarten()
    {
        return $this->belongsTo(Kindergarten::class);
    }
}
