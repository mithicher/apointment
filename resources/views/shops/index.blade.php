@extends('layouts.base')

@section('content')

@php
$statuses = \App\Enums\AppointmentStatusType::toArray();
$weekdays = \App\Enums\WeekName::toSelectArray();
@endphp

<div class="max-w-lg mx-auto my-5">
	<shop-settings :shops="{{ $shops }}"></shop-settings> 
	<appointment-settings :data="{{ json_encode($statuses) }}"></appointment-settings>
	<business-hours :weekdays="{{ json_encode($weekdays) }}"></business-hours>
</div>
@endsection
