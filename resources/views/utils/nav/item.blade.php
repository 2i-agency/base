@php

	$item_url = route($item['route']);
	$item_is_active = Route::currentRouteNamed($item['route']) || Request::fullUrlIs($item_url . '/*');

@endphp

{{--Ссылка на раздел--}}
@if (!isset($item['policy']) || Auth::user()->can($item['policy']))
	<li{!! $item_is_active ? ' class="active"' : NULL !!}>
		<a href="{{ $item_url }}">
			@include('chunker.base::utils.nav.icon')
			{{ $item['name'] }}
		</a>
	</li>
@endif