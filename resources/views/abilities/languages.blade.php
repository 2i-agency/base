{{--Переключатели возможностей для языков--}}
<div class="form-group">
	<label>Языки:</label>
	<select class="form-control" name="abilities[languages]">

		@include('base::utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'languages',
			'is_selected'    => !$role->hasAccess('languages'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'languages.view',
			'is_selected'    => $role->hasAbility('languages.view'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'languages.edit',
			'is_selected'    => $role->hasAbility('languages.edit'),
		])

	</select>
</div>