<?php declare(strict_types=1);

namespace App\Repositories;

use App\Employee;

class EmployeeRepository extends Repository implements RepositoryInterface
{
    /**
     * @var model property on class instances
     */
    protected $model;


    /**
     * EmployeeRepository constructor.
     * @param Employee $model
     */
    public function __construct(Employee $model)
    {
        parent::__construct($model);
    }


    /**
     * @return mixed
     */
    public function all()
    {
        return $this->model->with('company')->get();
    }

    /**
     * @return mixed
     */
    public function paginate()
    {
        $limit = config('repository.pagination.limit', 10);

        return $this->model->with('company')->orderBy('updated_at', 'desc')->paginate($limit, ['*']);
    }
}
