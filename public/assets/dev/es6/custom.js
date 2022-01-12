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
    loadPrintRowFromLocalStorage: () => {
        if( localStorage.hasOwnProperty('printRowIds') && localStorage.hasOwnProperty('printRowNames') ){
            if( !localStorage.getItem('printRowIds') && !localStorage.getItem('printRowNames') ){
                return;
            }

            $("#printRowIds").val( localStorage.getItem('printRowIds') );
            $("#printRowNames").val( localStorage.getItem('printRowNames') );
            SVD.loadPrintSettingsFromLocalStorage();

            let idsArr = localStorage.getItem('printRowIds').split("|");
            let namesArr = localStorage.getItem('printRowNames').split("|");
            let html = "";

            for(let i=0; i<idsArr.length; i++){
                let $row = `
                    <p class="print-person">
                        ${idsArr[i]}, ${namesArr[i]}
                        <a class="text-danger js-remove-from-print-row" href="javascript:void(0);" data-person-id="${idsArr[i]}" data-person-name="${namesArr[i]}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-backspace-fill" viewBox="0 0 16 16">
                                <path d="M15.683 3a2 2 0 0 0-2-2h-7.08a2 2 0 0 0-1.519.698L.241 7.35a1 1 0 0 0 0 1.302l4.843 5.65A2 2 0 0 0 6.603 15h7.08a2 2 0 0 0 2-2V3zM5.829 5.854a.5.5 0 1 1 .707-.708l2.147 2.147 2.146-2.147a.5.5 0 1 1 .707.708L9.39 8l2.146 2.146a.5.5 0 0 1-.707.708L8.683 8.707l-2.147 2.147a.5.5 0 0 1-.707-.708L7.976 8 5.829 5.854z"/>
                        </svg>
                        </a>
                    </p>
                `;

                html += $row;
            }

            $("#printRow").html(html);

            $(".printRowWrap").show();
        }
    },
    loadPrintSettingsFromLocalStorage: () => {
        $("#printRowColumns").val( localStorage.getItem('printRowColumns') );
        $("#printRowStartPosition").val( localStorage.getItem('printRowStartPosition') );
    },
    addToPrintRow: () => {
        $(document).on("click", ".js-add-to-print-row", function() {
            let personId = $(this).attr("data-person-id");
            let personName = $(this).attr("data-person-name");
            let $row = `
                <p class="print-person">
                    ${personId}, ${personName}
                    <a class="text-danger js-remove-from-print-row" href="javascript:void(0);" data-person-id="${personId}" data-person-name="${personName}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-backspace-fill" viewBox="0 0 16 16">
                            <path d="M15.683 3a2 2 0 0 0-2-2h-7.08a2 2 0 0 0-1.519.698L.241 7.35a1 1 0 0 0 0 1.302l4.843 5.65A2 2 0 0 0 6.603 15h7.08a2 2 0 0 0 2-2V3zM5.829 5.854a.5.5 0 1 1 .707-.708l2.147 2.147 2.146-2.147a.5.5 0 1 1 .707.708L9.39 8l2.146 2.146a.5.5 0 0 1-.707.708L8.683 8.707l-2.147 2.147a.5.5 0 0 1-.707-.708L7.976 8 5.829 5.854z"/>
                    </svg>
                    </a>
                </p>
            `;

            $("#printRow").append($row);
            $(".printRowWrap").show();

            let $ids = $("#printRowIds");
            let printRowIdsArr = [];
            
            if( $ids.val() ){
                printRowIdsArr = $ids.val().split("|");
            }

            printRowIdsArr.push(personId);
            $ids.val(printRowIdsArr.join("|"));
            
            localStorage.setItem('printRowIds', printRowIdsArr.join("|"));

            /////////////

            let $names = $("#printRowNames");
            let printRowNamesArr = [];
            
            if( $names.val() ){
                printRowNamesArr = $names.val().split("|");
            }

            printRowNamesArr.push(personName);
            $names.val(printRowNamesArr.join("|"));
            
            localStorage.setItem('printRowNames', printRowNamesArr.join("|"));

            SVD.loadPrintSettingsFromLocalStorage();
        });
    },
    removeFromPrintRow: () => {
        $(document).on("click", ".js-remove-from-print-row", function() {
            let personId = $(this).attr("data-person-id");
            let $ids = $("#printRowIds");
            let printRowIdsArr = $ids.val().split("|");
            let index = printRowIdsArr.indexOf(personId);

            printRowIdsArr.splice(index, 1);

            $ids.val(printRowIdsArr.join("|"));

            localStorage.setItem('printRowIds', printRowIdsArr.join("|"));
            
            /////////////

            let $names = $("#printRowNames");
            let printRowNamesArr = $names.val().split("|");;
            
            printRowNamesArr.splice(index, 1);

            $names.val(printRowNamesArr.join("|"));
            
            localStorage.setItem('printRowNames', printRowNamesArr.join("|"));
            
            if( !$names.val() && !$ids.val()  ){
                $(".printRowWrap").hide();
            }

            $(this).closest(".print-person").remove();

            SVD.loadPrintSettingsFromLocalStorage();
        });
    },
    savePrintRowSettingsOnSubmit: () => {
        $(document).on("submit", "#printRowForm", function(){
            let printRowForm = function(){            
                let cols = parseInt($("#printRowColumns").val());
                let startPosition = parseInt($("#printRowStartPosition").val());
                let idsArrLength = localStorage.getItem('printRowIds').split("|").length;

                localStorage.setItem('printRowColumns', cols);

                if( cols === 2 ){
                    if( (startPosition+idsArrLength) % 12 === 0 ){
                        startPosition = 12;
                    } else {
                        startPosition = (startPosition+idsArrLength) % 12;
                    }
                } else if( cols === 3 ){
                    if( (startPosition+idsArrLength) % 24 === 0 ){
                        startPosition = 24;
                    } else {
                        startPosition = (startPosition+idsArrLength) % 24;
                    }
                }

                localStorage.setItem('printRowStartPosition', startPosition);

                //localStorage.clear();

                localStorage.setItem('printRowIds', '');
                localStorage.setItem('printRowNames', '');
                
                $("#printRow").empty();
                $("#printRowIds").val('');
                $("#printRowNames").val('');
                $(".printRowWrap").hide();

                // return false;
            }

            setTimeout(printRowForm, 3000);
        });
    },
}

//////////
// INIT
//////////
$(document).ready(function(){
    SVD.togglePrintSettings();
    SVD.loadPrintRowFromLocalStorage();
    SVD.addToPrintRow();
    SVD.removeFromPrintRow();
    SVD.savePrintRowSettingsOnSubmit();
});