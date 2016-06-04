{{--Кнопка удаления--}}
<button
	type="submit"
	class="
		btn
		btn-danger
		{{ isset($block) && $block ? 'btn-block' : NULL }}
		{{ isset($size) ? 'btn-' . $size : NULL }}
	"
	@if (isset($url))
		formmethod="POST"
		formaction="{{ $url }}"
		name="_method"
		value="DELETE"
	@endif
>
	<span class="fa fa-times"></span>
	Удалить
</button>