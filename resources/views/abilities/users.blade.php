{{--Переключатели возможностей для пользователей--}}
<div class="form-group">
	<label>Пользователи:</label>
	<select
		class="form-control"
		name="abilities[users]"
		{{ $disabled ? ' disabled' : NULL }}
	>

		@include('base::utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'users',
			'is_selected'    => $agent->exists && $agent->checkAbility('users'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'users.view',
			'is_selected'    => $agent->exists && $agent->checkAbility('users.view'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'users.edit',
			'is_selected'    => $agent->exists && $agent->checkAbility('users.edit'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Администрирование',
			'ability'       => 'users.admin',
			'is_selected'    => $agent->exists && $agent->checkAbility('users.admin'),
		])

	</select>
</div>