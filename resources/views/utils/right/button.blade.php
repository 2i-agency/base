@if (isset($model) && \Auth::user()->hasAdminAccess($ability, $model))
	{{--Кнопка прав--}}
	<span
		class="js-right-button fa fa-star fa-fw{!! isset($right) && $right ? ' pull-right' : NULL !!}"
		{{--Подсказка--}}
		data-hover="tooltip"
		title="Настройка прав"
		data-placement="left"

		data-toggle="modal"
		data-target="#js-right-container"

		type="button"
		data-url="{{ route('admin.rights') }}"
		data-id="{{ $model->getRouteKey() }}"
		data-ability="{{ $ability }}"
		data-model="{{ get_class($model) }}"
	></span>
@endif