@extends('chunker.base::base')


@section('page.assets')
	<link rel="stylesheet" href="{{ asset('admin/css/auth.css') }}">
@stop


@section('page.body')

	<div>
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12 col-lg-offset-4 col-md-offset-3 col-sm-offset-2">
					@include('chunker.base::utils.flash.message')
					@yield('content')
				</div>
			</div>
		</div>
	</div>

@stop