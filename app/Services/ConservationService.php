<?php

namespace App\Services;

use App\Models\BoccCriteriaDefinition;
use App\Models\ConservationStatus;
use App\Models\ConservationStatusCriteria;

class ConservationService
{
    /**
     * Attach BoCC criteria to conservation statuses.
     *
     * @param  int|null  $statusId
     * @param  string|null  $criteriaString
     */
    public static function attachBoccCriteria($statusId, $criteriaString)
    {
        if ($statusId && ! empty($criteriaString)) {
            $criteriaCodes = explode('; ', $criteriaString);

            // Fetch all matching criteria in one query
            $criteria = BoccCriteriaDefinition::whereIn('code', array_map('trim', $criteriaCodes))->get();

            foreach ($criteria as $criterion) {
                ConservationStatusCriteria::create([
                    'conservation_status_id' => $statusId,
                    'bocc_criteria_id' => $criterion->id,
                ]);
            }
        }
    }

    public static function deleteConservationStatus(ConservationStatus $status)
    {
        // Delete each of the criteria first
        ConservationStatusCriteria::where('conservation_status_id', $status->id)->delete();

        // Delete the conservation status
        $status->delete();
    }
}
