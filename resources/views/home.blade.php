@extends('layouts.app')
@section('content')
<div class="mx-auto col-md-11 pt-4">
	<div class="row mx-md-n5">
	  <a href="{{ route('bakan.create') }}" class="btn col px-md-5" title="click para ir a la sección de Bakan">
	  	<div class="p-4 border bg-light">
	  		<img src="{{ URL::asset('public/images/logoBakanNuevo.JPG')  }}">
	  	</div>
	  </a>
	  <a href="{{ route('durex.create') }}" class="btn col px-md-5" title="click para ir a la sección de Durex">
	  	<div class="p-4 border bg-light">
	  		<img src="{{ URL::asset('public/images/durexlogo.png')  }}">
	  	</div>
	  </a>
	</div>
</div>
@stop