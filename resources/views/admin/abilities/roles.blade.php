<div class="form-group">
	<label>Просмотр ролей:</label>
	<div>

		<label class="radio-inline">
			<input type="radio" name="abilities[roles.view]" value="1"{{ $role->hasAbility('roles.view') ? ' checked' : NULL }}>Да
		</label>

		<label class="radio-inline">
			<input type="radio" name="abilities[roles.view]" value="0"{{ !$role->hasAbility('roles.view') ? ' checked' : NULL }}>Нет
		</label>

	</div>
</div>

<div class="form-group">
	<label>Добавление ролей:</label>
	<div>

		<label class="radio-inline">
			<input type="radio" name="abilities[roles.add]" value="1"{{ $role->hasAbility('roles.add') ? ' checked' : NULL }}>Да
		</label>

		<label class="radio-inline">
			<input type="radio" name="abilities[roles.add]" value="0"{{ !$role->hasAbility('roles.add') ? ' checked' : NULL }}>Нет
		</label>

	</div>
</div>

<div class="form-group">
	<label>Редактирование ролей:</label>
	<div>

		<label class="radio-inline">
			<input type="radio" name="abilities[roles.edit]" value="1"{{ $role->hasAbility('roles.edit') ? ' checked' : NULL }}>Да
		</label>

		<label class="radio-inline">
			<input type="radio" name="abilities[roles.edit]" value="0"{{ !$role->hasAbility('roles.edit') ? ' checked' : NULL }}>Нет
		</label>

	</div>
</div>