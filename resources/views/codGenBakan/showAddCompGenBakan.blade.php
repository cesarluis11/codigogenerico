@extends('layouts.app')
@section('content')
<div class="mx-auto col-md-11">
	<div>
		<h4>Información del Código Seleccionado</h4>
		<hr>
		<div class="form-row">
			<div class="col-md-2 mb-3 md-form">
				<label for="codGen">Código Genérico</label>
				<input type="text" class="form-control is-valid" id="codGen" name="codGen" value="{{ $getArticulo[0]->Articulo }}" readonly="true">
			</div>
			<div class="col-md-6 mb-3">
				<label for="des1CodGen">Descripción 1 del Código Genérico</label>
				<input type="text" class="form-control is-valid" id="des1CodGen" value="{{ $getArticulo[0]->Descripcion1 }}" readonly="true"> 
			</div>
			@if($getArticulo[0]->Descripcion2 != NULL)
				<div class="col-md-4 mb-3">
					<label for="des2CodGen">Descripción 2 del Código Génerico</label>
					<input type="text" class="form-control is-valid" id="des2CodGen" value="{{ $getArticulo[0]->Descripcion2 }}" readonly="true">
				</div>
			@endif
		</div>
		<hr>
		<h4>Componentes del Código Seleccionado</h4>
		<hr>
		@if($getCompArticulos->count() == 0)
			<h5>Sin Componentes</h5>
			<hr>
		@else
			@foreach($getCompArticulos AS $getCompArticulo)
				<div class="form-row">
					<div class="col-md-2 mb-3 md-form">
						<label for="codGen">Código Genérico</label>
						<input type="text" class="form-control is-valid codGen" id="{{ $getCompArticulo->Articulo }}" name="codGen" value="{{ $getCompArticulo->Articulo }}" readonly="true">
					</div>
					<div class="col-md-6 mb-3">
						<label for="des1CodGen">Descripción 1 del Código Genérico</label>
						<input type="text" class="form-control is-valid" id="des1CodGen" value="{{ $getCompArticulo->Descripcion1 }}" readonly="true"> 
					</div>
					@if($getCompArticulo->Descripcion2 != NULL)
						<div class="col-md-4 mb-3">
							<label for="des2CodGen">Descripción 2 del Código Génerico</label>
							<input type="text" class="form-control is-valid" id="des2CodGen" value="{{ $getCompArticulo->Descripcion2 }}" readonly="true">
						</div>
					@endif
				</div>
			@endforeach
			<hr>
		@endif
	</div>
	<div class="form-group text-center">
		<hr>
		<h4>Agregar Componentes al Código Genérico Asignado</h4>
		<hr>
		<div class="row">
			<div class="col-md">
				<div class="field_wrapperCasco">
					<div>
						<label for="casco">Agregar Casco o Estructura en Crudo</label><br>
						<a class="add_buttonCascoAdd btn btn-primary" title="Agregar Componente"><img src="{{ URL::asset('public/images/mas.png') }}" style="width: 20px; height: 20px;" /></a>
					</div>
				</div>
			</div>
			<div class="col-md">
				<div class="field_wrapperEstructura">
					<div>
						<label for="estruc">Agregar Estructura en Obra Negra</label><br>
						<a class="add_buttonEstructura btn btn-primary" title="gregar componente"><img src="{{ URL::asset('public/images/mas.png') }}" style="width: 20px; height: 20px;" /></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop