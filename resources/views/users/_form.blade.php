{{--Форма с данными пользователя--}}

{!! csrf_field() !!}

<div class="panel-heading">
	<h4 class="panel-title">
		<span class="fa fa-file-text"></span>
		Данные пользователя
	</h4>
</div>

<div class="panel-body">

	{{--Логин--}}
	<div class="form-group">
		<label>Логин:</label>
		<input
			type="text"
			name="login"
			value="{{ old('login') ?: (isset($user) ? $user->login : NULL) }}"
			class="form-control"
			pattern="^[0-9A-Za-z][0-9A-Za-z-]*[0-9A-Za-z]$"
			maxlength="20"
			required
			autofocus
			autocomplete="off">
		<div class="help-block">
			Логин может содержать латинские буквы, цифры и дефис и содержать не более 20 символов
		</div>
	</div>

	{{--Пароль--}}
	<div class="form-group">
		<label>Пароль:</label>
		<input
			type="password"
			name="password"
			class="form-control"
			{{ isset($user) ? NULL : ' required'}}
			minlength="6"
		>
		<div class="help-block">Не менее 6 символов</div>
	</div>

	{{--Электронный адрес--}}
	<div class="form-group">
		<label>Электронный адрес:</label>
		<input
			type="email"
			name="email"
			value="{{ old('email') ?: (isset($user) ? $user->email : NULL) }}"
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
			value="{{ old('name') ?: (isset($user) ? $user->name : NULL) }}"
			class="form-control"
			autocomplete="off">
	</div>

	{{--Отправка уведомлений--}}
	<div class="form-group">
		<label>Отправлять уведомления:</label>
		<div>
			<label class="radio-inline">
				<input
					type="radio"
					name="is_subscribed"
					value="1"
					{{ !isset($user) || $user->is_subscribed ? ' checked' : NULL }}
				>Да
			</label>
			<label class="radio-inline">
				<input
					type="radio"
					name="is_subscribed"
					value="0"
					{{ isset($user) && !$user->is_subscribed ? ' checked' : NULL }}
				>Нет
			</label>
		</div>
	</div>

	{{--Заблокирован--}}
	<div class="form-group">
		<label>Заблокирован:</label>
		<div>
			<label class="radio-inline">
				<input
					type="radio"
					name="is_blocked"
					value="1"
					{{ isset($user) && $user->is_blocked ? ' checked' : NULL }}
					{{ isset($user) && !$user->isCanBeBlocked() ? ' disabled' : NULL }}
				>Да
			</label>
			<label class="radio-inline">
				<input
					type="radio"
					name="is_blocked"
					value="0"
					{{ !isset($user) || !$user->is_blocked ? ' checked' : NULL }}
					{{ isset($user) && !$user->isCanBeBlocked() ? ' disabled' : NULL }}
				>Нет
			</label>
		</div>
	</div>

	{{--Заблокирован--}}
	<div class="form-group">
		<label>Доступ в админ-центр:</label>
		<div>
			<label class="radio-inline">
				<input
					type="radio"
					name="is_admin"
					value="1"
					{{ isset($user) && $user->is_admin ? ' checked' : NULL }}
					{{ isset($user) && !$user->isCanBeAdminChanged() ? ' disabled' : NULL }}
				>Да
			</label>
			<label class="radio-inline">
				<input
					type="radio"
					name="is_admin"
					value="0"
					{{ !isset($user) || !$user->is_admin ? ' checked' : NULL }}
					{{ isset($user) && !$user->isCanBeAdminChanged() ? ' disabled' : NULL }}
				>Нет
			</label>
		</div>
	</div>

</div>