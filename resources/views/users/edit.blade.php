@extends('base::template')


@section('page.title', $user->getName())


@section('page.content')

	{{--Хлебные крошки--}}
	@include('base::users._breadcrumbs')

	{{--Табы--}}
	@include('base::users._tabs')

	{{--Форма с данными пользователя--}}
	@can('users.edit', [$user])
		<form method="POST" action="{{ route('admin.users.update', $user) }}" class="panel panel-default">
			{!! method_field('PUT') !!}
			@include('base::users._form')
			<div class="panel-footer">
				@include('base::utils.buttons.save')
			</div>
		</form>
	@else
		@include('base::users._view')
	@endcan

@stop