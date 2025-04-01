<?php

namespace App\Helpers;

class CatalogueHelper {
    public static function getStatusBgClass(string $status): string
    {
        return match (strtolower($status)) {
            'green' => 'bg-green-100 dark:bg-green-900',
            'amber' => 'bg-yellow-100 dark:bg-yellow-900',
            'red' => 'bg-red-100 dark:bg-red-900',
            'former breeder' => 'bg-gray-100 dark:bg-gray-900',
            'not assessed' => 'bg-gray-200 dark:bg-gray-800',
            default => 'bg-gray-100 dark:bg-gray-700',
        };
    }
}

?>
