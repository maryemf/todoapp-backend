<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HelpersTrait;


/**
 *
 * @OA\Schema(
 * required={"name"},
 * @OA\Xml(name="Task"),
 * @OA\Property(property="name", type="string",  description="task name", example="Task 1"),
 * @OA\Property(property="description", type="string",  description="task description", example="This is a example task"),
 * @OA\Property(property="is_complete", type="boolean",  description="Task completed or not", example="false"),
 * @OA\Property(property="start_date", type="string", format="date-time", description="Start date for task"),
 * @OA\Property(property="end_date", type="string", format="date-time", description="End date for task"),
 * @OA\Property(property="completed_date", type="string", format="date-time", description="Date on completed task"), *
 * @OA\Property(property="created_at", ref="#/components/schemas/BaseModel/properties/created_at"),
 * @OA\Property(property="updated_at", ref="#/components/schemas/BaseModel/properties/updated_at"),
 * @OA\Property(property="deleted_at", ref="#/components/schemas/BaseModel/properties/deleted_at")
 * )
 *
 * Class Task
 *
 */
class Task extends Model
{
    use HasFactory, HelpersTrait;

    protected $table = 'task';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'is_complete',
        'completed_date'
    ];


    /**
     * Get only available fields
     *
     * @param  array  $input
     * @return array
     */
    public function filterFields(array $input)
    {
        $fields = $this->fillable;
        return $this->filterInputFields($fields, $input);
    }


    /**
     * The categories that belong to the task.
     */

    public function categories()
    {
        return $this->belongsToMany(Task::class, 'task_task', 'task_id');
    }
}
