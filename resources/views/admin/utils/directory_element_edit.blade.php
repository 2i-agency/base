<ul class="breadcrumb">
	<li><a href="{{ route($breadcrumbs['route']) }}">{{ $breadcrumbs['name'] }}</a></li>
	<li class="active">{{ $model->name }}</li>
</ul>

<div class="panel panel-default">

	<div class="panel-body">
		@can($ability_edit)

			<form id="save" method="POST" action="{{ route($route['save'], $model) }}">

				<input type="hidden" name="_method" value="PUT">
				{!! csrf_field() !!}

				{{--Название--}}
				<div class="form-group">
					<label>Название:</label>
					<input
							type="text"
							class="form-control"
							required
							autocomplete="off"
							name="name"
							value="{{ old('name') ?: (isset($model) ? $model->name : null) }}"
					>
				</div>

				@if(isset($fields))
					{{--Ключевые слова--}}
					@if( isset($fields['meta_keywords']) && $fields['meta_keywords'] )
						<div class="form-group">
							<label>Ключевые слова:</label>
							<input
								type="text"
								class="form-control"
								autocomplete="off"
								name="meta_keywords"
								value="{{ old('meta_keywords') ?: (isset($model) ? $model->meta_keywords : NULL) }}"
							>
						</div>
					@endif
					{{--Описание--}}
					@if( isset($fields['meta_description']) && $fields['meta_description'] )
						<div class="form-group">
							<label>Описание для мета-тега:</label>
							<input
								type="text"
								class="form-control"
								autocomplete="off"
								name="meta_description"
								value="{{ old('meta_description') ?: (isset($model) ? $model->meta_description : NULL) }}"
							>
						</div>
					@endif

					{{--Слаг--}}
					@if( isset($fields['slugs']) && $fields['slugs'] )
						<div class="form-group">
							<label>Псевдоним:</label>
							<input
								type="text"
								class="form-control"
								autocomplete="off"
								name="slug"
								value="{{ old('slug') ?: (isset($model) ? $model->slug : NULL) }}"
							>
							<div class="help-block">Служит адресом страницы</div>
						</div>
					@endif
				@endif

				{{--Описание--}}
				@include('chunker.base::admin.utils.editor', [
					'name'      => 'description',
					'value'     => old('description') ?: (isset($model) ? $model->description : null),
					'disabled'  => \Auth::user()->cannot($ability_edit)
				])

			</form>

			{{--Форма для отправки запроса на удаление проекта--}}
			<form id="delete" method="POST" action="{{ route($route['destroy'], $model) }}">
				<input type="hidden" name="_method" value="DELETE">
			</form>

		@else

			{{--Название--}}
			<div class="form-group">
				<label>Название:</label>
				<div>{{ $model->name }}</div>
			</div>

			{{--Ключевые слова--}}
			<p class="form-control-static">
				@if(strlen($model->meta_keywords))
					{{ $model->meta_keywords }}
				@else
					<span class="text-muted">Не задан</span>
				@endif
			</p>

			{{--Слаг--}}
			<p class="form-control-static">
				@if(strlen($model->slugs))
					{{ $model->slugs }}
				@else
					<span class="text-muted">Не задан</span>
				@endif
			</p>

			{{--Описание--}}
			<div class="form-group">
				<label>Описание:</label>
				<div>{{ $model->description }}</div>
			</div>

		@endcan
	</div>

	@can($ability_edit)
		<div class="panel-footer">

			{{--Кнопка сохранения--}}
			<button form="save" class="btn btn-primary" type="submit">
				<span class="fa fa-check"></span>
				Сохранить
			</button>

			@if (isset($model) && isset($can_delete) && $can_delete)
				<button form="delete" class="btn btn-danger" type="submit">
					<span class="glyphicon glyphicon-remove"></span>
					Удалить
				</button>
			@endif
		</div>
	@endcan

</div>