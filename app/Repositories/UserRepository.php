<?php

namespace App\Repositories;

use App\Models\User;

/**
 * Class UserRepository
 *
 * @package App\Repositories
 */
class UserRepository extends BaseRepository
{
    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
