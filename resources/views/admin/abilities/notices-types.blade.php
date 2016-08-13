<div class="form-group">
	<label>Типы уведомлений:</label>
	<div class="btn-group w100percent" data-toggle="buttons">

		@include('chunker.base::admin.utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'notices-types',
			'icon'          => 'ban',
			'is_checked'    => !$role->isHasAccess('notices-types'),
		])

		@include('chunker.base::admin.utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'notices-types.view',
			'icon'          => 'eye',
			'is_checked'    => $role->isHasAbility('notices-types.view'),
		])

		@include('chunker.base::admin.utils.ability-trigger', [
			'label'     => 'Правка',
			'ability'   => 'notices-types.edit',
			'icon'      => 'pencil',
			'is_checked'    => $role->isHasAbility('notices-types.edit'),
		])

	</div>
</div>