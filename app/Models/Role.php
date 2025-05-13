<?php

// app/Models/Role.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug','is_super_admin'];

    // Inverse of the relation: One role has many admins
    public function admins()
    {
        return $this->hasMany(Admin::class);
    }

    // public function tasks(): HasMany
    // {
    //     return $this->hasMany(Task::class);
    // }

    public function permissions(): belongsToMany
    {
        return $this->belongsToMany(Permission::class,'role_permission');
    }
}
