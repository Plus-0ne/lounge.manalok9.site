<?php

namespace App\Http\Controllers;

use App\Services\UserReferenceService;
use Illuminate\Http\Request;

class APIController extends Controller
{
    protected $userReferenceService;

    public function __construct(UserReferenceService $userReferenceService)
    {
        $this->userReferenceService = $userReferenceService;
    }

    public function getUserReferences(Request $request)
    {
        $iagd_number = $request->query('iagd_number');

        if (!isset($iagd_number)) {
            return response()->json([
                'error' => [
                    'message' => 'Missing iagd_number parameter.',
                ]
            ], 400);
        }

        $references = $this->userReferenceService->getUserReferences($iagd_number);

        if (isset($references['error'])) {
            return response()->json(['error' => $references['error']], 404);
        }

        return response()->json($references);
    }
}