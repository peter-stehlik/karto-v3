/*
*	
*	GENERAL SMALL SNIPPETS
*
*/
let SVD = {
	changeAccountingDate: () => {
		$(document).on("click", "#changeAccountingDate", function(){
			$("#accountingDateBox").slideToggle();
		});

		$(document).on("click", "#setAccountingDate", function(){
			let newDate = $("#accountingDate").val();
			let userId = $("#accountingDateUserId").val();

			$.getJSON(
				"/uzivatel/uctovny-datum",
				{
					accounting_date: newDate,
					user_id: userId,
				},
				function (data) {
					if (data.result == 1) {	
						$("#successChangeAccountingDate").slideToggle();
						$("#accountingDatePreview").text(newDate);
					}
				}
			);
		});
	},
}

//////////
// INIT
//////////
SVD.changeAccountingDate();