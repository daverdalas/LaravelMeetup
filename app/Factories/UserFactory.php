<?php
namespace App\Factories;

use App\Extensions\Creational\AbstractFactory;
use App\User;
use Illuminate\Database\Eloquent\Model;

class UserFactory extends AbstractFactory
{
    public function getNewModelInstance(): Model
    {
       return new User();
    }

    /**
     * @return string[]
     */
    public function getFillableKeys(): array
    {
        return [
            'name',
            'email'
        ];
    }

    public function getFillableKeysForAdmin(): array
    {
        return [
            'name',
            'email',
            'is_admin',
        ];
    }
}



