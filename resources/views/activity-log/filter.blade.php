{{--Форма поиска--}}
<form class="row mb20px" action="{{ route('admin.activity-log') }}" method="post">
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
				<option value="{{ $action }}">{{ $item['name'] }}</option>
			@endforeach
		</select>
	</div>

	{{--Пользователи--}}
	<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
		<select name="user" class="form-control">
			<option value="">Все пользователи</option>
			@if(isset($users))
				@foreach($users as $user)
					<option value="{{ $user->id }}">{{ $user->getName() }}</option>
				@endforeach
			@endif
		</select>
	</div>

	{{--Элементы--}}
	<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
		<select name="element" class="form-control">
			<option value="">Все элементы</option>
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