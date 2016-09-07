<textarea
	name="{{ $name or 'content' }}"
	rows="10"
	class="form-control js-editor"
	data-css="{{ json_encode(config('chunker.admin.editor.css')) }}"
	data-js="{{ json_encode(config('chunker.admin.editor.js')) }}"
    @if (isset($disabled) && $disabled) disabled @endif
>{!! $value or NULL !!}</textarea>