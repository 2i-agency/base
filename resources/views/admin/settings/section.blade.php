@extends('chunker.base::admin.template')


@section('page.title', 'Настройки')


@section('page.content')

	<h3>Настройки</h3>

	<div class="row">

		{{--Разделы--}}
		<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
			<div class="list-group">
				@foreach (config('chunker.admin.settings') as $section_name => $section_data)
					<a
						href="{{ route('admin.settings', $section_name) }}"
						class="list-group-item{{ $section_name == $section ? ' active' : NULL }}"
					>
						@if (isset($section_data['icon']))
							<span class="fa fa-fw fa-{{ $section_data['icon'] }}"></span>
						@endif
						{{ $section_data['name'] }}
					</a>
				@endforeach
			</div>
		</div>

		{{--Форма--}}
		<div class="col-lg-10 col-md-9 col-sm-8 col-xs-12">
			<form method="POST" class="panel panel-default" action="{{ route('admin.settings.save') }}">
				{!! csrf_field() !!}
				{!! method_field('PUT') !!}

				<div class="panel-body">
					@foreach ($settings as $setting)
						<div class="form-group">

							{{--Метка--}}
							@include('chunker.base::admin.utils.edit', [
								'element' => $setting,
								'right' => true
							])
							<label>{{ $setting->title }}:</label>

							{{--Многострочное поле--}}
							@if ($setting->control_type == 'textarea')
								<textarea name="settings[{{ $setting->id }}]" class="form-control">{{ $setting->value }}</textarea>

							{{--Переключатель--}}
							@elseif($setting->control_type == 'radio')
								<label class="radio-inline">
									<input
										type="radio"
										name="settings[{{ $setting->id }}]"
										value="1"
										{{ $setting->value ? ' checked' : NULL }}
									> Да
								</label>
								<label class="radio-inline">
									<input
										type="radio"
										name="settings[{{ $setting->id }}]"
										{{ $setting->value ? NULL : ' checked' }}
										value="0"
									> Нет
								</label>

							{{--Однострочное поле--}}
							@else
								<input
									type="{{ $setting->control_type }}"
									name="settings[{{ $setting->id }}]"
									value="{{ $setting->value }}"
									class="form-control"
									autocomplete="off"
								>
							@endif

							{{--Подсказка--}}
							@if ($setting->hint)
								<div class="help-block">{{ $setting->hint }}</div>
							@endif

						</div>
					@endforeach
				</div>

				<div class="panel-footer">
					@include('chunker.base::admin.utils.buttons.save')
				</div>

			</form>
		</div>


	</div>

@stop