<html>
<head>
	<!-- WORKING FOR EPSON LX 350
	 
		Control Panel - Hardware and Software - Devices and Printers [Print server properties]
		v nastaveniach papiera rozmer 10 x 3.8 cm
	-->
	<style>
		html, body {
			margin: 0;
			font-family: 'Sans Serif', 'Draft', 'Roman', monospace;
		}
		body {
			font-size: 14px;
		}
		p {
			width: 100%;
			margin: 0 0 0px;
			overflow: hidden;
			white-space: nowrap;
		}
		.sided {
			
			display: flex;
			justify-content: space-between;
		}
		.mt {
			margin-top: 8px;
		}
		.mw {
			width: 330px;
		}
	</style>
	<style>
		.person {
  			page-break-after: always;
		}
	</style>
</head>
<body>
	@foreach( $people as $person )
	<section class="person mw">
		<p class="sided mt">
			<span>{!! $person->title !!}</span>
			<span class="padding-left: 20px;">{!! $person->id !!}</span>
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