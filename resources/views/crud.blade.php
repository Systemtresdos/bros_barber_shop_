@extends('adminlte::page')

@section('title', 'System32')

@section('content_header')
    <h1 style="text-align: center">Base de datos</h1>
@stop

@section('content')
<div class="col-md-12" style="overflow-y: auto;">
  @if (Auth::user()->rol!="cliente")
    @include('adminlte::partials.system32.tabla',[
      'datos' => $datos,
      'arregloDatos' => $arregloDatos,
      'nombre' => $nombre,
      'fk' => $fk,
    ])
  @if (Auth::user()->rol!="cliente")
    @include('adminlte::partials.system32.modal-dinamico',[
      'datos' => $datos,
      'arregloDatos' => $arregloDatos,
      'nombre' => $nombre,
      'fk' => $fk,
    ])
  @endif
  @if (Auth::user()->rol!="cliente")
    @include('adminlte::partials.system32.modal-eliminar',[
      'datos' => $datos,
      'arregloDatos' => $arregloDatos,
      'nombre' => $nombre,
      'fk' => $fk,
    ])
  @endif
  @endif
</div>
@stop


@section('css')
    <link rel="stylesheet" href="{{ asset('css/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables/dataTables.bootstrap5.css') }}">
@stop

@section('js')
    <script type="text/javascript" src="{{ asset('js/datatables/jquery-3.7.1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/datatables/dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/datatables/dataTables.bootstrap5.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/datatables/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/toastr/toastr.min.js') }}"></script>
    <script>
    let crudTable = new DataTable('#datatables');
    </script>
    <script>
      @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error('Error: {{ $error }}')
        @endforeach
      @endif
      @if (session('error'))
        toastr.error('Error: {{ session('error') }}')
      @endif
      @if (session('warning'))
        toastr.warning('Aviso: {{ session('warning') }}')
      @endif
      @if (session('success'))
        toastr.success('{{ session('success') }}')
      @endif
    </script>
    <script>
      /*const source = new EventSource('{{url('/crud_update')}}');
      source.onmessage = function(event) {
          const data = JSON.parse(event.data);
          console.log(data['type']); // Recibe los datos JSON
      };*/
    </script>
    @if (Auth::user()->rol!="cliente")
      @include('adminlte::partials.system32.modal-dinamico-js')
    @endif
@stop