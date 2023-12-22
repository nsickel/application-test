<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTrackings extends Model
{
    use HasFactory;

    protected $table = 'time_tracks';

    protected $fillable = [
        'time_start',
        'time_end',
        'user_id',
        'project_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Projects::class);
    }
}
