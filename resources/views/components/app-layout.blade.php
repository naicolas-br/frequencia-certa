@props(['header'])

{{-- 
|--------------------------------------------------------------------------
| App Layout Component
|--------------------------------------------------------------------------
| Este componente serve como ponte entre <x-app-layout>
| e o layout base resources/views/layouts/app.blade.php
| Usamos @extends + @section para garantir compatibilidade total.
|--------------------------------------------------------------------------
--}}

@extends('layouts.app')

{{-- =========================
| Header opcional da página
========================= --}}
@if (isset($header))
    @section('header')
        {{ $header }}
    @endsection
@endif

{{-- =========================
| Conteúdo principal
========================= --}}
@section('content')
    {{ $slot }}
@endsection
