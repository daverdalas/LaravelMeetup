<?php

namespace App\Extensions\Repositories;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class AbstractRepository
{
    /**
     * @var Builder
     */
    protected $query;

    /**
     * @var string[]
     */
    protected $returnAsResult = [
        Model::class,
        LengthAwarePaginator::class,
        Collection::class
    ];

    public function __construct()
    {
        $this->fresh();
    }

    /**
     * @param string|mixed $name
     * @param string[] $arguments
     * @return $this|mixed
     */
    public function __call($name, array $arguments)
    {
        $result = call_user_func_array([$this->query, $name], $arguments);
        if (!is_object($result)) {
            $this->fresh();
            return $result;
        }

        foreach ($this->returnAsResult as $class) {
            if ($result instanceof $class) {
                $this->fresh();
                return $result;
            }
        }

        return $this;
    }

    public function getQuery(): Builder
    {
        return $this->query;
    }

    public function getModel(): Model
    {
        return $this->query->getModel();
    }

    public function getTableName(): string
    {
        return $this->getModel()->getTable();
    }

    public function fresh(): AbstractRepository
    {
        $this->query = $this->newQuery();
        return $this;
    }

    public function addCriteria(CriteriaInterface $criteria): AbstractRepository
    {
        $criteria->apply($this);
        return $this;
    }

    /**
     * @param string[] $columns
     */
    public function paginate(
        ?int $perPage = null,
        ?int $page = null,
        array $columns = ['*'],
        string $pageName = 'page'
    ): LengthAwarePaginator {
        $results = $this->query->paginate($perPage, $columns, $pageName, $page);
        $this->fresh();
        return $results;
    }

    /**
     * @param string[] $columns
     */
    public function get(array $columns = ['*']): EloquentCollection
    {
        $results = $this->query->get($columns);
        $this->fresh();
        return $results;
    }

    public function exists(): bool
    {
        $result = $this->query->exists();
        $this->fresh();
        return $result;
    }

    public function first(bool $fail = true): ?Model
    {
        if ($fail) {
            $result = $this->query->firstOrFail();
        } else {
            $result = $this->query->first();
        }

        $this->fresh();
        return $result;
    }

    public function find(int $id, bool $fail = true): ?Model
    {
        $this->query->where($this->getTableName() . '.id', $id);
        return $this->first($fail);
    }

    abstract public function newQuery(): Builder;
}
