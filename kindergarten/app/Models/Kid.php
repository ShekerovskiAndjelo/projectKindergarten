<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\GeneratedNumber;
use App\Models\Attendance;

class Kid extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'age',
        'generated_number_id',
        'parent_id',
        'group_id'
    ];

    /**
     * Get the generated number associated with the kid.
     */
    public function generatedNumber()
    {
        return $this->belongsTo(GeneratedNumber::class);
    }

    /**
     * Get the parent associated with the kid.
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    /**
     * Get the attendance records associated with the kid.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
