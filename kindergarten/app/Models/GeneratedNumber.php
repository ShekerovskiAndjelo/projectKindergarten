<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Kid;

class GeneratedNumber extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'number',
        'status',
    ];

    /**
     * Get the kids associated with the generated number.
     */
    public function kids()
    {
        return $this->hasMany(Kid::class);
    }
}
