<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // GET /api/clients
    public function index()
    {
        return Client::all();
    }

    // POST /api/clients
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'  => 'required|string|max:255',
            'correo' => 'required',
        ]);

        $client = Client::create($validated);

        return response()->json($client, 201);
    }

    // GET /api/clients/{id}
    public function show($id)
    {
        return Client::findOrFail($id);
    }

    // PUT/PATCH /api/clients/{id}
    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $validated = $request->validate([
            'name'  => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $client->update($validated);

        return response()->json($client, 200);
    }

    // DELETE /api/clients/{id}
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return response()->json(null, 204);
    }
}
