<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PosPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_and_about_pages_load(): void
    {
        $this->get('/')->assertOk()->assertSee('Run your store with clarity.');
        $this->get('/about')->assertOk()->assertSee('About the workspace');
    }

    public function test_customer_page_displays_database_records(): void
    {
        Customer::create([
            'full_name' => 'Test Customer',
            'email' => 'test@example.com',
            'phone' => '09170000000',
        ]);

        $this->get('/customers')
            ->assertOk()
            ->assertSee('Test Customer')
            ->assertSee('test@example.com');
    }

    public function test_user_page_displays_database_records(): void
    {
        User::create([
            'username' => 'test_user',
            'full_name' => 'Test User',
        ]);

        $this->get('/users')
            ->assertOk()
            ->assertSee('test_user')
            ->assertSee('Test User');
    }

    public function test_database_seeder_is_repeatable(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(5, Customer::count());
        $this->assertSame(5, User::count());
    }
}
