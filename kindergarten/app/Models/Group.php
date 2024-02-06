<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'period',
        'kindergarten_id',
        'teacher_id',
    ];

    /**
     * Get the kindergarten associated with the group.
     */
    public function kindergarten()
    {
        return $this->belongsTo(Kindergarten::class);
    }

    /**
     * Get the teacher associated with the group.
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the attendance records associated with the group.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function kids()
    {
        return $this->hasMany(Kid::class);
    }
}
