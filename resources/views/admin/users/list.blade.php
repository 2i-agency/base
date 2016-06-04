@extends('chunker.base::admin.template')


@section('page.title', 'Пользователи')


@section('page.content')

	<h3>Пользователи</h3>

	{{--Ссылка на страницу добавления пользователя--}}
	<div class="mb20px">
		<a href="{{ route('admin.users.create') }}" class="btn btn-default">
			<span class="fa fa-plus"></span>
			Добавление пользователя
		</a>
	</div>

	{{--Табы--}}
	<ul class="nav nav-tabs">
		<li class="active">
			<a href="#active" data-toggle="tab">
				<span class="fa fa-heartbeat"></span>
				Активные
			</a>
		</li>
		<li>
			<a href="#deleted" data-toggle="tab">
				<span class="fa fa-trash"></span>
				Удалённые
			</a>
		</li>
	</ul>
	<div class="tab-content">

		{{--Действующие пользователи--}}
		<div class="tab-pane active" id="active">
			@include('chunker.base::admin.users._list', ['users' => $active_users])
		</div>

		{{--Удалённые пользователи--}}
		<div class="tab-pane" id="deleted">
			@include('chunker.base::admin.users._list', ['users' => $deleted_users])
		</div>

	</div>

@stop