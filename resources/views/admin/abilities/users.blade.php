<div class="form-group">
	<label>Просмотр пользователей:</label>
	<div>

		<label class="radio-inline">
			<input type="radio" name="abilities[users.view]" value="1"{{ $role->hasAbility('users.view') ? ' checked' : NULL }}>Да
		</label>

		<label class="radio-inline">
			<input type="radio" name="abilities[users.view]" value="0"{{ !$role->hasAbility('users.view') ? ' checked' : NULL }}>Нет
		</label>

	</div>
</div>

<div class="form-group">
	<label>Добавление пользователей:</label>
	<div>

		<label class="radio-inline">
			<input type="radio" name="abilities[users.add]" value="1"{{ $role->hasAbility('users.add') ? ' checked' : NULL }}>Да
		</label>

		<label class="radio-inline">
			<input type="radio" name="abilities[users.add]" value="0"{{ !$role->hasAbility('users.add') ? ' checked' : NULL }}>Нет
		</label>

	</div>
</div>

<div class="form-group">
	<label>Редактирование пользователей:</label>
	<div>

		<label class="radio-inline">
			<input type="radio" name="abilities[users.edit]" value="1"{{ $role->hasAbility('users.edit') ? ' checked' : NULL }}>Да
		</label>

		<label class="radio-inline">
			<input type="radio" name="abilities[users.edit]" value="0"{{ !$role->hasAbility('users.edit') ? ' checked' : NULL }}>Нет
		</label>

	</div>
</div>