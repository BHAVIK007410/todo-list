<?php

namespace App\Http\Requests\Api;

/**
 * Class TodoNameUpdateRequest
 *
 * @package App\Http\Requests\Api
 */
class TodoNameUpdateRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'todo_name' => 'required|max:100|unique:todos,todo_name,' . $this->todoId . ',deleted_at',
        ];
    }
}
