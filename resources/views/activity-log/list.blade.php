@extends('base::template')


@section('page.title', 'Аудит действий')


@section('page.content')

	<h3>Аудит действий</h3>

	@include('base::activity-log.table', ['activities' => $activities])

@stop