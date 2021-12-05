<html>
<head>
	<style>
		html, body {
			margin: 0;
		}
		body {
			font-size: 14px;
			color: #333;
		}
		p {
			margin: 0;
		}
		.sided {
			display: flex;
			justify-content: space-between;
		}
		.person {
  			page-break-after: always;
		}
	</style>
</head>
<body>
	@foreach( $people as $person )
	<section class="person">
		<p class="sided">
			<span>{!! $person->title !!}</span>
			<span>{!! $person->id !!}</span>
		</p>
		
		<p><span>{!! $person->name1 !!}</span></p>
		
		<p>{!! $person->address1 !!}</p>
		
		<p>{!! $person->address2 !!}</p>
		
		<p>{!! $person->zip_code !!} {!! $person->city !!}</p>
		
		<p>{!! $person->state !!}</p>
	</section>
	@endforeach

	<script>
		window.print();
		// window.close();
	</script>
</body>
</html>