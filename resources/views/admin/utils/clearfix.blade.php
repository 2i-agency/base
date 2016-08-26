@php

	$visibilities = [];

	foreach (compact('lg', 'md', 'sm', 'xs') as $size => $width) {
		$count = 12 / $width;
		if ($i && ($i % $count === 0)) {
			$visibilities[] = 'visible-' . $size;
		}
	}

@endphp

@if (count($visibilities))
	<div class="clearfix {{ implode(' ', $visibilities) }}"></div>
@endif