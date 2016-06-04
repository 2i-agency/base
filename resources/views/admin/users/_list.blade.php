@if ($users->count())

	{{--Список пользователей--}}
	<div class="panel panel-default table-responsive">
		<table class="table table-striped table-hover">

			<thead>
				<tr>
					<th>Логин</th>
					<th>Электропочта</th>
					<th>Имя</th>
					<th>Последняя авторизация</th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				@foreach($users as $user)
					<tr>

						{{--Логин--}}
						<td>{{ $user->login }}</td>

						{{--Электронный адрес--}}
						<td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>

						{{--Имя--}}
						@if ($user->name)
							<td>{{ $user->name }}</td>
						@else
							<td class="text-muted">Имя не указано</td>
						@endif

						{{--Время последней авторизации--}}
						@if ($user->authentications()->count())
							<td>{{ $user->authentications()->recent()->first(['logged_in_at'])->logged_in_at }}</td>
						@else
							<td class="text-muted">Пока не авторизовывался</td>
						@endif

						{{--Ссылки на страницу редактирования--}}
						<td class="text-right">
							@if ($user->trashed())
								<a href="{{ route('admin.users.restore', $user) }}" class="btn btn-warning btn-xs">
									<span class="fa fa-repeat"></span>
									Восстановить
								</a>
							@else
								<a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-xs">
									<span class="fa fa-pencil"></span>
									Редактировать
								</a>
							@endif
						</td>

					</tr>
				@endforeach
			</tbody>

		</table>
	</div>

@else

	{{--Уведомление об отсутствии пользователей--}}
	@include('chunker.base::admin.utils.alert', ['message' => 'Пользователи отсутствуют'])

@endif