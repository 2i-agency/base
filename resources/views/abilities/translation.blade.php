{{--Переключатели возможностей для перевода интерфейсов--}}
<div class="form-group">
	<label>Перевод интерфейса:</label>
	<div class="btn-group w100percent" data-toggle="buttons">

		@include('base::utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'translation',
			'icon'          => 'ban',
			'is_checked'    => !$role->hasAccess('translation'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'translation.view',
			'icon'          => 'eye',
			'is_checked'    => $role->hasAbility('translation.view'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'translation.edit',
			'icon'          => 'pencil',
			'is_checked'    => $role->hasAbility('translation.edit'),
		])

	</div>
</div>