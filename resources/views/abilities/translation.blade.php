{{--Переключатели возможностей для перевода интерфейсов--}}
<div class="form-group">
	<label>Перевод интерфейса:</label>
	<select class="form-control" name="abilities[languages]">

		@include('base::utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'translation',
			'is_selected'    => !$role->hasAccess('translation'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'translation.view',
			'is_selected'    => $role->hasAbility('translation.view'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'translation.edit',
			'is_selected'    => $role->hasAbility('translation.edit'),
		])

	</select>
</div>