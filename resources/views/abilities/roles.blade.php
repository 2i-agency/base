{{--Переключатели возможностей для ролей--}}
<div class="form-group">
	<label>Роли:</label>
	<select
		class="form-control"
		name="abilities[roles]"
		{{ \Auth::user()->hasAdminAccess('roles') ? NULL : 'disabled' }}
	>

		@include('base::utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'roles',
			'is_selected'    => !$agent->hasAccess('roles'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'roles.view',
			'is_selected'    => $agent->hasAbility('roles.view'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'roles.edit',
			'is_selected'    => $agent->hasAbility('roles.edit'),
		])

	</select>
</div>