<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kindergarten extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'city',
        'street',
        'managed_by',
    ];

    /**
     * Get the director associated with the kindergarten.
     */
    public function director()
    {
        return $this->belongsTo(User::class, 'managed_by');
    }

    /**
     * Get the groups associated with the kindergarten.
     */
    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
