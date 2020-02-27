<?php


namespace Alcoy\Repository;


class BaseRepository implements RepositoryContract
{
    protected $model;

    protected $relationships = [];

    protected $requiredRelationships = [];

    public function __construct(){
        $this->model = app($this->model);
    }

    public function getAll($columns = null, $orderBy = 'created_at', $sort = 'desc')
    {
        $instances = $this->model->with($this->requiredRelationships)->orderBy($orderBy, $sort)->get();
        $this->reset();
        return $instances;
    }

    public function getPaginated($number = 15, $orderBy = 'created_at', $sort = 'desc')
    {
        $instances = $this->model->with($this->requiredRelationships)->orderBy($orderBy, $sort)->paginate($number);
        $this->reset();
        return $instances;
    }


    public function getById($id)
    {
        $instance = $this->model->with($this->requiredRelationships)->find($id);
        $this->reset();
        return $instance;
    }


    public function getItemByColumn($term, $column = 'slug')
    {
        $instance = $this->model->with($this->requiredRelationships)
            ->where{ucfirst($column)}($term)->first();
        $this->reset();
        return $instance;
    }


    public function getCollectionByColumn($term, $column = 'slug', $orderBy = 'created_at', $sort = 'desc')
    {
        $column = ucfirst($column);

        $instances = $this->model->with($this->requiredRelationships)
            ->${"where$column"}($term)->orderBy($orderBy, $sort)->get();
        $this->reset();
        return $instances;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }


    public function updateOrCreate(array $identifiers, array $data)
    {
        $item = $this->model->where($identifiers)->first();

        if ($item->exists()){
            $item->update($data);
        }
        else {
            $item = $this->create($data);
        }
        return $item;
    }


    public function delete($id)
    {
        return $this->model->where($this->model->getKeyName(), $id)->delete();
    }

    public function update($id, array $data)
    {
        return $this->model->where($this->model->getKeyName(), $id)->update($data);
    }

    public function with($relationships)
    {
        $this->requiredRelationships = [];

        if ($relationships == 'all') {
            $this->requiredRelationships = $this->relationships;
        } elseif (is_array($relationships)) {
            $this->requiredRelationships = array_filter($relationships, function ($value) {
                return in_array($value, $this->relationships);
            });
        } elseif (is_string($relationships)) {
            array_push($this->requiredRelationships, $relationships);
        }

        return $this;
    }

    private function reset(){
        $this->requiredRelationships = [];
    }
}