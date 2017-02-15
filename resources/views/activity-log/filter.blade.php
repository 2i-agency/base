{{--Форма поиска--}}
<form class="row mb20px" action="{{ $action }}" method="post">
	{!! csrf_field() !!}

	{{--С--}}
	<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
		@include('base::utils.inputs.timepicker', [
			'name'          => 'published_since',
			'placeholder'   => 'С',
			'value'         => Request::get('published_since')
		])
	</div>

	{{--По--}}
	<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
		@include('base::utils.inputs.timepicker', [
			'name'          => 'published_until',
			'placeholder'   => 'По',
			'value'         => Request::get('published_until')
		])
	</div>

	{{--Действия--}}
	<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
		<select name="log_name" class="form-control">
			<option value="">Все действия</option>
			@foreach($actions as $action => $item)
				<option value="{{ $action }}" {{ request('log_name') == $action ? 'selected' : NULL }}>{{ $item['name'] }}</option>
			@endforeach
		</select>
	</div>

	{{--Пользователи--}}
	@if(isset($user))
		<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
			<select name="causes" class="form-control" disabled>
				<option value="{{ $user->id }}" {{ request('causes') == $user->id ? 'selected' : NULL }}>{{ $user->getName() }}</option>
			</select>
		</div>
	@else
		<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
			<select name="causes" class="form-control">
				<option value="">Все пользователи</option>
				<optgroup label="Пользователи">
					@if(isset($users))
						@foreach($users as $user)
							<option value="user:{{ $user->id }}" {{ request('causes') == 'user:' . $user->id ? 'selected' : NULL }}>{{ $user->getName() }}</option>
						@endforeach
					@endif
				</optgroup>
				<optgroup label="Роли">
					@if(isset($roles))
						@foreach($roles as $role)
							<option value="role:{{ $role->id }}" {{ request('causes') == 'role:' . $role->id ? 'selected' : NULL }}>{{ $role->name }}</option>
						@endforeach
					@endif
				</optgroup>
			</select>
		</div>
	@endif

	{{--Элементы--}}
	<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
		<select name="element" class="form-control">
			<option value="">Все элементы</option>
			@foreach(app('Packages')->getActivityElements() as $class => $activity_element)
				<option
					value="{{ $class }}"
					{{ request('element') == $class ? 'selected' : NULL }}
				>{{ trans_choice($activity_element, 2) }}</option>
			@endforeach
		</select>
	</div>

	{{--Кнопка--}}
	<div class="col-lg-2 col-md-3 col-sm-3 col-xs-6">
		<button type="submit" class="btn btn-primary btn-block">
			<span class="fa fa-search"></span>
			Найти
		</button>
	</div>

</form>