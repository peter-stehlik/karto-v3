<x-app-layout>
	@if ($errors->any())
		<div class="alert alert-danger">
			<ul class="m-0">
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<h1 class="h3 py-2 border-bottom text-uppercase">Zmeniť heslo</h1>

	<div class="row">
		<div class="col-lg-5">
			<form method="POST" action="{{ route('uzivatel.zmenit-heslo-post') }}">
				@csrf

				<div class="d-flex align-items-center mb-3">
					<label class="pr-2" for="newPassword">Napíšte nové heslo <sup>*</sup></label>

					<div class="flex-fill">
						<input class="form-control" id="newPassword" type="password" name="newPassword" minlength="6" autocomplete="off" required>
					</div>
				</div>

				<div class="d-flex align-items-center mb-3">
					<label class="pr-2" for="repeatNewPassword">Zopakujte nové heslo <sup>*</sup></label>

					<div class="flex-fill">
						<input class="form-control" id="repeatNewPassword" type="password" name="repeatNewPassword" minlength="6" autocomplete="off" required>
					</div>
				</div>

				<div class="mb-3 d-flex justify-content-end">
					<button class="btn btn-primary" type="submit">Potvrďte zmenu hesla</button>
				</div>
			</form>
		</div>
	</div>
</x-app-layout>