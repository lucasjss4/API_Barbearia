<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdmController extends Controller
{
    private function ifUserAdm(): bool
    {
        $user = Auth::user();

        return $user && $user->user_type_id === 1;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!$this->ifUserAdm()) return response()->json(['error' => 'Acesso negado !'], 403);

        $users = User::where('user_type_id', 1)->get();

        $format = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'type user' => $user->user_type->role
            ];
        });

        return response()->json($format, 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$this->ifUserAdm()) return response()->json(['error' => 'Acesso negado !'], 403);

        $novoADM = new User();
        $novoADM->name = $request->name;
        $novoADM->email = $request->email;
        $novoADM->password = Hash::make($request->password);
        $novoADM->user_type_id = 1;
        $novoADM->save();

        return response()->json(['message' => 'Administrator criado com sucesso !'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!$this->ifUserAdm()) return response()->json(['error' => 'Acesso negado !'], 403);

        $userProcurado = User::find($id);

        if (!$userProcurado) return response()->json(['message' => 'Usuário não encontrado'], 404);

        return response()->json([
            'id' => $userProcurado->id,
            'name' => $userProcurado->name,
            'email' => $userProcurado->email,
            'type user' => $userProcurado->user_type->role
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!$this->ifUserAdm()) return response()->json(['error' => 'Acesso negado !'], 403);

        $userProcurado = User::find($id);
        $userProcurado->name = $request->name;
        $userProcurado->email = $request->email;
        $userProcurado->save();

        return response()->json(['message' => 'Usuário atualizado com sucesso'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$this->ifUserAdm()) return response()->json(['error' => 'Acesso negado !'], 403);

        $userProcurado = User::find($id);
        $userProcurado->delete();

        return response()->json(['message' => 'Usuário deletado com sucesso !'], 200);
    }
}
