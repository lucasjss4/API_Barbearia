<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use App\Services\UserService as ServicesUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {

        $users = Client::all();

        $format = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->user->name,
                'email' => $user->user->email,
                'type user' => $user->user->user_type->role,
                'phone' => $user->phone,
                'address' => $user->address,
                'city' => $user->city
            ];
        });

        return response()->json($format,200);
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->user_type_id = 2;
        $user->save();

        $client = new Client();
        $client->phone = $request->phone;
        $client->address = $request->address;
        $client->city = $request->city;
        $client->user_id = $user->id;
        $client->save();

        return response()->json(["message" => "Usuário criado com sucesso !"], 201);
    }

    public function show(string $id)
    {
        $user = Client::find($id);

        if (!$user) return response()->json(['message' => 'Usuário não encontrado !'], 404);

        return response()->json([
            'name' => $user->user->name,
            'email' => $user->user->email,
            'type user' => $user->user->user_type->role,
            'phone' => $user->phone,
            'address' => $user->address,
            'city' => $user->city,
        ], 200);
    }

    public function update(Request $request, string $id){
        $client = Client::find($id);
        $client->phone = $request->phone;
        $client->address = $request->address;
        $client->city = $request->city;
        $client->save();

        $user = User::find($client->user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
    
        return response()->json(["message" => "Usuário atualizado com sucesso !"], 200);
    }

    public function destroy(string $id){
        $client = Client::find($id);
        $user = User::find($client->user_id);
        $user->delete();
        $client->delete();

        return response()->json(["message" => "Usuário excluído com sucesso !"], 200);
    }
}
