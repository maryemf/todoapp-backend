<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HelpersTrait;

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
        'end_date'
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
        return $this->belongsToMany(Category::class, 'task_category', 'task_id');
    }
}
