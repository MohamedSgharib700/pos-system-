<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Modules\Branch\Entities\Branch;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BranchTest extends TestCase
{
    protected static $admin;

    public function setUp(): void
    {
        parent::setUp();
        static::$admin = Admin::first();
    }

    public function test_store_branch()
    {
        $branch = Branch::newFactory()->create();

        $this->actingAs(static::$admin, 'admin');

        $this->json('POST', RouteServiceProvider::ADMIN_PREFIX . '/branches', $branch->toArray(), ['Accept' => 'application/json'])
            ->assertStatus(200);

            $this->assertDatabaseHas('branches',[
                'company_id' => $branch->company_id,
                'name' => $branch->name,
            ]);

    }


    public function test_show_branch()
    {
        $branch = Branch::newFactory()->create();

         $this->actingAs(static::$admin, 'admin');

        $this->json('GET', RouteServiceProvider::ADMIN_PREFIX . '/branches/'.$branch->id, [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertSee($branch->id);
    }


    public function test_update_branch()
    {
        $branch = Branch::newFactory()->create();

        $branch_data = [
            'name' => 'new branch for test',
        ];

        $branch_data = $branch_data + $branch->toArray();

         $this->actingAs(static::$admin, 'admin');

        $this->json('PUT', RouteServiceProvider::ADMIN_PREFIX . '/branches/'.$branch->id, $branch_data, ['Accept' => 'application/json'])
            ->assertStatus(200);

        $this->assertTrue( $branch->fresh()->name == $branch_data['name']);

    }

    public function test_delete_branch()
    {
        $branch = Branch::newFactory()->create();

        $this->actingAs(static::$admin, 'admin');

        $this->json('DELETE', RouteServiceProvider::ADMIN_PREFIX . '/branches/'.$branch->id, [], ['Accept' => 'application/json']);
        $this->assertModelMissing($branch);
    }

    public function test_index_branches()
    {
        $branches = Branch::newFactory()->count(2)->create();

         $this->actingAs(static::$admin, 'admin');

        $this->json('GET', RouteServiceProvider::ADMIN_PREFIX . '/branches', [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertSee($branches->first()->id);
    }
}
