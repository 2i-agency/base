<div class="alert alert-{{ $class or 'info' }}">
	{{ $message }}

	@if (isset($close) && $close)
		<button type="button" class="close" data-dismiss="alert">
			<span>&times;</span>
		</button>
	@endif
</div>