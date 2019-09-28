@extends('layouts.base')

@section('content')
<div class="bg-white py-10 px-4">
    <div class="container mx-auto flex items-center leading-normal">
        <div class="w-1/2 md:pr-16">
            <h2 class="text-2xl lg:text-3xl mb-2 text-grey-darkest">Appointments Made Easy</h2>
            <p class="text-grey-darker">Booking cannot be this easy. Just register, select your service or category, pick your time and schedule an appointment. Yay! it's that easy.</p>


            <div class="flex flex-col md:flex-row items-center mt-5">
                <a href="#" class="inline-flex items-center rounded-lg bg-blue text-white px-4 h-10 no-underline hover:bg-blue-dark font-semibold">
                    <!-- <Zondicon icon="arrow-thin-right" class="fill-current svg-icon mr-2"></Zondicon> -->
                    Browse Services
                </a>
                <span class="inline-flex mx-4 text-grey-dark">or</span>
                <a href="#" class="inline-flex items-center rounded-lg border-2 border-grey-light text-blue px-4 h-10 no-underline hover:border-blue hover:border-blue font-semibold">
                    Get Started
                </a>
            </div>

        </div>
        <div class="w-1/2 text-center">
            <img src="/svg/welcome.jpg" alt="" class="h-64">
        </div>
    </div>
</div>

@php
$services = [
    [       
        "service_name" => "Book a Dentist",
        "service_info" => "Find a nearby dentist and schedule a cleaning.",
        "service_icon" => "dental-chair"
    ],   
    [       
        "service_name" => "Book a Psychiatrist",
        "service_info" => "Find a psychiatrist and schedule a health checkup.",
        "service_icon" => "relaxation"
    ],   
    [       
        "service_name" => "Book a Salon",
        "service_info" => "Find a nearby salon and schedule a haircut in seconds.",
        "service_icon" => "scissors"
    ],   
    [       
        "service_name" => "Book an Eye Doctor",
        "service_info" => "Find a nearby eye specialist and schedule a checkup.",
        "service_icon" => "doctor"
    ],   
    [       
        "service_name" => "Book a Law Consultant",
        "service_info" => "Find a law consultant and schedule an appointment.",
        "service_icon" => "auction"
    ],   
    [       
        "service_name" => "Book a Photographer",
        "service_info" => "Find a photographer for your events.",
        "service_icon" => "photo-camera"
    ]
];
@endphp

<div class="bg-grey-lightest border-grey-lighter py-10 md:py-16 px-4">
    <div class="container mx-auto">
        <h2 class="text-2xl lg:text-3xl mb-4 text-grey-darkest">Choose a service</h2>
        <div class="flex flex-wrap -mx-4">
            @foreach($services as $service)
            <div class="w-full md:w-1/3 px-4 my-4">
                <div class="flex bg-white shadow rounded-lg p-5 w-full">
                    <div class="mr-4 w-24 h-24 rounded-full bg-blue-lightest inline-flex flex-no-shrink items-center justify-center">
                    @svg($service['service_icon'], 'text-blue text-5xl')
                    </div>
                    <div>
                        <h3 class="mb-2 text-grey-darkest font-semibold truncate">{{ $service['service_name'] }}</h3>
                        <p class="text-grey-darker mb-3 leading-normal text-sm">{{ $service['service_info'] }}</p>

                        <a href="#" class="inline-flex items-center no-underline text-blue hover:text-blue-dark font-semibold">Search<Zondicon icon="arrow-right" class="fill-current svg-icon ml-2"></Zondicon></a>
                    </div>
                </div>
            </div>
            @endforeach

            <a href="#" class="mt-5 mx-auto inline-flex items-center rounded-lg bg-blue text-white px-4 h-10 no-underline hover:bg-blue-dark font-semibold">
                <Zondicon icon="view-tile" class="fill-current svg-icon mr-2"></Zondicon>
                Browse Services
            </a>
        </div>
    </div>
</div>

<div class="bg-white py-10 md:py-24 px-4">
    <div class="container mx-auto flex items-center leading-normal">
        <div class="w-1/2 text-center">
            <img src="/svg/business.png" alt="" class="h-64">
        </div>
        <div class="w-1/2 md:pl-16">
            <h2 class="text-2xl lg:text-3xl mb-2 text-grey-darkest">Every business is now digital</h2>
            <p class="text-grey-darkest mb-2 uppercase tracking-wide">Don't Wait! Business Owner. Start Listing</p> 
            <p class="text-grey-darker">The easiest system to manage your business, receive online payments and get clients self-booking 24/7. If you have doubt feel free to contact us. Our team will help you to set up your business and get you up and running in no time.</p>

            <a href="#" class="mt-5 inline-flex items-center rounded-lg bg-blue text-white px-4 h-10 no-underline hover:bg-blue-dark font-semibold">
                <!-- <Zondicon icon="arrow-thin-right" class="fill-current svg-icon mr-2"></Zondicon> -->
                Let's Get Started
            </a>
        </div>
    </div>
</div>

<div class="bg-grey-lightest py-10 px-4">
    <div class="container mx-auto flex items-center leading-normal">
        <div class="w-1/2 md:pr-16">
            <h2 class="text-2xl lg:text-3xl mb-2 text-grey-darkest">Appointments on the go</h2>
             
            <p class="text-grey-darker mb-4">Download our app from PlayStore and start scheduling from wherever, whenever you wish.</p>

            <a href="#" class="no-underline -ml-2">
                <img src="/svg/googlePlay.png" alt="PlayStore" class="h-16">
            </a>
        </div>
        <div class="w-1/2 text-center">
            <img src="/svg/messaging.svg" alt="" class="h-64">
        </div>
    </div>
</div>
@endsection
