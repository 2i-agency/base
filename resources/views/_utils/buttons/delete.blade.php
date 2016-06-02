{{--Кнопка удаления--}}
<button
	type="submit"
	class="
		btn
		btn-danger
		@if (isset($block) && $block)
			btn-block
		@endif
		@if (isset($size))
			btn-{{ $size }}
		@endif
	"
	@if (isset($url))
		formmethod="POST"
		formaction="{{ $url }}"
		name="_method"
		value="DELETE"
	@endif
>
	<span class="glyphicon glyphicon-remove"></span>
	Удалить
</button>