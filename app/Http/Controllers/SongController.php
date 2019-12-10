<?php

namespace App\Http\Controllers;

use App\Data\Models\Lyric;
use App\Data\Models\Song;
use App\Http\Controllers\Transformers\SongTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class SongController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $songs = Song::FilterBy($request->all())->orderBy('created_at')->orderBy('created_at')->paginate(20);
        return $this->response->paginator($songs, new SongTransformer());

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
            'title' => ['required', 'unique:songs'],
            'singer' => ['required'],
        ]);
        if ($request->hasFile('file_path')) {
            $path = $request->file('file_path')->store('audios');
            $song = Song::create([
                'title' => $request->title,
                'singer' => $request->singer,
                'uploaded_by' => $request->user()->id,
                'file_path' => Storage::url($path)
            ]);
            if ($request->exists('song_lyric')) {
                Lyric::create([
                    'song_id' => $song->id,
                    'title' => $request->title,
                    'song_lyric' => $request->song_lyric,
                    'uploaded_by' => $request->user()->id
                ]);
            }
            return $this->index($request);
        } else {
            return $this->response->error('File required', 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        $song = Song::findOrFail($id);
        $song->update([
            'title' => $request->title,
            'singer' => $request->singer,
        ]);
        if ($request->exists('song_lyric')) {
            Lyric::updateOrCreate([
                'song_id' => $song->id,
                'title' => $request->title,
                'song_lyric' => $request->song_lyric,
                'uploaded_by' => $request->user()->id
            ]);
        }
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
        //
    }
}
