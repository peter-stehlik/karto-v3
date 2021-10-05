"use strict";

var PersonTransfersFilter = {
  emptySearchResults: function emptySearchResults() {
    $("#personIncomesFilterTabulator").empty();
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
        var table = new Tabulator("#personTransfersFilterTabulator", {
          layout: "fitColumns",
          pagination: "local",
          paginationSize: 20,
          paginationSizeSelector: [10, 20, 50, 100],
          data: data.transfers,
          //assign data to table
          rowFormatter: function rowFormatter(row) {
            var data = row.getData(); //get data object for row

            var transfer_id = data["transfer_id"];
            var html_id = "transfer-" + transfer_id;
            row.getElement().setAttribute("id", html_id);
          },
          columns: [{
            title: "ID",
            field: "transfer_id",
            sorter: "number",
            width: 60
          }, {
            title: "income_id",
            field: "income_id",
            sorter: "string",
            visible: false
          }, {
            title: "meno",
            field: "name1",
            sorter: "string"
          }, {
            title: "mesto",
            field: "city",
            sorter: "string"
          }, {
            title: "dátum prevodu",
            field: "transfer_date",
            sorter: "date",
            formatter: function formatter(cell, formatterParams) {
              var value = cell.getValue();
              var transfer_date = Help.beautifyDate(value);
              return transfer_date;
            }
          }, {
            title: "suma",
            field: "transfer_sum",
            sorter: "number",
            formatter: function formatter(cell, formatterParams) {
              var value = cell.getValue();
              var transfer_sum = Help.beautifyDecimal(value);
              transfer_sum += " &euro;";
              return transfer_sum;
            }
          }, {
            title: "periodikum",
            field: "pp_name",
            sorter: "string"
          }, {
            title: "neperiodikum",
            field: "np_name",
            sorter: "string"
          }, {
            title: "poznámka",
            field: "note",
            sorter: "string"
          }, {
            title: "príjem",
            field: "income",
            width: 300,
            formatter: function formatter(cell, formatterParams) {
              var transfer_id = cell.getRow().getCells()[0].getValue();
              var income_id = cell.getRow().getCells()[1].getValue();
              return "<a class='js-toggle-income btn btn-primary btn-sm' href='javascript:void(0);' data-transfer-id='" + transfer_id + "' data-income-id='" + income_id + "'>zobraziť</a>";
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
        PersonTransfersFilter.toggleIncome();
      } else {
        alert("Nič som nenašiel.");
      }

      Help.hidePreloader();
    });
  },

  /**
   * NOT USED, OLD WAY, REPLACED BY TABULATOR.JS
   */
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
        var row = "\n            <tr class=\"transfer-row\">\n              <td>".concat(transfer_id, "</td>\n              <td>").concat(transfer_sum, " &euro;</td>\n              <td>").concat(pp_name ? pp_name : '', "</td>\n              <td>").concat(np_name ? np_name : '', "</td>\n              <td>").concat(note, "</td>\n              <td>").concat(transfer_date, "</td>\n              <td><a class=\"js-toggle-income btn btn-primary btn-sm\" href=\"javascript:void(0);\" data-income-id=\"").concat(income_id, "\" data-transfer-id=\"").concat(transfer_id, "\">pr\xEDjem</a></td>\n            </tr>\n            <tr class=\"income-row bg-light\" style=\"display: none;\">\n              <td id=\"transfer-").concat(transfer_id, "\" colspan=\"11\"></td>\n            </tr>\n          ");
        htmlResults += row;
      }

      $("#personTransferFilterTableResults").html(htmlResults);
      PersonTransfersFilter.toggleIncome();
    }
  },
  toggleIncome: function toggleIncome() {
    $(document).off("click", ".js-toggle-income").on("click", ".js-toggle-income", function () {
      Help.showPreloader();
      var transfer_id = parseInt($(this).attr("data-transfer-id"));
      var income_id = parseInt($(this).attr("data-income-id")); // OLD WAY

      /*let $transferRow = $(this).closest(".transfer-row");
      $transferRow.toggleClass("bg-light").next(".income-row").slideToggle();
       if( $transferRow.next(".income-row").find(".income-list").length ){
        Help.hidePreloader();
         return;
      }*/

      /***
       * GET DATA FROM SERVER
       */

      $.getJSON("/dobrodinec/prevody-filter-zobraz-prijem", {
        transfer_id: transfer_id,
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
      var htmlResults = "<ul class='income-list' style='margin: 0; padding: 0;'>";
      var transfer_id;

      for (var i = 0; i < income.length; i++) {
        transfer_id = income[i].transfer_id;
        var sum = Help.beautifyDecimal(income[i].sum);
        var username = income[i].username;
        var bank_account_name = income[i].bank_account_name;
        var number = income[i].number;
        var package_number = income[i].package_number;
        var invoice = income[i].invoice;
        var note = income[i].note;
        var accounting_date = Help.beautifyDate(income[i].accounting_date);
        var row = "\n              <li>\n                Nahral(a): ".concat(username, " <br>\n                ").concat(bank_account_name, ", <strong>").concat(sum, " &euro;</strong> <br>\n                ").concat(number ? "\u010D\xEDslo: ".concat(number, "<br>") : "", "\n                ").concat(package_number ? "bal\xEDk: ".concat(package_number, "<br>") : "", "\n                ").concat(invoice ? "fakt\xFAra: ".concat(invoice, "<br>") : "", " \n                <span class=\"text-secondary\">").concat(accounting_date, "</span><br>\n                ").concat(note ? note : "", "\n              </li>\n          ");
        htmlResults += row;
      }

      htmlResults += "</ul>"; // OLD WAY $("#transfer-" + transfer_id + "").html(htmlResults);

      $(".tabulator-tableHolder").css("height", "auto");
      $("#transfer-" + transfer_id + " .tabulator-cell").css("height", "auto");
      $("#transfer-" + transfer_id + " .tabulator-cell[tabulator-field='income']").prepend(htmlResults);
      $("#transfer-" + transfer_id + " .tabulator-cell[tabulator-field='income']").find(".js-toggle-income").remove();
    }
  }
};
$(document).ready(function () {
  if ($("#personTransfersFilterTabulator").length) {
    $(document).off("click", "#initPersonTransfersFilter").on("click", "#initPersonTransfersFilter", function () {
      PersonTransfersFilter.filterPersonTransfers();
    });
  }
});
