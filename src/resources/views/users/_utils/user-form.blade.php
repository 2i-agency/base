{!! csrf_field() !!}
<div class="panel-heading">
	<h4 class="panel-title">Данные пользователя</h4>
</div>
<div class="panel-body">

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

	<div class="form-group">
		<label>Пароль:</label>
		@if (isset($user))
			<input type="password" name="password" class="form-control">
		@else
			<input type="password" name="password" class="form-control" required>
		@endif
	</div>

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

	<div class="form-group">
		<label>Имя:</label>
		<input
			type="text"
			name="name"
			value="{{ isset($user) ? $user->name : NULL }}"
			class="form-control"
			autocomplete="off">
	</div>

	@include('Base::_utils.buttons.save')

	@if (isset($user) && $user->isCanBeDeleted())
		@include('Base::_utils.buttons.delete', ['url' => route('admin.users.delete', $user)])
	@endif

</div>