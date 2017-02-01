@if (isset($model) && \Auth::user()->hasAdminAccess($ability, $model))

	@section('page.assets')
		<link href="{{ asset('admin/css/magnific-popup.css') }}" rel="stylesheet"/>
		<link href="{{ asset('admin/css/right-settings.css') }}" rel="stylesheet"/>

		<script src="{{ asset('admin/js/jquery.magnific-popup.min.js') }}"></script>
		<script type="text/javascript" src="{{asset('admin/js/right-settings.js')}}"></script>
	@append

	{{--Кнопка прав--}}
	<button
		id="js-right-button"
		type="button"
		class="btn btn-default"
		data-url="{{ route('admin.rights') }}"
		data-id="{{ $model->getRouteKey() }}"
		data-ability="{{ $ability }}"
		data-model="{{ get_class($model) }}"
	>Настройка прав</button>


	{{--Диалоговое окно для настройки прав--}}
	<div id="js-right-container" class="white-popup mfp-hide mfp-fade">
		<div class="panel panel-default">
			<div class="panel-heading">
				Настройка прав доступа
			</div>

			<div class="js-body">

			</div>

			<div id="js-error-right" class="alert alert-danger hidden"></div>
		</div>
	</div>
@endif