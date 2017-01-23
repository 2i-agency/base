{{--Переключатели возможностей для настроек--}}
<div class="form-group">
	<label>Настройки:</label>
	<select class="form-control" name="abilities[languages]">

		@include('base::utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'settings',
			'is_selected'    => !$role->hasAccess('settings'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'settings.view',
			'is_selected'    => $role->hasAbility('settings.view'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'settings.edit',
			'is_selected'    => $role->hasAbility('settings.edit'),
		])

	</select>
</div>