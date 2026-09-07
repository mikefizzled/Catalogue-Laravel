<?php

namespace App\Http\Controllers;

use App\Models\ConservationList;
use Illuminate\Http\Request;

class ConservationController extends Controller
{
        public function conservation()
    {
        $conservationLists = ConservationList::get();

        return view('conservation', ['conservationLists' => $conservationLists]);
    }
}
