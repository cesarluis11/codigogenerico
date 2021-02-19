@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row justify container-center">
		<div class="col-sm-8">
			<div class="card">
				<div class="card-heading text-center pt-3">
					<h3>Nuevo Usuario</h3>
				</div>
				<div class="card-body">
					<form action="{{ route('usuarios.store') }}" method="POST">
						@csrf
						<div class="form-group">
							<label for="name">Nombre</label>
							<input type="text" name="name" class="form-control UpperCase" required maxlength="38">
						</div>
						<div class="form-group">
							<label for="email">Correo Electrónico</label>
							<input type="email" name="email" class="form-control" required>
						</div>
						<div class="form-group">
							<label for="password">Contraseña</label>
							<input type="password" name="password" class="form-control" required>
						</div>
						<div class="form-group">
							<label for="rol">Rol de Usuario</label>
							<select name="rol" class="form-control" required>
								<option value="">seleccione una opción... </option>
								@foreach($roles AS $rol)
									<option value="{{ $rol}}">{{ $rol}}</option>
								@endforeach
							</select>
						</div>
						<div>
							<input type="submit" value="Guardar Usuario" class="btn btn-success btn-block"><br>
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