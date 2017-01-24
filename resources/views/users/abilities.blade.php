@extends('base::template')


@section('page.title', 'Доступ пользователя ' . $user->getName())


@section('page.content')

	{{--Хлебные крошки--}}
	@include('base::users._breadcrumbs')

	{{--Табы--}}
	@include('base::users._tabs')

	<form action="{{ route('admin.users.update-abilities', ['user' => $user]) }}" method="POST">
		<input type="hidden" name="_method" value="PUT">
		{{--Роли--}}
		<div class="list-group">
			<div class="form-group list-group-item">
				<label>Роли:</label>
				<div>
					@foreach ($_roles as $_role)
						<label class="checkbox-inline">
							<input
								type="checkbox"
								name="roles[]"
								value="{{ $_role->id }}"
								{{ \Auth::user()->hasAdminAccess(['users', 'roles']) ? NULL : 'disabled' }}
								@if ((isset($user) && $user->isRelatedWith('roles', $_role)) || (array_search($_role->id, old('roles', [])) !== false))
								checked
								@endif
							>
							{{ $_role->name}}
						</label>
					@endforeach
				</div>
			</div>
		</div>

		{{--Настройка возможностей--}}
		@if (count($packages_abilities_views))
			<div class="list-group">
				@foreach($packages_abilities_views as $abilities_views)
					<div class="list-group-item">
						@foreach($abilities_views as $ability_view)
							@include($ability_view)
						@endforeach
					</div>
				@endforeach
			</div>
		@endif

		{{--Уведомления--}}
		@if ($notices_types->count())
			<div class="list-group">
				<div class="list-group-item">
					<label>Получает уведомления:</label>
					<div>
						@foreach($notices_types as $notices_type)
							<label class="checkbox-inline">
								<input
									type="checkbox"
									name="notices_types[]"
									value="{{ $notices_type->id }}"
									{{ $notices_type->users()->where('id', $user->id)->count() ? ' checked' : NULL }}
								>{{ $notices_type->name }}
							</label>
						@endforeach
					</div>
				</div>
			</div>
		@endif

		{{--Кнопки сохранения и удаления--}}
		@if(\Auth::user()->hasAdminAccess('users'))
			<div class="mb20px">
				@include('base::utils.buttons.save')
			</div>
		@endif
	</form>

@stop