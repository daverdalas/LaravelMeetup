<?php
namespace App\Repositories;

use App\Extensions\Repositories\AbstractRepository;
use App\SkinnyModel;
use Illuminate\Database\Eloquent\Builder;

class SkinnyModelRepository extends AbstractRepository
{
    public function newQuery(): Builder
    {
        return SkinnyModel::query();
    }

    public function active(): SkinnyModelRepository
    {
        $this->query->where('active', 1);
        return $this;
    }

    public function withDescription(): SkinnyModelRepository
    {
        $this->query->whereNotNull('description');
        return $this;
    }

    public function whereWeightBetween(int $from, int $to): SkinnyModelRepository
    {
        $this->query->whereBetween('weight', [$from, $to]);
        return $this;
    }

    public function whereFirstNameLike(string $like): SkinnyModelRepository
    {
        $this->query->where('name', 'LIKE', "%{$like}%");
        return $this;
    }
}