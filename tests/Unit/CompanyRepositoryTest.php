<?php
/**
 * Created by PhpStorm.
 * User: larissa
 * Date: 2019-09-21
 * Time: 14:20
 */

namespace Tests\Unit;

use App\Company;
use App\Repositories\CompanyRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CompanyRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    public function test_find()
    {
        $item = factory(Company::class)->create();
        $repository = new CompanyRepository(new Company());
        $found = $repository->show($item->id);
        $this->assertEquals($item->name, $found->name);
    }

    public function test_paginate()
    {
        $items = factory(Company::class, 2)->create();
        $repository = new CompanyRepository(new Company());
        $found = $repository->paginate();
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $found);
    }

    public function test_update()
    {
        $item = factory(Company::class)->create();
        $repository = new CompanyRepository(new Company());
        $repository->update(['name'=>'test'],$item->id);
        $found = $repository->show($item->id);
        $this->assertEquals( 'test', $found->name);
    }

    public function test_all()
    {
        $items = factory(Company::class, 2)->create();
        $repository = new CompanyRepository(new Company());
        $found = $repository->all();
        $this->assertEquals(2, $found->count());
        $this->assertArrayHasKey('employees_count', $found->toArray()[0]);
        $this->assertEquals(0, $found->toArray()[0]['employees_count']);
    }

    public function test_show()
    {
        $item = factory(Company::class)->create();
        $repository = new CompanyRepository(new Company());
        $found = $repository->show($item->id);
        $this->assertEquals($item->name, $found->name);
    }

    public function test_delete()
    {
        $item = factory(Company::class)->create();
        $repository = new CompanyRepository(new Company());
        $repository->delete($item->id);
        $this->assertDatabaseMissing('companies', $item->toArray());
    }

    public function test_get_list()
    {
        $item = factory(Company::class)->create(['name'=>'test']);
        $repository = new CompanyRepository(new Company());
        $found = $repository->getList();

        $this->assertEquals(['1'=>'test'], $found->toArray());
    }

    public function test_create()
    {
        $item = ['name'=>'test'];
        $repository = new CompanyRepository(new Company());
        $repository->create($item);
        $this->assertDatabaseHas('companies', $item);
    }
}
