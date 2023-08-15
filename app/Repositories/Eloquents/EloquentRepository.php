<?php
namespace App\Repositories\Eloquents;

use App\Repositories\Interfaces\RepositoryInterface;

abstract class EloquentRepository implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    /**
     * get Model
     * @return string
     */
    abstract public function getModel();

    /**
     * set Model
     */
    public function setModel()
    {
        $this->model = app()->make($this->getModel());
    }

    public function all($request)
    {
        $result = $this->model->all();
        return $result;
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function update($id, $data)
    {
        return $this->model->where('id', $id)->update($data);
    }
    

    public function destroy($id)
    {
        return $this->model->where('id',$id)->delete();
    }
}