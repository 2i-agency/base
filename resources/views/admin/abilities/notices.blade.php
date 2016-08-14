<div class="form-group">
	<label>Уведомления:</label>
	<div class="btn-group w100percent" data-toggle="buttons">

		@include('chunker.base::admin.utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'notices',
			'is_checked'    => !$role->hasAbility('notices.edit'),
			'icon'          => 'eye'
		])

		@include('chunker.base::admin.utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'notices.edit',
			'is_checked'    => $role->hasAbility('notices.edit'),
			'icon'          => 'pencil'
		])

	</div>
</div>