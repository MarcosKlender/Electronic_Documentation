@extends('master')

@section('tabla')
<div class="container text-center mt-4">
  <h2>Documentos Electrónicos</h2>
</div>

<div class="container mt-4">
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link" href="{{ route('ruta.documentos.factura') }}">Factura - Nota de Débito - Nota de Crédito</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('ruta.documentos.retencion') }}">Retención</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="{{ route('ruta.documentos.remision') }}">Guías de Remisión</a>
    </li>
  </ul>

  @if (count($remision) === 0)
  <div class="card">
    <div class="card-body">
      No se han encontrado documentos actualmente.
    </div>
  </div>
  @else

  <table class="table table-hover table-responsive">
    <thead>
      <tr>
        <th scope="col">Tipo</th>
        <th scope="col">Número</th>
        <th scope="col">Fecha de Emisión</th>
        <!-- <th scope="col">Valor</th> -->
        <th scope="col">Cliente</th>
        <!-- <th scope="col">RUC/CI</th> -->
        <th scope="col">Estado</th>
        <th scope="col">Fecha de Autorización</th>
        <th scope="col">PDF</th>
      </tr>
    </thead>
    <tbody>
      @foreach($remision as $value)
      <tr>
        <td>{{ $value->id_documento }}</td>
        <td>{{ $value->numero_documento }}</td>
        <td>{{ $value->fecha_emision_documento }}</td>
        {{-- <td>{{ $value->valor_total }}</td> --}}
        <td>{{ $value->persona_nombre }}</td>
        {{-- <td>{{ $value->ruc_cliente_proveedor }}</td> --}}
        <td>{{ $value->mensaje_sri }}</td>
        <td>{{ $value->fecha_autorizacion }}</td>
        <td>
          <a href="{{ route('ruta.documentos.pdf') }}" target="_blank">
            <i class="fas fa-file-pdf"></i>
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @endif
</div>
@endsection