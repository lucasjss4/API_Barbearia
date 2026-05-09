<h1>Novo agendamento na barbearia !</h1>
<p><strong>Cliente:</strong> {{$agendamento->client->user->name}}</p>
<p><strong>Data:</strong> {{\Carbon\Carbon::parse($agendamento->start_date)->format('d/m/Y')}}</p>
<p><strong>Horário:</strong> {{ $agendamento->start_time }} até {{ $agendamento->end_time }}</p>