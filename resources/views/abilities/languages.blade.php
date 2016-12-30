{{--Переключатели возможностей для языков--}}
<div class="form-group">
	<label>Языки:</label>
	<div class="btn-group w100percent" data-toggle="buttons">

		@include('base::utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'languages',
			'icon'          => 'ban',
			'is_checked'    => !$role->hasAccess('languages'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'languages.view',
			'icon'          => 'eye',
			'is_checked'    => $role->hasAbility('languages.view'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'languages.edit',
			'icon'          => 'pencil',
			'is_checked'    => $role->hasAbility('languages.edit'),
		])

	</div>
</div>