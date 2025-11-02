<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['activity_id', 'image', 'caption'];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
