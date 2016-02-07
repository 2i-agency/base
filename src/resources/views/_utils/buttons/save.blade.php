{{--Кнопка сохранения--}}
<button
	type="submit"
	class="
		btn
		btn-primary
		@if (isset($block) && $block)
			btn-block
		@endif
		@if (isset($size))
			btn-{{ $size }}
		@endif
	"
>
	<span class="glyphicon glyphicon-ok"></span>
	Сохранить
</button>