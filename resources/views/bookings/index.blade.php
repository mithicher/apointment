@extends('layouts.base')

@section('content')

<div class="container mx-auto py-5">
	
	<h2 class="text-xl md:text-2xl mb-5 text-grey-darkest">My Appointments</h2>
	<appointments :appointments="{{ $bookings }}" :calendardata="{{ $bookingDates }}"></appointments>

</div>

@endsection