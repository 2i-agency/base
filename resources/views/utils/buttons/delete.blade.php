{{--Кнопка удаления--}}
{{--@var bool   $block - флаг установки класса btn-block--}}
{{--@var string $size - указывает размер кнопки--}}
{{--@var string $url - ссылка по которой будет произведён запрос на удаление--}}
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