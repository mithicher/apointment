@extends('layouts.base')

@section('content')
<div class="py-5 px-4">
    <div class="container mx-auto leading-normal">
			<a href="/services" class="inline-flex items-center mb-4 no-underline text-blue hover:text-blue-dark font-semibold">
				<Zondicon icon="arrow-thin-left" class="fill-current svg-icon mr-2"></Zondicon>Back
			</a>
			
			<h2 class="text-xl md:text-2xl mb-5 text-grey-darkest">Booking an appointment</h2>

			<booking-form :shop="{{ $shop }}"></booking-form>
    </div>
</div>

@endsection