"use strict";

var PersonCorrectionsFilter = {
  emptySearchResults: function emptySearchResults() {
    $("#personCorrectionsFilterTabulator").empty();
  },
  filterPersonCorrections: function filterPersonCorrections() {
    Help.showPreloader();
    PersonCorrectionsFilter.emptySearchResults();
    var person_id = $("#person_id").val();
    var user_id = $("#user_id").val();
    var sum_from = $("#sum_from").val();
    var sum_to = $("#sum_to").val();
    var from_periodical_id = $("#from_periodical_id").val();
    var from_nonperiodical_id = $("#from_nonperiodical_id").val();
    var for_periodical_id = $("#for_periodical_id").val();
    var for_nonperiodical_id = $("#for_nonperiodical_id").val();
    var correction_date_from = $("#correction_date_from").val();
    var correction_date_to = $("#correction_date_to").val();
    /***
     * VALIDATE IF SOME PARAMETER FILLED
     */

    if (person_id == 0 && sum_from.length == 0 && sum_to.length == 0 && from_periodical_id == 0 && from_nonperiodical_id == 0 && for_periodical_id == 0 && for_nonperiodical_id == 0 && correction_date_from.length == 0 && correction_date_to.length == 0) {
      alert("Zadajte aspoň jeden parameter do vyhľadávania.");
      Help.hidePreloader();
      return;
    }
    /***
     * GET DATA FROM SERVER
     */


    $.getJSON("/dobrodinec/opravy-filter", {
      person_id: person_id,
      sum_from: sum_from,
      sum_to: sum_to,
      from_periodical_id: from_periodical_id,
      from_nonperiodical_id: from_nonperiodical_id,
      for_periodical_id: for_periodical_id,
      for_nonperiodical_id: for_nonperiodical_id,
      correction_date_from: correction_date_from,
      correction_date_to: correction_date_to,
      user_id: user_id
    }, function (data) {
      if (data.corrections.length) {
        var table = new Tabulator("#personCorrectionsFilterTabulator", {
          layout: "fitColumns",
          pagination: "local",
          paginationSize: 20,
          paginationSizeSelector: [10, 20, 50, 100],
          data: data.corrections,
          //assign data to table
          columns: [{
            title: "ID",
            field: "correction_id",
            sorter: "number",
            width: 60
          }, {
            title: "nahral(a)",
            field: "username",
            sorter: "string"
          }, {
            title: "dátum opravy",
            field: "correction_date",
            sorter: "date",
            formatter: function formatter(cell, formatterParams) {
              var value = cell.getValue();
              var correction_date = Help.beautifyDate(value);
              return correction_date;
            }
          }, {
            title: "suma",
            field: "correction_sum",
            sorter: "number",
            formatter: function formatter(cell, formatterParams) {
              var value = cell.getValue();
              var correction_sum = Help.beautifyDecimal(value);
              correction_sum += " &euro;";
              return correction_sum;
            }
          }, {
            title: "meno od",
            field: "from_person_id_name1",
            sorter: "string"
          }, {
            title: "mesto od",
            field: "from_person_id_city",
            sorter: "string",
            visible: false
          }, {
            title: "meno pre",
            field: "for_person_id_name1",
            sorter: "string"
          }, {
            title: "mesto do",
            field: "for_person_id_city",
            sorter: "string",
            visible: false
          }, {
            title: "periodikum od",
            field: "from_periodical_publications_name",
            sorter: "string",
            visible: false
          }, {
            title: "neperiodikum od",
            field: "from_nonperiodical_publications_name",
            sorter: "string",
            visible: false
          }, {
            title: "účel od",
            field: "transfer_from",
            sorter: "string",
            formatter: function formatter(cell, formatterParams) {
              var pp_from = cell.getRow().getCells()[8].getValue();
              var np_from = cell.getRow().getCells()[9].getValue();
              var transfer_from = pp_from ? pp_from : np_from;
              return transfer_from;
            }
          }, {
            title: "periodikum do",
            field: "for_periodical_publications_name",
            sorter: "string",
            visible: false
          }, {
            title: "neperiodikum do",
            field: "for_nonperiodical_publications_name",
            sorter: "string",
            visible: false
          }, {
            title: "účel pre",
            field: "transfer_for",
            sorter: "string",
            formatter: function formatter(cell, formatterParams) {
              var pp_for = cell.getRow().getCells()[11].getValue();
              var np_for = cell.getRow().getCells()[12].getValue();
              var transfer_for = pp_for ? pp_for : np_for;
              return transfer_for;
            }
          }, {
            title: "poznámka",
            field: "correction_note",
            sorter: "string"
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
      } else {
        alert("Nič som nenašiel.");
      }

      Help.hidePreloader();
    });
  }
};
$(document).ready(function () {
  if ($("#personCorrectionsFilterTabulator").length) {
    $(document).off("click", "#initPersonCorrectionsFilter").on("click", "#initPersonCorrectionsFilter", function () {
      PersonCorrectionsFilter.filterPersonCorrections();
    });
  }
});
