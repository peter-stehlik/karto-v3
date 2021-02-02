<!DOCTYPE html>
<html lang="sk">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="{{url('/images/svdmainlogo.gif')}}" />

	<title>SVD Kancelária</title>

	<meta name="robots" content="noindex, nofollow">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,500;0,900;1,300;1,500;1,900&amp;display=swap" rel="stylesheet">

	<link rel="stylesheet" href="{{ asset('assets/dist/css/bootstrap.5.0.0.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/dist/css/dashboard-template.css') }}">

	<script src="{{ asset('assets/dist/js/dashboard-template.js') }}" defer></script>
	<script src="{{ asset('assets/dist/js/bootstrap.bundle.min.js') }}" defer></script>
	<script src="{{ asset('assets/dist/js/custom.js') }}" defer></script>
</head>
<body>
	<header class="navbar navbar-dark navbar-expand sticky-top bg-dark flex-md-nowrap p-0 shadow justify-content-start">
		<a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3 text-primary" href="{{ route('dashboard') }}">
			SVD kancelária
		</a>

		<nav class="w-100 px-md-2 pt-0 pb-0">
			<div class="container-fluid d-flex align-items-center justify-content-between px-md-2">
				<ul class="navbar-nav mb-0">
					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">Kartotéka</a>

						<ul class="nav flex-column">
							<li class="nav-item">
								<a class="nav-link" href="#ui-homepage">
									Príjem platby
								</a>
							</li><!-- / .nav-item -->

							<li class="nav-item">
								<a class="nav-link" href="#ui-page-right-sidebar">
									Zoznam príjmov
								</a>
							</li><!-- / .nav-item -->

							<li class="nav-item">
								<a class="nav-link" href="#ui-page-no-sidebar">
									Zoznam prevodov
								</a>
							</li><!-- / .nav-item -->

							<li class="nav-item">
								<a class="nav-link" href="#ui-page-no-sidebar">
									Pridať opravu
								</a>
							</li><!-- / .nav-item -->

							<li class="nav-item">
								<a class="nav-link" href="#ui-page-no-sidebar">
									Zoznam opráv
								</a>
							</li><!-- / .nav-item -->

							<li class="nav-item">
								<a class="nav-link" href="#ui-page-no-sidebar">
									Peniaze na ceste
								</a>
							</li><!-- / .nav-item -->

							<li class="nav-item">
								<a class="nav-link" href="#ui-page-no-sidebar">
									Zaúčtovať
								</a>
							</li><!-- / .nav-item -->
						</ul><!-- / .nav -->
					</li><!-- / .nav-item -->

					<li class="nav-item">
						<a class="nav-link" href="general.html">Vydavateľstvo</a>
					</li><!-- / .nav-item -->

					<li class="nav-item">
						<a class="nav-link" href="components.html">Osoba</a>
					</li><!-- / .nav-item -->

					<li class="nav-item">
						<a class="nav-link" href="demo.html">Kancelária</a>
					</li><!-- / .nav-item -->

					<li class="nav-item">
						<a class="nav-link" href="demo.html">Užívateľ</a>
					</li><!-- / .nav-item -->
				</ul><!-- / .navbar-nav -->
				
				<ul class="navbar-nav">
					<li class="nav-item">
						<form method="POST" action="{{ route('logout') }}">
							@csrf

							<a class="nav-link" href="route('logout')"
									onclick="event.preventDefault();
												this.closest('form').submit();">
								Odhlásiť sa
							</a>
						</form>
					</li>
				</ul>
			</div><!-- / .container-fluid -->
		</nav><!-- / .navbar -->
	</header>

	<div class="container-fluid">
		<div class="row">
			<nav class="col-12 pb-4 pl-0 pl-md-2 col-md-3 col-lg-2 bg-light sidebar overflow-auto">
				<div class="position-sticky pt-2">
					<h6 class="sidebar-heading px-2 mt-3 mb-1 text-muted">
						Kartotéka
					</h6>

					<ul class="nav flex-column">
						<li class="nav-item">
							<a class="nav-link" href="#ui-homepage">
								Príjem platby
							</a>
						</li><!-- / .nav-item -->

						<li class="nav-item">
							<a class="nav-link" href="#ui-page-right-sidebar">
								Zoznam príjmov
							</a>
						</li><!-- / .nav-item -->

						<li class="nav-item">
							<a class="nav-link" href="#ui-page-no-sidebar">
								Zoznam prevodov
							</a>
						</li><!-- / .nav-item -->

						<li class="nav-item">
							<a class="nav-link" href="#ui-page-no-sidebar">
								Pridať opravu
							</a>
						</li><!-- / .nav-item -->

						<li class="nav-item">
							<a class="nav-link" href="#ui-page-no-sidebar">
								Zoznam opráv
							</a>
						</li><!-- / .nav-item -->

						<li class="nav-item">
							<a class="nav-link" href="#ui-page-no-sidebar">
								Peniaze na ceste
							</a>
						</li><!-- / .nav-item -->

						<li class="nav-item">
							<a class="nav-link" href="#ui-page-no-sidebar">
								Zaúčtovať
							</a>
						</li><!-- / .nav-item -->
					</ul><!-- / .nav -->
					
					<hr class="mr-2">

					<h6 class="sidebar-heading px-2 mt-3 mb-1 text-muted">
						užívateľ
					</h6>

					<ul class="nav flex-column">
						<li class="nav-item">
							<a class="nav-link" href="#ui-homepage">
								{{ Auth::user()->name }}
							</a>
						</li><!-- / .nav-item -->

						<li class="nav-item">
							<a class="nav-link" href="#ui-homepage">
								Účtovný dátum: <br>
								13.2.2021
							</a>
						</li><!-- / .nav-item -->
					</ul><!-- / .nav -->
				</div>
			</nav><!-- / .sidebar -->

			<main class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-md-3 d-flex flex-column justify-content-between">
				<div class="content">
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
