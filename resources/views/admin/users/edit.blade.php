@extends('chunker.base::admin.template')


@section('page.title', $user->getName())


@section('page.content')

	{{--Хлебные крошки--}}
	@include('chunker.base::admin.users._breadcrumbs')

	{{--Табы--}}
	@include('chunker.base::admin.users._tabs')

	{{--Форма с данными пользователя--}}
	<form method="POST" action="{{ route('admin.users.update', $user) }}" class="panel panel-default">

		{!! method_field('PUT') !!}
		@include('chunker.base::admin.users._form')

		<div class="panel-footer">
			@include('chunker.base::admin.utils.buttons.save')

			@if ($user->isCanBeDeleted())
				@include('chunker.base::admin.utils.buttons.delete', ['url' => route('admin.users.destroy', $user)])
			@endif

		</div>
	</form>

@stop