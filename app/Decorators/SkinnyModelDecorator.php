<?php

namespace App\Decorators;

use App\SkinnyModel;

class SkinnyModelDecorator
{
    /**
     * @var SkinnyModel
     */
    private $skinnyModel;

    public function __construct(SkinnyModel $skinnyModel)
    {
        $this->skinnyModel = $skinnyModel;
    }

    public function getCreatedAtDay(): string
    {
        return $this->skinnyModel->created_at->format('d');
    }

    public function getCreatedAtDayAsString(): string
    {
        return $this->skinnyModel->created_at->format('l');
    }

    public function getUpdatedAtMonth(): string
    {
        return $this->skinnyModel->updated_at->format('m');
    }

    public function getUpdatedAtYear(): string
    {
        return $this->skinnyModel->updated_at->format('Y');
    }
}
