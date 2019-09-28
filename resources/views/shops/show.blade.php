@extends('layouts.base')

@section('content')
<div class="container mx-auto py-5">

	<a href="/services" class="inline-flex items-center mb-4 no-underline text-blue hover:text-blue-dark font-semibold">
		<Zondicon icon="arrow-thin-left" class="fill-current svg-icon mr-2"></Zondicon>Back
	</a>

	<h2 class="text-xl md:text-2xl mb-2 text-grey-darkest">{{ $shop->shop_name }}</h2>
	<p class="text-grey-darker text-sm font-semibold my-2">Hair Salon</p>
	<p class="text-grey-dark text-sm mb-5">{{ $shop->shop_address }}</p>

	<a href="{{ route('bookings.create', $shop->id) }}" class="relative mb-6 mx-auto inline-flex items-center rounded-lg bg-blue text-grey-lighter px-4 h-10 no-underline hover:bg-blue-dark font-semibold">
		<Zondicon icon="calendar" class="fill-current svg-icon mr-2"></Zondicon>
		Book an appointment
	</a>

	@php
		$openings = [
			[
				"day" => "Monday",
				"time_open" => "10:00",
				"time_close" => "17:00"
			],
			[
				"day" => "Tuesday",
				"time_open" => "10:00",
				"time_close" => "17:00"
			],
			[
				"day" => "Wednesday",
				"time_open" => "10:00",
				"time_close" => "17:00"
			],
			[
				"day" => "Thursday",
				"time_open" => "10:00",
				"time_close" => "17:00"
			],
			[
				"day" => "Friday",
				"time_open" => "10:00",
				"time_close" => "17:00"
			],
			[
				"day" => "Saturday",
				"time_open" => "10:00",
				"time_close" => "17:00"
			],
			[
				"day" => "Sunday",
				"time_open" => null,
				"time_close" => null
			]
		];
	@endphp

	<div class="flex flex-wrap -mx-4">
		<div class="w-2/3 px-4">
			<div class="rounded-lg bg-white shadow mb-4">
				@foreach($shop->services as $service)
					<div class="block p-5 border-t border-grey-lighter">
						<div class="flex w-full justify-between">
							<p class="font-semibold mb-0 text-grey-darker">{{ $service->service_name }}</p>
							
							<div>
								<p class="inline-flex items-center text-grey-dark text-sm">
									<Zondicon icon="time" class="fill-current text-grey text-xs svg-icon mr-1"></Zondicon>{{ $service->service_duration }}m
								</p>
								<p class="ml-5 inline-flex text-grey-darkest text-sm">Rs. {{ $service->service_price }}</p>
				
								<!-- <a href="#" class="inline-flex ml-4 no-underline text-blue hover:text-blue-dark font-semibold">Book Now</a> -->
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
		<div class="w-1/3 px-4">
			<div class="rounded-lg bg-white shadow mb-4 block flex flex-col h-full p-5">
				<p class="font-semibold mb-4 text-grey-darkest">
					<Zondicon icon="time" class="fill-current text-grey-dark svg-icon mr-2"></Zondicon>Opening Hours
				</p>

				@foreach($openings as $opening)
					<div class="flex justify-between w-full py-2">
						<p class="text-grey-darker">{{ $opening['day'] }}</p>
						@if($opening['time_open'] == null || $opening['time_close'] == null)
							<p class="text-grey-darkest">closed</p>
						@else
							<p class="text-grey-darkest">{{ $opening['time_open'] }}
							<Zondicon icon="cheveron-right" class="fill-current text-grey-dark svg-icon mx-1"></Zondicon>{{ $opening['time_close'] }}</p>
						@endif
					</div>
				@endforeach

				<a href="#" class="mt-auto mb-0 mx-auto inline-flex py-0 justify-center w-full items-center rounded-lg bg-blue text-grey-lighter px-4 h-10 no-underline hover:bg-blue-dark font-semibold">
					<Zondicon icon="calendar" class="fill-current svg-icon mr-2"></Zondicon>
					Book an appointment
				</a>
			</div>
		</div>
	</div>

	<p class="text-grey-dark text-xs">Note: Prices may vary.</p>

</div>
@endsection