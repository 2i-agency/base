@extends('chunker.base::admin.template')


@section('page.title', 'Роли')


@section('page.content')

	<h3>Роли</h3>

	<div class="row">

		{{--Разделы--}}
		<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">

			@can('roles.edit')
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
							class="list-group-item{{ $_role->is($role) ? ' active' : NULL }}"
						>
							{{ $_role['name'] }}
						</a>
					@endforeach
				</div>
			@endif

		</div>

		<div class="col-lg-10 col-md-9 col-sm-8 col-xs-12">

			{{--Форма--}}
			<form method="POST" class="panel panel-default" action="{{ route('admin.roles.' . ($role->exists ? 'update' : 'store'), $role) }}">
				{!! csrf_field() !!}
				@if($role->exists)
					{!! method_field('PUT') !!}
				@endif

				<div class="panel-heading">
					<h4 class="panel-title">Данные роли</h4>
				</div>

				<div class="list-group">
					<div class="list-group-item">
						<div class="form-group">
							<label>Название:</label>
							@can('roles.edit')
								<input
									type="text"
									name="name"
									class="form-control"
									autocomplete="off"
									autofocus
									required
									value="{{ old('name') ?: ($role->exists ? $role->name : NULL) }}"
								>
							@else
								<p class="form-control-static">{{ $role->name }}</p>
							@endcan
						</div>
					</div>

					@if (count($abilities_views))
						<div class="list-group-item">
							@foreach($abilities_views as $ability_view)
								@include($ability_view)
							@endforeach
						</div>
					@endif

				</div>

				@can('roles.edit')
					<div class="panel-footer">
						@if ($role->exists)
							@include('chunker.base::admin.utils.buttons.save')
							@include('chunker.base::admin.utils.buttons.delete', ['url' => route('admin.roles.destroy', $role)])
						@else
							@include('chunker.base::admin.utils.buttons.add')
						@endif
					</div>
				@endcan

			</form>
		</div>


	</div>

@stop