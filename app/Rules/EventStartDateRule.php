<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class EventStartDateRule implements ValidationRule, DataAwareRule
{
    protected $data = [];

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $event = request()->route()->parameter('event');
        $endDate = Carbon::parse($this->data['end_date'] ?? $event->end_date);

        $startDate = Carbon::parse($value);

        if (! $startDate->between((clone $endDate)->subHours(12), $endDate)) {
            $fail('The start date must be before end date ('
                .$endDate->format('Y-m-d H:i:s')
                .'). But no more than 12 hours.');
        }

        /*dd(
            (clone $endDate)->subHours(12)->format('Y-m-d H:i:s'),
            $endDate->format('Y-m-d H:i:s'),
            $startDate->format('Y-m-d H:i:s'),
            $startDate->between((clone $endDate)->subHours(12), $endDate),
        );*/

    }

    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }
}
