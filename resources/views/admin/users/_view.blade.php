<div class="panel panel-default">

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
			<p class="form-control-static">{{ $user->login }}</p>
		</div>

		{{--Электронный адрес--}}
		<div class="form-group">
			<label>Электронный адрес:</label>
			<p class="form-control-static">
				<a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
			</p>
		</div>

		{{--Имя--}}
		<div class="form-group">
			<label>Имя:</label>
			<p class="form-control-static">{{ $user->name }}</p>
		</div>

		{{--Отправка уведомлений--}}
		<div class="form-group">
			<label>Получает уведомления:</label>
			<p class="form-control-static">{{ $user->is_subscribed ? 'Да' : 'Нет' }}</p>
		</div>

		{{--Заблокирован--}}
		<div class="form-group">
			<label>Заблокирован:</label>
			<p class="form-control-static">{{ $user->is_blocked ? 'Да' : 'Нет' }}</p>
		</div>

		{{--Роли--}}
		<div class="form-group">
			<label>Роли:</label>
			<p class="form-control-static">
				@if ($user->roles()->count())
					{{ implode(', ', $user->roles()->pluck('name')->toArray()) }}
				@else
					<span class="text-muted">Нет ролей</span>
				@endif
			</p>
		</div>

	</div>

</div>