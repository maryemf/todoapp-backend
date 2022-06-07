<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Http\Resources\TaskResource;
use App\Models\Task;

class TaskController extends BaseController
{
    /** @var TaskRepositoryInterface */
    private $repository;
    private $model;


    public function __construct(TaskRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->model = new Task();
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
            return $this->sendResponseOk(TaskResource::collection($data));
        } catch (\Illuminate\Database\QueryException $ex) {
            return $this->sendResponseError('SQL error in current operation');
        } catch (\Exception $ex) {
            return $this->sendResponseError($ex->getMessage());
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
            $req = $request->all();
            $input = $this->model->filterFields($req);

            $exist = $this->repository->validateExist('name = ? ', [$input['name']] );

            if ($exist){
                return $this->sendResponseMessage("error", "UNIQUE constraint failed");
            }
            try {
                $attach = [];
                if (isset($req['categories']) ){
                    $attach = $req['categories'];
                }
                $reg = $this->repository->create($input, $attach);

                return $this->sendResponseOk(new TaskResource($reg), 'Task created');
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
                return $this->sendResponseError("Task {$id} not found", 404);
            }
            return $this->sendResponseOk(new TaskResource($data));
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
            $req = $request->all();
            $input = $this->model->filterFields($req);

            $exist = $this->repository->validateExist( 'name = ? and id <> ?', [$input['name'], $id] );

            if ($exist){
                return $this->sendResponseError("UNIQUE constraint failed");
            }

            $attach = [];
            if (isset($req['categories']) ){
                $attach = $req['categories'];
            }

            $reg = $this->repository->update($input, $id, $attach);

            return $this->sendResponseOk(new TaskResource($reg), "Task updated");
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
                return $this->sendResponseError("Task {$id} not found", 404);
            }
            $this->repository->delete($id);
            return $this->sendResponseMessage("message", "Task deleted");
        } catch (\Illuminate\Database\QueryException $ex) {
            return $this->sendResponseError('SQL error in current operation');
        } catch (\Exception $ex) {
            return $this->sendResponseError($ex->getMessage(), 404);
        }
    }

    public function filterByCategory($id){
        try{
            $data = $this->repository->findByCategory($id);
            return $this->sendResponseOk(TaskResource::collection($data));
        } catch (\Illuminate\Database\QueryException $ex) {
            return $this->sendResponseError('SQL error in current operation');
        } catch (\Exception $ex) {
            return $this->sendResponseError($ex->getMessage(), 404);
        }
    }
}
