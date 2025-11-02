<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'participant_id',
        'title',
        'file',
        'visibility'
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
