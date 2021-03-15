<?php


namespace App\Http\Controllers\Transformers;


use App\Data\Models\Church;
use League\Fractal\TransformerAbstract;

class ChurchTransformer extends TransformerAbstract
{
    public function transform(Church $church)
    {
        return [
            'id' => $church->id,
            'name' => $church->name,
            'location' => $church->location,
            'lat' => $church->lat,
            'lng' => $church->lng
        ];
    }

}
