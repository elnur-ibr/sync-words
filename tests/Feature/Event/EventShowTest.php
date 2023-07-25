<?php

namespace Tests\Feature\Event;

use App\Models\Authorization;
use App\Models\Event;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class EventShowTest extends TestCase
{
    protected User $user;

    protected Collection|Event $events;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->events = Event::factory([
            'organization_id' => $organization = Organization::factory()->create(),
        ])->count(3)->create();

        Authorization::factory()->create([
            'organization_id' => $organization,
            'user_id'         => $this->user->id
        ]);
    }

    /**
     * @test
     */
    public function successful(): void
    {
        $event = $this->events->first();
        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson(route('events.show', [$event->id]));

        $response->assertStatus(200)
            ->assertExactJson([
                'id'              => $event->id,
                'title'           => $event->title,
                'start_date'      => $event->start_date,
                'end_date'        => $event->end_date,
                'organization_id' => $event->organization_id,
                'created_at'      => $event->created_at,
                'updated_at'      => $event->updated_at,
            ]);
    }
}
