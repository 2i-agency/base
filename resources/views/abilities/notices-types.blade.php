{{--Переключатели возможностей для типов уведомлений--}}
<div class="form-group">
	<label>Типы уведомлений:</label>
	<select
		class="form-control"
		name="abilities[notices-types]"
		{{ $disabled ? ' disabled' : NULL }}
	>

		@include('base::utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'notices-types',
			'is_selected'   => !$agent->checkAbility('notices-types'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'notices-types.view',
			'is_selected'   => $agent->checkAbility('notices-types.view'),
		])

		@include('base::utils.ability-trigger', [
			'label'     => 'Правка',
			'ability'   => 'notices-types.edit',
			'is_selected'    => $agent->checkAbility('notices-types.edit'),
		])

		@include('base::utils.ability-trigger', [
			'label'     => 'Администрирование',
			'ability'   => 'notices-types.admin',
			'is_selected'    => $agent->checkAbility('notices-types.admin'),
		])

	</select>
</div>