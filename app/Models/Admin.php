<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use App\Models\Task;
use App\Models\Comment;
use App\Models\Message;
  
class Admin extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $with = ['role.permissions'];
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_superadmin',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_by');
    }

    public function isSuperAdmin(): bool
    {
        return $this->role && $this->role->is_super_admin === 1;
    }


    public function hasPermission(string $permissionSlug): bool
    {
        if (!$this->role) {
        return false;
    }

     return $this->role->permissions->contains('slug', $permissionSlug);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function sentMessages()
    {
        return $this->morphMany(Message::class, 'sender');
    }

    public function receivedMessages()
    {
        return $this->morphMany(Message::class, 'receiver');
    }

}
