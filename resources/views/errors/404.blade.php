@extends('layouts.errors')

<style type="text/css" media="screen">
	#app{
		padding:10% 0;
		text-align: center;
	}
	h1{
		font-size: 70px !important;
	}
	p{
		font-size: 30px;
	}
	b{
		font-size: 18px;
	}
</style>

@section('content')
	<h1>¡ Perdido ! </h1>
	<p> No importa, siempre hay solución </p>
	<b> Para volver a tu destino <a href="{{ url('/') }}">Click Aquí</a> </b>
@endsection
