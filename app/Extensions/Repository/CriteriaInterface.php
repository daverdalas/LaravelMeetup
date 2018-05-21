<?php

namespace App\Extensions\Repositories;

interface CriteriaInterface
{
    public function apply(AbstractRepository $repository): void;
}
