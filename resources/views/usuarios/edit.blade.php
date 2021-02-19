@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row justify container-center">
		<div class="col-sm-8">
			<div class="card">
				<div class="card-heading text-center pt-3">
					<h3>Editar Usuario de: {{ $usuario->name }}</h3>
				</div>
				<div class="card-body">
					<form action="{{ route('usuarios.update',$usuario->id) }}" method="POST">
						@csrf
						@method('PUT')
						<div class="form-group">
							<label for="name">Nombre</label>
							<input type="text" name="name" class="form-control" value="{{ $usuario->name }}">
						</div>
						<div class="form-group">
							<label for="email">Correo Electrónico</label>
							<input type="email" name="email" class="form-control" value="{{ $usuario->email }}">
						</div>
						<div class="form-group">
							<label for="password">Contraseña</label>
							<input type="password" name="password" class="form-control" placeholder="Dejar en blanco si no se cambia la contraseña">
						</div>
						<div class="form-group">
							<label for="rol">Rol de Usuario</label>
							<select name="rol" class="form-control">
								@foreach($roles AS $rol)
									@if($usuario->hasRole($rol))
										<option value="{{ $rol }}" selected>{{ $rol }}</option>
									@else
										<option value="{{ $rol }}">{{ $rol }}</option>
									@endif	
								@endforeach
							</select>
						</div>
						<div>
							<input type="submit" value="Actualizar Usuario" class="btn btn-success btn-block"><br>
						</div>
						
					</form>	
					<div>
						<a href="{{ route('usuarios.index')}}" style="text-decoration: none;"><button class="btn btn-danger btn-block">Cancelar</button></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection