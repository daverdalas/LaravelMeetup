<?php

namespace App\Extensions\Creational;

use Illuminate\Database\Eloquent\Model;

interface DirectorInterface
{
    public function build(Model $model, array $data): Model;
}