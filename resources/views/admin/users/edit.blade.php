@extends('chunker.base::admin.template')


@section('page.title', $user->getName())


@section('page.content')

	{{--Хлебные крошки--}}
	@include('chunker.base::admin.users._breadcrumbs')

	{{--Табы--}}
	@include('chunker.base::admin.users._tabs')

	{{--Форма с данными пользователя--}}
	@can('users.edit')
		<form method="POST" action="{{ route('admin.users.update', $user) }}" class="panel panel-default">
			{!! method_field('PUT') !!}
			@include('chunker.base::admin.users._form')
			<div class="panel-footer">
				@include('chunker.base::admin.utils.buttons.save')
			</div>
		</form>
	@else
		@include('chunker.base::admin.users._view')
	@endcan

@stop