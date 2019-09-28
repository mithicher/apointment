@extends('layouts.base')


@section('content')

@php
$statuses = \App\Enums\AppointmentStatusType::toArray();
@endphp

<div class="max-w-lg mx-auto my-5">
	<appointment-settings :data="{{ json_encode($statuses) }}"></appointment-settings>
	<business-hours :weekdays="{{ json_encode($weekdays) }}"></business-hours>
</div>

@endsection