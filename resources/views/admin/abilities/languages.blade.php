<div class="form-group">
	<label>Языки:</label>
	<div class="btn-group w100percent" data-toggle="buttons">

		@include('chunker.base::admin.utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'languages',
			'icon'          => 'ban',
			'is_checked'    => !$role->isHasAccess('languages'),
		])

		@include('chunker.base::admin.utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'languages.view',
			'icon'          => 'eye',
			'is_checked'    => $role->isHasAbility('languages.view'),
		])

		@include('chunker.base::admin.utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'languages.edit',
			'icon'          => 'pencil',
			'is_checked'    => $role->isHasAbility('languages.edit'),
		])

	</div>
</div>