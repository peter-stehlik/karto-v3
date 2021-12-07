<html>
<head>
	<style>
		html, body {
			margin: 0;
			font-family: monospace;
			font-weight: 300;
			letter-spacing: 0.2px;
		}
		body {
			font-size: 16px;
		}
		p {
			margin: 0 0 5px;
		}
		.sided {
			
			display: flex;
			justify-content: space-between;
		}
		.mw {
			width: 320px;
		}
	</style>
</head>
<body>
	<p class="mw sided">
		<span>{!! $person->title !!}</span>
		<span class="padding-left: 20px;">{!! $person->id !!}</span>
	</p>

	<p class="mw"><span>{!! $person->name1 !!}</span></p>
	
	<p>{!! $person->address1 !!}</p>

	<p>{!! $person->address2 !!}</p>

	<p>{!! $person->zip_code !!} {!! $person->city !!}</p>
	
	<p>{!! $person->state !!}</p>

	<script>
		window.print();
		// window.close();
	</script>
</body>
</html>