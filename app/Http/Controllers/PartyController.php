<?php

namespace App\Http\Controllers;

use App\Data\Models\Contribution;
use App\Data\Models\Party;
use App\Http\Controllers\Transformers\PartyTransformer;
use Carbon\Carbon;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $party = Party::where('church_id', $request->user()->church_id)->paginate(50);
        return $this->response->paginator($party, new PartyTransformer());
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
                'church_id' => $request->user()->church_id,

            ]);
        }
        Party::create([
            'title' => $request->title,
            'message' => $request->message,
            'venue' => $request->venue,
            'start_time' => Carbon::parse($request->start_time)->toDate(),
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
        if ($request->exists('amount')) {
            $contribution = Contribution::updateOrCreate([
                'title' => $request->title,
                'message' => $request->message,
                'amount' => $request->amount,
                'deadline' => Carbon::parse($request->deadline)->toDate(),
                'payment_method' => $request->payment_method,
                'church_id' => $request->user()->church_id,
            ]);
        }
        $party = Party::findOrFail($id);
        $party->update([
            'title' => $request->title,
            'message' => $request->message,
            'venue' => $request->venue,
            'start_time' => Carbon::parse($request->input('start_time'))->toDate(),
            'user_id' => $request->user()->id,
            'contribution_id' => $contribution ? $contribution->id : null
        ]);
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
        $party = Party::findOrFail($id);
        $party->delete();
        return $this->index(null);
    }
}
