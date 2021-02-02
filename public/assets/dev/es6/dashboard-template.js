/**
 * 
 * GENERAL CLICK EVENT
 * TO MATCH CONCRETE ELEMENT
 * USE CONDITION
 * if( $this.matches('.your-desired-element') ){}
 * 
 */
document.addEventListener('click', function (event) {
	let $this = event.target;

	// SIDEBAR ONE PAGE NAVIGATION, TOGGLE ACTIVE CLASS
	if ($this.matches('.sidebar .nav-link')){
		let $sideLinks = document.querySelectorAll('.sidebar .nav-link');

		$sideLinks.forEach(el => el.classList.remove("active"));

		$this.classList.add("active");
	}

}, false);