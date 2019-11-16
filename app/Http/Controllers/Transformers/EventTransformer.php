<?php


namespace App\Http\Controllers\Transformers;


use App\Data\Models\Event;
use League\Fractal\TransformerAbstract;

class EventTransformer extends TransformerAbstract
{
    public $availableIncludes = ['user'];

    public function transform(Event $event)
    {
        return [
            'id' => $event->id,
            'title' => $event->title,
            'message' => $event->message,
            'start_time' => $event->start_time,
            'venue' => $event->venue,
        ];
    }

    public function includeUser(Event $event)
    {
        return $this->item($event->uploaded_by, new WorshipperTransformer());
    }

}
