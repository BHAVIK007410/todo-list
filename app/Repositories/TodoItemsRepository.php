<?php

namespace App\Repositories;

use App\Models\TodoItems;

/**
 * Class TodoItemsRepo *
ry
 *


 * @package App\Repositories
 */
class TodoItemsRepository extends BaseRepository
{
    /**
     * constructor.
     *
     * @param TodoItems $model
     */
    public function __construct(TodoItems $model)
    {
        parent::__construct($model);
    }

    /**
     * store
     *
     * @param array $storeData
     *
     * @return bool
     */
    public function store(array $storeData): bool
    {
        $store = $this->model->insert($storeData);
        if ($store) {
            return true;
        }

        return false;
    }

    /**
     * to do item Update
     *
     * @param int $itemId
     * @param array $itemData
     *
     * @return bool
     */
    public function todoItemUpdate(int $itemId, array $itemData): bool
    {
        $update = $this->model->where('list_id', $itemId)->update(['list_item' => $itemData['list_item']]);
        if ($update) {
            return true;
        }

        return false;
    }

    /**
     * to do item Update
     *
     * @param int $itemId
     *
     * @return bool
     */
    public function todoItemDelete(int $itemId): bool
    {
        $delete = $this->model->where('list_id', $itemId)->where('is_completed', '!=', 1)->delete();
        if ($delete) {
            return true;
        }

        return false;
    }

    /**
     * to do item mark complete
     *
     * @param int $itemId
     *
     * @return bool
     */
    public function todoItemComplete(int $itemId): bool
    {
        $update = $this->model->where('list_id', $itemId)->where('is_completed', '!=', 1)->update(['is_completed' => 1]);
        if ($update) {
            return true;
        }

        return false;
    }

    /**
     * to do Items Delete
     *
     * @param int $todoId
     *
     * @return bool
     */
    public function todoItemsDelete(int $todoId): bool
    {
        $update = $this->model->where('todo_id', $todoId)->delete();
        if ($update) {
            return true;
        }

        return false;
    }
}
