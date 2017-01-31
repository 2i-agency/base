@extends('base::template')


@section('page.title', 'Доступ')


@section('page.content')

	<h3>Роли</h3>

	<div class="row">

		{{--Разделы--}}
		<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">

			@can('roles.edit', $role)
				<div class="list-group">
					<a href="{{ route('admin.roles') }}" class="list-group-item{{ $role->exists ? NULL : ' active' }}">
						<span class="fa fa-plus"></span>
						Новая роль
					</a>
				</div>
			@endcan

			@if ($_roles->count())
				<div class="list-group">
					@foreach ($_roles as $_role)
						<a
							href="{{ route('admin.roles', $_role) }}"
							class="list-group-item{{ $_role->is($role) ? ' active' : NULL }}{{ $_role->trashed() ? ' deleted': NULL}}"
						>
							{{ $_role['name'] }}
						</a>
					@endforeach
				</div>
			@endif

		</div>

		<div class="col-lg-10 col-md-9 col-sm-8 col-xs-12">

			{{--Форма--}}
			<form
				method="POST"
				action="{{ route('admin.roles.' . ($role->exists ? 'update' : 'store'), $role) }}"
			>
				{!! csrf_field() !!}
				@if($role->exists)
					{!! method_field('PUT') !!}
				@endif

				{{--Название--}}
				<div class="form-group">
					<label>Название:</label>
					@can('roles.edit', $role)
						<input
							type="text"
							name="name"
							class="form-control"
							autocomplete="off"
							autofocus
							required
							value="{{ old('name') ?: ($role->exists ? $role->name : NULL) }}"
							{{ !$role->trashed() ? NULL : 'disabled' }}
						>
					@else
						<p class="form-control-static">{{ $role->name }}</p>
					@endcan
				</div>

				{{--Настройка возможностей--}}
				@if (count($packages_abilities_views))
					<div class="list-group">
						@foreach($packages_abilities_views as $abilities_views)
							<div class="list-group-item">
								@foreach($abilities_views as $ability_view)
									@php($disabled = !\Auth::user()->hasAbility('roles.edit', $role) || $role->trashed() )
									@include($ability_view)
								@endforeach
							</div>
						@endforeach
					</div>
				@endif


				{{--Уведомления--}}
				@if (isset($role) && $role->noticesTypes()->count() || \Auth::user()->hasAbility('roles.edit', $role) )
					@if($notices_types->count())
						<div class="list-group">
							<div class="list-group-item">
								<label>Получает уведомления:</label>
								<div>
									@foreach($notices_types as $notices_type)
										@php($checked =
											(isset($role) && $role->isRelatedWith('noticesTypes', $notices_type))
											|| in_array($notices_type->id, old('notices_types', []))
										)
										<label class="checkbox-inline">

											@if(\Auth::user()->hasAdminAccess('roles'))
												<input
													type="checkbox"
													name="notices_types[]"
													value="{{ $notices_type->id }}"
													{{ $notices_type->roles()->where('id', $role->id)->count() ? ' checked' : NULL }}
													{{ !$role->trashed() ? NULL : 'disabled' }}
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
				@can('roles.edit', $role)
					<div class="mb20px">
						@if ($role->exists)
							@can('roles.admin', $role)
								@if($role->trashed())
									@include('base::utils.buttons.restore', ['url' => route('admin.roles.restore', $role)])
								@else
									@include('base::utils.buttons.save')
									@include('base::utils.buttons.delete', ['url' => route('admin.roles.destroy', $role)])
								@endif
							@endcan
						@else
							@include('base::utils.buttons.add')
						@endif
					</div>
				@endcan

			</form>
		</div>

	</div>

@stop