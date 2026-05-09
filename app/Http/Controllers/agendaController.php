<?php

namespace App\Http\Controllers;

use App\Mail\NewSchedulingMail;
use App\Models\Client;
use App\Models\Scheduling;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class agendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    
    /**
     * Agendar Horário
     * 
     * Este endpoint permite que um cliente logado realize um agendamento de 30 minutos.
     * O sistema valida se o horário está disponível e notifica os administradores via SMTP.
     * 
     * @group Agendamentos
     * @authenticated
     * 
     * @bodyParam start_date string required Data do agendamento no formato DDMMAAAA. Example: 15052026
     * @bodyParam start_time string required Horário de início no formato HH:mm. Example: 14:30
     * 
     * @response 201 {
     *  "message": "Agendamento realizado com sucesso!",
     *  "data": {
     *    "id": 10,
     *    "client_id": 5,
     *    "start_date": "2026-05-15",
     *    "end_date": "2026-05-15",
     *    "start_time": "14:30",
     *    "end_time": "15:00"
     *  }
     * }
     * @response 422 {
     *  "error": "Horário indisponível"
     * }
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|digits:8', // DDMMAAAA
            'start_time' => 'required|date_format:H:i', // HH:mm
        ]);

        $user = $request->user();
        $client = Client::where('user_id', $user->id)->first();

        if (!$client) {
            return response()->json(['error' => 'Perfil de cliente não encontrado.'], 404);
        }

        $dataBanco = Carbon::createFromFormat('dmY', $request->start_date)->format('Y-m-d');

        $horaInicio = $request->start_time;

        $horaTermino = Carbon::createFromFormat('H:i', $horaInicio)->addMinutes(30)->format('H:i');

        $ocupado = Scheduling::where('start_date', $dataBanco)
            ->where('start_time', '<=', $horaInicio)
            ->where('end_time', '>=', $horaTermino)
            ->exists();

        if ($ocupado) {
            return response()->json(['error' => 'Horário indisponível'], 422);
        }

        $agendamento = new Scheduling();
        $agendamento->client_id = $client->id;
        $agendamento->start_date = $dataBanco;
        $agendamento->end_date = $dataBanco;
        $agendamento->start_time = $request->start_time;
        $agendamento->end_time = $horaTermino;
        $agendamento->save();


        $adminEmails = User::where('user_type_id', 1)->pluck('email');

        if ($adminEmails->isNotEmpty()) {
            Mail::to($adminEmails)->send(new NewSchedulingMail($agendamento));
        }

        return response()->json([
            'message' => 'Agendamento realizado com sucesso!',
            'data' => $agendamento
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
