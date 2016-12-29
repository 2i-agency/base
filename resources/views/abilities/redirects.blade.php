<div class="form-group">
	<label>Перенаправления:</label>
	<div class="btn-group w100percent" data-toggle="buttons">

		@include('chunker.base::utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'redirects',
			'icon'          => 'ban',
			'is_checked'    => !$role->hasAccess('redirects'),
		])

		@include('chunker.base::utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'redirects.view',
			'icon'          => 'eye',
			'is_checked'    => $role->hasAbility('redirects.view'),
		])

		@include('chunker.base::utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'redirects.edit',
			'icon'          => 'pencil',
			'is_checked'    => $role->hasAbility('redirects.edit'),
		])

	</div>
</div>