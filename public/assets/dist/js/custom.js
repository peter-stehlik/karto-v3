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
  },
  loadPrintRowFromLocalStorage: function loadPrintRowFromLocalStorage() {
    if (localStorage.hasOwnProperty('printRowIds') && localStorage.hasOwnProperty('printRowNames')) {
      if (!localStorage.getItem('printRowIds') && !localStorage.getItem('printRowNames')) {
        return;
      }

      $("#printRowIds").val(localStorage.getItem('printRowIds'));
      $("#printRowNames").val(localStorage.getItem('printRowNames'));
      SVD.loadPrintSettingsFromLocalStorage();
      var idsArr = localStorage.getItem('printRowIds').split("|");
      var namesArr = localStorage.getItem('printRowNames').split("|");
      var html = "";

      for (var i = 0; i < idsArr.length; i++) {
        var $row = "\n                    <p class=\"print-person\">\n                        ".concat(idsArr[i], ", ").concat(namesArr[i], "\n                        <a class=\"text-danger js-remove-from-print-row\" href=\"javascript:void(0);\" data-person-id=\"").concat(idsArr[i], "\" data-person-name=\"").concat(namesArr[i], "\">\n                            <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-backspace-fill\" viewBox=\"0 0 16 16\">\n                                <path d=\"M15.683 3a2 2 0 0 0-2-2h-7.08a2 2 0 0 0-1.519.698L.241 7.35a1 1 0 0 0 0 1.302l4.843 5.65A2 2 0 0 0 6.603 15h7.08a2 2 0 0 0 2-2V3zM5.829 5.854a.5.5 0 1 1 .707-.708l2.147 2.147 2.146-2.147a.5.5 0 1 1 .707.708L9.39 8l2.146 2.146a.5.5 0 0 1-.707.708L8.683 8.707l-2.147 2.147a.5.5 0 0 1-.707-.708L7.976 8 5.829 5.854z\"/>\n                        </svg>\n                        </a>\n                    </p>\n                ");
        html += $row;
      }

      $("#printRow").html(html);
      $(".printRowWrap").show();
    }
  },
  loadPrintSettingsFromLocalStorage: function loadPrintSettingsFromLocalStorage() {
    $("#printRowColumns").val(localStorage.getItem('printRowColumns'));
    $("#printRowStartPosition").val(localStorage.getItem('printRowStartPosition'));
  },
  addToPrintRow: function addToPrintRow() {
    $(document).on("click", ".js-add-to-print-row", function () {
      var personId = $(this).attr("data-person-id");
      var personName = $(this).attr("data-person-name");
      var $row = "\n                <p class=\"print-person\">\n                    ".concat(personId, ", ").concat(personName, "\n                    <a class=\"text-danger js-remove-from-print-row\" href=\"javascript:void(0);\" data-person-id=\"").concat(personId, "\" data-person-name=\"").concat(personName, "\">\n                        <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-backspace-fill\" viewBox=\"0 0 16 16\">\n                            <path d=\"M15.683 3a2 2 0 0 0-2-2h-7.08a2 2 0 0 0-1.519.698L.241 7.35a1 1 0 0 0 0 1.302l4.843 5.65A2 2 0 0 0 6.603 15h7.08a2 2 0 0 0 2-2V3zM5.829 5.854a.5.5 0 1 1 .707-.708l2.147 2.147 2.146-2.147a.5.5 0 1 1 .707.708L9.39 8l2.146 2.146a.5.5 0 0 1-.707.708L8.683 8.707l-2.147 2.147a.5.5 0 0 1-.707-.708L7.976 8 5.829 5.854z\"/>\n                    </svg>\n                    </a>\n                </p>\n            ");
      $("#printRow").append($row);
      $(".printRowWrap").show();
      var $ids = $("#printRowIds");
      var printRowIdsArr = [];

      if ($ids.val()) {
        printRowIdsArr = $ids.val().split("|");
      }

      printRowIdsArr.push(personId);
      $ids.val(printRowIdsArr.join("|"));
      localStorage.setItem('printRowIds', printRowIdsArr.join("|")); /////////////

      var $names = $("#printRowNames");
      var printRowNamesArr = [];

      if ($names.val()) {
        printRowNamesArr = $names.val().split("|");
      }

      printRowNamesArr.push(personName);
      $names.val(printRowNamesArr.join("|"));
      localStorage.setItem('printRowNames', printRowNamesArr.join("|"));
      SVD.loadPrintSettingsFromLocalStorage();
    });
  },
  removeFromPrintRow: function removeFromPrintRow() {
    $(document).on("click", ".js-remove-from-print-row", function () {
      var personId = $(this).attr("data-person-id");
      var $ids = $("#printRowIds");
      var printRowIdsArr = $ids.val().split("|");
      var index = printRowIdsArr.indexOf(personId);
      printRowIdsArr.splice(index, 1);
      $ids.val(printRowIdsArr.join("|"));
      localStorage.setItem('printRowIds', printRowIdsArr.join("|")); /////////////

      var $names = $("#printRowNames");
      var printRowNamesArr = $names.val().split("|");
      ;
      printRowNamesArr.splice(index, 1);
      $names.val(printRowNamesArr.join("|"));
      localStorage.setItem('printRowNames', printRowNamesArr.join("|"));

      if (!$names.val() && !$ids.val()) {
        $(".printRowWrap").hide();
      }

      $(this).closest(".print-person").remove();
      SVD.loadPrintSettingsFromLocalStorage();
    });
  },
  savePrintRowSettingsOnSubmit: function savePrintRowSettingsOnSubmit() {
    $(document).on("submit", "#printRowForm", function () {
      var printRowForm = function printRowForm() {
        var cols = parseInt($("#printRowColumns").val());
        var startPosition = parseInt($("#printRowStartPosition").val());
        var idsArrLength = localStorage.getItem('printRowIds').split("|").length;
        localStorage.setItem('printRowColumns', cols);

        if (cols === 2) {
          if ((startPosition + idsArrLength) % 12 === 0) {
            startPosition = 12;
          } else {
            startPosition = (startPosition + idsArrLength) % 12;
          }
        } else if (cols === 3) {
          if ((startPosition + idsArrLength) % 24 === 0) {
            startPosition = 24;
          } else {
            startPosition = (startPosition + idsArrLength) % 24;
          }
        }

        localStorage.setItem('printRowStartPosition', startPosition); //localStorage.clear();

        localStorage.setItem('printRowIds', '');
        localStorage.setItem('printRowNames', '');
        $("#printRow").empty();
        $("#printRowIds").val('');
        $("#printRowNames").val('');
        $(".printRowWrap").hide(); // return false;
      };

      setTimeout(printRowForm, 3000);
    });
  }
}; //////////
// INIT
//////////

$(document).ready(function () {
  SVD.togglePrintSettings();
  SVD.loadPrintRowFromLocalStorage();
  SVD.addToPrintRow();
  SVD.removeFromPrintRow();
  SVD.savePrintRowSettingsOnSubmit();
});
