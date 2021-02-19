@extends('layouts.app')
@section('content')
{{-- is-valid is-invalid --}}
<div class="mx-auto col-md-11"> <!--pt-5-->
	@if ($errors->any())
	    <div class="alert alert-danger">
	        <ul> {{ $errors->first('ptxAsignado') }} </ul>
	        <ul> {{ $errors->first('codGenerico') }} </ul>
	        <ul> {{ $errors->first('des1CodGenerico') }} </ul>
	        <ul> {{ $errors->first('codigoComponCasco') }} </ul>
	        <ul> {{ $errors->first('codigoCompoCascoDescrip') }} </ul>
	        <ul> {{ $errors->first('codigoComponOAN') }} </ul>
	        <ul> {{ $errors->first('codigoCompoOANDescrip') }} </ul>
	        <ul> {{ $errors->first('solicito') }} </ul>
	    </div>
	    <hr/>
	@endif
	<h3 class="text-center">Asignar Nuevo Código Genérico de BAKAN</h3><hr>
	<form action="{{ route('bakan.store') }}" method="post">
		@csrf
		<div id="ptAsignado" class="form-row">
			<div class="col-md-2 mb-3 md-form">
				<label for="ptxAsignado">PT por Asignar</label>
				<input type="text" class="form-control solo-numeros" id="ptxAsignado" name="ptxAsignado" placeholder="Introduce el PT por Asignar" autofocus required>
				<div id="invalid" class="invalid-feedback">
				</div>
			</div>
			<div class="col-md-6 mb-3">
				<label for="desc1PtxAsignado">Descripción 1 del PT por Asignar</label>
				<input type="text" class="form-control" id="desc1PtxAsignado" readonly>
			</div>
			<div class="col-md-4 mb-3">
				<label for="desc2PtxAsignado">Descripción 2 del PT por Asignar</label>
				<input type="text" class="form-control" id="desc2PtxAsignado" readonly>
			</div>
		</div>
		<div id="codGenAsignado" class="form-row">
			<hr>
			<div class="col-md-2 mb-3 md-form">
				<label for="codGenerico">Código Genérico Asignado</label>
				<input type="text" class="form-control is-valid" id="codGenerico" name="codGenerico" value="{{ $codigoAsignado }}" readonly>
			</div>
			<div class="col-md-6 mb-3">
				<label for="des1CodGenerico">Descripción 1 del Código Genérico Asignado</label>
				<input type="text" class="form-control " id="des1CodGenerico" name="des1CodGenerico" required> 
				<div id="invalidDes1CodGenerico" class="invalid-feedback">
				</div>
			</div>
			<div class="col-md-4 mb-3">
				<label for="des2CodGenerico">Descripción 2 del Código Genérico Asignado</label>
				<input type="text" class="form-control UpperCase" id="des2CodGenerico" name="des2CodGenerico">
			</div>
		</div>
		<div id="codGenAsignadoComp" class="form-group text-center">
			<hr>
			<h4>Agregar Componentes al Código Genérico Asignado</h4>
			<hr>
			<div class="row">
				<div class="col-md">
					<div class="field_wrapperCasco">
						<div>
							<label for="casco">Agregar Casco o Estructura en Crudo</label><br>
							<a class="add_buttonCasco btn btn-primary" title="Agregar Componente"><img src="{{ URL::asset('public/images/mas.png') }}" style="width: 20px; height: 20px;" /></a>
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
		{{-- <div id="autor" class="form-group" align="center">
			<hr>
			<label for="autor">Quien solicito</label>
			<select class="form-control col-md-6" name="solicito" required>
		        <option value="">Selecciona un opción...</option>
		        <option value="ACORDOBA">ALFREDO CORDOBA</option>
		        <option value="DVAZQUEZ">DANIEL VAZQUEZ</option>
		        <option value="FRODRIGUEZ">FERNANDO RODRIGUEZ</option>
		        <option value="IDOMINGUEZ">IAMARA DOMINGUEZ</option>
		    </select>
		</div> --}}
		<div align="center">
			<button id="enviarSoliCodGenBakan" class="btn btn-primary" type="submit">Enviar Solicitud</button>
		</div>
	</form>
</div>
@stop