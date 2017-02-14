@extends('base::template')


@section('page.title', 'Аудит действий')


@section('page.content')

	<h3>Аудит действий</h3>

	@if($activities->count())
		@include('base::activity-log.filter', ['action' => route('admin.activity-log')])
	@endif

	@include('base::activity-log.table', ['activities' => $activities])

@stop