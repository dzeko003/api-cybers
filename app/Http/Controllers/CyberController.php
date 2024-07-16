<?php

namespace App\Http\Controllers;

use App\Models\Cyber;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'address' => 'required|string|max:255',
            'printers' => 'required|integer',
            'img' => 'nullable|url',
        ]);

        // Find the cyber by ID
        $cyber = Cyber::findOrFail($id);

        // Update the cyber with new data
        $cyber->update([
            'name' => $request->input('name'),
            'longitude' => $request->input('longitude'),
            'latitude' => $request->input('latitude'),
            'address' => $request->input('address'),
            'printers' => $request->input('printers'),
            'img' => $request->input('img'),
        ]);

        // Return a response
        return response()->json([
            'message' => 'Cyber updated successfully',
            'cyber' => $cyber
        ], 200);
    }

    public function destroy($id)
    {
        // Trouver le cyber par ID
        $cyber = Cyber::find($id);

        // Vérifier si le cyber existe
        if (!$cyber) {
            return response()->json([
                'message' => 'Cyber not found',
            ], Response::HTTP_NOT_FOUND);
        }

        // Supprimer le cyber
        $cyber->delete();

        // Retourner une réponse de succès
        return response()->json([
            'message' => 'Cyber deleted successfully',
        ], Response::HTTP_OK);
    }

}
