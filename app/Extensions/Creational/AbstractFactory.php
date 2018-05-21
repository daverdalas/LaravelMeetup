<?php

namespace App\Extensions\Creational;

use App\User;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractFactory
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var string[]
     */
    protected $modelsToAssociate = [];

    /**
     * @var int[]|string[]
     */
    protected $payload = [];

    /**
     * @var Model|null
     */
    protected $model;

    /**
     * @var DirectorInterface[]
     */
    protected $directors = [];

    /**
     * @param int[]|string[] $data
     */
    public function make(array $data, ?Model $model = null): Model
    {
        $model = $model ?: $this->getNewModelInstance();
        $this->model = $model;
        $this->data = $data;
        $this->assignExistingValues();
        $this->associateModels();
        $this->runDirectors();
        $this->reset();

        return $model;
    }

    /**
     * @return string[]
     */
    public function getModelsToAssociate(): array
    {
        return $this->modelsToAssociate;
    }

    /**
     * @param string[] $payloadKeys
     */
    public function payload(array $payloadKeys): AbstractFactory
    {
        $this->payload = $payloadKeys;
        return $this;
    }

    /**
     * @return int[]|string[]
     */
    public function getPayload()
    {
        return $this->payload;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function reset(): AbstractFactory
    {
        $this->modelsToAssociate = [];
        $this->payload = [];
        $this->directors = [];
        $this->model = null;
        return $this;
    }

    public function pushModelToAssociate(string $relation, Model $model): AbstractFactory
    {
        $this->modelsToAssociate[$relation] = $model;
        return $this;
    }

    public function pushDirector(DirectorInterface $director): AbstractFactory {
        $this->directors[] = $director;
        return $this;
    }

    public function getUserDependentFillableKeys(): array
    {
        $user = $this->authUser();

        if (!$user) {
            return $this->getFillableKeys();
        }

        if ($user->is_admin) {
            return $this->getFillableKeysForAdmin();
        }

        return $this->getFillableKeysForUser();
    }

    public function getFillableKeysForAdmin(): array
    {
        return $this->getFillableKeys();
    }

    public function getFillableKeysForUser(): array
    {
        return $this->getFillableKeys();
    }

    public function associateModels(): void
    {
        foreach ($this->modelsToAssociate as $relation => $model) {
            $this->model->$relation()->associate($model);
        }
    }

    public function runDirectors(): void
    {
        foreach ($this->directors as $director) {
            $director->build($this->model, $this->data);
        }
    }

    protected function assignValueIfExists(string $key): AbstractFactory
    {
        if (array_key_exists($key, $this->data)) {
            $keySnakeCase = snake_case($key);
            $this->model->{$keySnakeCase} = $this->data[$key];
        }

        return $this;
    }

    protected function assignExistingValues(): AbstractFactory
    {
        foreach (array_keys($this->data) as $key) {
            if ($this->canSetKey($key)) {
                $this->assignValueIfExists($key);
            }
        }

        return $this;
    }

    protected function canSetKey(string $key): bool
    {
        if (!empty($this->payload) && !in_array($key, $this->payload)) {
            return false;
        }
        return in_array($key, $this->getUserDependentFillableKeys());
    }

    public function authUser(): ?User
    {
        return \Auth::user();
    }

    abstract public function getNewModelInstance(): Model;

    /**
     * @return string[]
     */
    abstract public function getFillableKeys(): array;
}
