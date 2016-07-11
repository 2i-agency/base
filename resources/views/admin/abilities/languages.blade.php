<div class="form-group">
	<label>Просмотр языков:</label>
	<div>

		<label class="radio-inline">
			<input type="radio" name="abilities[languages.view]" value="1"{{ $role->hasAbility('languages.view') ? ' checked' : NULL }}>Да
		</label>

		<label class="radio-inline">
			<input type="radio" name="abilities[languages.view]" value="0"{{ !$role->hasAbility('languages.view') ? ' checked' : NULL }}>Нет
		</label>

	</div>
</div>

<div class="form-group">
	<label>Добавление языков:</label>
	<div>

		<label class="radio-inline">
			<input type="radio" name="abilities[languages.add]" value="1"{{ $role->hasAbility('languages.add') ? ' checked' : NULL }}>Да
		</label>

		<label class="radio-inline">
			<input type="radio" name="abilities[languages.add]" value="0"{{ !$role->hasAbility('languages.add') ? ' checked' : NULL }}>Нет
		</label>

	</div>
</div>

<div class="form-group">
	<label>Редактирование языков:</label>
	<div>

		<label class="radio-inline">
			<input type="radio" name="abilities[languages.edit]" value="1"{{ $role->hasAbility('languages.edit') ? ' checked' : NULL }}>Да
		</label>

		<label class="radio-inline">
			<input type="radio" name="abilities[languages.edit]" value="0"{{ !$role->hasAbility('languages.edit') ? ' checked' : NULL }}>Нет
		</label>

	</div>
</div>