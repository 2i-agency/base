<ul class="nav navbar-nav">
	@foreach(config('chunker.admin.structure') as $parent)

		{{--Выпадающее меню--}}
		@if (isset($parent['children']))
			@include('chunker.base::admin.utils.nav.section', ['item' => $parent])

		{{--Ссылка--}}
		@else
			@include('chunker.base::admin.utils.nav.item', ['item' => $parent])
		@endif

	@endforeach
</ul>