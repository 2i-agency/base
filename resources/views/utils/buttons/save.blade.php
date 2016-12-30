{{--Кнопка сохранения--}}
{{--@var bool   $block - флаг установки класса btn-block--}}
{{--@var string $size - указывает размер кнопки--}}
<button
	type="submit"
	class="
		btn
		btn-primary
		{{ isset($block) && $block ? 'btn-block' : NULL }}
		{{ isset($size) ? 'btn-' . $size : NULL }}
	"
>
	<span class="fa fa-check"></span>
	Сохранить
</button>