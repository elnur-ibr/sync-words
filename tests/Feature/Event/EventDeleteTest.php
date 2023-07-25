<?php

namespace Event;

use App\Models\Authorization;
use App\Models\Event;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class EventDeleteTest extends TestCase
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
            ->deleteJson(route('events.destroy', [$event->id]));

        $response->assertStatus(204)
            ->isEmpty();

        $this->assertDatabaseMissing('events',[
            'id' => $event->id
        ]);
    }
}
