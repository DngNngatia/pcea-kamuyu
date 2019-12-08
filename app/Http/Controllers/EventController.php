<?php

namespace App\Http\Controllers;

use App\Data\Models\Contribution;
use App\Data\Models\Event;
use App\Http\Controllers\Transformers\EventTransformer;
use Carbon\Carbon;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $events = Event::where('church_id', $request->user()->id)->whereDate('start_time', '>', Carbon::now()->toDateTime())->orderByDesc('created_at')->paginate(20);
        return $this->response->paginator($events, new EventTransformer());

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'unique:events'],
            'message' => ['required'],
            'start_time' => ['required', 'date'],
            'venue' => ['required']
        ]);
        $contribution = null;
        if ($request->exists('amount')) {
            $this->validate($request, [
                'deadline' => ['required', 'date'],
                'payment_method' => ['required'],
            ]);
            $contribution = Contribution::create([
                'title' => $request->title,
                'message' => $request->message,
                'amount' => $request->amount,
                'deadline' => Carbon::parse($request->deadline)->toDate(),
                'payment_method' => $request->payment_method,
                'church_id' => $request->user()->church_id
            ]);
        }
        Event::create([
            'title' => $request->title,
            'message' => $request->message,
            'start_time' => Carbon::parse($request->start_time)->toDate(),
            'venue' => $request->venue,
            'user_id' => $request->user()->id,
            'church_id' => $request->user()->church_id,
            'contribution_id' => $contribution ? $contribution->id : null
        ]);
        return $this->index($request);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request['start_time'] = Carbon::parse($request->input('start_time'))->toDate();
        if ($request->exists('amount')) {
            Contribution::updateOrCreate([
                'title' => $request->title,
                'message' => $request->message,
                'amount' => $request->amount,
                'deadline' => Carbon::parse($request->deadline)->toDate(),
                'payment_method' => $request->payment_method,
                'church_id' => $request->user()->church_id
            ]);
        }
        $event = Event::findOrFail($id);
        $event->update($request->only('title', 'message', 'start_time', 'venue'));
        return $this->index($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return $this->index(null);
    }
}
