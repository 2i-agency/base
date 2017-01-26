{{--Переключатели возможностей для перевода интерфейсов--}}
<div class="form-group">
	<label>Перевод интерфейса:</label>
	<select
		class="form-control"
		name="abilities[translation]"
		{{ $disabled ? ' disabled' : NULL }}
	>

		@include('base::utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'translation',
			'is_selected'    => !$agent->hasAccess('translation'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'translation.view',
			'is_selected'    => $agent->hasAbility('translation.view'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'translation.edit',
			'is_selected'    => $agent->hasAbility('translation.edit'),
		])

	</select>
</div>