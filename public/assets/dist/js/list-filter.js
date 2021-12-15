"use strict";

var ListFilter = {
  emptySearchResults: function emptySearchResults() {
    $("#listFilterTabulator").empty();
  },
  filterList: function filterList() {
    Help.showPreloader();
    ListFilter.emptySearchResults();
    var periodical_publication_ids = $("#periodical_publication_id").val();
    /***
     * VALIDATE IF SOME PARAMETER FILLED
     */

    if (periodical_publication_ids.length == 0) {
      alert("Zadajte aspoň jeden parameter do vyhľadávania.");
      Help.hidePreloader();
      return;
    }
    /***
     * GET DATA FROM SERVER
     */


    $.getJSON("/vydavatelstvo/zoznam-filter", {
      periodical_publication_ids: periodical_publication_ids
    }, function (data) {
      if (data.list.length) {
        $("#totalCount").text(data.list.length);
        var table = new Tabulator("#listFilterTabulator", {
          layout: "fitColumns",
          pagination: "local",
          paginationSize: 20,
          paginationSizeSelector: [10, 20, 50, 100],
          data: data.list,
          //assign data to table
          columns: [{
            title: "ID",
            field: "person_id",
            sorter: "number",
            width: 60
          }, {
            title: "titul",
            field: "title",
            sorter: "string",
            visible: false
          }, {
            title: "meno",
            field: "name1",
            sorter: "string",
            formatter: function formatter(cell, formatterParams) {
              var value = cell.getValue();
              var id = cell.getRow().getCells()[0].getValue();
              var titul = cell.getRow().getCells()[1].getValue();

              if (titul === null) {
                titul = "";
              }

              return "<a href='/dobrodinec/" + id + "/ucty' target='_blank'>" + titul + " " + value + "</a>";
            }
          }, {
            title: "adresa",
            field: "address1",
            sorter: "string"
          }, {
            title: "mesto",
            field: "city",
            sorter: "string"
          }, {
            title: "PSČ",
            field: "zip_code",
            sorter: "string"
          }, {
            title: "publikácia",
            field: "name",
            sorter: "string"
          }, {
            title: "ks",
            field: "count",
            sorter: "number",
            width: 60
          }, {
            title: "platné od",
            field: "valid_from",
            sorter: "date",
            formatter: function formatter(cell, formatterParams) {
              var value = cell.getValue();
              var outcome_date = Help.beautifyDate(value);
              return outcome_date;
            }
          }, {
            title: "kredit",
            field: "credit",
            sorter: "number",
            formatter: function formatter(cell, formatterParams) {
              var value = cell.getValue();
              value = Help.beautifyDecimal(value) + " &euro;";
              return value;
            }
          }, {
            title: "platné do",
            field: "valid_to",
            sorter: "date",
            formatter: function formatter(cell, formatterParams) {
              var value = cell.getValue();
              var outcome_date = Help.beautifyDate(value);
              return outcome_date;
            }
          }, {
            title: "poznámka",
            field: "note",
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
  if ($("#listFilterTabulator").length) {
    $(document).off("click", "#initListFilter").on("click", "#initListFilter", function () {
      ListFilter.filterList();
    });
  }
});
