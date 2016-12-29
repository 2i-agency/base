@extends('chunker.base::template')


@section('page.title', $user->getName())


@section('page.content')

	{{--Хлебные крошки--}}
	@include('chunker.base::users._breadcrumbs')

	{{--Табы--}}
	@include('chunker.base::users._tabs')

	{{--Форма с данными пользователя--}}
	@can('users.edit', [$user])
		<form method="POST" action="{{ route('admin.users.update', $user) }}" class="panel panel-default">
			{!! method_field('PUT') !!}
			@include('chunker.base::users._form')
			<div class="panel-footer">
				@include('chunker.base::utils.buttons.save')
			</div>
		</form>
	@else
		@include('chunker.base::users._view')
	@endcan

@stop