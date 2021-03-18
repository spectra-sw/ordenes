@extends('layouts.app')

@section('content')

<button type="button" class="btn btn-primary" onclick="window.open('ordenes','_blank')">CREAR ORDENES</button>
@if (session('tipo')==0)
<button type="button" class="btn btn-primary" onclick="window.open('admin','_blank')">ADMINISTRACIÓN</button>
@endif
@if (session('tipo')==1)
<button type="button" class="btn btn-primary" onclick="window.open('consultas','_blank')">CONSULTAR</button>
@endif

@endsection

