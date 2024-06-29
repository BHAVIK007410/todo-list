<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TodoItemUpdateRequest;
use App\Http\Requests\Api\TodoNameUpdateRequest;
use App\Http\Requests\Api\TodoStoreRequest;
use App\Services\TodoServices;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class TodoController
 *
 * @package App\Http\Controllers\Api
 */
class TodoController extends Controller
{
    protected TodoServices $todo;

    /**
     * __construct
     *
     * @param TodoServices $todo
     *
     * @return void
     */
    public function __construct(TodoServices $todo)
    {
        $this->todo = $todo;
    }

    /**
     * @OA\Get(
     *     path="/api/user/todos",
     *     summary="List all to dos of the logged in user",
     *     operationId="todolistsearch",
     *     security={{"x_api_key":{}, "app_lang":{}, "passport":{}}},
     *     tags={"Todo"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="test"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of user todos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=200
     *             ),
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="To dos fetched successfully."
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="current_page",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(
     *                             property="id",
     *                             type="integer",
     *                             example=1
     *                         ),
     *                         @OA\Property(
     *                             property="todo_id",
     *                             type="integer",
     *                             example=6261184744
     *                         ),
     *                         @OA\Property(
     *                             property="user_id",
     *                             type="integer",
     *                             example=930952413
     *                         ),
     *                         @OA\Property(
     *                             property="todo_name",
     *                             type="string",
     *                             example="test"
     *                         ),
     *                         @OA\Property(
     *                             property="is_archived",
     *                             type="integer",
     *                             example=0
     *                         ),
     *                         @OA\Property(
     *                             property="created_at",
     *                             type="string",
     *                             format="date-time",
     *                             example="2024-06-29T08:13:30.000000Z"
     *                         ),
     *                         @OA\Property(
     *                             property="updated_at",
     *                             type="string",
     *                             format="date-time",
     *                             example="2024-06-29T08:13:30.000000Z"
     *                         ),
     *                         @OA\Property(
     *                             property="deleted_at",
     *                             type="string",
     *                             format="date-time",
     *                             nullable=true,
     *                             example=null
     *                         ),
     *                         @OA\Property(
     *                             property="items",
     *                             type="array",
     *                             @OA\Items(
     *                                 type="object",
     *                                 @OA\Property(
     *                                     property="id",
     *                                     type="integer",
     *                                     example=1
     *                                 ),
     *                                 @OA\Property(
     *                                     property="list_id",
     *                                     type="integer",
     *                                     example=34725545444
     *                                 ),
     *                                 @OA\Property(
     *                                     property="todo_id",
     *                                     type="integer",
     *                                     example=6261184744
     *                                 ),
     *                                 @OA\Property(
     *                                     property="list_item",
     *                                     type="string",
     *                                     example="What is your nameee?"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="is_completed",
     *                                     type="integer",
     *                                     example=0
     *                                 ),
     *                                 @OA\Property(
     *                                     property="created_at",
     *                                     type="string",
     *                                     format="date-time",
     *                                     example="2024-06-29T08:13:30.000000Z"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="updated_at",
     *                                     type="string",
     *                                     format="date-time",
     *                                     example="2024-06-29T08:13:30.000000Z"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="deleted_at",
     *                                     type="string",
     *                                     format="date-time",
     *                                     nullable=true,
     *                                     example=null
     *                                 )
     *                             )
     *                         )
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="first_page_url",
     *                     type="string",
     *                     example="http://localhost:8000/api/user/todos?page=1"
     *                 ),
     *                 @OA\Property(
     *                     property="from",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="last_page",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="last_page_url",
     *                     type="string",
     *                     example="http://localhost:8000/api/user/todos?page=1"
     *                 ),
     *                 @OA\Property(
     *                     property="links",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(
     *                             property="url",
     *                             type="string",
     *                             example=null,
     *                             nullable=true
     *                         ),
     *                         @OA\Property(
     *                             property="label",
     *                             type="string",
     *                             example="&laquo; Previous"
     *                         ),
     *                         @OA\Property(
     *                             property="active",
     *                             type="boolean",
     *                             example=false
     *                         )
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="next_page_url",
     *                     type="string",
     *                     example=null,
     *                     nullable=true
     *                 ),
     *                 @OA\Property(
     *                     property="path",
     *                     type="string",
     *                     example="http://localhost:8000/api/user/todos"
     *                 ),
     *                 @OA\Property(
     *                     property="per_page",
     *                     type="integer",
     *                     example=10
     *                 ),
     *                 @OA\Property(
     *                     property="prev_page_url",
     *                     type="string",
     *                     example=null,
     *                     nullable=true
     *                 ),
     *                 @OA\Property(
     *                     property="to",
     *                     type="integer",
     *                     example=3
     *                 ),
     *                 @OA\Property(
     *                     property="total",
     *                     type="integer",
     *                     example=3
     *                 )
     *             )
     *         )
     *     ),
     * )
     *
     * @param Request $request
     * @param string $search
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $search = $request->has('search') ? $request->get('search') : '';
            return $this->todo->getTodos($user->user_id, $search);
        } catch (Exception $ex) {
            return redirect()->response([
                'status' => 500,
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/todo/{todoId}/view",
     *     summary="View specific todo by ID",
     *     security={{"x_api_key":{}, "app_lang":{}, "passport":{}}},
     *     tags={"Todo"},
     *     @OA\Parameter(
     *         name="todoId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=6261184744
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Todo fetched successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=200
     *             ),
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Todo fetched successfully."
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="todo_id",
     *                     type="integer",
     *                     example=6261184744
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer",
     *                     example=930952413
     *                 ),
     *                 @OA\Property(
     *                     property="todo_name",
     *                     type="string",
     *                     example="test"
     *                 ),
     *                 @OA\Property(
     *                     property="is_archived",
     *                     type="integer",
     *                     example=0
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     format="date-time",
     *                     example="2024-06-29T08:13:30.000000Z"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     format="date-time",
     *                     example="2024-06-29T08:13:30.000000Z"
     *                 ),
     *                 @OA\Property(
     *                     property="deleted_at",
     *                     type="string",
     *                     format="date-time",
     *                     nullable=true,
     *                     example=null
     *                 ),
     *                 @OA\Property(
     *                     property="items",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(
     *                             property="id",
     *                             type="integer",
     *                             example=1
     *                         ),
     *                         @OA\Property(
     *                             property="list_id",
     *                             type="integer",
     *                             example=34725545444
     *                         ),
     *                         @OA\Property(
     *                             property="todo_id",
     *                             type="integer",
     *                             example=6261184744
     *                         ),
     *                         @OA\Property(
     *                             property="list_item",
     *                             type="string",
     *                             example="What is your nameee?"
     *                         ),
     *                         @OA\Property(
     *                             property="is_completed",
     *                             type="integer",
     *                             example=0
     *                         ),
     *                         @OA\Property(
     *                             property="created_at",
     *                             type="string",
     *                             format="date-time",
     *                             example="2024-06-29T08:13:30.000000Z"
     *                         ),
     *                         @OA\Property(
     *                             property="updated_at",
     *                             type="string",
     *                             format="date-time",
     *                             example="2024-06-29T08:13:30.000000Z"
     *                         ),
     *                         @OA\Property(
     *                             property="deleted_at",
     *                             type="string",
     *                             format="date-time",
     *                             nullable=true,
     *                             example=null
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     * )
     *
     * @param int $todoId
     *
     * @return JsonResponse
     */
    public function view(int $todoId): JsonResponse
    {
        try {
            return $this->todo->getTodo($todoId);
        } catch (Exception $ex) {
            return redirect()->response([
                'status' => 500,
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/create/todo",
     *     summary="Create a new todo",
     *     security={{"x_api_key":{}, "app_lang":{}, "passport":{}}},
     *     tags={"Todo"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="todo_name",
     *                 type="string",
     *                 example="test1"
     *             ),
     *             @OA\Property(
     *                 property="list",
     *                 type="object",
     *                 @OA\Property(
     *                     property="0",
     *                     type="string",
     *                     example="Email follow up for projects"
     *                 ),
     *                  @OA\Property(
     *                     property="1",
     *                     type="string",
     *                     example="Check the new task"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Todo List created successfully."),
     *         )
     *     ),
     * )
     *
     * @param TodoStoreRequest $request
     *
     * @return JsonResponse
     */
    public function store(TodoStoreRequest $request): JsonResponse
    {
        try {
            $todoData = $request->validated();
            $user = $request->user();
            return $this->todo->store($user->user_id, $todoData);
        } catch (Exception $ex) {
            return redirect()->response([
                'status' => 500,
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }
    }

    /**
     * @OA\Patch(
     *     path="/api/todo/{todoId}/update",
     *     summary="Update specific todo by ID",
     *     tags={"Todo"},
     *     security={{"x_api_key":{}, "app_lang":{}, "passport":{}}},
     *     @OA\Parameter(
     *         name="todoId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=6261184744
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="todo_name",
     *                 type="string",
     *                 example="testa1a"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Todo updated successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=200
     *             ),
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Todo updated successfully."
     *             ),
     *         )
     *     ),
     * )
     *
     * @param int $todoId
     * @param TodoNameUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function todoUpdate(int $todoId, TodoNameUpdateRequest $request): JsonResponse
    {
        try {
            $todoData = $request->validated();
            return $this->todo->todoUpdate($todoId, $todoData);
        } catch (Exception $ex) {
            return redirect()->response([
                'status' => 500,
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }
    }

    /**
     * @OA\Patch(
     *     path="/api/todo/item/{itemId}/update",
     *     summary="Update specific todo by ID",
     *     tags={"Todo"},
     *     security={{"x_api_key":{}, "app_lang":{}, "passport":{}}},
     *     @OA\Parameter(
     *         name="itemId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=34725545444
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="list_item",
     *                 type="string",
     *                 example="What is your nameeessss?"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Todo item updated successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=200
     *             ),
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Todo item updated successfully.",
     *             ),
     *         )
     *     ),
     * )
     *
     * @param int $itemId
     * @param TodoItemUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function todoItemUpdate(int $itemId, TodoItemUpdateRequest $request): JsonResponse
    {
        try {
            $todoItemData = $request->validated();
            return $this->todo->todoItemUpdate($itemId, $todoItemData);
        } catch (Exception $ex) {
            return redirect()->response([
                'status' => 500,
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }
    }

    /**
     *  @OA\Delete(
     *     path="/api/todo/{todoId}/delete",
     *     summary="delete a todo by ID",
     *     security={{"x_api_key":{}, "app_lang":{}, "passport":{}}},
     *     tags={"Todo"},
     *     @OA\Parameter(
     *         name="todoId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=6261184744
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="To do deleted successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=200
     *             ),
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="To do deleted successfully."
     *             ),
     *         )
     *     ),
     * )
     *
     * @param int $todoId
     *
     * @return JsonResponse
     */
    public function todoDelete(int $todoId): JsonResponse
    {
        try {
            return $this->todo->todoDelete($todoId);
        } catch (Exception $ex) {
            return redirect()->response([
                'status' => 500,
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }
    }

    /**
     *  @OA\Delete(
     *     path="/api/todo/item/{list_id}/delete",
     *     summary="delete a todo by ID",
     *     security={{"x_api_key":{}, "app_lang":{}, "passport":{}}},
     *     tags={"Todo"},
     *     @OA\Parameter(
     *         name="list_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=34725545444
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="To do item deleted successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=200
     *             ),
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="To do item deleted successfully."
     *             ),
     *         )
     *     ),
     * )
     *
     * @param int $itemId
     *
     * @return JsonResponse
     */
    public function todoItemDelete(int $itemId): JsonResponse
    {
        try {
            return $this->todo->todoItemDelete($itemId);
        } catch (Exception $ex) {
            return redirect()->response([
                'status' => 500,
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }
    }

    /**
     * @OA\Patch(
     *     path="/api/todo/{todoId}/archieve",
     *     summary="Archive a todo item by ID",
     *     security={{"x_api_key":{}, "app_lang":{}, "passport":{}}},
     *     tags={"Todo"},
     *     @OA\Parameter(
     *         name="todoId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=6261184744
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Todo item archived successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=200
     *             ),
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Todo item archived successfully."
     *             ),
     *         )
     *     ),
     * )
     *
     * @param int $todoId
     *
     * @return JsonResponse
     */
    public function todoArchieve(int $todoId): JsonResponse
    {
        try {
            return $this->todo->todoArchieve($todoId, 1);
        } catch (Exception $ex) {
            return redirect()->response([
                'status' => 500,
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }
    }

    /**
     *  @OA\Patch(
     *     path="/api/todo/{todoId}/unarchieve",
     *     summary="Unarchive a todo item by ID",
     *     security={{"x_api_key":{}, "app_lang":{}, "passport":{}}},
     *     tags={"Todo"},
     *     @OA\Parameter(
     *         name="todoId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=6261184744
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Todo item unarchieved successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=200
     *             ),
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Todo item unarchieved successfully."
     *             ),
     *         )
     *     ),
     * )
     *
     * @param int $todoId
     *
     * @return JsonResponse
     */
    public function todoUnarchieve(int $todoId): JsonResponse
    {
        try {
            return $this->todo->todoArchieve($todoId);
        } catch (Exception $ex) {
            return redirect()->response([
                'status' => 500,
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }
    }

    /**
     * @OA\Patch(
     *     path="/api/todo/item/{itemId}/mark-complete",
     *     summary="mark complete a todo item by ID",
     *     security={{"x_api_key":{}, "app_lang":{}, "passport":{}}},
     *     tags={"Todo"},
     *     @OA\Parameter(
     *         name="itemId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=36151430765
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Todo item completed successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 example=200
     *             ),
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Todo item completed successfully."
     *             ),
     *         )
     *     ),
     * )
     *
     * @param int $itemId
     *
     * @return JsonResponse
     */
    public function todoItemComplete(int $itemId): JsonResponse
    {
        try {
            return $this->todo->todoItemComplete($itemId);
        } catch (Exception $ex) {
            return redirect()->response([
                'status' => 500,
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }
    }
}
