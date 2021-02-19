@extends('layouts.app')
@section('content')
<div class="mx-auto col-md-11">
	<h3 class="text-center">Asignar Nuevo Código Genérico de DUREX</h3><hr>
	<form action="{{ route('durex.store') }}" method="post">
		@csrf
		<div id="codGenAsignadoDurex" class="form-row">
			<hr>
			<div class="col-md-2 mb-3 md-form">
				<label for="codGenericoDurex">Código Genérico Asignado</label>
				<input type="text" class="form-control is-valid" id="codGenericoDurex" name="codGenericoDurex" value="{{ $codigoAsignado }}" readonly>
			</div>
			<div class="col-md-6 mb-3">
				<label for="des1CodGenericoDurex">Descripción 1 del Código Genérico Asignado</label>
				<input type="text" class="form-control UpperCase" id="des1CodGenericoDurex" name="des1CodGenericoDurex" required placeholder="Descripción 1"> 
				<div id="invalidDes1CodGenerico" class="invalid-feedback">
				</div>
			</div>
			<div class="col-md-4 mb-3">
				<label for="des2CodGenericoDurex">Descripción 2 del Código Génerico Asignado</label>
				<input type="text" class="form-control UpperCase" id="des2CodGenericoDurex" name="des2CodGenericoDurex" placeholder="Descripción 2">
			</div>
		</div>
		<div id="codGenAsignadoCompDurex" class="form-group text-center">
			<hr>
			<h4>Agregar Componentes al Código Genérico Asignado</h4>
			<hr>
			<div class="row">
				<div class="col-md">
					<div class="field_wrapperCascoDurex">
						<div>
							<label for="casco">Agregar Casco o Estructura en Crudo</label><br>
							<a class="add_buttonCasco btn btn-primary" title="Agregar Componente"><img src="public/images/mas.png" style="width: 20px; height: 20px;" /></a>
						</div>
					</div>
				</div>
				<div class="col-md">
					<div class="field_wrapperEstructuraDurex">
						<div>
							<label for="estruc">Agregar Estructura en Obra Negra</label><br>
							<a class="add_buttonEstructura btn btn-primary" title="gregar componente"><img src="public/images/mas.png" style="width: 20px; height: 20px;" /></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div align="center">
			<button id="enviarSoliCodGenDurex" class="btn btn-primary" type="submit">Enviar Solicitud</button>
		</div>	
	</form>
</div>
@stop