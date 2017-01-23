{{--Переключатели возможностей для перенаправлений--}}
<div class="form-group">
	<label>Перенаправления:</label>
	<select class="form-control" name="abilities[redirects]">

		@include('base::utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'redirects',
			'is_selected'    => !$role->hasAccess('redirects'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'redirects.view',
			'is_selected'    => $role->hasAbility('redirects.view'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'redirects.edit',
			'is_selected'    => $role->hasAbility('redirects.edit'),
		])

	</select>
</div>