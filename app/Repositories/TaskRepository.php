<?php

namespace App\Repositories;

use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskRepository implements TaskRepositoryInterface
{

	protected $model;

    /**
     * TaskRepository constructor.
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->model = $task;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data, array $attach = [])
    {
        $reg = $this->model->create($data);
        if (count($attach) > 0){
            $reg->categories()->sync($attach);
        }
        return $reg;
    }

    public function update(array $data, $id, $attach = [])
    {
        $this->model->where('id', $id)->update($data);
        if (count($attach) > 0){
            $this->find($id)->categories()->sync($attach);
        }
        return $this->find($id);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function find($id)
    {
        if (null == $task = $this->model->find($id)) {
            throw new ModelNotFoundException("Task {$id} not found");
        }

        return $task;
    }


    public function validateExist($where, $values) {
        $exist = $this->model->whereRaw($where, $values)->get();

        if (!$exist->isEmpty()){
            return true;
        }

        return false;
    }


    public function findByCategory($id)
    {
        $tasks = $this->model->with(['categories' => function ($query) use ($id) {
            $query->where('category_id', $id);
        }])->get();

        return $tasks;
    }
}
