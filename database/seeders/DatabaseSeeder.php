<?php

namespace Database\Seeders;

use App\Models\Authorization;
use App\Models\Event;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Event::factory([
            'organization_id' => $organization = Organization::factory()->create()
        ])->count(3)->create();

        Authorization::factory()->create([
            'organization_id' => $organization
        ]);

        Event::factory([
            'organization_id' => $organization = Organization::factory()->create()
        ])->count(10)->create();

        Authorization::factory()->create([
            'organization_id' => $organization
        ]);

        Event::factory([
            'organization_id' => $organization = Organization::factory()->create()
        ])->count(20)->create();

        Authorization::factory()->create([
            'organization_id' => $organization
        ]);
    }
}
