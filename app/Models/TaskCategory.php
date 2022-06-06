<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskCategory extends Model
{
    use HasFactory;

    protected $table = 'task_category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'task_id',
        'category_id'
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

        return array_filter($input, function ($v, $k) use ($fields) {
            return in_array($k, $fields);
        }, ARRAY_FILTER_USE_BOTH);
    }
}
