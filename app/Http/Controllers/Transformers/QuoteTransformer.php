<?php


namespace App\Http\Controllers\Transformers;


use App\Data\Models\Quote;
use League\Fractal\TransformerAbstract;

class QuoteTransformer extends TransformerAbstract
{
    public $availableIncludes = ['user'];

    public function transform(Quote $quote)
    {
        return [
            'id' => $quote->id,
            'quote' => $quote->quote,
        ];
    }

    public function includeUser(Quote $quote)
    {
        return $this->item($quote->user, new WorshipperTransformer());
    }

}
