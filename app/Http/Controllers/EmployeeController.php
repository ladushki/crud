<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\EmployeeRequest;
use App\Repositories\CompanyRepository;
use App\Repositories\EmployeeRepository;

class EmployeeController extends Controller
{
    /**
     * @var EmployeeRepository
     */
    private $repository;

    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * EmployeeController constructor.
     * @param EmployeeRepository $repository
     * @param CompanyRepository  $companyRepository
     */
    public function __construct(EmployeeRepository $repository, CompanyRepository $companyRepository)
    {
        $this->repository        = $repository;
        $this->companyRepository = $companyRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $employees = $this->repository->paginate();

        return view('admin.employee.index', compact('employees'));
    }

    /**
     * @param EmployeeRequest $employee
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(EmployeeRequest $employee)
    {
        $form = $employee->form(route('employee.store'));
        $form->company_id->options($this->companyRepository->getList());

        return view('admin.employee.create', ['form' => $form]);
    }


    /**
     * @param integer         $id
     * @param EmployeeRequest $employee
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id, EmployeeRequest $employee)
    {
        $form = $employee->form(route('employee.update', [$id]))->model($this->repository->show($id));
        $form->id->value($id);
        $form->company_id->options($this->companyRepository->getList());

        return view('admin.employee.edit', ['form' => $form]);
    }

    /**
     * @param EmployeeRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(EmployeeRequest $request)
    {
        $data = $request->validated();
        $this->repository->create($data);

        return redirect(route('employee.list'))->with('success', 'Success!');
    }

    /**
     * @param EmployeeRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(EmployeeRequest $request)
    {
        $data = $request->validated();
        $id   = (int) $request->get('id');
        if (empty($id)) {
            return redirect(route('employee.list'));
        }
        $this->repository->update($data, $id);

        return redirect(route('employee.show', [$id]))->with('success', 'Success!');
    }

    /**
     * @param integer $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(int $id)
    {
        $employee = $this->repository->show($id);

        return view('admin.employee.show')->with('employee', $employee);
    }

    /**
     * @param integer $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(int $id)
    {
        $employee = $this->repository->findWithoutFail($id);
        if (empty($employee)) {
            return redirect(route('employee.list'));
        }
        $this->repository->delete($id);

        return redirect(route('employee.list'));
    }
}
