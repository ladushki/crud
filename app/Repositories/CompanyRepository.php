<?php


namespace App\Repositories;

use App\Company;

class CompanyRepository extends Repository implements RepositoryInterface
{

    // Constructor to bind model to repo
    public function __construct(Company $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    // Get all instances of model
    public function all()
    {
        return $this->model->withCount('employees')->orderBy('created_at', 'desc')->get();
    }

    public function paginate()
    {
        $limit = config('repository.pagination.limit', 10);
        return $this->model->withCount('employees')->orderBy('created_at', 'desc')->paginate($limit, ['*']);
    }

    public function getList()
    {
        return $this->model->all()->pluck('name', 'id');
    }
}
