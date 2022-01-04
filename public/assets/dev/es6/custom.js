/*
*	
*	GENERAL SMALL SNIPPETS
*
*/
let SVD = {
    togglePrintSettings: () => {
        $("#togglePrintSettings").click(function(){
            $("#printSettings").slideToggle();
        });
    },
}

//////////
// INIT
//////////
SVD.togglePrintSettings();