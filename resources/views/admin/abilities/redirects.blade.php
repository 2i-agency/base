<div class="form-group">
	<label>Перенаправления:</label>
	<div class="btn-group w100percent" data-toggle="buttons">

		@include('chunker.base::admin.utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'redirects',
			'icon'          => 'ban',
			'is_checked'    => !$role->isHasAccess('redirects'),
		])

		@include('chunker.base::admin.utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'redirects.view',
			'icon'          => 'eye',
			'is_checked'    => $role->isHasAbility('redirects.view'),
		])

		@include('chunker.base::admin.utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'redirects.edit',
			'icon'          => 'pencil',
			'is_checked'    => $role->isHasAbility('redirects.edit'),
		])

	</div>
</div>