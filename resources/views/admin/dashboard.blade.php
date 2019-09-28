<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" value="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Libre+Franklin:400,400i,600,700" rel="stylesheet" type="text/css">

		<link rel="stylesheet" href="{{ mix('css/app.css') }}">
		<script>
            @if(auth()->check())
                window.Laravel = {!! json_encode([
                    'company' => auth()->user()->shops,
                    'user' => [
                        'id' => auth()->user()->id,
						'name' => e(auth()->user()->name),
						'role' => auth()->user()->user_type
                    ],
                    'csrfToken' => csrf_token()
                ]) !!}
            @endif
        </script>
    </head>
    <body class="font-sans antialiased bg-grey-lightest">
		<div id="app" v-cloak>
		   	<the-admin 
				:user-name='@json(auth()->user()->name)' 
				:user-id='@json(auth()->user()->id)'
			></the-admin>
		</div>

		<script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
