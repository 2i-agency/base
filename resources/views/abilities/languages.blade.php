{{--Переключатели возможностей для языков--}}
<div class="form-group">
	<label>Языки:</label>
	<select
		class="form-control"
		name="abilities[languages]"
		{{ $disabled ? ' disabled' : NULL }}
	>

		@include('base::utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'languages',
			'is_selected'    => $agent->exists && !$agent->checkAbility('languages'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'languages.view',
			'is_selected'    => $agent->exists && $agent->checkAbility('languages.view'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'languages.edit',
			'is_selected'    => $agent->exists && $agent->checkAbility('languages.edit'),
		])

	</select>
</div>