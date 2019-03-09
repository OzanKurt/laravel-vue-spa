<?php

namespace App\Models\Traits;

use Illuminate\Support\Carbon;

/**
 * HasDateOfBirth
 * @package App\Models\Traits
 */
trait HasDateOfBirth
{
    /**
     * Format the date of birth as wanted.
     *
     * @param  string $format
     * @return string
     */
    public function dateOfBirth($format = 'd/m/Y', $default = 'N/A')
    {
        if ($format == 'age') {
            $date_of_birth = $this->getDate('date_of_birth', null);

            if ($date_of_birth instanceof Carbon) {
                return $date_of_birth->age; // . ' years old'
            }

            return $date_of_birth;
        }

        if ($format == 'in') {
            return $this->dateOfBirthIn();
        }

        return $this->getDate('date_of_birth', $format, $default);
    }

    /**
     * Get the remaining time until the birthday.
     *
     * @return string
     */
    public function dateOfBirthIn()
    {
        $today = Carbon::today();
        $date_of_birth = $this->getDate('date_of_birth', null);

        if ($date_of_birth instanceof Carbon) {
            $message = 'Birthday ';

            $nextBirthday = $date_of_birth->year($today->year);
            if ($nextBirthday->lt($today)) {
                $nextBirthday->addYear(1);
            }

            if ($nextBirthday->isSameAs('d/m/Y')) {
                return $message . 'is today!';
            }

            $diffInMonths = $today->diffInMonths($nextBirthday);

            if ($diffInMonths > 0) {
                $text = str_plural('month', $diffInMonths);
                $message .= "in {$diffInMonths} {$text}";
            }

            $diffInDays = $today->addMonths($diffInMonths)->diffInDays($nextBirthday);
            if ($diffInDays > 0) {
                $text = str_plural('day', $diffInDays);
                if ($diffInMonths > 0) {
                    $message .= " and {$diffInDays} {$text}.";
                } else {
                    $message .= "in {$diffInDays} {$text}.";
                }
            } else {
                $message .= ".";
            }

            return $message;
        }

        return $date_of_birth;
    }
}
