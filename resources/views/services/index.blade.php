@extends('layouts.base')

@section('content')
<div class="bg-white pt-4 px-4">
    <div class="container mx-auto flex flex-wrap items-center leading-normal">
        <div class="w-full md:w-1/2 md:pr-16">
			<h2 class="text-xl lg:text-3xl mb-2 leading-tight text-grey-darkest truncate">Book an appointment</h2>
			<!-- <p class="text-grey-darker mb-3">Booking cannot be this easy.</p> -->
			<p class="text-grey-dark">Quick Links: 
				<a href="#" class="no-underline text-blue hover:text-blue-dark">Hair Salon</a>, 
				<a href="#" class="no-underline text-blue hover:text-blue-dark">Dentist</a>,
				<a href="#" class="no-underline text-blue hover:text-blue-dark">Law Consultant</a>, 
				<a href="#" class="no-underline text-blue hover:text-blue-dark">All Categories</a>
			</p>
        </div>
        <div class="w-full md:w-1/2 text-center">
            <img src="/svg/barber.svg" alt="" class="h-32 md:h-48">
        </div>
    </div>
</div>
<div class="container mx-auto py-10">
	@foreach($shops as $shop)
		
		<div class="block no-underline p-5 rounded-lg bg-white shadow mb-4 w-full md:w-2/3">
			<div class="flex">
				<div class="mr-4 flex-no-shrink w-32 h-32 rounded bg-blue-lightest">
					<img src="{{ url($shop->shop_logo) }}" alt="" class="rounded w-32 h-32">
				</div>
				<div class="flex flex-col w-full">
					<h2 class="text-xl mb-2 text-grey-darkest">{{ $shop->shop_name }}</h2>
					<p class="text-grey-darker text-sm font-semibold my-2">Hair Salon</p>

					<div class="flex flex-wrap mt-auto justify-between">

						<p class="text-grey-dark text-sm w-full md:w-1/2 leading-normal">{{ $shop->shop_address }}</p>
	
						<div class="w-full md:w-1/2 text-right">
							<p class="text-sm mb-0 mt-3 md:mt-2 border rounded-lg inline-block overflow-hidden">
							<a href="{{ route('shops.show', $shop->id) }}" class="justify-center inline-flex relative mx-auto items-center text-grey-dark hover:text-blue-dark hover:bg-grey-lightest px-3 py-2 no-underline font-semibold">
								See Details
							</a><a href="{{ route('bookings.create', $shop->id) }}" class="border-l justify-center inline-flex relative mx-auto items-center text-blue hover:text-blue-dark hover:bg-grey-lightest px-3 py-2 no-underline font-semibold">
								Book Now
								<!-- <span class="absolute block h-10 pin-l pin-y -ml-4" style="border-bottom: 3rem solid #29a7c9;
							border-left: 16px solid transparent;"></span> -->
							</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endforeach
</div>
@endsection