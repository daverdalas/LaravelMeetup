<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'email' => str_limit($user->email, 3, '****'),
            'name' => $user->name,
            'created_at' => (string)$user->created_at,
        ];
    }
}