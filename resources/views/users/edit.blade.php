@extends('base::template')


@section('page.title', $user->getName())


@section('page.content')

	{{--Хлебные крошки--}}
	@include('base::users._breadcrumbs')

	{{--Табы--}}
	@include('base::users._tabs')

	{{--Форма с данными пользователя--}}
	@can('users.edit', [$user])
		<form
			method="POST"
			action="{{ route('admin.users.update', $user) }}"
			class="panel panel-default"
		>
			{!! method_field('PUT') !!}
			@include('base::users._form')
			<div class="panel-footer">
				@include('base::utils.buttons.save')
				@if(config('chunker.admin.can_user_delete'))
					@include('base::utils.buttons.delete', ['url' => route('admin.users.delete', compact('user'))])
				@endif
			</div>
		</form>
	@else
		@include('base::users._view')
	@endcan

@stop