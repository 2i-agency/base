{{--Переключатели возможностей для пользователей--}}
<div class="form-group">
	<label>Пользователи:</label>
	<select class="form-control" name="abilities[languages]">

		@include('base::utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'users',
			'is_selected'    => !$role->hasAccess('users'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'users.view',
			'is_selected'    => $role->hasAbility('users.view'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'users.edit',
			'is_selected'    => $role->hasAbility('users.edit'),
		])

	</select>
</div>