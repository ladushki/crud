<?php declare(strict_types=1);

namespace App\Repositories;


abstract class Repository implements RepositoryInterface
{

    /**
     * model property on class instances
     * @var
     */
    protected $model;

    /**
     * Constructor to bind model to repo
     * Repository constructor.
     *
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Get all instances of model
     * @return mixed
     */
    public function all()
    {
        return $this->model->all();
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
     *  update record in the database
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $record = $this->show($id);
        return $record->update($data);
    }


    /**
     * remove record from the database
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }


    /**
     * show the record with the given id
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }


    /**
     * Get the associated model
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }


    /**
     * Set the associated model
     * @param $model
     * @return Repository
     */
    public function setModel($model): Repository
    {
        $this->model = $model;
        return $this;
    }


    /**
     * Eager load database relationships
     * @param $relations
     * @return mixed
     */
    public function with($relations)
    {
        return $this->model->with($relations);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed|void
     */
    public function findWithoutFail($id, $columns = ['*'])
    {
        try {
            return $this->show($id, $columns);
        } catch (Exception $e) {
            return;
        }
    }
}
