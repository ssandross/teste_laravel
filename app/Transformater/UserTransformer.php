<?php namespace App\Transformer;
 
use League\Fractal\TransformerAbstract;
use App\User;

/**
 * 
 * @author Sandro
 *
 */
class UserTransformer extends TransformerAbstract {
 
    public function transform($user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ];
    }
 }