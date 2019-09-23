<?php

namespace Tests\Unit;

use App\Company;
use App\Employee;
use App\Repositories\EmployeeRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

/**
 * @property  company
 */
class EmployeeRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    private $company;

    public function setUp(): void
    {
        parent::setUp();
        $this->company = factory(Company::class)->create();
    }

    public function test_find()
    {
        $item = factory(Employee::class)->create(['company_id'=>$this->company->id]);
        $repository = new EmployeeRepository(new Employee());
        $found = $repository->show($item->id);
        $this->assertEquals($item->name, $found->name);
    }

    public function test_paginate()
    {
        $items = factory(Employee::class, 2)->create(['company_id'=>$this->company->id]);
        $repository = new EmployeeRepository(new Employee());
        $found = $repository->paginate();
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $found);
    }

    public function test_update()
    {
        $item = factory(Employee::class)->create(['company_id'=>$this->company->id]);
        $repository = new EmployeeRepository(new Employee());
        $repository->update(['first_name'=>'Test', 'last_name' => 'Smith'],$item->id);
        $found = $repository->show($item->id);
        $this->assertEquals( 'Test Smith', $found->name);
        $this->assertEquals( 'Smith', $found->last_name);
        $this->assertEquals( 'Test', $found->first_name);
    }

    public function test_all()
    {
        $items = factory(Employee::class, 2)->create(['company_id'=>$this->company->id]);
        $repository = new EmployeeRepository(new Employee());
        $found = $repository->all();
        $this->assertEquals(2, $found->count());
    }

    public function test_show()
    {
        $item = factory(Employee::class)->create(['company_id'=>$this->company->id]);
        $repository = new EmployeeRepository(new Employee());
        $found = $repository->show($item->id);
        $this->assertEquals($item->name, $found->name);
    }

    public function test_delete()
    {
        $item = factory(Employee::class)->create(['company_id'=>$this->company->id]);
        $repository = new EmployeeRepository(new Employee());
        $repository->delete($item->id);
        $this->assertDatabaseMissing('companies', $item->toArray());
    }

    public function test_create()
    {
        $item = ['first_name'=>'test', 'last_name'=>'smith', 'company_id'=>$this->company->id];
        $repository = new EmployeeRepository(new Employee());
        $repository->create($item);
        $this->assertDatabaseHas('employees', $item);
    }
}
