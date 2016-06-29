@php

	$item_is_active = false;

	foreach ($item['children'] as $child) {
		if (is_array($child))
		{
			$child_url = route($child['route']);
			$item_is_active = $item_is_active || (Route::currentRouteNamed($child['route']) || Request::fullUrlIs($child_url . '/*'));
		}
	}

@endphp

<li class="dropdown{!! $item_is_active ? ' active' : NULL !!}">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		@include('chunker.base::admin.utils.nav.icon')
		{{ $item['name'] }}
		<span class="caret"></span>
	</a>
	<ul class="dropdown-menu">
		@foreach ($item['children'] as $child)
			@if (is_array($child))
				@include('chunker.base::admin.utils.nav.item', ['item' => $child])
			@elseif ($child === '')
				<li class="divider"></li>
			@endif
		@endforeach
	</ul>
</li>