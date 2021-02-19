@extends('layouts.app')
@section('content')
<div class="mx-auto col-md-11">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="card">
				<div class="card-header">Usuarios</div>
				@if (session('status'))
				    <div class="alert alert-success alert-dismissible fade show" role="alert">
					  <strong>En hora buena</strong> {{ session('status') }}
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				@endif	
				<div class="card-body">
					<div class="text-center pb-4">
						<a href="{{ route('usuarios.create') }}" class="btn btn-success btn-sm" title="Nuevo Usuario">Nuevo Usuario</a><br>
					</div>
					<table class="table table-hover" id="tableUsuarios">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Email</th>
								<th>Rol de Usuario</th>
								<th>Acción</th>
							</tr>
						</thead>
						<tbody>
							@foreach($filter AS $user)
								<tr>
									<td>{{ $user->name }}</td>
									<td>{{ $user->email }}</td>
									<td>{{ $user->roles->implode('name',', ') }}</td>
									<td>
										<a href="{{ route('usuarios.edit',$user->id) }}" class="btn btn-primary btn-sm" title="Editar">Editar</a>
										<a href="{{ route('usuarios.baja',$user->id) }}" class="btn btn-danger btn-sm eliminar" title="Dar de Baja">Dar de Baja</a>
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