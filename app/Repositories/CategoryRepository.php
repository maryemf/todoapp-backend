<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryRepository implements CategoryRepositoryInterface
{

	protected $model;

    /**
     * CategoryRepository constructor.
     *
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $this->model->where('id', $id)->update($data);
        return $this->find($id);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function find($id)
    {
        if (null == $category = $this->model->find($id)) {
            throw new ModelNotFoundException("Category {$id} not found");
        }

        return $category;
    }


    public function validateExist($where, $values) {
        $exist = $this->model->whereRaw($where, $values)->get();

        if (!$exist->isEmpty()){
            return true;
        }

        return false;
    }
}
