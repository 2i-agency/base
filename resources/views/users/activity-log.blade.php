@extends('base::template')


@section('page.title', 'Аудит действий пользователя ' . $user->getName())


@section('page.content')

	{{--Хлебные крошки--}}
	@include('base::users._breadcrumbs')

	@include('base::activity-log.filter', ['action' => route('admin.users.activity-log', $user)])

	{{--Табы--}}
	@include('base::users._tabs')

	@include('base::activity-log.table', ['activities' => $activities])

@stop