<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" value="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,400i,600,700" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script>
            @if(auth()->check())
                window.Laravel = {!! json_encode([
                    'user' => [
                        'id' => auth()->user()->id,
                        'name' => e(auth()->user()->name),
                        'role' => auth()->user()->user_type
                    ]
                ]) !!}
            @endif
        </script>
    </head>
    <body class="antialiased font-sans bg-grey-lightest">
		<div id="app" class="flex min-h-screen flex-col">        
            <div class="bg-white px-4 border-t-4 border-blue">
                <div class="flex container mx-auto h-16 items-center justify-between">
                    <div class="flex-no-shrink">
                        <a href="/" class="no-underline inline-flex items-center">
                            <!-- <span class="inline-block rounded w-5 h-5 text-center bg-blue-dark text-white"> -->
                            <!-- <Zondicon icon="calendar" class="fill-current svg-icon text-blue"></Zondicon> -->
                            <img src="/svg/logo.jpeg" alt="logo" class="inline-flex h-8">
                            <span class="tracking-tight font-semibold text-lg text-grey-darkest">apoint</span>
                        </a>
                    </div>
                    <div class="flex justify-between w-full">
                        <div class="pl-0 md:pl-10">
                            <a href="/" class="no-underline text-grey-dark hover:text-blue mx-4">Home</a>
                            <a href="/services" class="no-underline text-grey-dark hover:text-blue mx-4">Services</a>
                            <a href="#" class="no-underline text-grey-dark hover:text-blue mx-4">Categories</a>
                            <a href="#" class="no-underline text-grey-dark hover:text-blue mx-4">For Business</a>
                            <a href="/appointments" class="no-underline text-grey-dark hover:text-blue mx-4"> My Appointments</a>
                        </div>

                        <div>
                            @guest
                                <a href="/login" class="no-underline text-grey-dark hover:text-blue mx-4">Login</a>
                                <a href="/register" class="ml-4 no-underline text-white bg-blue px-3 py-2 rounded-lg hover:bg-blue-dark">Get Started</a>
                            @else 
                                <a href="/get-started" class="no-underline text-grey-dark hover:text-blue mx-4">Get Started</a>

                                <a href="/dashboard" class="no-underline text-grey-dark hover:text-blue mx-4">Dashboard</a>

                                <navbar-dropdown class="inline-flex text-grey-dark hover:text-blue ml-4" title="{{ auth()->user()->name }}"></navbar-dropdown>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex-1">
                @yield('content')
            </div>
            <footer class="bg-white py-8 md:py-16 w-full px-4">
                <div class="container mx-auto">
                    <div class="table w-full align-top">
                        <div class="block sm:table-cell">
                            <!-- <div class="no-underline font-semibold text-lg text-grey-darkest mb-3">
                                <Zondicon icon="calendar" class="fill-current svg-icon text-blue"></Zondicon>
                                <span class="tracking-tight">/apoint</span>
                            </div> -->
                            <img src="/svg/logo.jpeg" alt="logo" class="inline-flex h-10">
                            <p class="text-grey-dark text-sm">Apoint &copy;{{ date('Y') }}. A product of <a href="https://sumato.global" target="_blank" class="text-grey-dark hover:text-blue">Sumato</a>.</p>
                        </div>
                        <div class="block sm:table-cell">
                            <p class="text-grey-darker text-sm font-semibold sm:mb-6 md:mb-3">Apoint</p>
                            <ul class="list-reset text-sm mb-6">
                                <li class="mt-2 inline-block mr-2 sm:block sm:mr-0">
                                    <a href="#" class="text-grey-dark hover:text-blue no-underline">About Apoint</a>
                                </li>
                                <li class="mt-2 inline-block mr-2 sm:block sm:mr-0">
                                    <a href="#" class="text-grey-dark hover:text-blue no-underline">FAQ</a>
                                </li>
                                <li class="mt-2 inline-block mr-2 sm:block sm:mr-0">
                                    <a href="#" class="text-grey-dark hover:text-blue no-underline">Help</a>
                                </li>
                                <li class="mt-2 inline-block mr-2 sm:block sm:mr-0">
                                    <a href="#" class="text-grey-dark hover:text-blue no-underline">Terms</a>
                                </li>
                                <li class="mt-2 inline-block mr-2 sm:block sm:mr-0">
                                    <a href="#" class="text-grey-dark hover:text-blue no-underline">Privacy</a>
                                </li>
                                <li class="mt-2 inline-block mr-2 sm:block sm:mr-0">
                                    <a href="#" class="text-grey-dark hover:text-blue no-underline">Support & Contact</a>
                                </li>
                            </ul>
                        </div>
                        <div class="block sm:table-cell">
                            <p class="text-grey-darker text-sm font-semibold sm:mb-6 md:mb-3">Services</p>
                            <ul class="list-reset text-sm mb-6">
                                <li class="mt-2 inline-block mr-2 sm:block sm:mr-0">
                                    <a href="#" class="text-grey-dark hover:text-blue no-underline">Book a Dentist</a>
                                </li>
                                <li class="mt-2 inline-block mr-2 sm:block sm:mr-0">
                                    <a href="#" class="text-grey-dark hover:text-blue no-underline">Book a Psychiatrist</a>
                                </li>
                                <li class="mt-2 inline-block mr-2 sm:block sm:mr-0">
                                    <a href="#" class="text-grey-dark hover:text-blue no-underline">Book a Salon</a>
                                </li>
                                <li class="mt-2 inline-block mr-2 sm:block sm:mr-0">
                                    <a href="#" class="text-grey-dark hover:text-blue no-underline">Book an Eye Doctor</a>
                                </li>
                                <li class="mt-2 inline-block mr-2 sm:block sm:mr-0">
                                    <a href="#" class="text-grey-dark hover:text-blue no-underline">Book a Lawyer</a>
                                </li>
                                <li class="mt-2 inline-block mr-2 sm:block sm:mr-0">
                                    <a href="#" class="text-grey-dark hover:text-blue no-underline">Book a Photographer</a>
                                </li>
                            </ul>
                        </div>
                        <div class="block sm:table-cell">
                            <p class="text-grey-darker text-sm font-semibold sm:mb-6 md:mb-3">Follow Apoint</p>
                            <ul class="list-reset text-sm mb-6">
                                <li class="mt-2 inline-block mr-2 sm:block sm:mr-0">
                                    <a href="#" class="text-grey-dark hover:text-blue no-underline">Facebook</a>
                                </li>
                                <li class="mt-2 inline-block mr-2 sm:block sm:mr-0">
                                    <a href="#" class="text-grey-dark hover:text-blue no-underline">Linkedin</a>
                                </li>
                                <li class="mt-2 inline-block mr-2 sm:block sm:mr-0">
                                    <a href="#" class="text-grey-dark hover:text-blue no-underline">Twitter</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
		</div>
		<script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
