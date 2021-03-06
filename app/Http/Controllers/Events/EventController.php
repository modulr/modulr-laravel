<?php

namespace App\Http\Controllers\Events;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Events\Event;
use App\Models\Events\EventImage;
use App\Http\Helpers\Upload;


class EventController extends Controller
{
    public function all()
    {
        return Event::with(['creator', 'images' => function ($query) {
                            $query->orderBy('order', 'asc');
                        }])
                        ->orderBy('id', 'desc')
                        ->paginate(20);
    }

    public function byCreator()
    {
        return Event::with(['creator', 'images' => function ($query) {
                        $query->orderBy('order', 'asc');
                    }])
                    ->where('created_by', Auth::id())
                    ->orderBy('id', 'desc')
                    ->paginate(20);
    }

    public function show($id)
    {
        return Event::with(['creator', 'images' => function ($query) {
                        $query->orderBy('order', 'asc');
                    }])->find($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'place' => 'required|string',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'after_or_equal:start_time',
        ]);

        $event = Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'place' => $request->place,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'attending_limit' => $request->attending_limit,
        ]);

        if (count($request->images)) {
            $upload = new Upload();
            foreach ($request->images as $key => $value) {
                if (isset($value['path'])) {
                    $upload->move($value['path'], 'events/'.$event->id.'/images')
                            ->resize(800,500)->thumbnail(360,130)
                            ->getData();

                    EventImage::create([
                        'basename' => $value['basename'],
                        'order' => $key,
                        'event_id' => $event->id
                    ]);
                }
            }
        }

        return Event::with(['creator', 'images' => function ($query) {
                        $query->orderBy('order', 'asc');
                    }])->find($event->id);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'place' => 'required|string',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'nullable|after_or_equal:start_time',
        ]);

        $event = Event::with('creator', 'images')->find($id);
        $event->name = $request->name;
        $event->description = $request->description;
        $event->place = $request->place;
        $event->date = $request->date;
        $event->start_time = $request->start_time;
        $event->end_time = $request->end_time;
        $event->attending_limit = $request->attending_limit;
        $event->save();

        return $event;
    }

    public function destroy($id)
    {
        return Event::destroy($id);
    }


    public function uploadImageTemp(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|max:10000',
        ]);
        $upload = new Upload();
        $uploadData = $upload->uploadTemp($request->file)->getData();
        return $uploadData;
    }

    public function uploadImage(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|max:10000',
        ]);
        $upload = new Upload();
        $data = $upload->upload($request->file, 'events/'.$request->id.'/images')
                        ->resize(800,500)->thumbnail(360,130)
                        ->getData();
        $maxOrder = EventImage::where('event_id', $request->id)->max('order');
        $maxOrder ++;
        return EventImage::create([
            'basename' => $data['basename'],
            'order' => $maxOrder,
            'event_id' => $request->id
        ]);
    }

    public function sortImage(Request $request, $eventId)
    {
        foreach ($request->images as $key => $v) {
            EventImage::where('id', $v['id'])
                        ->where('event_id', $eventId)
                        ->update(['order' => $key]);
        }
        return EventImage::where('event_id', $eventId)->orderBy('order', 'asc')->get();
    }

    public function destroyImage($id)
    {
        return EventImage::destroy($id);
    }
}
