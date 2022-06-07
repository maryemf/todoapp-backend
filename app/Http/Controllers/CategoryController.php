<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\TaskCategory;

class CategoryController extends BaseController
{
    /** @var CategoryRepositoryInterface */
    private $repository;
    private $model;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->model = new Category();
    }

    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        try{
            $data = $this->repository->all();
            return $this->sendResponseOk(CategoryResource::collection($data));
        } catch (\Illuminate\Database\QueryException $ex) {
            return $this->sendResponseError('SQL error in current operation');
        } catch (\Exception $ex) {
            return $this->sendResponseError($ex->getMessage(), 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function store(Request $request)
    {
        try{
            $input = $this->model->filterFields($request->all());
            $input['color'] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);

            $exist = $this->repository->validateExist('name = ? ', [$input['name']] );

            if ($exist){
                return $this->sendResponseError( "UNIQUE constraint failed");
            }
            try {
                $reg = $this->repository->create($input);
                return $this->sendResponseOk(new CategoryResource($reg), 'Category created');
            } catch (\Illuminate\Database\QueryException $ex) {
                return $this->sendResponseError('SQL error in current operation');
            } catch (\Exception $ex) {
                return $this->sendResponseError($ex->getMessage());
            }
        } catch (\Exception $ex) {
            return $this->sendResponseError($ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return string
     */
    public function show($id)
    {
        try {
            $data = $this->repository->find($id);

            if (!$data){
                return $this->sendResponseError("Category {$id} not found", 404);
            }
            return $this->sendResponseOk(new CategoryResource($data));
        } catch (\Illuminate\Database\QueryException $ex) {
            return $this->sendResponseError('SQL error in current operation');
        } catch (\Exception $ex) {
            return $this->sendResponseError($ex->getMessage(), 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return string
     */
    public function update(Request $request, $id)
    {
        try {
            $input = $this->model->filterFields($request->all());

            $exist = $this->repository->validateExist( 'name = ? and id <> ?', [$input['name'], $id] );

            if ($exist){
                return $this->sendResponseError("UNIQUE constraint failed");
            }

            $reg = $this->repository->update($input, $id);

            return $this->sendResponseOk(new CategoryResource($reg), "Category updated");
        } catch (\Illuminate\Database\QueryException $ex) {
            return $this->sendResponseError('SQL error in current operation');
        } catch (\Exception $ex) {
            return $this->sendResponseError($ex->getMessage(), 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return string
     */
    public function destroy($id)
    {
        try {
            $reg = $this->repository->find($id);
            if (!$reg){
                return $this->sendResponseError("Category {$id} not found", 404);
            }
            $related = TaskCategory::where('category_id', $id)->first();
            if ($related){
                return $this->sendResponseError('Integrity relationship violated');
            }
            $this->repository->delete($id);
            return $this->sendResponseMessage("message", "Category deleted");
        } catch (\Illuminate\Database\QueryException $ex) {
            return $this->sendResponseError('SQL error in current operation');
        } catch (\Exception $ex) {
            return $this->sendResponseError($ex->getMessage(), 404);
        }
    }
}
