<div class="form-group">
	<label>Просмотр настроек:</label>
	<div>

		<label class="radio-inline">
			<input type="radio" name="abilities[settings.view]" value="1"{{ !$role->exists || $role->hasAbility('settings.view') ? ' checked' : NULL }}>Да
		</label>

		<label class="radio-inline">
			<input type="radio" name="abilities[settings.view]" value="0"{{ $role->exists && !$role->hasAbility('settings.view') ? ' checked' : NULL }}>Нет
		</label>

	</div>
</div>

<div class="form-group">
	<label>Редактирование настроек:</label>
	<div>

		<label class="radio-inline">
			<input type="radio" name="abilities[settings.edit]" value="1"{{ !$role->exists || $role->hasAbility('settings.edit') ? ' checked' : NULL }}>Да
		</label>

		<label class="radio-inline">
			<input type="radio" name="abilities[settings.edit]" value="0"{{ $role->exists && !$role->hasAbility('settings.edit') ? ' checked' : NULL }}>Нет
		</label>

	</div>
</div>