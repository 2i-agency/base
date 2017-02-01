@section('page.assets')
	<link href="{{ asset('admin/css/magnific-popup.css') }}" rel="stylesheet"/>
	<link href="{{ asset('admin/css/right-settings.css') }}" rel="stylesheet"/>

	<script src="{{ asset('admin/js/jquery.magnific-popup.min.js') }}"></script>
	<script type="text/javascript" src="{{asset('admin/js/right-settings.js')}}"></script>
@append

{{--Диалоговое окно для настройки прав--}}
<div id="js-right-container" class="white-popup mfp-hide mfp-fade">
	<div class="panel panel-default">
		<div class="panel-heading">
			Настройка прав доступа
		</div>

		<div class="js-body">

		</div>

	</div>
</div>