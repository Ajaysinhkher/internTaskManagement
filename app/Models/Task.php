<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Admin;
use App\Models\Comment;

class Task extends Model
{
    use hasFactory;
    protected $fillable = [
        'title',
        'description',
        'status',
        'due_date',
        'assigned_by',  
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function users(): belongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(Admin::class, 'assigned_by');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    
}
