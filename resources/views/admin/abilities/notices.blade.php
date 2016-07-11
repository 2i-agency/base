<div class="form-group">
	<label>Просмотр уведомлений:</label>
	<div>

		<label class="radio-inline">
			<input type="radio" name="abilities[notices.view]" value="1"{{ !$role->exists || $role->hasAbility('notices.view') ? ' checked' : NULL }}>Да
		</label>

		<label class="radio-inline">
			<input type="radio" name="abilities[notices.view]" value="0"{{ $role->exists && !$role->hasAbility('notices.view') ? ' checked' : NULL }}>Нет
		</label>

	</div>
</div>

<div class="form-group">
	<label>Редактирование уведомлений:</label>
	<div>

		<label class="radio-inline">
			<input type="radio" name="abilities[notices.edit]" value="1"{{ !$role->exists || $role->hasAbility('notices.edit') ? ' checked' : NULL }}>Да
		</label>

		<label class="radio-inline">
			<input type="radio" name="abilities[notices.edit]" value="0"{{ $role->exists && !$role->hasAbility('notices.edit') ? ' checked' : NULL }}>Нет
		</label>

	</div>
</div>