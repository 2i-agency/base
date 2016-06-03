@extends('chunker.base::base')


@section('page.body')

	<div class="container" style="margin-top: 100px;">
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 col-lg-offset-4 col-md-offset-4 col-sm-offset-3">@yield('content')</div>
		</div>
	</div>

@stop