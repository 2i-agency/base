@php($namespace = Chunker\Base\Models\Ability::detectNamespace($ability))
@php($disabled = \Auth::user()->hasAdminAccess($namespace) ? NULL : ' disabled')

<option
	value="{{ str_contains($ability, '.') ? $ability : 0 }}"
    {{ $is_selected ? ' selected' : NULL }}
	{{ $disabled }}
>{{ $label }}</option>