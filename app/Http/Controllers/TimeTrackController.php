<?php

namespace App\Http\Controllers;

use App\Http\Resources\TimeTrackingResource;
use App\Models\TimeTrackings;
use Illuminate\Http\Request;

class TimeTrackController extends Controller
{
    public function create() {
        $time_tracking = TimeTrackings::create([
            'time_start' => request()->time_start,
            'time_end' => request()->time_end,
            'user_id' => auth()->user()->id,
            'project_id' => request()->project_id
        ]);

        return new TimeTrackingResource($time_tracking);
    }

}
