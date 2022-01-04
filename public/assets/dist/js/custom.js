"use strict";

/*
*	
*	GENERAL SMALL SNIPPETS
*
*/
var SVD = {
  togglePrintSettings: function togglePrintSettings() {
    $("#togglePrintSettings").click(function () {
      $("#printSettings").slideToggle();
    });
  }
}; //////////
// INIT
//////////

SVD.togglePrintSettings();
