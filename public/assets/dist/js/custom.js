"use strict";

/*
*	
*	GENERAL SMALL SNIPPETS
*
*/
var SVD = {
  changeAccountingDate: function changeAccountingDate() {
    $(document).on("click", "#changeAccountingDate", function () {
      $("#accountingDateBox").slideToggle();
    });
    $(document).on("click", "#setAccountingDate", function () {
      var newDate = $("#accountingDate").val();
      var userId = $("#accountingDateUserId").val();
      $.getJSON("/uzivatel/uctovny-datum", {
        accountingDate: newDate,
        userId: userId
      }, function (data) {
        if (data.result === 1) {
          $("#successChangeAccountingDate").slideToggle();
          $("#accountingDatePreview").text(newDate);
        }
      });
    });
  }
}; //////////
// INIT
//////////

SVD.changeAccountingDate();
