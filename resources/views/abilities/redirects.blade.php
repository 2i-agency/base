{{--Переключатели возможностей для перенаправлений--}}
<div class="form-group">
	<label>Перенаправления:</label>
	<select
		class="form-control"
		name="abilities[redirects]"
		{{ $disabled ? ' disabled' : NULL }}
	>

		@include('base::utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'redirects',
			'is_selected'    => !$agent->hasAbility('redirects'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'redirects.view',
			'is_selected'    => $agent->checkAbility('redirects.view'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'redirects.edit',
			'is_selected'    => $agent->checkAbility('redirects.edit'),
		])

		@include('base::utils.ability-trigger', [
			'label'     => 'Администрирование',
			'ability'   => 'redirects.admin',
			'is_selected'    => $agent->checkAbility('redirects.admin'),
		])

	</select>
</div>