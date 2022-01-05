<!DOCTYPE html>
<html>
<head>
	<!-- 
		Control Panel - Hardware and Software - Devices and Printers [Print server properties]
		v nastaveniach papiera rozmer 17 x 3.81 cm
	-->

	<style>
		html, body {
			margin: 0;
			font-family: Verdana, 'Sans Serif', 'Draft', 'Roman', monospace;
		}
		body {
			font-size: 12px;
			letter-spacing: 7px;
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
			margin-top: 4px;
		}
		.mw {
			width: 580px;
		}
	</style>
</head>
<body>
	<section class="person mw">
		<p class="sided mt">
			<span>{!! $person->title !!} &nbsp;</span>
			<span class="padding-left: 20px;">{!! $person->id !!} &nbsp;</span>
		</p>

		<p class=""><span>{!! $person->name1 !!} &nbsp;</span></p>
		
		<p class=""><span>{!! $person->name2 !!} &nbsp;</span></p>
			
		<p>{!! $person->address1 !!} &nbsp;</p>

		@if( $person->address2 )
			<p>{!! $person->address2 !!} &nbsp;</p>
		@endif

		<p>{!! $person->zip_code !!} {!! $person->city !!} &nbsp;</p>
		
		<p>{!! $person->state !!} &nbsp;</p>
	</section>

	<script>
		window.print();

        setTimeout(window.close, 1000);
		// window.close();
	</script>
</body>
</html>