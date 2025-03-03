<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EBirdTaxonomyController extends Controller
{
    public function search(Request $request)
    {
        $query = trim($request->input('query'));
        $filePath = storage_path('app/public/ebird_taxonomy.json');

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'eBird data not found'], 404);
        }

        $data = json_decode(file_get_contents($filePath), true);
        // Perform a case-insensitive "LIKE" search
        $matches = collect($data)->filter(function ($species) use ($query) {
            return stripos($species['comName'], $query) !== false;
        })->sortBy('comName')->values();

        if ($matches->isNotEmpty()) {
            return response()->json($matches);
        }

        return response()->json(['error' => 'Species not found'], 404);
    }

    public function fetchBoccData(Request $request)
    {
        $scientificName = $request->query('scientific_name');

        if (!$scientificName) {
            return response()->json(['error' => 'Scientific name is required'], 400);
        }

        // Load both JSON files
        $filePathMain = storage_path('app/public/British_Bird_Conservation_Status.json');
        $filePath5a = storage_path('app/public/British_Bird_Conservation_Status_5a.json');

        $boccDataMain = file_exists($filePathMain) ? json_decode(file_get_contents($filePathMain), true) : [];
        $boccData5a = file_exists($filePath5a) ? json_decode(file_get_contents($filePath5a), true) : [];

        // Check if the species exists in either dataset
        $birdDataMain = $boccDataMain[$scientificName] ?? null;
        $birdData5a = $boccData5a[$scientificName] ?? null;

        $defaultBirdData = [
            "bocc_1" => "Not Assessed",
            "bocc_2" => "Not Assessed",
            "bocc_3" => "Not Assessed",
            "bocc_4" => "Not Assessed",
            "bocc_5" => "Not Assessed",
            "bocc_5a" => "Not Assessed",
            "bocc_5_criteria" => "",
            "bocc_5a_criteria" => "",
            "iucn_status" => "Not Assessed",
        ];

        $statusMapping = [
            "G" => "Green",
            "A" => "Amber",
            "R" => "Red",
            "n" => "Not Assessed",
            "N"  => "Not Assessed",
            null => "Not Assessed"
        ];
        // Apply mapping for BoCC main dataset
        if ($birdDataMain) {
            $defaultBirdData['bocc_1'] = $statusMapping[$birdDataMain['bocc_1']] ?? "Not Assessed";
            $defaultBirdData['bocc_2'] = $statusMapping[$birdDataMain['bocc_2']] ?? "Not Assessed";
            $defaultBirdData['bocc_3'] = $statusMapping[$birdDataMain['bocc_3']] ?? "Not Assessed";
            $defaultBirdData['bocc_4'] = $statusMapping[$birdDataMain['bocc_4']] ?? "Not Assessed";
            $defaultBirdData['bocc_5'] = $birdDataMain['bocc_5'] ?? "Not Assessed";
            $defaultBirdData['bocc_5_criteria'] = $birdDataMain['bocc_5_criteria'] ?? "";
            $defaultBirdData['iucn_status'] = $birdDataMain['iucn_status'] ?? "Not Assessed";
        }

        // Apply mapping for BoCC5a dataset
        if ($birdData5a) {
            $defaultBirdData['bocc_5a'] = $birdData5a['bocc_5a'] ?? "Not Assessed";
            $defaultBirdData['bocc_5a_criteria'] = $birdData5a['bocc_5a_criteria'] ?? "";
            $defaultBirdData['iucn_status'] = $birdData5a['iucn_status'] ?? "Not Assessed";
        }
        return response()->json($defaultBirdData);
    }
}
