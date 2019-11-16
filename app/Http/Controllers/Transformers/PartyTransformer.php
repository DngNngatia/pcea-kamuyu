<?php


namespace App\Http\Controllers\Transformers;


use App\Data\Models\Party;
use League\Fractal\TransformerAbstract;

class PartyTransformer extends TransformerAbstract
{
    public $availableIncludes = ['contribution'];

    public function transform(Party $party)
    {
        return [
            'id' => $party->id,
            'title' => $party->title,
            'message' => $party->message,
            'venue' => $party->venue,
            'start_time' => $party->start_time,
        ];
    }

    public function includeContribution(Party $party)
    {
        return $this->item($party->contribution, new ContributionTransformer());
    }

}
