<?php
/**
 * Created by PhpStorm.
 * User: larissa
 * Date: 2019-09-21
 * Time: 14:38
 */

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Company;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class CompanyControllerTest extends TestCase
{
    use DatabaseMigrations;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    public function testUpdate()
    {
        $items = factory(Company::class, 2)->create();
        Storage::fake('public');

        $response = $this->actingAs($this->user)->json('post', '/admin/company/update/' . $items[0]->id, [
            'name' => 'test',
            'id' => $items[0]->id,
        ])->assertRedirect('/admin/company/show/' . $items[0]->id);

    }

    public function test_edit()
    {
        $item = factory(Company::class)->create();

        $response = $this->actingAs($this->user)->get('/admin/company/edit/' . $item->id);
        $response->assertViewHas('form')->assertSee($item->name)->assertSee('Back');
    }

    public function test_store()
    {
        $company = factory(Company::class)->create();
        $this->actingAs($this->user)->post('/admin/company/store', $company->toArray());
        $this->assertEquals(1, Company::all()->count());
    }

    public function test_validation()
    {
        $this->actingAs($this->user)->put('/admin/company/store')->assertRedirect();
    }

    public function test_create()
    {
        $this->actingAs($this->user)->get('/admin/company/create')->assertSee('Name')->assertSee('Logo')->assertSee('Website');
    }

    public function test_fails_upload_logo()
    {
        Storage::fake('public');

        $response = $this->actingAs($this->user)->json('post', '/admin/company/store', [
            'logo' => $file = UploadedFile::fake()->image('random.jpg'),
            'name' => 'test',
        ]);
        $response->assertJsonValidationErrors(['logo']);
        Storage::disk('public')->assertMissing('random.jpg');
    }

    public function test_fails_validation()
    {
        Storage::fake('public');

        $response = $this->actingAs($this->user)->json('post', '/admin/company/store', [
            'logo' => $file = UploadedFile::fake()->image('random.text'),
        ]);
        $response->assertJsonValidationErrors(['logo']);
        $response->assertJsonValidationErrors(['name']);
        Storage::disk('public')->assertMissing('random.text');
    }

    public function test_upload_logo()
    {
        Storage::fake('app/public');
        $response = $this->actingAs($this->user)->post('/admin/company/store', [
            'logo' => $file = UploadedFile::fake()->image('random1.jpg', 100, 100),
            'name' => 'test',
        ]);
        Storage::disk('public')->assertExists('random1.jpg');
        Storage::disk('public')->assertMissing(time() . 'missing.jpg');
    }

    public function test_destroy()
    {
        $item = factory(Company::class)->create();

        $response = $this->actingAs($this->user)->delete('/admin/company/destroy/' . $item->id);
        $this->assertDatabaseMissing('companies', ['id' => $item->id]);
        $response->assertRedirect();
    }

    public function test_fails_destroy()
    {
        $response = $this->actingAs($this->user)->delete('/admin/company/destroy/1000');
        $response->assertStatus(404);
    }

    public function test_index()
    {
        $items = factory(Company::class, 2)->create();
        $response = $this->actingAs($this->user)->get('/admin/companies');
        $response->assertViewHas('companies');
    }

    public function test_index_paginnated()
    {
        Config::set('repository.pagination.limit', 1);
        $items = factory(Company::class, 2)->create();
        $response = $this->actingAs($this->user)->get('/admin/companies');
        $response->assertSeeText('&rsaquo;');
    }

    public function test_show()
    {
        $item = factory(Company::class)->create();
        $response = $this->actingAs($this->user)->get('/admin/company/show/' . $item->id);
        $response->assertViewHas('company')->assertSee($item->name)->assertSee('Back');
    }

    public function test_show_fails()
    {
        $item = factory(Company::class)->create();
        $response = $this->actingAs($this->user)->get('/admin/company/show/10000');
        $response->assertStatus(404);
    }
}
