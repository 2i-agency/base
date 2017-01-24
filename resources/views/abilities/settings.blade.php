{{--Переключатели возможностей для настроек--}}
<div class="form-group">
	<label>Настройки:</label>
	<select
		class="form-control"
		name="abilities[settings]"
		{{ \Auth::user()->hasAdminAccess('settings') ? NULL : 'disabled' }}
	>

		@include('base::utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'settings',
			'is_selected'    => !$agent->hasAccess('settings'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'settings.view',
			'is_selected'    => $agent->hasAbility('settings.view'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'settings.edit',
			'is_selected'    => $agent->hasAbility('settings.edit'),
		])

	</select>
</div>