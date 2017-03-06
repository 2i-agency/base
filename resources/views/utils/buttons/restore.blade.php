{{--Кнопка Восстановления--}}
{{--@var bool   $block - флаг установки класса btn-block--}}
{{--@var string $size - указывает размер кнопки--}}
{{--@var string $url - ссылка по которой будет произведён запрос на восстановление--}}
<button
	type="submit"
	class="
		btn
		btn-success
		{{ isset($block) && $block ? 'btn-block' : NULL }}
		{{ isset($size) ? 'btn-' . $size : NULL }}
	"
	@if (isset($url))
		formmethod="POST"
		formaction="{{ $url }}"
		name="_method"
		value="put"
	@endif
>
	<span class="fa fa-reply"></span>{{ (isset($is_icon) && $is_icon) ? NULL : ' Восстановить' }}
</button>