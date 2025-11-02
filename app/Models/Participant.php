<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'user_id',
        'full_name',
        'phone',
        'qr_token',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
