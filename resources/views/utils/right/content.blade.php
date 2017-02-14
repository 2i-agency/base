@if((isset($roles) && $roles->count()) || (isset($users) && $users->count()))
	<table
		class="table"
		id="js-add-right"
	    data-url="{{ route('admin.rights.store') }}"
	>
		<tr>
			<td>
				<select class="form-control" name="new-agent" id="js-new-agent">
					@if(isset($roles) && $roles->count())
						<optgroup label="Роли">
							@foreach($roles as $role)
								<option value="role:{{ $role->id }}">{{ $role->name }}</option>
							@endforeach
						</optgroup>
					@endif
					@if(isset($users) && $users->count())
						<optgroup label="Пользователи">
							@foreach($users as $user)
								<option value="user:{{ $user->id }}">{{ $user->getName() }}</option>
							@endforeach
						</optgroup>
					@endif
				</select>
			</td>
			<td>
				<select class="form-control" name="new-ability" id="js-new-ability">
					@include('base::utils.ability-trigger', [
						'is_selected' => isset($agent->ability_id),
						'ability' => '',
						'label' => 'Доступ закрыт'
					])
					@foreach($postfixes as $postfix)
						@include('base::utils.ability-trigger', [
							'is_selected' => false,
							'ability' => $ability . '.' . $postfix,
							'label' => \Chunker\Base\Models\Ability::getName($postfix)
						])
					@endforeach
				</select>
			</td>
			<td class="text-right">
				<div class="btn-group">
					<a id="js-btn-add-right" class="btn btn-primary" href="#"><span class="fa fa-check"></span></a>
				</div>
			</td>
		</tr>
	</table>
@endif

@if($agents->count())
	<table class="table table-striped table-hover">
		@foreach($agents as $agent)
			<tr class="vertical-middle">
				<td>
					@php($is_role = $agent->agent_type == \Chunker\Base\Models\Role::class)
					<span
						class="fa fa-{{ $is_role ? 'users' : 'user' }}"
						data-hover="tooltip"
						title="{{ $is_role ? 'Роль' : 'Пользователь' }}"
						data-placement="top"
					></span>
					{{ $is_role ? $agent->agentable()->first()->name : $agent->agentable()->first()->getName() }}
				</td>
				<td>
					<select
						class="form-control"
						name="new-ability"
						id="js-update-agent-{{ $agent->id }}"
					    {{ !$is_role && ($agent->agentable()->first() == \Auth::user()) ? 'disabled' : NULL }}
					>
						@include('base::utils.ability-trigger', [
							'is_selected' => isset($agent->ability_id),
							'ability' => '',
							'label' => 'Доступ закрыт'
						])
						@foreach($postfixes as $postfix)
							@include('base::utils.ability-trigger', [
								'is_selected' => $ability . '.' . $postfix == $agent->ability_id,
								'ability' => $ability . '.' . $postfix,
								'label' => \Chunker\Base\Models\Ability::getName($postfix)
							])
						@endforeach
					</select>
				</td>
				<td class="text-right">
					@unless(!$is_role && ($agent->agentable()->first() == \Auth::user()))
						<div class="btn-group">
							<a
								class="js-btn-update-right btn btn-primary"
								href="#"
								data-agent="{{ $agent->id }}"
								data-url="{{ route('admin.rights.update') }}"
							><span class="fa fa-floppy-o"></span></a>
							<a
								class="js-btn-delete-right btn btn-danger"
								href="#"
								data-agent="{{ $agent->id }}"
								data-url="{{ route('admin.rights.delete') }}"
							><span class="fa fa-trash"></span></a>
						</div>
					@endunless
				</td>
			</tr>
		@endforeach
	</table>
@endif