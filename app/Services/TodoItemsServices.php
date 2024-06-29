<?php

namespace App\Services;

use App\Repositories\TodoItemsRepository;
use App\Repositories\UserRepository;

/**
 * Class TodoItemsServices
 *
 * @package App\Services
 */
class TodoItemsServices
{
    protected TodoItemsRepository $item;

    /**
     * __construct
     *
     * @param TodoItemsRepository $item
     *
     * @return void
     */
    public function __construct(TodoItemsRepository $item)
    {
        $this->item = $item;
    }
}
