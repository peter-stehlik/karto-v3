"use strict";

/**
 * 
 * GENERAL CLICK EVENT
 * TO MATCH CONCRETE ELEMENT
 * USE CONDITION
 * if( $this.matches('.your-desired-element') ){}
 * 
 */
document.addEventListener('click', function (event) {
  var $this = event.target; // SIDEBAR ONE PAGE NAVIGATION, TOGGLE ACTIVE CLASS

  if ($this.matches('.sidebar .nav-link')) {
    var $sideLinks = document.querySelectorAll('.sidebar .nav-link');
    $sideLinks.forEach(function (el) {
      return el.classList.remove("active");
    });
    $this.classList.add("active");
  }
}, false);
