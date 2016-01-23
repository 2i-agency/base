<button
	type="submit"
	class="btn btn-danger{{ isset($block) && $block ? ' btn-block' : NULL }}"
	formmethod="POST"
	formaction="{{ $url }}"
	name="_method"
	value="DELETE">
	<span class="glyphicon glyphicon-remove"></span>
	Удалить
</button>