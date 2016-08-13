<div class="form-group">
	<label>Роли:</label>
	<div class="btn-group w100percent" data-toggle="buttons">

		@include('chunker.base::admin.utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'roles',
			'icon'          => 'ban',
			'is_checked'    => !$role->isHasAccess('roles'),
		])

		@include('chunker.base::admin.utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'roles.view',
			'icon'          => 'eye',
			'is_checked'    => $role->isHasAbility('roles.view'),
		])

		@include('chunker.base::admin.utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'roles.edit',
			'icon'          => 'pencil',
			'is_checked'    => $role->isHasAbility('roles.edit'),
		])

	</div>
</div>