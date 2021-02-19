@extends('layouts.app')
@section('content')
<div class="mx-auto col-md-11">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="card">
				<div class="card-header">Agregar Componentes a Código Genérico de Bakan</div>	
				<div class="card-body">
					<table class="table table-hover" id="tableAddCompBakan">
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
									<td>
										<a href="{{ route('bakan.showAddComGenBakan',$codigo->Articulo) }}" class="btn btn-primary btn-sm btn-block">Agregar Componente</a>
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
@endsection