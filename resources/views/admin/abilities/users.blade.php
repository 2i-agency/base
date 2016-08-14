<div class="form-group">
	<label>Пользователи:</label>
	<div class="btn-group w100percent" data-toggle="buttons">

		@include('chunker.base::admin.utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'users',
			'icon'          => 'ban',
			'is_checked'    => !$role->hasAccess('users'),
		])

		@include('chunker.base::admin.utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'users.view',
			'icon'          => 'eye',
			'is_checked'    => $role->hasAbility('users.view'),
		])

		@include('chunker.base::admin.utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'users.edit',
			'icon'          => 'pencil',
			'is_checked'    => $role->hasAbility('users.edit'),
		])

	</div>
</div>