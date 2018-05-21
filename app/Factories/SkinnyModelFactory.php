<?php
namespace App\Factories;

use App\Extensions\Creational\AbstractFactory;
use App\SkinnyModel;
use Illuminate\Database\Eloquent\Model;

class SkinnyModelFactory extends AbstractFactory
{
    public function getNewModelInstance(): Model
    {
       return new SkinnyModel();
    }

    /**
     * @return string[]
     */
    public function getFillableKeys(): array
    {
        return [
            'first_name',
            'weight',
            'active',
            'description',
        ];
    }
}



