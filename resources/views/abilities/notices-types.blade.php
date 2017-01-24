{{--Переключатели возможностей для типов уведомлений--}}
<div class="form-group">
	<label>Типы уведомлений:</label>
	<select
		class="form-control"
		name="abilities[notices-types]"
		{{ \Auth::user()->hasAdminAccess('notices-types') ? NULL : 'disabled' }}
	>

		@include('base::utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'notices-types',
			'is_selected'    => !$agent->hasAccess('notices-types'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'notices-types.view',
			'is_selected'    => $agent->hasAbility('notices-types.view'),
		])

		@include('base::utils.ability-trigger', [
			'label'     => 'Правка',
			'ability'   => 'notices-types.edit',
			'is_selected'    => $agent->hasAbility('notices-types.edit'),
		])

	</select>
</div>