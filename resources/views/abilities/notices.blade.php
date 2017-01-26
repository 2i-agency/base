{{--Переключатели возможностей для уведомлений--}}
<div class="form-group">
	<label>Уведомления:</label>
	<select
		class="form-control"
		name="abilities[notices]"
		{{ $disabled ? ' disabled' : NULL }}
	>

		@include('base::utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'notices',
			'is_selected'    => !$agent->hasAbility('notices.edit'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'notices.edit',
			'is_selected'    => $agent->hasAbility('notices.edit'),
		])

	</select>
</div>