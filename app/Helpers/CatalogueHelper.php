<?php

namespace App\Helpers;

class CatalogueHelper {
    public static function getStatusBgClass(string $status): string
    {
        return match (strtolower($status)) {
            'green'        => 'bg-conservationGreen dark:bg-conservationGreen-dark',
            'amber'        => 'bg-conservationAmber dark:bg-conservationAmber-dark',
            'red'          => 'bg-conservationRed dark:bg-conservationRed-dark',
            'former breeder' => 'bg-gray-100 dark:bg-gray-900',
            'not assessed' => 'bg-gray-200 dark:bg-gray-800',
            default         => 'bg-gray-100 dark:bg-gray-700',
        };
    }
    
}

?>
