{{--Переключатели возможностей для настроек--}}
<div class="form-group">
	<label>Настройки:</label>
	<div class="btn-group w100percent" data-toggle="buttons">

		@include('base::utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'settings',
			'icon'          => 'ban',
			'is_checked'    => !$role->hasAccess('settings'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'settings.view',
			'icon'          => 'eye',
			'is_checked'    => $role->hasAbility('settings.view'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'settings.edit',
			'icon'          => 'pencil',
			'is_checked'    => $role->hasAbility('settings.edit'),
		])

	</div>
</div>