<?php

namespace App\Http\Requests\Api;

/**
 * Class TodoStoreRequest
 *
 * @package App\Http\Requests\Api
 */
class TodoStoreRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'todo_name' => 'required|max:100|unique:todos,todo_name,null,deleted_at',
            'list' => 'required',
            'list.0' => 'required|min:6|max:100',
        ];
    }
}
