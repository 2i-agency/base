@extends('Base::template')


@section('page.content')

<h3>Пользователи</h3>

<div>
	<ul class="nav nav-tabs">
		<li class="active"><a href="#active" data-toggle="tab">Активные</a></li>
		<li><a href="#deleted" data-toggle="tab">Удалённые</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="active">
			@include('Base::users._utils.users-list', ['users' => $active_users])
		</div>
		<div class="tab-pane" id="deleted">
			@include('Base::users._utils.users-list', ['users' => $deleted_users])
		</div>
	</div>
</div>

@stop