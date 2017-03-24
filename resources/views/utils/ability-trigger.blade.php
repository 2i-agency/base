<option
	value="{{ str_contains($ability, '.') ? $ability : NULL }}"
	{{ $is_selected ? ' selected' : NULL }}
>{{ $label }}</option>