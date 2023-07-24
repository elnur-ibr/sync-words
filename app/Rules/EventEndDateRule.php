<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class EventEndDateRule implements ValidationRule, DataAwareRule
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
        $startDate = Carbon::parse($this->data['end_date'] ?? $event->end_date);

        $endDate = Carbon::parse($value);

        if (! $endDate->between($startDate, (clone $startDate)->addHours(12))) {
            $fail('The end date must be after start date('
                .$startDate->format('Y-m-d H:i:s')
                .'). But no more than 12 hours.');
        }
    }

    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }
}
