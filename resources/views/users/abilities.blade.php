@extends('base::template')


@section('page.title', 'Доступ пользователя ' . $user->getName())


@section('page.content')

	{{--Хлебные крошки--}}
	@include('base::users._breadcrumbs')

	{{--Табы--}}
	@include('base::users._tabs')

	<form action="{{ route('admin.users.update-abilities', ['user' => $user]) }}" method="POST">
		<input type="hidden" name="_method" value="PUT">

		@if(
			app('Packages')->isActiveSection('roles')
			&& (
				isset($user)
				&& \Auth::user()->hasAdminAccess(['users', 'roles'])
				|| $user->roles()->count()
			)
		)
			{{--Роли--}}
			<div class="list-group">
				<div class="form-group list-group-item">
					<label>Роли:</label>
					@if(\Auth::user()->hasAdminAccess(['users', 'roles']))
						<div>

							@foreach ($_roles as $_role)
								@php($checked = (isset($user) && $user->isRelatedWith('roles', $_role)) || in_array($_role->id, old('roles', [])))
								<label class="checkbox-inline">
									<input
										type="checkbox"
										name="roles[]"
										value="{{ $_role->id }}"
										{{ $checked ? 'checked' : NULL }}
									>
									{{ $_role->name }}
								</label>
							@endforeach

						</div>
					@else
						@php($roles_checked = [])
						@foreach ($_roles as $_role)

							@if((isset($user) && $user->isRelatedWith('roles', $_role)) || in_array($_role->id, old('roles', [])))
								@php($roles_checked[] =  $_role->name)
							@endif
						@endforeach
						{{ implode(', ', $roles_checked) }}
					@endif
				</div>
			</div>
		@endif

		{{--Настройка возможностей--}}
		@if (count($packages_abilities_views))
			<div class="list-group">
				@foreach($packages_abilities_views as $abilities_views)
					<div class="list-group-item">
						@foreach($abilities_views as $ability_view)
							@php($disabled = !\Auth::user()->hasAdminAccess([$ability_view, 'users']))
							@include($ability_view)
						@endforeach
					</div>
				@endforeach
			</div>
		@endif

		{{--Уведомления--}}
		@if(
			app('Packages')->isActiveSection('notices-types')
			&& (
				isset($user)
				&& \Auth::user()->hasAdminAccess(['users', 'notices-types'], $user)
				|| $user->noticesTypes()->count()
			)
		)
			@if($notices_types->count())
				<div class="list-group">
					<div class="list-group-item">
						<label>Получает уведомления:</label>
						<div>
							@foreach($notices_types as $notices_type)
								@php($checked =
									(isset($user) && $user->isRelatedWith('noticesTypes', $notices_type))
									|| in_array($notices_type->id, old('notices_types', []))
								)
								<label class="checkbox-inline">

									@if(\Auth::user()->hasAdminAccess(['users', 'notices-types']))
										<input
											type="checkbox"
											name="notices_types[]"
											value="{{ $notices_type->id }}"
											{{ $notices_type->users()->where('id', $user->id)->count() ? ' checked' : NULL }}
										>{{ $notices_type->name }}
									@elseif($checked)
										{{ $notices_type->name }}
									@endif

								</label>
							@endforeach
						</div>
					</div>
				</div>
			@endif
		@endif

		{{--Кнопки сохранения и удаления--}}
		@if(\Auth::user()->hasAdminAccess(['users']) && \Auth::user()->hasAdminAccess(['roles', 'notices-types'], NULL, false))
			<div class="mb20px">
				@include('base::utils.buttons.save')
			</div>
		@endif
	</form>

@stop