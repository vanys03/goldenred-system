<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Ticket Perfil</title>
<style>
    @media print {
        @page { size: 48mm auto; margin: 0; }
        body { margin: 0; padding: 0 12px; font-family: 'Courier New', monospace; font-size: 14px; }
    }
    body { padding: 10px; font-family: 'Courier New'; font-size: 14px; }
    .line { border-top: 1px dashed #999; margin: 6px 0; }
    .bold { font-weight: bold; }
</style>
</head>

<body onload="window.print();">

@php
    use Carbon\Carbon;
    $fechaInicio = Carbon::parse($assignment->started_at);
    $fechaFin = $fechaInicio->copy()->addMonth();
@endphp

<div class="bold">
    <img src="{{ asset('assets/img/logo1.png') }}" style="width: 150px;">
</div>

<div class="line"></div>

<div class="bold">Datos del Perfil</div>
<div>Cliente: {{ $assignment->customer_name }}</div>
<div>Teléfono: {{ $assignment->telefono ?? '---' }}</div>

<div class="line"></div>

<div class="bold">Plataforma</div>
<div>{{ $assignment->profile->account->platform->name }}</div>

<div class="bold">Correo</div>
<div>{{ $assignment->profile->account->email }}</div>

<div class="bold">Contraseña</div>
<div>{{ $assignment->profile->account->password_plain ?? '---' }}</div>

<div class="bold">Perfil</div>
<div>{{ $assignment->profile->name }}</div>

<div class="bold">PIN</div>
<div>{{ $assignment->notes ?? '---' }}</div>

<div class="line"></div>

<div class="bold">Datos del Ticket</div>
<div>ID Ticket: {{ $assignment->id }}</div>
<div>Asignado desde: {{ $fechaInicio->format('Y-m-d') }}</div>
<div>Asignado hasta: {{ $fechaFin->format('Y-m-d') }}</div>
<div>Atendido por: {{ $assignment->user->name ?? '---' }}</div>

<div class="line"></div>

<div style="font-size: 12px;">¡Gracias por tu preferencia!</div>

</body>
</html>
