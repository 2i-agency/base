{{--Содержимое формы с данными пользователя--}}

{!! csrf_field() !!}

<div class="panel-heading">
	<h4 class="panel-title">Данные пользователя</h4>
</div>

<div class="panel-body">

	{{--Логин--}}
	<div class="form-group">
		<label>Логин:</label>
		<input
			type="text"
			name="login"
			value="{{ isset($user) ? $user->login : NULL }}"
			class="form-control"
			required
			autofocus
			autocomplete="off">
	</div>

	{{--Пароль--}}
	<div class="form-group">
		<label>Пароль:</label>
		<input type="password" name="password" class="form-control"{{ isset($user) ? NULL : ' require'}}>
	</div>

	{{--Электронный адрес--}}
	<div class="form-group">
		<label>Электронный адрес:</label>
		<input
			type="email"
			name="email"
			value="{{ isset($user) ? $user->email : NULL }}"
			class="form-control"
			required
			autocomplete="off">
	</div>

	{{--Имя--}}
	<div class="form-group">
		<label>Имя:</label>
		<input
			type="text"
			name="name"
			value="{{ isset($user) ? $user->name : NULL }}"
			class="form-control"
			autocomplete="off">
	</div>

	{{--Кнопка сохранения--}}
	@include('Base::_utils.buttons.save')

	{{--Кнопка удаления--}}
	@if (isset($user) && $user->isCanBeDeleted())
		@include('Base::_utils.buttons.delete', ['url' => route('admin.users.destroy', $user)])
	@endif

</div>