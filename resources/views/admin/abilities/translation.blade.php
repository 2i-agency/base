<div class="form-group">
	<label>Просмотр перевода интерфейса:</label>
	<div>

		<label class="radio-inline">
			<input type="radio" name="abilities[translation.view]" value="1"{{ !$role->exists || $role->hasAbility('translation.view') ? ' checked' : NULL }}>Да
		</label>

		<label class="radio-inline">
			<input type="radio" name="abilities[translation.view]" value="0"{{ $role->exists && !$role->hasAbility('translation.view') ? ' checked' : NULL }}>Нет
		</label>

	</div>
</div>

<div class="form-group">
	<label>Редактирование перевода интерфейса:</label>
	<div>

		<label class="radio-inline">
			<input type="radio" name="abilities[translation.edit]" value="1"{{ !$role->exists || $role->hasAbility('translation.edit') ? ' checked' : NULL }}>Да
		</label>

		<label class="radio-inline">
			<input type="radio" name="abilities[translation.edit]" value="0"{{ $role->exists && !$role->hasAbility('translation.edit') ? ' checked' : NULL }}>Нет
		</label>

	</div>
</div>