{{--Переключатели возможностей для типов уведомлений--}}
<div class="form-group">
	<label>Типы уведомлений:</label>
	<div class="btn-group w100percent" data-toggle="buttons">

		@include('base::utils.ability-trigger', [
			'label'         => 'Не доступно',
			'ability'       => 'notices-types',
			'icon'          => 'ban',
			'is_checked'    => !$role->hasAccess('notices-types'),
		])

		@include('base::utils.ability-trigger', [
			'label'         => 'Просмотр',
			'ability'       => 'notices-types.view',
			'icon'          => 'eye',
			'is_checked'    => $role->hasAbility('notices-types.view'),
		])

		@include('base::utils.ability-trigger', [
			'label'     => 'Правка',
			'ability'   => 'notices-types.edit',
			'icon'      => 'pencil',
			'is_checked'    => $role->hasAbility('notices-types.edit'),
		])

	</div>
</div>