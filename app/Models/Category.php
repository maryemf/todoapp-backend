<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HelpersTrait;

class Category extends Model
{
    use HasFactory, HelpersTrait;

    protected $table = 'category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'color'
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
     * The tasks that belong to the category.
    */
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_category', 'category_id');
    }
}
