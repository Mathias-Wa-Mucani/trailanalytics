<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Interface EloquentRepositoryInterface
 * @package App\Repositories
 */
interface RepositoryInterface
{
    public function all(): Collection;
    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param $id
     * @return Model
     */
    public function find($id): ?Model;

    /**
     * @param array $attributes
     * @return Model
     */
    // public function update(array $attributes): Model;

    /**
     * @param $id
     */
    public function update(array $data, $id);

    /**
     * @param $id
     */
    public function delete($id);
}
