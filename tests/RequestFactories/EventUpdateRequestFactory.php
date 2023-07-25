<?php

namespace Tests\RequestFactories;

use Illuminate\Support\Carbon;
use Worksome\RequestFactories\RequestFactory;

class EventUpdateRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            //
        ];
    }

    public function addTitle(?string $title = null)
    {
        return $this->state([
            'title' => $title ?? $this->faker->text()
        ]);
    }

    public function addStartDate(?string $startDate = null)
    {
        return $this->state([
            'start_date' => $startDate ?? now()->subDays(3)->format('Y-m-d H:i:s'),
        ]);
    }

    public function addEndDate(?string $endDate = null)
    {
        return $this->state([
            'end_date' => function (array $attributes) use ($endDate) {
                return $endDate ?? (
                $attributes['start_date'] ?
                    Carbon::parse($attributes['start_date'])->addMinutes(rand(1, 12 * 60))->format('Y-m-d H:i:s')
                    : now()->format('Y-m-d H:i:s')
                );
            }
        ]);
    }

    public function all()
    {
        return $this->addTitle()->addStartDate()->addEndDate();
    }
}
