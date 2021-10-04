"use strict";

/**
 * search for person
 * similar to income search
 * but adapted more universally
 * 
 */
var PeopleSearch = {
  /*
  *
  *  AUTOCOMPLETE SEARCH FOR PERSON FROM DATABASE:
  *  LIST FOUND RESULTS.
  *
  */
  initSearch: function initSearch() {
    var search_name = $("#search_name").val();
    var search_zip_code = $("#search_zip_code").val();
    var search_address = $("#search_address").val();
    var search_city = $("#search_city").val();
    search_zip_code = Help.beautifyZipCode(search_zip_code);
    Help.hidePreloader();

    if (search_name.length == 0 && search_zip_code.length == 0 && search_address.length == 0 && search_city.length == 0) {
      return;
    }

    Help.showPreloader();
    $.getJSON("/kartoteka/prijem/autocomplete", {
      search_name: search_name,
      search_zip_code: search_zip_code,
      search_address: search_address,
      search_city: search_city
    }, function (data) {
      if (data.people) {
        PeopleSearch.populateSearchedPeople(data.people);
      } else {
        alert("Nič som nenašiel. Skontrolujte, čo vyhľadávate. Hlavne v žiadnom prípade nepíšte programátorovi ;-)");
      }

      Help.hidePreloader();
    });
  },

  /*
  *
  *  HELPER:
  *  SIMPLY HIDE SEARCH RESULTS
  *
  */
  clearSearchResults: function clearSearchResults() {
    $(".people-search-results").hide();
    $("#searchBox").hide();
  },

  /*
  *
  *  HELPER:
  *  DISPLAY ALL PEOPLE FOUND IN DATABASE IN HTML TABLE
  *
  */
  populateSearchedPeople: function populateSearchedPeople(people) {
    var html = "";

    for (var i = 0; i < people.length; i++) {
      var personHtml = "\n\t\t\t\t\t<tr>\n\t\t\t\t\t\t<td>".concat(people[i].id, "</td>\n\t\t\t\t\t\t<td>").concat(people[i].name1, "</td>\n\t\t\t\t\t\t<td>").concat(people[i].address, "</td>\n\t\t\t\t\t\t<td>").concat(people[i].city, "</td>\n\t\t\t\t\t\t<td>").concat(people[i].zip_code, "</td>\n\t\t\t  \t\t\t<td class=\"icn-td\">\n\t\t\t\t\t\t  \t<a class=\"populate-chosen-person btn btn-sm btn-info\" href=\"javascript:void(0);\" title=\"pou\u017Ei\u0165\" data-person-id=\"").concat(people[i].id, "\" data-person-name=\"").concat(people[i].name1, "\">\n\t\t\t\t\t\t\t\tpou\u017Ei\u0165\n\t\t\t\t\t\t\t</a>\n\t\t\t\t\t\t</td>\n\t\t\t\t\t</tr>\n\t\t\t\t");
      html += personHtml;
    }

    $(".people-search-results").show();
    $(".preloader").hide();
    $("#peopleSearchResults").html(html);
  },

  /*
  *
  *  HELPER:
  *  FILL THE PERSON INTO INCOME CHOSEN FROM THE SEARCH LIST
  *
  */
  populateChosenPerson: function populateChosenPerson(userId, name) {
    $("#for_person_id").val(userId);
    $("#name1").val(name);
    PeopleSearch.clearSearchResults();
  }
}; //////////
// INIT
//////////

/* search */

var initSearchFn = debounce(function () {
  PeopleSearch.initSearch();
}, 400);
$(document).on("input", "#search_name, #search_address, #search_zip_code, #search_city", initSearchFn); ///////////////////////

/* fill chosen person into the income form from the search list */

$(document).on("click", ".populate-chosen-person", function () {
  var userId = $(this).attr("data-person-id");
  var name = $(this).attr("data-person-name");
  PeopleSearch.populateChosenPerson(userId, name);
}); ///////////////////////
