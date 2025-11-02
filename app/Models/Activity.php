<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'start_date',
        'end_date'
    ];

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function documents()
    {
/*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Get the documents associated with the activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
/*******  a4d46e9d-4076-4759-9583-f6179d70293a  *******/        return $this->hasMany(Document::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
