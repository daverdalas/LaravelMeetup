<?php
namespace App\Extensions\Creational;

use Illuminate\Database\Eloquent\Model;

interface BuilderInterface
{
    public function getModel(): Model;

    public function setModel(Model $model): void;
}