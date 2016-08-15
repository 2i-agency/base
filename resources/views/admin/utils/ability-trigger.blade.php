@php($namespace = Chunker\Base\Models\Ability::detectNamespace($ability))
@php($disabled = Auth::user()->can('roles.edit') && Auth::user()->can($namespace . '.edit') ? NULL : ' disabled')

<label class="btn btn-default {{ $is_checked ? ' active' : NULL }} {{ $disabled }}">

	<input
		type="radio"
		name="abilities[{{ $namespace }}]"
		autocomplete="off"
		value="{{ str_contains($ability, '.') ? $ability : 0 }}"
		{{ $is_checked ? ' checked' : NULL }}
		{{ $disabled }}
	>

	@if (isset($icon))
		<span class="fa fa-{{ $icon }}"></span>
	@endif

	{{ $label }}

</label>