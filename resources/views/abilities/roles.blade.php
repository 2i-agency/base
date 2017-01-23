{{--Переключатели возможностей для ролей--}}
<div class="form-group">
	<label>Роли:</label>
	<select class="form-control" name="abilities[roles]">

		@include('base::utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'roles',
			'is_selected'    => !$role->hasAccess('roles'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'roles.view',
			'is_selected'    => $role->hasAbility('roles.view'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'roles.edit',
			'is_selected'    => $role->hasAbility('roles.edit'),
		])

	</select>
</div>