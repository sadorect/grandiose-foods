<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = ['name', 'subject', 'email', 'content', 'status'];
    
    const STATUS_UNREAD = 0;
    const STATUS_READ = 1;
    const STATUS_REPLIED = 2;
    
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
