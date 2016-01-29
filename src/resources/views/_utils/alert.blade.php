{{--Уведомление--}}
<div class="alert alert-{{ $class or 'info' }}">

	{{ $message }}

	{{--Кнопка закрытия--}}
	@if (isset($close) && $close)
		<button type="button" class="close" data-dismiss="alert">
			<span>&times;</span>
		</button>
	@endif

</div>