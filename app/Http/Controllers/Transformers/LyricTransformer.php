<?php


namespace App\Http\Controllers\Transformers;


use App\Data\Models\Lyric;
use League\Fractal\TransformerAbstract;

class LyricTransformer extends TransformerAbstract
{
    public $availableIncludes = ['user'];

    public function transform(Lyric $lyric)
    {
        return [
            'id' => $lyric->id,
            'title' => $lyric->title,
            'song_lyric' => $lyric->song_lyric,
        ];
    }

    public function includeUser(Lyric $lyric)
    {
        return $lyric->uploaded_by ? $this->item($lyric->uploaded_by, new WorshipperTransformer()) : null;
    }

}
