@extends('layouts.app')
@section('content')
<div class="mx-auto col-md-11">
	<br>
	<div class="text-center">
		<h4>Códigos Generados/Obtenidos/Relacionados</h4>
	</div>
	<hr>
	<div class="table-responsive">
		<table class="table table-sm table-hover table-bordered" id="tableCodDurex">
			<thead class="thead-dark">
				<tr>
					<th>Linea</th>
					<th>Articulo</th>
					<th>Descripción 1</th>
					<th>Descripción 2</th>
					<th>Clave Fabricante</th>
					<th>Código Alterno</th>
				</tr>
			</thead>
			<tbody>

				@foreach($index AS $codigo)
				<tr>
					<td>{{ $codigo->Linea }}</td>
					<td>{{ $codigo->Articulo }}</td>
					<td>{{ $codigo->Descripcion1 }}</td>
					<td>{{ $codigo->Descripcion2 }}</td>
					<td>{{ $codigo->ClaveFabricante }}</td>
					<td>{{ $codigo->CodigoAlterno }}</td>
				</tr>
				@endforeach

			</tbody>
		</table>
	</div>
	<hr>
	<div class="text-center">
		<a href="{{ route('durex.create') }}" class="btn btn-success btn-sm">Regresar/Nueva Solicitud</a>
	</div>
</div>
@stop