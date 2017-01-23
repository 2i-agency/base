{{--Переключатели возможностей для уведомлений--}}

<div class="form-group">
	<label>Уведомления:</label>
	<select class="form-control" name="abilities[notices]">

		@include('base::utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'notices',
			'is_selected'    => !$role->hasAbility('notices.edit'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Правка',
			'ability'       => 'notices.edit',
			'is_selected'    => $role->hasAbility('notices.edit'),
		])

	</select>
</div>