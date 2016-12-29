@php

	$parent_is_active = false;
	$children = [];

	foreach ($item['children'] as $child) {

		// Добавление дочернего элемента
		if (is_array($child))
		{
			if (!isset($child['policy']) || Auth::user()->can($child['policy'])) {
				$children[] = $child;
				$child_url = route($child['route']);
				$parent_is_active = $parent_is_active || (Route::currentRouteNamed($child['route']) || Request::fullUrlIs($child_url . '/*'));
			}
		}

		// Добавление разделителя
		elseif (count($children) && $children[count($children) - 1] !== '') {
			$children[] = $child;
		}

	}

	// Удаление концевого разделителя
	if (count($children) && $children[count($children) - 1] === '') {
		array_pop($children);
	}

@endphp

@if(count($children) > 1)

	{{--Выпадающее меню--}}
	<li class="dropdown{!! $parent_is_active ? ' active' : NULL !!}">

		{{--Родительский элемент--}}
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			@include('chunker.base::utils.nav.icon')
			{{ $item['name'] }}
			<span class="caret"></span>
		</a>

		{{--Вложенные элементы--}}
		<ul class="dropdown-menu">

			@foreach ($children as $child)

				{{--Дочерний элемент--}}
				@if (is_array($child))
					@include('chunker.base::utils.nav.item', ['item' => $child])

				{{--Разделитель--}}
				@elseif ($child === '')
					<li class="divider"></li>
				@endif

			@endforeach

		</ul>

	</li>

@elseif(count($children) == 1)

	@include('chunker.base::utils.nav.item', [ 'item' => $children[0] ])

@endif