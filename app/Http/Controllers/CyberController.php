<?php

namespace App\Http\Controllers;

use App\Models\Cyber;
use Exception;
use Illuminate\Http\Request;

class CyberController extends Controller
{
    public function index()
    {
        try {
            $cybers = Cyber::all();
            return response()->json($cybers, 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve cybers',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $cyber = Cyber::findOrFail($id);
            return response()->json($cyber, 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve cyber',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'longitude' => 'required|numeric',
                'latitude' => 'required|numeric',
                'address' => 'required|string|max:255',
                'printers' => 'required|integer',
                'img' => 'nullable|string|max:255',
            ]);

            $cyber = Cyber::create($validatedData);

            return response()->json($cyber, 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to create cyber',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function storeBatch(Request $request)
    {
        try {
            $cybersData = $request->json()->all();

            // Tableau pour stocker les instances de Cyber créées
            $createdCybers = [];

            foreach ($cybersData as $cyberData) {
                $createdCybers[] = Cyber::create([
                    'name' => $cyberData['name'],
                    'longitude' => $cyberData['longitude'],
                    'latitude' => $cyberData['latitude'],
                    'address' => $cyberData['address'],
                    'printers' => $cyberData['printers'],
                    'img' => 'nullable|string|max:255',
                  
                ]);
            }

            return response()->json($createdCybers, 201);
        } catch (\Exception $e) {
            // Pour toute autre exception non prévue
            return response()->json(['message' => 'Failed to process request', 'error' => $e->getMessage()], 500);
        }
    }

}
