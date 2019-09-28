@extends('layouts.base')

@section('content')
<div class="py-5 px-4">
	<div class="container mx-auto leading-normal">

		@if (session('success'))
			<div class="bg-blue-lightest border-l-4 border-blue rounded-lg text-blue-darkest px-4 py-4 shadow" role="alert">
				<div class="flex">
					<div>
						<Zondicon icon="checkmark-outline" class="fill-current text-blue text-lg svg-icon mr-3"></Zondicon>
					</div>
					<div>
						<strong class="font-bold">Success!</strong>
						<span class="block sm:inline">{{ session('success') }}</span>
					</div>
				</div>
			</div>
		@endif
		
	</div>
</div>

@endsection