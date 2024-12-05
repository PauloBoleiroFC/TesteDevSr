<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;

class AbstractRepository
{


    /**
     * @var
     */
    protected $model;

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * @param int $id
     * @param string|null $with
     * @return mixed
     */
    public function show(int $id, string $with = null)
    {

        if(isset($with)){
            return $this->model->with($with)->findOrFail($id);
        }else{
            return $this->model->findOrFail($id);
        }

    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {

        return $this->model->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return false
     */
    public function update(int $id, array $data)
    {

        $entity = $this->model->findOrFail($id);
        if($entity) {
            return $entity->update($data);
        }else{
            return false;
        }

    }

    /**
     * @param int $id
     * @return false
     */
    public function delete(int $id)
    {

        return $this->model->findOrFail($id)->delete();

    }

}
