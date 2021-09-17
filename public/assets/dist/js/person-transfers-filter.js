"use strict";

var PersonTransfersFilter = {
  emptySearchResults: function emptySearchResults() {
    $("#personTransferFilterTableResults").empty();
  },
  filterPersonTransfers: function filterPersonTransfers() {
    Help.showPreloader();
    PersonTransfersFilter.emptySearchResults();
    var person_id = $("#person_id").val();
    var sum_from = $("#sum_from").val();
    var sum_to = $("#sum_to").val();
    var periodical_publication_id = $("#periodical_publication_id").val();
    var nonperiodical_publication_id = $("#nonperiodical_publication_id").val();
    var transfer_date_from = $("#transfer_date_from").val();
    var transfer_date_to = $("#transfer_date_to").val();
    /***
     * VALIDATE IF SOME PARAMETER FILLED
     */

    if (person_id == 0 && sum_from.length == 0 && sum_to.length == 0 && periodical_publication_id == 0 && nonperiodical_publication_id == 0 && transfer_date_from.length == 0 && transfer_date_to.length == 0) {
      alert("Zadajte aspoň jeden parameter do vyhľadávania.");
      Help.hidePreloader();
      return;
    }
    /***
     * GET DATA FROM SERVER
     */


    $.getJSON("/dobrodinec/prevody-filter", {
      person_id: person_id,
      sum_from: sum_from,
      sum_to: sum_to,
      periodical_publication_id: periodical_publication_id,
      nonperiodical_publication_id: nonperiodical_publication_id,
      transfer_date_from: transfer_date_from,
      transfer_date_to: transfer_date_to
    }, function (data) {
      if (data.transfers.length) {
        PersonTransfersFilter.populateSearchedTransfers(data.transfers);
      } else {
        alert("Nič som nenašiel.");
      }

      Help.hidePreloader();
    });
  },
  populateSearchedTransfers: function populateSearchedTransfers(transfers) {
    if (transfers) {
      var htmlResults = "";

      for (var i = 0; i < transfers.length; i++) {
        var income_id = transfers[i].income_id;
        var transfer_id = transfers[i].transfer_id;
        var transfer_sum = Help.beautifyDecimal(transfers[i].transfer_sum);
        var pp_name = transfers[i].pp_name;
        var np_name = transfers[i].np_name;
        var transfer_date = Help.beautifyDate(transfers[i].transfer_date);
        var note = transfers[i].note;
        var row = "\n            <tr class=\"transfer-row\">\n              <td>".concat(transfer_id, "</td>\n              <td>").concat(transfer_sum, " &euro;</td>\n              <td>").concat(pp_name, "</td>\n              <td>").concat(np_name, "</td>\n              <td>").concat(note, "</td>\n              <td>").concat(transfer_date, "</td>\n              <td><a class=\"js-toggle-income btn btn-primary btn-sm\" href=\"javascript:void(0);\" data-income-id=\"").concat(income_id, "\">pr\xEDjem</a></td>\n            </tr>\n            <tr class=\"income-row bg-light\" style=\"display: none;\">\n              <td id=\"income-").concat(income_id, "\" colspan=\"11\"></td>\n            </tr>\n          ");
        htmlResults += row;
      }

      $("#personTransferFilterTableResults").html(htmlResults);
      PersonTransfersFilter.toggleIncome();
    }
  },
  toggleIncome: function toggleIncome() {
    $(document).off("click", ".js-toggle-income").on("click", ".js-toggle-income", function () {
      Help.showPreloader();
      var income_id = parseInt($(this).attr("data-income-id"));
      var $transferRow = $(this).closest(".transfer-row");
      $transferRow.toggleClass("bg-light").next(".income-row").slideToggle();

      if ($transferRow.next(".income-row").find(".income-list").length) {
        Help.hidePreloader();
        return;
      }
      /***
       * GET DATA FROM SERVER
       */


      $.getJSON("/dobrodinec/prevody-filter-zobraz-prijem", {
        income_id: income_id
      }, function (data) {
        if (data.income.length) {
          PersonTransfersFilter.populateIncome(data.income);
        } else {
          alert("Nič som nenašiel.");
        }

        Help.hidePreloader();
      });
    });
  },
  populateIncome: function populateIncome(income) {
    if (income) {
      var htmlResults = "<ul class='income-list'>";
      var income_id;

      for (var i = 0; i < income.length; i++) {
        income_id = income[i].id;
        var sum = Help.beautifyDecimal(income[i].sum);
        var username = income[i].username;
        var bank_account_name = income[i].bank_account_name;
        var number = income[i].number;
        var package_number = income[i].package_number;
        var invoice = income[i].invoice;
        var note = income[i].note;
        var accounting_date = Help.beautifyDate(income[i].accounting_date);
        var row = "\n              <li>Nahrala: ".concat(username, ", bankov\xFD \xFA\u010Det: ").concat(bank_account_name, ", <strong>").concat(sum, " &euro;</strong>, \u010D\xEDslo: ").concat(number, ", bal\xEDk: ").concat(package_number, ", fakt\xFAra: ").concat(invoice, ", <span class=\"text-secondary\">").concat(accounting_date, "</span> ").concat(note, "</li>\n          ");
        htmlResults += row;
      }

      htmlResults += "</ul>";
      $("#income-" + income_id + "").html(htmlResults);
    }
  }
};
$(document).ready(function () {
  if ($("#personTransferFilterTable").length) {
    $(document).off("click", "#initPersonTransfersFilter").on("click", "#initPersonTransfersFilter", function () {
      PersonTransfersFilter.filterPersonTransfers();
    });
  }
});
