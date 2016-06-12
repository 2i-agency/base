{{--Форма с данными пользователя--}}

{!! csrf_field() !!}

<div class="panel-heading">
	<h4 class="panel-title">
		<span class="fa fa-file-text"></span>
		Данные пользователя
		@if (isset($user))
			@include('chunker.base::admin.utils.edit', ['element' => $user, 'right' => true])
		@endif
	</h4>
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

</div>