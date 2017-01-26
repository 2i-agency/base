@extends('base::template')


@section('page.title', 'Доступ пользователя ' . $user->getName())


@section('page.content')

	{{--Хлебные крошки--}}
	@include('base::users._breadcrumbs')

	{{--Табы--}}
	@include('base::users._tabs')

	<form action="{{ route('admin.users.update-abilities', ['user' => $user]) }}" method="POST">
		<input type="hidden" name="_method" value="PUT">

		@if(isset($user) && $user->roles()->count() || \Auth::user()->hasAdminAccess('roles'))
			{{--Роли--}}
			<div class="list-group">
				<div class="form-group list-group-item">
					<label>Роли:</label>
					<div>

						@foreach ($_roles as $_role)
							@php($checked = (isset($user) && $user->isRelatedWith('roles', $_role)) || in_array($_role->id, old('roles', [])))
							<label class="checkbox-inline">
								@if(\Auth::user()->hasAdminAccess('roles'))
									<input
										type="checkbox"
										name="roles[]"
										value="{{ $_role->id }}"
										{{ $checked ? 'checked' : NULL }}
									>
									{{ $_role->name }}
								@elseif($checked)
									{{ $_role->name }}
								@endif
							</label>
						@endforeach

					</div>
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
		@if (isset($user) && $user->noticesTypes()->count() || \Auth::user()->hasAdminAccess('notices-types') )
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

									@if(\Auth::user()->hasAdminAccess('roles'))
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
		@if(\Auth::user()->hasAdminAccess([$ability_view, 'users']))
			<div class="mb20px">
				@include('base::utils.buttons.save')
			</div>
		@endif
	</form>

@stop