<?php

namespace App\Repositories;

use App\Models\Todos;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class TodoRepository
 *
 * @package App\Repositories
 */
class TodoRepository extends BaseRepository
{
    /**
     * constructor.
     *
     * @param Todos $model
     */
    public function __construct(Todos $model)
    {
        parent::__construct($model);
    }

    /**
     * getTodos
     *
     * @param int $userId
     * @param string $search
     *
     * @return object
     */
    public function getTodos(int $userId, string $search): object
    {
        $query = $this->model->where('user_id', $userId)->with('items');
        if ($search != '') {
            $query->where('todo_name', 'LIKE', "%{$search}%");
        }

        return $query->paginate(10);
    }

    /**
     * getTodo
     *
     * @param int $todoId
     *
     * @return object
     */
    public function getTodo(int $todoId): object
    {
        return $this->model->where('todo_id', $todoId)->with('items')->first();
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
        $store = $this->model->create($storeData);
        if ($store) {
            return true;
        }

        return false;
    }

    /**
     * to do Update
     *
     * @param int $todoId
     * @param array $todoData
     *
     * @return bool
     */
    public function todoUpdate(int $todoId, array $todoData): bool
    {
        $update = $this->model->where('todo_id', $todoId)->update(['todo_name' => $todoData['todo_name']]);
        if ($update) {
            return true;
        }

        return false;
    }

    /**
     * to do Update
     *
     * @param int $todoId
     *
     * @return bool
     */
    public function todoDelete(int $todoId): bool
    {
        $delete = $this->model->where('todo_id', $todoId)->delete();
        if ($delete) {
            return true;
        }

        return false;
    }

    /**
     * to do archive
     *
     * @param int $todoId
     * @param int $flag
     *
     * @return bool
     */
    public function todoArchieve(int $todoId, int $flag): bool
    {
        $update = $this->model->where('todo_id', $todoId)->update(['is_archived' => $flag]);
        if ($update) {
            return true;
        }

        return false;
    }
}
