<?php


namespace App\Http\Controllers\Transformers;


use App\User;
use League\Fractal\TransformerAbstract;

class WorshipperTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'device_token' => $user->device_token,
        ];
    }

}
