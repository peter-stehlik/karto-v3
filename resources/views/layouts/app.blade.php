<!DOCTYPE html>
<html lang="sk">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="{{url('/images/svdmainlogo.gif')}}" />

	<title>{{ request()->route()->getName() }} | SVD</title>

	<meta name="robots" content="noindex, nofollow">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,500;0,900;1,300;1,500;1,900&amp;display=swap" rel="stylesheet">

	<link rel="stylesheet" href="{{ asset('assets/dist/css/bootstrap.5.0.0.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/dist/css/dashboard-template.css') }}">

	<script src="{{ asset('assets/dist/js/jquery-3.6.0.min.js') }}"></script>
	<script src="{{ asset('assets/dist/js/dashboard-template.js') }}" defer></script>
	<script src="{{ asset('assets/dist/js/bootstrap.bundle.min.js') }}" defer></script>
	<script src="{{ asset('assets/dist/js/debounce.1.1.js') }}" defer></script>
	<script src="{{ asset('assets/dist/js/custom.js') }}" defer></script>
	<script src="{{ asset('assets/dist/js/helper.js') }}" defer></script>
	<script src="{{ asset('assets/dist/js/income.js') }}" defer></script>
	<script src="{{ asset('assets/dist/js/filter.js') }}" defer></script>
</head>
<body>
	@include('layouts/header')

	<div class="container-fluid">
		<div class="row">
		@include('layouts/sidebar')

			<main class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-md-3 d-flex flex-column justify-content-between">
				<div class="content">
					@if (session('message'))
						<div class="alert alert-info alert-dismissible fade show" role="alert">
							{{ session('message') }}

							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					@endif

                    {{ $slot }}
				</div><!-- / .content -->

				<footer class="pb-3 pt-1 mt-5 border-top text-right text-muted">
					Spoločnosť Božieho Slova &copy; 2021
				</footer>
			</main>
		</div><!-- / .row -->
	</div><!-- / .container-fluid -->
</body>
</html>
