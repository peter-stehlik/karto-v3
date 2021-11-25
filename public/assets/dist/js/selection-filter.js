"use strict";

var SelectionFilter = {
  emptySearchResults: function emptySearchResults() {
    $("#selectionFilterTabulator").empty();
  },
  filterList: function filterList() {
    Help.showPreloader();
    SelectionFilter.emptySearchResults();
    var date_from = $("#date_from").val();
    var date_to = $("#date_to").val();
    var transfer = $("#transfer").val();
    var category = $("#category").val();
    var category_excluded = $("#category_excluded").val();
    var periodical_publication_id = 0;
    var nonperiodical_publication_id = 0;

    if (transfer.startsWith("p")) {
      periodical_publication_id = transfer.substring(1);
    } else if (transfer.startsWith("n")) {
      nonperiodical_publication_id = transfer.substring(1);
    }
    /***
     * VALIDATE IF SOME PARAMETER FILLED
     */


    if (date_from.length == 0 && date_to.length == 0 && category == 0 && category_excluded == 0 && periodical_publication_id == 0 && nonperiodical_publication_id == 0) {
      alert("Zadajte aspoň jeden parameter do vyhľadávania.");
      Help.hidePreloader();
      return;
    }
    /***
     * GET DATA FROM SERVER
     */


    $.getJSON("/kancelaria/selekcie-filter", {
      date_from: date_from,
      date_to: date_to,
      category_id: category,
      category_excluded_id: category_excluded,
      periodical_publication_id: periodical_publication_id,
      nonperiodical_publication_id: nonperiodical_publication_id
    }, function (data) {
      if (data.selection.length) {
        var table = new Tabulator("#selectionFilterTabulator", {
          layout: "fitColumns",
          pagination: "local",
          paginationSize: 20,
          paginationSizeSelector: [10, 20, 50, 100],
          data: data.selection,
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
  if ($("#selectionFilterTabulator").length) {
    $(document).off("click", "#initSelectionFilter").on("click", "#initSelectionFilter", function () {
      SelectionFilter.filterList();
    });
  }
});
