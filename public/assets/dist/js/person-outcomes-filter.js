"use strict";

var PersonOutcomesFilter = {
  emptySearchResults: function emptySearchResults() {
    $("#personOutcomesFilterTabulator").empty();
  },
  filterPersonOutcomes: function filterPersonOutcomes() {
    Help.showPreloader();
    PersonOutcomesFilter.emptySearchResults();
    var person_id = $("#person_id").val();
    var sum_from = $("#sum_from").val();
    var sum_to = $("#sum_to").val();
    var goal = $("#goal").val();
    var outcome_date_from = $("#outcome_date_from").val();
    var outcome_date_to = $("#outcome_date_to").val();
    /***
     * VALIDATE IF SOME PARAMETER FILLED
     */

    if (person_id == 0 && sum_from.length == 0 && sum_to.length == 0 && goal == 0 && outcome_date_from.length == 0 && outcome_date_to.length == 0) {
      alert("Zadajte aspoň jeden parameter do vyhľadávania.");
      Help.hidePreloader();
      return;
    }
    /***
     * GET DATA FROM SERVER
     */


    $.getJSON("/dobrodinec/vydavky-filter", {
      person_id: person_id,
      sum_from: sum_from,
      sum_to: sum_to,
      goal: goal,
      outcome_date_from: outcome_date_from,
      outcome_date_to: outcome_date_to
    }, function (data) {
      if (data.outcomes.length) {
        $("#totalCount").text(data.outcomes.length);
        var table = new Tabulator("#personOutcomesFilterTabulator", {
          layout: "fitColumns",
          pagination: "local",
          paginationSize: 20,
          paginationSizeSelector: [10, 20, 50, 100],
          data: data.outcomes,
          //assign data to table
          columns: [{
            title: "ID",
            field: "id",
            sorter: "number",
            width: 60
          }, {
            title: "dátum",
            field: "created_at",
            sorter: "date",
            formatter: function formatter(cell, formatterParams) {
              var value = cell.getValue();
              var outcome_date = Help.beautifyDate(value);
              return outcome_date;
            }
          }, {
            title: "meno",
            field: "name1",
            sorter: "string"
          }, {
            title: "suma",
            field: "sum",
            sorter: "number",
            formatter: function formatter(cell, formatterParams) {
              var value = cell.getValue();
              var sum = Help.beautifyDecimal(value);
              sum += " &euro;";
              return sum;
            }
          }, {
            title: "účel",
            field: "goal",
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
  if ($("#personOutcomesFilterTabulator").length) {
    $(document).off("click", "#initPersonOutcomesFilter").on("click", "#initPersonOutcomesFilter", function () {
      PersonOutcomesFilter.filterPersonOutcomes();
    });
  }
});
