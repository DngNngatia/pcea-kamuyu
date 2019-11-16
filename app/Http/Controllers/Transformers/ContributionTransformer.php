<?php


namespace App\Http\Controllers\Transformers;


use App\Data\Models\Contribution;
use League\Fractal\TransformerAbstract;

class ContributionTransformer extends TransformerAbstract
{
    public function transform(Contribution $contribution)
    {
        return [
            'id' => $contribution->id,
            'title' => $contribution->title,
            'message' => $contribution->message,
            'amount' => $contribution->amount,
            'deadline' => $contribution->deadline,
            'payment_method' => $contribution->payment_method
        ];
    }

}
