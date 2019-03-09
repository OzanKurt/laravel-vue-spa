<?php

namespace App\Models\Traits;

/**
 * HasDates
 * @package App\Models\Traits
 */
trait HasDates
{
    /**
     * Get a specific date field while customizing it.
     *
     * @param  string $field
     * @param  string|null $format
     * @return string $default
     */
    public function getDate($field, $format = 'd/m/Y', $default = 'N/A')
    {
        if ($this->{$field}) {
            if ($format) {
                if (in_array($format, ['timeago', 'diffForHumans'])) {
                    return $this->{$field}->diffForHumans();
                }

                return $this->{$field}->format($format);
            }

            return $this->{$field};
        }

        return $default;
    }

    /**
     * Get a specific date field while customizing it.
     *
     * @param  string $field
     * @param  string|null $format
     * @return string $default
     */
    public function getDate2($field, $format = 'd/m/Y', $default = 'N/A')
    {
        if ($this->{$field} == null) {
            return $default;
        }

        if ($format == null) {
            return $this->{$field};
        }

        if (in_array($format, ['timeago', 'diffForHumans'])) {
            return $this->{$field}->diffForHumans();
        }

        return carbon($this->{$field})->format($format);
    }
}
