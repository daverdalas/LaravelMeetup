<?php
namespace App\Builder;

use App\SkinnyModel;
use App\Extensions\Creational\BuilderInterface;
use Illuminate\Database\Eloquent\Model;

class SkinnyModelBuilder implements BuilderInterface
{
    /**
     * @var SkinnyModel
     */
    private $skinnyModel;

    public function __construct(SkinnyModel $skinnyModel = null)
    {
        $this->skinnyModel = $skinnyModel;
    }

    public function getModel(): Model
    {
        return $this->skinnyModel;
    }

    public function setModel(Model $model): void
    {
        $this->skinnyModel = $model;
    }

    public function setFirstName(string $value): void
    {
        $this->skinnyModel->first_name = strtolower($value);
    }

    public function setActive(string $value): void
    {
        $this->skinnyModel->active = $value === 'true';
    }

    public function setWeight(float $value): void
    {
        $this->skinnyModel->weight = round($value, 2);
    }

    public function setDescription(string $description): void
    {
        $this->skinnyModel->description = $description;
    }
}