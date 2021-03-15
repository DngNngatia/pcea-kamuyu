<?php


namespace App\Http\Controllers\Transformers;


use App\Data\Models\Song;
use League\Fractal\TransformerAbstract;

class SongTransformer extends TransformerAbstract
{
    public $availableIncludes = ['lyric', 'user'];

    public function transform(Song $song)
    {
        return [
            'id' => $song->id,
            'title' => $song->title,
            'singer' => $song->singer,
            'file_path' => $song->file_path,
        ];
    }

    public function includeLyric(Song $song)
    {
        return $song->lyric ? $this->item($song->lyric, new LyricTransformer()) : null;
    }

    public function includeUser(Song $song)
    {
        return $song->uploaded_by ? $this->item($song->uploaded_by, new WorshipperTransformer()) : null;
    }

}
