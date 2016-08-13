<label class="btn btn-default{{ $is_checked ? ' active' : NULL }}">

	<input
		type="radio"
		name="abilities[{{ Chunker\Base\Models\Ability::detectNamespace($ability) }}]"
		autocomplete="off"
		value="{{ str_contains($ability, '.') ? $ability : 0 }}"
		{{ $is_checked ? ' checked' : NULL }}
	>

	@if (isset($icon))
		<span class="fa fa-{{ $icon }}"></span>
	@endif

	{{ $label }}

</label>