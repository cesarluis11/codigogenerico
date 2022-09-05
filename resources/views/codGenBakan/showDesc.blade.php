@extends('layouts.app')
@section('content')
<div class="mx-auto col-md-11">
	<br>
	<div class="text-center">
		<h4>Editar la Descripción del Código: {{ $art[0]->Articulo }}</h4>
	</div>
	<form method="POST" action="{{ route('bakan.updateDescBakan',$art[0]->Articulo) }}">
	  @csrf
	  	@method('PUT')		
	  	<div class="form-group col-md-7">
		    <label for="desc1Actual">Descripción 1 Actual </label>
		    <input type="text" class="form-control" id="desc1Actual" value="{{ $art[0]->Descripcion1 }}" readonly="true">
		    <label for="desc1Corregida">Descripción 1 Corregida </label>
		    <input type="text" class="form-control" id="desc1Corregida" name="desc1Corregida" required="true" maxlength="100" autocomplete="false">
	  	</div>
		  <div class="form-group col-md-10">
		    <label for="desc2Actual">Descripción 2 Actual </label>
		    <input type="text" class="form-control" id="desc2Actual" value="{{ $art[0]->Descripcion2 }}" readonly="true">
		    <label for="desc2Corregida">Descripción 2 Corregida </label>
		    <input type="text" class="form-control" id="desc2Corregida" name="desc2Corregida" maxlength="240">
		  </div>
	  	<button type="submit" class="btn btn-primary btn-sm">Actualizar Descripción</button>
	  	<a href="{{ URL::previous() }}" class="btn btn-danger btn-sm">Regresar/Cancelar</a>
	</form>
</div>
@stop