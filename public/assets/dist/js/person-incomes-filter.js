"use strict";

var PersonIncomesFilter = {
  emptySearchResults: function emptySearchResults() {
    $("#personIncomeFilterTableResults").empty();
  },
  filterPersonIncomes: function filterPersonIncomes() {
    Help.showPreloader();
    PersonIncomesFilter.emptySearchResults();
    var person_id = $("#person_id").val();
    var user_id = $("#user_id").val();
    var sum_from = $("#sum_from").val();
    var sum_to = $("#sum_to").val();
    var bank_account_id = $("#bank_account_id").val();
    var number_from = $("#number_from").val();
    var number_to = $("#number_to").val();
    var package_number = $("#package_number").val();
    var invoice = $("#invoice").val();
    var accounting_date_from = $("#accounting_date_from").val();
    var accounting_date_to = $("#accounting_date_to").val();
    var income_date_from = $("#income_date_from").val();
    var income_date_to = $("#income_date_to").val();
    /***
     * VALIDATE IF SOME PARAMETER FILLED
     */

    if (person_id.length == 0 && user_id == 0 && sum_from.length == 0 && sum_to.length == 0 && bank_account_id == 0 && number_from.length == 0 && number_to.length == 0 && package_number.length == 0 && invoice.length == 0 && accounting_date_from.length == 0 && accounting_date_to.length == 0 && income_date_from.length == 0 && income_date_to.length == 0) {
      alert("Zadajte aspoň jeden parameter do vyhľadávania.");
      Help.hidePreloader();
      return;
    }
    /***
     * GET DATA FROM SERVER
     */


    $.getJSON("/dobrodinec/prijmy-filter", {
      person_id: person_id,
      user_id: user_id,
      sum_from: sum_from,
      sum_to: sum_to,
      bank_account_id: bank_account_id,
      number_from: number_from,
      number_to: number_to,
      package_number: package_number,
      invoice: invoice,
      accounting_date_from: accounting_date_from,
      accounting_date_to: accounting_date_to,
      income_date_from: income_date_from,
      income_date_to: income_date_to
    }, function (data) {
      if (data.incomes) {
        PersonIncomesFilter.populateSearchedPeople(data.incomes);
      } else {
        alert("Nič som nenašiel.");
      }

      Help.hidePreloader();
    });
  },
  populateSearchedPeople: function populateSearchedPeople(incomes) {
    if (incomes) {
      var htmlResults = "";

      for (var i = 0; i < incomes.length; i++) {
        var income_id = incomes[i].income_id;
        var username = incomes[i].username;
        var income_sum = Help.beautifyDecimal(incomes[i].income_sum);
        var bank_name = incomes[i].bank_name;
        var number = incomes[i].number;
        var package_number = incomes[i].package_number;
        var invoice = incomes[i].invoice;
        var accounting_date = Help.beautifyDate(incomes[i].accounting_date);
        var note = incomes[i].note;
        var income_date = Help.beautifyDate(incomes[i].income_date);
        var row = "\n            <tr class=\"income-row\">\n              <td>".concat(income_id, "</td>\n              <td>").concat(username, "</td>\n              <td>").concat(income_sum, " &euro;</td>\n              <td>").concat(bank_name, "</td>\n              <td>").concat(number, "</td>\n              <td>").concat(package_number, "</td>\n              <td>").concat(invoice, "</td>\n              <td>").concat(accounting_date, "</td>\n              <td>").concat(note, "</td>\n              <td>").concat(income_date, "</td>\n              <td><a class=\"js-toggle-transfers btn btn-primary btn-sm\" href=\"javascript:void(0);\" data-income-id=\"").concat(income_id, "\">prevody</a></td>\n            </tr>\n            <tr class=\"transfers-row bg-light\" style=\"display: none;\">\n              <td colspan=\"11\">prevody</td>\n            </tr>\n          ");
        htmlResults += row;
      }

      $("#personIncomeFilterTableResults").html(htmlResults);
      PersonIncomesFilter.toggleTransfers();
    }
  },
  toggleTransfers: function toggleTransfers() {
    $(document).on("click", ".js-toggle-transfers", function () {
      Help.showPreloader();
      var income_id = parseInt($(this).attr("data-income-id"));
      var $incomeRow = $(this).closest(".income-row");
      $incomeRow.toggleClass("bg-light").next(".transfers-row").slideToggle();
      /***
       * GET DATA FROM SERVER
       */

      $.getJSON("/dobrodinec/prijmy-filter-zobraz-prevody", {
        income_id: income_id
      }, function (data) {
        if (data.transfers) {
          console.log(data.transfers);
        } else {
          alert("Nič som nenašiel.");
        }

        Help.hidePreloader();
      });
    });
  }
};
$("document").ready(function () {
  if ($("#personIncomeFilterTable").length) {
    $(document).on("click", "#initPersonIncomesFilter", function () {
      PersonIncomesFilter.filterPersonIncomes();
    });
  }
});
