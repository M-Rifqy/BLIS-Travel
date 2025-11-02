<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
        use HasFactory;

    protected $fillable = [
        'participant_id', 'activity_id', 'group', 'check_in_time'
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
