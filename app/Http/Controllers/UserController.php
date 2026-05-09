<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClient;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Models\User;
use App\Services\UserService as ServicesUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group Clientes
 *
 * Gerenciamento de dados dos clientes e seus perfis.
 */
class UserController extends Controller
{
    /**
     * Listar Clientes
     * @authenticated
     */
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

    /**
     * Cadastro de Cliente (Público)
     * 
     * Cria um novo usuário do tipo 'Cliente' no sistema. 
     * A validação dos dados é feita automaticamente.
     * 
     * @response 201 {
     *   "message": "Usuário criado com sucesso !"
     * }
     */
    public function store(StoreClient $request)
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

    /**
     * Detalhes do Cliente
     * 
     * Retorna as informações completas de um cliente específico, incluindo dados de endereço e contato.
     * 
     * @authenticated
     * @urlParam id required O ID numérico do cliente. Example: 1
     * 
     * @response 200 {
     *   "name": "Lucas Silva",
     *   "email": "lucas@exemplo.com",
     *   "type user": "cliente",
     *   "phone": "11999999999",
     *   "address": "Rua Exemplo, 123",
     *   "city": "São Paulo"
     * }
     * @response 404 {
     *   "message": "Usuário não encontrado !"
     * }
     */
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

    /**
     * Atualizar Cliente
     * 
     * Permite editar as informações de perfil do cliente e os dados de acesso do usuário.
     * 
     * @authenticated
     * @urlParam id required O ID do cliente que será editado. Example: 1
     * 
     * @response 200 {
     *   "message": "Usuário atualizado com sucesso !"
     * }
     * @response 404 {
     *   "message": "Usuário não encontrado !"
     * }
     */
    public function update(UpdateClientRequest $request, string $id){
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

    /**
     * Excluir Cliente
     * 
     * Remove permanentemente o registro do cliente e seu usuário vinculado do sistema.
     * **Atenção:** Esta operação é irreversível.
     * 
     * @authenticated
     * @urlParam id required O ID do cliente a ser removido. Example: 1
     * 
     * @response 200 {
     *   "message": "Usuário excluído com sucesso !"
     * }
     * @response 404 {
     *   "message": "Usuário não encontrado !"
     * }
     */
    public function destroy(string $id){
        $client = Client::find($id);
        $user = User::find($client->user_id);
        $user->delete();
        $client->delete();

        return response()->json(["message" => "Usuário excluído com sucesso !"], 200);
    }
}
