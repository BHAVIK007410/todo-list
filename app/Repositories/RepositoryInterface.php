<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface RepositoryInterface
 *
 * @package App\Repositories
 */
interface RepositoryInterface
{
    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param int $id
     * @return Model
     */
    public function find(int $id): ?Model;
}
