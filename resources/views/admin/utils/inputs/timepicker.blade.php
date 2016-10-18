<div class="input-group date js-timepicker">
	<input
		id="{{ $id or NULL }}"
		type="text"
		class="form-control"
		name="{{ $name }}"
		value="{{ $value or NULL }}"
	    placeholder="{{ $placeholder or NULL }}"
	>
	<span class="input-group-addon">
		<span class="fa fa-calendar"></span>
	</span>
</div>