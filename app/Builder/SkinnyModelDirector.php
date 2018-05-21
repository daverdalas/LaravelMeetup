<?php
namespace App\Builder;

use App\Extensions\Creational\DirectorInterface;
use Illuminate\Database\Eloquent\Model;

class SkinnyModelDirector implements DirectorInterface
{
    /**
     * @var SkinnyModelBuilder
     */
    private $skinnyModelBuilder;

    public function __construct(SkinnyModelBuilder $skinnyModelBuilder)
    {
        $this->skinnyModelBuilder = $skinnyModelBuilder;
    }

    public function build(Model $model, array $data): Model
    {
        $this->skinnyModelBuilder->setModel($model);
        $this->skinnyModelBuilder->setFirstName($data['first_name']);
        $this->skinnyModelBuilder->setWeight($data['weight']);
        $this->skinnyModelBuilder->setActive($data['active']);
        $this->skinnyModelBuilder->setDescription($data['description']);
        return $this->skinnyModelBuilder->getModel();
    }
}