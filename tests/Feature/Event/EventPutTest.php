<?php

namespace Event;

use App\Http\Requests\EventUpdateRequest;
use App\Models\Authorization;
use App\Models\Event;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\RequestFactories\EventUpdateRequestFactory;
use Tests\TestCase;

class EventPutTest extends TestCase
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
        $updateData = EventUpdateRequestFactory::new()->all()->create();

        $event = $this->events->first();

        $response = $this->actingAs($this->user, 'sanctum')
            ->putJson(route('events.update', $event->id), $updateData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('events', [
            'id'         => $event->id,
            'title'      => $updateData['title'],
            'start_date' => $updateData['start_date'],
            'end_date'   => $updateData['end_date'],
        ]);
    }

    /**
     * @test
     */
    public function without_title(): void
    {
        $updateData = EventUpdateRequestFactory::new()
            ->addStartDate()->addEndDate()
            ->create();

        $event = $this->events->first();

        $response = $this->actingAs($this->user, 'sanctum')
            ->putJson(route('events.update', $event->id), $updateData);

        $response->assertStatus(422)
            ->assertJsonValidationErrorFor('title');

        $this->assertDatabaseHas('events', [
            'id'         => $event->id,
            'title'      => $event->title,
            'start_date' => $event->start_date,
            'end_date'   => $event->end_date,
        ]);
    }
}
