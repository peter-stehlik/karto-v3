"use strict";

var PersonIncomesFilter = {
  emptySearchResults: function emptySearchResults() {
    $("#personIncomesFilterTabulator").empty();
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
      if (data.incomes.length) {
        /* OLD WAY REPLACED BY TABULAR.JS */
        // PersonIncomesFilter.populateSearchedPeople(data.incomes);
        var table = new Tabulator("#personIncomesFilterTabulator", {
          layout: "fitColumns",
          pagination: "local",
          paginationSize: 20,
          paginationSizeSelector: [10, 20, 50, 100],
          data: data.incomes,
          //assign data to table
          rowFormatter: function rowFormatter(row) {
            var data = row.getData(); //get data object for row

            var income_id = data["income_id"];
            var html_id = "income-" + income_id;
            row.getElement().setAttribute("id", html_id);
          },
          columns: [{
            title: "ID",
            field: "income_id",
            sorter: "number",
            width: 70
          }, {
            title: "meno",
            field: "name1",
            sorter: "string"
          }, {
            title: "mesto",
            field: "city",
            sorter: "string"
          }, {
            title: "dátum príjmu",
            field: "income_date",
            sorter: "date",
            formatter: function formatter(cell, formatterParams) {
              var value = cell.getValue();
              var income_date = Help.beautifyDate(value);
              return income_date;
            }
          }, {
            title: "suma",
            field: "income_sum",
            sorter: "number",
            formatter: function formatter(cell, formatterParams) {
              var value = cell.getValue();
              var income_sum = Help.beautifyDecimal(value);
              income_sum += " &euro;";
              return income_sum;
            }
          }, {
            title: "bankový účet",
            field: "bank_name",
            sorter: "string"
          }, {
            title: "číslo",
            field: "number",
            sorter: "number",
            width: 70
          }, {
            title: "balík",
            field: "package_number",
            sorter: "number",
            width: 70
          }, {
            title: "účt. dátum",
            field: "accounting_date",
            sorter: "date",
            formatter: function formatter(cell, formatterParams) {
              var value = cell.getValue();
              var accounting_date = Help.beautifyDate(value);
              return accounting_date;
            }
          }, {
            title: "poznámka",
            field: "note",
            sorter: "string"
          }, {
            title: "nahral(a)",
            field: "username",
            sorter: "string"
          }, {
            title: "prevody (účely)",
            field: "transfers",
            width: 300,
            formatter: function formatter(cell, formatterParams) {
              var id = cell.getRow().getCells()[0].getValue();
              var income_sum = cell.getRow().getCells()[4].getValue();
              return "<a class='js-toggle-transfers btn btn-primary btn-sm' href='javascript:void(0);' data-income-sum='" + income_sum + "' data-income-id='" + id + "'>zobraziť</a>";
            }
          }],
          locale: "sk",
          langs: {
            "sk": {
              "pagination": {
                "first": "prvá",
                "first_title": "prvá strana",
                "last": "posledná",
                "last_title": "posledná strana",
                "prev": "predošlá",
                "prev_title": "predošlá strana",
                "next": "ďalšia",
                "next_title": "ďalšia strana",
                "all": "všetky",
                "page_size": "počet na stranu"
              }
            }
          }
        });
        PersonIncomesFilter.toggleTransfers();
      } else {
        alert("Nič som nenašiel.");
      }

      Help.hidePreloader();
    });
  },

  /**
   * OLD WAY, REPLACED BY TABULAR.JS
   */
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
        var row = "\n            <tr class=\"income-row\">\n              <td>".concat(income_id, "</td>\n              <td>").concat(username, "</td>\n              <td>").concat(income_sum, " &euro;</td>\n              <td>").concat(bank_name, "</td>\n              <td>").concat(number, "</td>\n              <td>").concat(package_number, "</td>\n              <td>").concat(invoice, "</td>\n              <td>").concat(accounting_date, "</td>\n              <td>").concat(note, "</td>\n              <td>").concat(income_date, "</td>\n              <td><a class=\"js-toggle-transfers btn btn-primary btn-sm\" href=\"javascript:void(0);\" data-income-id=\"").concat(income_id, "\">prevody</a></td>\n            </tr>\n            <tr class=\"transfers-row bg-light\" style=\"display: none;\">\n              <td id=\"income-").concat(income_id, "\" colspan=\"11\"></td>\n            </tr>\n          ");
        htmlResults += row;
      }

      $("#personIncomeFilterTableResults").html(htmlResults);
      PersonIncomesFilter.toggleTransfers();
    }
  },
  toggleTransfers: function toggleTransfers() {
    $(document).off("click", ".js-toggle-transfers").on("click", ".js-toggle-transfers", function () {
      Help.showPreloader();
      var income_id = parseInt($(this).attr("data-income-id"));
      var $incomeRow = $(this).closest(".income-row");
      $incomeRow.toggleClass("bg-light").next(".transfers-row").slideToggle();
      /* OLD WAY, LOAD DATA ONLY ONCE
      if( $incomeRow.next(".transfers-row").find(".transfers-list").length ){
        Help.hidePreloader();
         return;
      }*/

      /***
       * GET DATA FROM SERVER
       */

      $.getJSON("/dobrodinec/prijmy-filter-zobraz-prevody", {
        income_id: income_id
      }, function (data) {
        if (data.transfers.length) {
          PersonIncomesFilter.populateTransfers(data.transfers);
        } else {
          alert("Nič som nenašiel.");
        }

        Help.hidePreloader();
      });
    });
  },
  populateTransfers: function populateTransfers(transfers) {
    if (transfers) {
      var htmlResults = "<ul class='transfers-list' style='margin: 0; padding: 0;'>";
      var income_id;
      var transfer_sum = 0;

      for (var i = 0; i < transfers.length; i++) {
        income_id = transfers[i].income_id;
        var pp_name = transfers[i].pp_name;
        var np_name = transfers[i].np_name;
        var sum = Help.beautifyDecimal(transfers[i].sum);
        var note = transfers[i].note;
        var transfer_date = Help.beautifyDate(transfers[i].transfer_date);
        var goal = pp_name ? pp_name : np_name;
        var row = "\n              <li>".concat(goal, ": <strong>").concat(sum, " &euro;</strong>, <span class=\"text-secondary\">").concat(transfer_date, "</span> ").concat(note, "</li>\n          ");
        htmlResults += row;
        transfer_sum += parseFloat(transfers[i].sum);
      }

      htmlResults += "</ul>";
      var income_sum = parseFloat($("#income-" + income_id + " .tabulator-cell[tabulator-field='transfers']").find(".js-toggle-transfers").attr("data-income-sum"));
      var peniaze_na_ceste = income_sum - transfer_sum;

      if (peniaze_na_ceste) {
        htmlResults += "<span class='text-danger'>PENIAZE NA CESTE</span>";
      }

      $(".tabulator-tableHolder").css("height", "auto");
      $("#income-" + income_id + " .tabulator-cell").css("height", "auto");
      $("#income-" + income_id + " .tabulator-cell[tabulator-field='transfers']").prepend(htmlResults);
      $("#income-" + income_id + " .tabulator-cell[tabulator-field='transfers']").find(".js-toggle-transfers").remove();
    }
  }
};
$(document).ready(function () {
  if ($("#personIncomesFilterTabulator").length) {
    $(document).off("click", "#initPersonIncomesFilter").on("click", "#initPersonIncomesFilter", function () {
      PersonIncomesFilter.filterPersonIncomes();
    });
  }
});
