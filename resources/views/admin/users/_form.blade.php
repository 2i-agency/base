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
			value="{{ old('login') ?: (isset($user) ? $user->login : NULL) }}"
			class="form-control"
			pattern="^[0-9A-Za-z][0-9A-Za-z-]*[0-9A-Za-z]$"
			maxlength="20"
			required
			autofocus
			autocomplete="off">
		<div class="help-block">Логин может содержать латинские буквы и дефис, должен начинаться и заканчиваться буквой и содержать не более 20 символов</div>
	</div>

	{{--Пароль--}}
	<div class="form-group">
		<label>Пароль:</label>
		<input
			type="password"
			name="password"
			class="form-control"{{ isset($user) ? NULL : ' required'}}
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

	{{--Роли--}}
	<div class="form-group">
		<label>Роли:</label>
		<div>
			@foreach ($_roles as $_role)
				<label class="checkbox-inline">
					<input
						type="checkbox"
						name="roles[]"
						value="{{ $_role->id }}"
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