<?php

$structure = config('admin.structure');
$markup = '';
$current_route = Route::currentRouteName();

foreach ($structure as $section_title => $section_data)
{
	// Dropdown list
	if (is_array($section_data))
	{
		$current_section = starts_with($current_route, $section_data['prefix'] . '.');

		$markup .= '
		<li class="dropdown' . ($current_section ? ' active' : NULL) . '">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				' . $section_title . '
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">';

		foreach ($section_data['children'] as $child_title => $child_route)
		{
			$markup .= '
			<li' . ($current_route == $child_route ? ' class="active"' : NULL) . '>
				<a href="' . route($child_route) . '">
					' . $child_title . '
				</a>
			</li>';
		}

		$markup .= '
			</ul>
		</li>';
	}
	// Section link
	else
	{
		$markup .= '
		<li' . ($current_route == $section_data ? ' class="active"' : NULL) . '>
			<a href="' . route($section_data) . '">
				' . $section_title . '
			</a>
		</li>';
	}
}


// Output markup of navigation
echo '<ul class="nav navbar-nav">' . $markup . '</ul>';