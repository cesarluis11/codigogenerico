@extends('layouts.app')
@section('content')
<div class="mx-auto col-md-11">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="card">
				<div class="card-header">Códigos Genéricos Durex Para Su Revisión</div>	
				<div class="card-body">
					<table class="table table-hover" id="tableRevisionBakan">
						<thead>
							<tr>
								<th>Linea</th>
								<th>Articulo</th>
								<th>Descripción 1</th>
								<th>Descripción 2</th>
								<th>Acción</th>
								
							</tr>
						</thead>
						<tbody>
							@foreach($index AS $codigo)
								<tr>
									<td>{{ $codigo->Linea }}</td>
									<td>{{ $codigo->Articulo }}</td>
									<td>{{ $codigo->Descripcion1 }}</td>
									<td>{{ $codigo->Descripcion2 }}</td>
									<td class="revision">
										<div class="form-group form-check">
									    	<input type="checkbox" class="form-check-input checkCorrectoDesc" id="{{ $codigo->Articulo }}">
										    <label class="form-check-label" for="checkCorrectoDesc">Correcto</label>
										</div>
										<a id="{{ $codigo->Articulo }}" href="" class="btn btn-success btn-sm btn-block guardarDesc">Guardar</a>
										<a id="{{ $codigo->Articulo }}" href="{{ route('durex.showDescDurex',$codigo->Articulo) }}" class="btn btn-primary btn-sm btn-block editarDesc">Editar</a>
									</td>
									
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@stop