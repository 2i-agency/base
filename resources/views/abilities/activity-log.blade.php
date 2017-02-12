{{--Переключатели возможностей для уведомлений--}}
<div class="form-group">
	<label>Аудит действий:</label>
	<select
		class="form-control"
		name="abilities[activity-log]"
		{{ $disabled ? ' disabled' : NULL }}
	>

		@include('base::utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'activity-log',
			'is_selected'    => !$agent->hasAbility('activity-log'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'activity-log.view',
			'is_selected'    => $agent->checkAbility('activity-log.view', NULL, true),
		])

	</select>
</div>