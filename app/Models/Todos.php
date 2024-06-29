<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Todos
 *
 * @package App\Models
 */
class Todos extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'todo_id',
        'todo_name',
        'is_archived',
    ];

    /**
     * items
     */
    public function items()
    {
        return $this->hasMany(TodoItems::class, 'todo_id', 'todo_id');
    }
}
