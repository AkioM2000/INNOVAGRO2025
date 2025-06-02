<?php

namespace App\Helpers;

use Carbon\Carbon;
use Exception;

class DateHelper
{
    /**
     * Parse a date string in Indonesian format (dd/mm/yyyy) to a Carbon instance
     *
     * @param string $dateString The date string to parse
     * @param string $format The format of the date string (default: d/m/Y H:i)
     * @return Carbon|null The parsed Carbon instance or null if parsing fails
     */
    public static function parseIndonesianDate($dateString, $format = 'd/m/Y H:i')
    {
        try {
            // First try with the specified format
            $date = Carbon::createFromFormat($format, $dateString);
            if ($date) {
                return $date;
            }

            // If that fails, try with a more lenient format
            $date = Carbon::createFromFormat('d/m/Y H:i', $dateString);
            if ($date) {
                return $date;
            }

            // If still fails, try with just the date part
            $date = Carbon::createFromFormat('d/m/Y', $dateString);
            if ($date) {
                return $date;
            }

            // If all attempts fail, throw an exception
            throw new Exception("Could not parse date: $dateString");
        } catch (Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error parsing date: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Format a Carbon instance to Indonesian format
     *
     * @param Carbon $date The Carbon instance to format
     * @param string $format The format to use (default: d-m-Y H:i)
     * @return string The formatted date string
     */
    public static function formatIndonesianDate($date, $format = 'd-m-Y H:i')
    {
        if (!$date) {
            return '-';
        }

        return $date->format($format);
    }
}
