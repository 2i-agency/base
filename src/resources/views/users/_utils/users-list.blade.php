@if ($users->count())
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Логин</th>
				<th>Электропочта</th>
				<th>Имя</th>
				<th>Последняя авторизация</th>
				<th></th>
			</tr>
			@foreach($users as $user)
				<tr>
					<td>{{ $user->login }}</td>
					<td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>

					@if ($user->name)
						<td>{{ $user->name }}</td>
					@else
						<td class="text-muted">Имя не указано</td>
					@endif

					@if ($user->authorizations()->count())
						<td>{{ $user->authorizations()->latest('logged_in_at')->first()->logged_in_at }}</td>
					@else
						<td class="text-muted">Пока не авторизовывался</td>
					@endif

					<td class="text-right">
						@if ($user->trashed())
							<a href="{{ route('admin.users.restore', $user) }}" class="btn btn-warning btn-xs">
								<span class="glyphicon glyphicon-repeat"></span>
								Восстановить
							</a>
						@else
							<a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-xs">
								<span class="glyphicon glyphicon-pencil"></span>
								Редактировать
							</a>
						@endif
					</td>
				</tr>
			@endforeach
		</thead>
	</table>
@else
	@include('Base::_utils.alert', ['message' => 'Пользователи отсутствуют'])
@endif