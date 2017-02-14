{{--Табы--}}
<ul class="nav nav-tabs">
	@foreach ($tabs as $tab_title => $tab_url)
		<li {!! $tab_url == Request::url() || Request::fullUrlIs($tab_url . '/') ? ' class="active"' : NULL !!}>
			<a href="{{ $tab_url }}">{!! $tab_title !!}</a>
		</li>
	@endforeach
</ul>