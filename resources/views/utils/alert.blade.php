{{--Уведомление--}}
<div class="alert alert-{{ $class or 'info' }}">

	{{--Кнопка закрытия--}}
	@if (isset($close) && $close)
		<button type="button" class="close" data-dismiss="alert">
			<span class="fa fa-times"></span>
		</button>
	@endif

	{{ $message }}

</div>