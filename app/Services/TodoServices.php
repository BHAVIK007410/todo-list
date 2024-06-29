<?php

namespace App\Services;

use App\Repositories\TodoItemsRepository;
use App\Repositories\TodoRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * Class TodoServices
 *
 * @package App\Services
 */
class TodoServices
{
    protected TodoRepository $todo;
    protected TodoItemsRepository $item;

    /**
     * __construct
     *
     * @param TodoRepository $todo [explicite description]
     * @param TodoItemsRepository $item [explicite description]
     *
     * @return void
     */
    public function __construct(TodoRepository $todo, TodoItemsRepository $item)
    {
        $this->todo = $todo;
        $this->item = $item;
    }

    /**
     * getTodos
     *
     * @param int $userId
     * @param string $search
     *
     * @return JsonResponse
     */
    public function getTodos(int $userId, string $search): JsonResponse
    {
        try {
            $todos =  $this->todo->getTodos($userId, $search);

            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => __('messages.todo_success'),
                'data' => $todos
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }

    /**
     * getTodo
     *
     * @param int $todoId
     *
     * @return JsonResponse
     */
    public function getTodo(int $todoId): JsonResponse
    {
        try {
            $todos =  $this->todo->getTodo($todoId);

            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => __('messages.todo_success'),
                'data' => $todos
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }

    /**
     * store
     *
     * @param int $userId
     * @param array $todoData
     *
     * @return JsonResponse
     */
    public function store(int $userId, array $todoData): JsonResponse
    {
        try {
            DB::beginTransaction();
            $todoId = substr(0, 6, time()) . rand(1111111111, 99999999999);
            $storeData = [
                'todo_id' => $todoId,
                'user_id' => $userId,
                'todo_name' => $todoData['todo_name'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ];

            $storeTodo = $this->todo->store($storeData);
            $itemData = [];

            foreach ($todoData['list'] as $items) {
                $itemData[] = [
                    'list_id' => substr(0, 6, time()) . rand(1111111111, 99999999999),
                    'todo_id' => $todoId,
                    'list_item' => $items,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ];
            }

            $storeItem = $this->item->store($itemData);
            if ($storeTodo && $storeItem) {
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'success' => true,
                    'message' => __('messages.todo_created'),
                ], 200);
            }

            return response()->json([
                'status' => 400,
                'success' => false,
                'message' => __('messages.todo_create_failed'),
            ], 200);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }

    /**
     * to do Update
     *
     * @param int $todoId
     * @param array $todoData
     *
     * @return JsonResponse
     */
    public function todoUpdate(int $todoId, array $todoData): JsonResponse
    {
        try {
            $updateTodo = $this->todo->todoUpdate($todoId, $todoData);
            if ($updateTodo) {
                return response()->json([
                    'status' => 200,
                    'success' => true,
                    'message' => __('messages.todo_updated'),
                ], 200);
            }

            return response()->json([
                'status' => 400,
                'success' => false,
                'message' => __('messages.todo_update_failed'),
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }

    /**
     * to do Item Update
     *
     * @param int $itemId
     * @param array $itemData
     *
     * @return JsonResponse
     */
    public function todoItemUpdate(int $itemId, array $itemData): JsonResponse
    {
        try {
            $updateTodoItem = $this->item->todoItemUpdate($itemId, $itemData);
            if ($updateTodoItem) {
                return response()->json([
                    'status' => 200,
                    'success' => true,
                    'message' => __('messages.todo_item_updated'),
                ], 200);
            }

            return response()->json([
                'status' => 400,
                'success' => false,
                'message' => __('messages.todo_item_update_failed'),
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }

    /**
     * to do Update
     *
     * @param int $todoId
     *
     * @return JsonResponse
     */
    public function todoDelete(int $todoId): JsonResponse
    {
        try {
            DB::beginTransaction();
            $deleteTodo = $this->todo->todoDelete($todoId);
            $deleteTodoItems = $this->item->todoItemsDelete($todoId);
            if ($deleteTodo && $deleteTodoItems) {
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'success' => true,
                    'message' => __('messages.todo_deleted'),
                ], 200);
            }

            return response()->json([
                'status' => 400,
                'success' => false,
                'message' => __('messages.todo_delete_failed'),
            ], 200);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }

    /**
     * to do Item Update
     *
     * @param int $itemId
     *
     * @return JsonResponse
     */
    public function todoItemDelete(int $itemId): JsonResponse
    {
        try {
            $deleteTodoItem = $this->item->todoItemDelete($itemId);
            if ($deleteTodoItem) {
                return response()->json([
                    'status' => 200,
                    'success' => true,
                    'message' => __('messages.todo_item_delete'),
                ], 200);
            }

            return response()->json([
                'status' => 400,
                'success' => false,
                'message' => __('messages.todo_item_delete_failed'),
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }

    /**
     * to do Item Update
     *
     * @param int $todoId
     * @param int $flag
     *
     * @return JsonResponse
     */
    public function todoArchieve(int $todoId, int $flag = 0): JsonResponse
    {
        try {
            $message = $flag == 1 ? __('messages.todo_archieve') : __('messages.todo_unarchieve');
            $archieveTodo = $this->todo->todoArchieve($todoId, $flag);
            if ($archieveTodo) {
                return response()->json([
                    'status' => 200,
                    'success' => true,
                    'message' => $message,
                ], 200);
            }

            return response()->json([
                'status' => 400,
                'success' => false,
                'message' => __('messages.todo_archieve_failed'),
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }

    /**
     * to do Item Complete
     *
     * @param int $todoId
     *
     * @return JsonResponse
     */
    public function todoItemComplete(int $todoId): JsonResponse
    {
        try {
            $archieveTodo = $this->item->todoItemComplete($todoId);
            if ($archieveTodo) {
                return response()->json([
                    'status' => 200,
                    'success' => true,
                    'message' => __('messages.todo_item_complete'),
                ], 200);
            }

            return response()->json([
                'status' => 400,
                'success' => false,
                'message' => __('messages.todo_item_complete_failed'),
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }
}
