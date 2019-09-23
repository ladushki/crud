<?php declare(strict_types=1);

namespace App\Http\Controllers;


use App\Http\Requests\CompanyRequest;
use App\Repositories\CompanyRepository;

class CompanyController extends Controller
{
    /**
     * @var \App\Repositories\CompanyRepository
     */
    private $repository;

    /**
     * CompanyController constructor.
     *
     * @param \App\Repositories\CompanyRepository $repository
     */
    public function __construct(CompanyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index(): \Illuminate\View\View
    {
        $companies = $this->repository->paginate();

        return view('admin.company.index', compact('companies'));
    }

    /**
     * @param \App\Http\Requests\CompanyRequest $company
     * @return \Illuminate\View\View
     */
    public function create(CompanyRequest $company): \Illuminate\View\View
    {
        return view('admin.company.create', ['form' => $company->form(route('company.store'))]);
    }

    /**
     * @param integer                           $id
     * @param \App\Http\Requests\CompanyRequest $company
     * @return \Illuminate\View\View
     */
    public function edit(int $id, CompanyRequest $company): \Illuminate\View\View
    {
        $form = $company->form(route('company.update', [$id]))->model($this->repository->show($id));
        $form->id->value($id);

        return view('admin.company.edit', ['form' => $form]);
    }

    /**
     * @param \App\Http\Requests\CompanyRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CompanyRequest $request)
    {
        $data = $request->validated();
        if (empty($data)) {
            return redirect(route('company.list'))->with('error', 'Error!');
        }
        $data['logo'] = $this->uploadLogo($request);
        $this->repository->create($data);

        return redirect(route('company.list'))->with('success', 'Success!');
    }

    /**
     * @param \App\Http\Requests\CompanyRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(CompanyRequest $request)
    {
        $data         = $request->validated();
        $id           = (int) $request->get('id');
        $uploadLogo   = $this->uploadLogo($request);
        if (!empty($uploadLogo)) {
            $data['logo'] = $uploadLogo;
        }
        if (! empty($id)) {
            $this->repository->update($data, $id);
        }

        return redirect(route('company.show', [$id]))->with('success', 'Success!');
    }

    /**
     * @param integer $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(int $id)
    {
        $company = $this->repository->show($id);

        return view('admin.company.show')->with('company', $company);
    }

    /**
     * @param \App\Http\Requests\CompanyRequest $request
     * @return string
     */
    public function uploadLogo(CompanyRequest $request): string
    {
        $imageName = '';
        if ($request->has('logo')) {
            $imageName = $request->logo->getClientOriginalName();
            $request->logo->move(storage_path('app/public'), $imageName);
        }
        return $imageName;
    }

    /**
     * @param integer $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(int $id)
    {
        $this->repository->show($id);
        $this->repository->delete($id);
        return redirect(route('company.list'));
    }
}
