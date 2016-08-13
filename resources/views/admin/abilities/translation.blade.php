<div class="form-group">
	<label>Перевод интерфейса:</label>
	<div class="btn-group w100percent" data-toggle="buttons">

		@include('chunker.base::admin.utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'translation',
			'icon'          => 'ban',
			'is_checked'    => !$role->isHasAccess('translation'),
		])

		@include('chunker.base::admin.utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'translation.view',
			'icon'          => 'eye',
			'is_checked'    => $role->isHasAbility('translation.view'),
		])

		@include('chunker.base::admin.utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'translation.edit',
			'icon'          => 'pencil',
			'is_checked'    => $role->isHasAbility('translation.edit'),
		])

	</div>
</div>