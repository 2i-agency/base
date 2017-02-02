@if (isset($model) && \Auth::user()->hasAdminAccess($ability, $model))
	{{--Кнопка прав--}}
	<span
		class="fa fa-star fa-fw{!! isset($right) && $right ? ' pull-right' : NULL !!}"
		data-toggle="popover"
		data-content="Настройка прав"
		data-placement="left"
		id="js-right-button"
		type="button"
		data-url="{{ route('admin.rights') }}"
		data-id="{{ $model->getRouteKey() }}"
		data-ability="{{ $ability }}"
		data-model="{{ get_class($model) }}"
	></span>
@endif