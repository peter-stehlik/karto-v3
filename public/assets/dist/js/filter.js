"use strict";

var Filter = {
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
        Filter.populateSearchedPeople(data.people);
      } else {
        alert("Nič som nenašiel.");
      }

      Help.hidePreloader();
    });
  },
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
  if ($("#filterTable").length) {
    $(document).on("click", "#initFilter", function () {
      Filter.filterPeople();
    });
  }
});
