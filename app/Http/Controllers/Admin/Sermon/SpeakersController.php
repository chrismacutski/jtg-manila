<?php

namespace App\Http\Controllers\Admin\Sermon;

use App\SermonSpeaker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpeakersController extends Controller
{
    public function store()
    {
        try {
            $sermon_speaker = SermonSpeaker::addNew(request()->only('first_name', 'middle_name', 'last_name', 'is_guest'));
        } catch (\Exception $e) {
            logger($e->getMessage());
            abort(500, $e->getMessage());
        }

        return $sermon_speaker;
    }

    public function getSpeakers()
    {
        return SermonSpeaker::get()->pluck('fullname', 'id');
    }
}
