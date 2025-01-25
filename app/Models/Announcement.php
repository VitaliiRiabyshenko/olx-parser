<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    const CREATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'url',
        'price',
        'updated_at',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_announcements');
    }
}
