<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function managedKindergartens()
    {
        return $this->hasMany(Kindergarten::class, 'managed_by', 'id');
    }

    public function groups()
    {
        return $this->hasMany(Group::class, 'teacher_id', 'id');
    }

    public function kids()
    {
        return $this->hasMany(Kid::class, 'parent_id', 'id');
    }

    public function hasRole($roles)
{
    return in_array($this->role, (array) $roles);
}

}
