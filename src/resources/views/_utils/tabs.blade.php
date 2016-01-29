{{--Табы--}}
<ul class="nav nav-tabs">
	@foreach ($tabs as $tab_title => $tab_route)
		<li {!! $tab_route == Route::currentRouteName() ? ' class="active"' : NULL !!}>
			<a href="{{ route($tab_route) }}">{{ $tab_title }}</a>
		</li>
	@endforeach
</ul>