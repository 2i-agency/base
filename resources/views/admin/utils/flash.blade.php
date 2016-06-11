{{--Ошибки валидации--}}
@if($errors->count())
	@php
		flash()->error('test');
	@endphp
	<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert">
			<span class="fa fa-times"></span>
		</button>
		<ul class="list-unstyled">
			@foreach($errors->all() as $error)
				<li>{!! $error !!}</li>
			@endforeach
		</ul>
	</div>
@endif

@include('flash::message')