{{--Поле выбора даты и времени--}}
<div
	class="input-group date js-timepicker"
	@if(isset($format))
		data-format="{{ $format }}"
	@endif
>
	<input
		id="{{ $id or NULL }}"
		type="text"
		class="form-control"
		name="{{ $name }}"
		value="{{ $value or NULL }}"
		placeholder="{{ $placeholder or NULL }}"
		{{ isset($required) && $required ? 'required' : NULL }}
	>
	<span class="input-group-addon">
		<span class="fa fa-calendar"></span>
	</span>
</div>