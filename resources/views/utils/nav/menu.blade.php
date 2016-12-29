<ul class="nav navbar-nav">
	@foreach(config('chunker.admin.structure') as $parent)

		{{--Выпадающее меню--}}
		@if (isset($parent['children']))
			@include('base::utils.nav.section', ['item' => $parent])

		{{--Ссылка--}}
		@else
			@include('base::utils.nav.item', ['item' => $parent])
		@endif

	@endforeach
</ul>