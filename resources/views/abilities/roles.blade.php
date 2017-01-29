{{--Переключатели возможностей для ролей--}}
<div class="form-group">
	<label>Роли:</label>
	<select
		class="form-control"
		name="abilities[roles]"
		{{ $disabled ? ' disabled' : NULL }}
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

		@include('base::utils.ability-trigger', [
			'label'     => 'Администрирование',
			'ability'   => 'roles.admin',
			'is_selected'    => $agent->hasAbility('roles.admin'),
		])

	</select>
</div>