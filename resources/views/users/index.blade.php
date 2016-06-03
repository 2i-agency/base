@extends('chunker.base::template')


@section('page.title', 'Пользователи')


@section('page.content')

	<h3>Пользователи</h3>

	{{--Ссылка на страницу добавления пользователя--}}
	<div class="mb20px">
		<a href="{{ route('admin.users.create') }}" class="btn btn-default">
			<span class="glyphicon glyphicon-plus"></span>
			Добавление пользователя
		</a>
	</div>

	{{--Табы--}}
	<ul class="nav nav-tabs">
		<li class="active"><a href="#active" data-toggle="tab">Активные</a></li>
		<li><a href="#deleted" data-toggle="tab">Удалённые</a></li>
	</ul>
	<div class="tab-content">

		{{--Действующие пользователи--}}
		<div class="tab-pane active" id="active">
			@include('chunker.base::users._utils.users-list', ['users' => $active_users])
		</div>

		{{--Удалённые пользователи--}}
		<div class="tab-pane" id="deleted">
			@include('chunker.base::users._utils.users-list', ['users' => $deleted_users])
		</div>

	</div>

@stop