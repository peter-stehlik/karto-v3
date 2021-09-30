"use strict";

var Filter = {
  /* NOT USED, OLD WAY */
  emptySearchResults: function emptySearchResults() {
    $("#filterResults").empty();
  },
  filterPeople: function filterPeople() {
    Help.showPreloader();
    Filter.emptySearchResults();
    var person_id = $("#id").val();
    var category_id = $("#category_id").val();
    var name1 = $("#name1").val();
    var address1 = $("#address1").val();
    var zip_code = $("#zip_code").val();
    var city = $("#city").val();
    var bin = $("#bin").val();
    zip_code = Help.beautifyZipCode(zip_code);
    /***
     * VALIDATE IF SOME PARAMETER FILLED
     */

    if (person_id.length == 0 && category_id == 0 && name1.length == 0 && address1.length == 0 && zip_code.length == 0 && city.length == 0 && bin == 0) {
      alert("Zadajte aspoň jeden parameter do vyhľadávania.");
      Help.hidePreloader();
      return;
    }
    /***
     * GET DATA FROM SERVER
     */


    $.getJSON("/osoba/filter", {
      person_id: person_id,
      category_id: category_id,
      name1: name1,
      address1: address1,
      zip_code: zip_code,
      city: city,
      bin: bin
    }, function (data) {
      if (data.people) {
        // Filter.populateSearchedPeople(data.people); OLD WAY TO DISPLAY AJAX RESULT
        var table = new Tabulator("#personFilterTabulator", {
          layout: "fitColumns",
          pagination: "local",
          paginationSize: 20,
          paginationSizeSelector: [10, 20, 50, 100],
          data: data.people,
          //assign data to table
          columns: [{
            title: "ID",
            field: "id",
            sorter: "number",
            width: 50
          }, {
            title: "titul",
            field: "title",
            sorter: "string",
            visible: false
          }, {
            title: "meno",
            field: "name1",
            sorter: "string",
            width: 250,
            formatter: function formatter(cell, formatterParams) {
              var value = cell.getValue();
              var id = cell.getRow().getCells()[0].getValue();
              var titul = cell.getRow().getCells()[1].getValue();
              return "<a href='/dobrodinec/" + id + "/ucty' target='_blank'>" + titul + " " + value + "</a>";
            }
          }, {
            title: "organizácia",
            field: "organization",
            sorter: "string"
          }, {
            title: "adresa",
            field: "address1",
            sorter: "string"
          }, {
            title: "PSČ",
            field: "zip_code",
            sorter: "string"
          }, {
            title: "mesto",
            field: "city",
            sorter: "string"
          }, {
            title: "štát",
            field: "state",
            sorter: "string"
          }, {
            title: "kategória",
            field: "category_name",
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
  },

  /**
   * OLD WAY HOW TO DISPLAY
   * AJAX RESULTS
   * REPLACED BY TABULATOR.JS PLUGIN
   */
  populateSearchedPeople: function populateSearchedPeople(people) {
    if (people) {
      var htmlResults = "";

      for (var i = 0; i < people.length; i++) {
        var id = people[i].id;
        var name1 = people[i].name1;
        var address1 = people[i].address1 + ", " + people[i].zip_code + " " + people[i].city;
        var note = people[i].note;
        var category = people[i].category_name;
        var row = "\n            <tr>\n              <td>".concat(id, "</td>\n              <td><a href=\"/dobrodinec/").concat(id, "/ucty\" target=\"_blank\">").concat(name1, "</a></td>\n              <td>").concat(address1, "</td>\n              <td>").concat(category, "</td>\n              <td>").concat(note, "</td>\n            </tr>\n          ");
        htmlResults += row;
      }

      $("#filterResults").html(htmlResults);
    }
  }
};
$("document").ready(function () {
  if ($("#personFilterTabulator").length) {
    $(document).on("click", "#initFilter", function () {
      Filter.filterPeople();
    });
  }
});
