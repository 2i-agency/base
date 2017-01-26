<option
	value="{{ str_contains($ability, '.') ? $ability : 0 }}"
    {{ $is_selected ? ' selected' : NULL }}
>{{ $label }}</option>