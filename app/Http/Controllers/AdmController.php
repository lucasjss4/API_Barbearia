<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdmRequest;
use App\Http\Requests\UpdateAdmRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * @group Administração
 *
 * Endpoints restritos para usuários com perfil de administrador.
 */
class AdmController extends Controller
{
    private function ifUserAdm(): bool
    {
        $user = Auth::user();

        return $user && $user->user_type_id === 1;
    }

    /**
     * Listar Administradores
     * @authenticated
     * @response 200 [
     *  {
     *    "id": 1,
     *    "name": "Admin",
     *    "email": "admin@sistema.com",
     *    "type user": "admin"
     *  }
     * ]
     * @response 403 {
     *  "error": "Acesso negado !"
     * }
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
     * Criar novo Administrador
     * 
     * Registra um novo usuário com privilégios administrativos (user_type_id = 1) no sistema.
     * 
     * @authenticated
     * 
     * @response 201 {
     *   "message": "Administrator criado com sucesso !"
     * }
     * @response 403 {
     *   "error": "Acesso negado !"
     * }
     */
    public function store(StoreAdmRequest $request)
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
     * Detalhes do Administrador
     * 
     * Retorna as informações de perfil de um administrador específico através do seu ID.
     * 
     * @authenticated
     * @urlParam id required O ID numérico do administrador. Example: 1
     * 
     * @response 200 {
     *   "id": 1,
     *   "name": "Admin Principal",
     *   "email": "admin@sistema.com",
     *   "type user": "admin"
     * }
     * @response 404 {
     *   "message": "Usuário não encontrado"
     * }
     * @response 403 {
     *   "error": "Acesso negado !"
     * }
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
     * Atualizar Administrador
     * 
     * Permite a alteração dos dados cadastrais (nome e e-mail) de um administrador existente.
     * 
     * @authenticated
     * @urlParam id required O ID do administrador que será editado. Example: 1
     * 
     * @response 200 {
     *   "message": "Usuário atualizado com sucesso"
     * }
     * @response 403 {
     *   "error": "Acesso negado !"
     * }
     */
    public function update(UpdateAdmRequest $request, string $id)
    {
        if (!$this->ifUserAdm()) return response()->json(['error' => 'Acesso negado !'], 403);

        $userProcurado = User::find($id);
        $userProcurado->name = $request->name;
        $userProcurado->email = $request->email;
        $userProcurado->save();

        return response()->json(['message' => 'Usuário atualizado com sucesso'], 200);
    }

   /**
     * Excluir Administrador
     * 
     * Remove permanentemente um registro de administrador do banco de dados.
     * **Nota:** Apenas administradores autorizados podem realizar esta ação.
     * 
     * @authenticated
     * @urlParam id required O ID do administrador a ser removido. Example: 1
     * 
     * @response 200 {
     *   "message": "Usuário deletado com sucesso !"
     * }
     * @response 403 {
     *   "error": "Acesso negado !"
     * }
     */
    public function destroy(string $id)
    {
        if (!$this->ifUserAdm()) return response()->json(['error' => 'Acesso negado !'], 403);

        $userProcurado = User::find($id);
        $userProcurado->delete();

        return response()->json(['message' => 'Usuário deletado com sucesso !'], 200);
    }
}
