<div class="form-group">
	<label>Доступ в админцентр:</label>
	<div>

		<label class="radio-inline">
			<input type="radio" name="abilities[admin.access]" value="1"{{ !$role->exists || $role->hasAbility('admin.access') ? ' checked' : NULL }}>Да
		</label>

		<label class="radio-inline">
			<input type="radio" name="abilities[admin.access]" value="0"{{ $role->exists && !$role->hasAbility('admin.access') ? ' checked' : NULL }}>Нет
		</label>

	</div>
</div>