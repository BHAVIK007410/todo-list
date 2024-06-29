<?php

namespace App\Http\Requests\Api;

/**
 * Class TodoItemUpdateRequest
 *
 * @package App\Http\Requests\Api
 */
class TodoItemUpdateRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'list_item' => 'required|max:100|unique:todo_items,list_item,' . $this->itemId . ',deleted_at',
        ];
    }
}
