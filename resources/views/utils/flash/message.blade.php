{{--Вывод уведомлений о результате той или иной операции--}}
{{--@var array $errors - массив с сообщениями--}}
@if (session()->has('flash_notification.message') || $errors->count())
	{{--Отображение в виде модального окна--}}
	@if (session()->has('flash_notification.overlay'))
		@include('flash::modal', [
			'modalClass' => 'flash-modal',
			'title'      => session('flash_notification.title'),
			'body'       => session('flash_notification.message')
		])
	@else
		{{--отображение в виде нотиса--}}
		<div class="alert alert-{{ $errors->count() ? 'danger' : session('flash_notification.level') }}">
			<button type="button"
					class="close"
					data-dismiss="alert"
					aria-hidden="true">
				<span class="fa fa-times"></span>
			</button>

			<ul class="list-unstyled">
				<li>{!! session('flash_notification.message') !!}</li>
				@foreach ($errors->all('<li>:message</li>') as $error)
					{!! $error !!}
				@endforeach
			</ul>
		</div>
	@endif
@endif

