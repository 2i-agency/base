@extends('chunker.base::admin.template')


@section('page.title', 'Перенаправления')


@section('page.content')

	<h3>Перенаправления</h3>


	{{--Форма добавления--}}
	<form method="POST" class="panel panel-default" action="{{ route('admin.redirects.store') }}">
		{!! csrf_field() !!}

		<div class="panel-heading">
			<div class="panel-title">Новое перенаправление</div>
		</div>

		<div class="panel-body">
			<div class="row">

				{{--Откуда--}}
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<input
						type="text"
						name="from"
						placeholder="Откуда"
						class="form-control"
						required
						autocomplete="off"
						autofocus
						value="{{ old('from') }}"
					>
				</div>

				{{--Куда--}}
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<input
						type="text"
						name="to"
						placeholder="Куда"
						class="form-control"
						required
						autocomplete="off"
						value="{{ old('to') }}"
					>
				</div>

				{{--Комментарий--}}
				<div class="col-lg-3 col-md-3 col-sm-9 col-xs-12">
					<input
						type="text"
						name="comment"
						placeholder="Комментарий"
						class="form-control"
						autocomplete="off"
						value="{{ old('comment') }}"
					>
				</div>

				{{--Активно--}}
				<div class="col-lg-1 col-md-1 col-sm-3 col-xs-12">
					<p class="form-control-static">
						<label class="checkbox-inline">
							<input
								type="checkbox"
								name="is_active"
								value="1"
								{{ old('is_active') ? ' checked' : NULL }}
							>Активно
						</label>
					</p>
				</div>

				{{--Кнопка--}}
				<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
					@include('chunker.base::admin.utils.buttons.add', ['block' => true])
				</div>

			</div>
		</div>

	</form>


	{{--Список перенаправлений--}}
	@if ($redirects->count())

		{{--Пагинация--}}
		{!! $redirects->render() !!}

		<form method="POST" class="panel panel-default table-responsive" action="{{ route('admin.redirects.save') }}">
			{!! csrf_field() !!}
			{!! method_field('PUT') !!}

			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Откуда</th>
						<th>Куда</th>
						<th>Комментарий</th>
						<th>Активность</th>
						<th class="w1px"></th>
						<th class="w1px"></th>
					</tr>
				</thead>
				<tbody>
					@foreach($redirects as $redirect)
						<tr>

							{{--Откуда--}}
							<td>
								<input
									type="text"
									name="redirects[{{ $redirect->id }}][from]"
									required
									autocomplete="off"
									value="{{ old('redirects.' . $redirect->id . '.from') ?: $redirect->from }}"
									class="form-control"
								>
							</td>

							{{--Куда--}}
							<td>
								<input
									type="text"
									name="redirects[{{ $redirect->id }}][to]"
									required
									autocomplete="off"
									value="{{ old('redirects.' . $redirect->id . '.to') ?: $redirect->to }}"
									class="form-control"
								>
							</td>

							{{--Комментарий--}}
							<td>
								<input
									type="text"
									name="redirects[{{ $redirect->id }}][comment]"
									autocomplete="off"
									value="{{ old('redirects.' . $redirect->id . '.comment') ?: $redirect->comment }}"
									class="form-control"
								>
							</td>

							{{--Активно--}}
							<td>
								<div class="form-control-static">
									<label class="checkbox-inline">
										<input
											type="hidden"
											name="redirects[{{ $redirect->id }}][is_active]"
											value="0"
										>
										<input
											type="checkbox"
											name="redirects[{{ $redirect->id }}][is_active]"
											value="1"
										    @if (strlen(old('redirects.' . $redirect->id . '.is_active')))
											    {{ old('redirects.' . $redirect->id . '.is_active') ? ' checked' : NULL }}
											@else
											    {{ $redirect->is_active ? ' checked' : NULL }}
											@endif
										>Активно
									</label>
								</div>
							</td>

							{{--Удаление--}}
							<td>
								<div class="form-control-static">
									<label class="checkbox-inline">
										<input
											type="checkbox"
											name="delete[]"
											value="{{ $redirect->id }}"
										>Удалить
									</label>
								</div>
							</td>

							{{--Информация о редактировании--}}
							<td>
								<div class="form-control-static">
									@include('chunker.base::admin.utils.edit', ['element' => $redirect])
								</div>
							</td>

						</tr>
					@endforeach

				</tbody>
			</table>

			{{--Кнопка сохранения--}}
			<div class="panel-footer">
				@include('chunker.base::admin.utils.buttons.save')
			</div>

		</form>

		{{--Пагинация--}}
		{!! $redirects->render() !!}

	@else

		{{--Уведомление об отсутствии--}}
		@include('chunker.base::admin.utils.alert', ['message' => 'Перенаправления отсутствуют'])

	@endif

@stop