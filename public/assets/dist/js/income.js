"use strict";

var Income = {
  /*
  *
  *  STORE TEMPORARILY INCOME CHARACTERS:
  *		- package_number
  *		- income_date
  *		- number
  *		- bank_account
  *  INTO LOCAL STORAGE.
  *  PREPOPULATED FOR NEXT INCOME, BUT ONLY AT THE SAME DAY.
  *
  */
  storeIncomeChars: function storeIncomeChars() {
    // date to compare, if local storage contains active or old data
    var today = new Date().toJSON().slice(0, 10).replace(/-/g, '/');
    var dateToCompare = localStorage.getItem('dateToCompare');

    if (!dateToCompare) {
      dateToCompare = today;
    } // prepopulate if active


    if (dateToCompare == today) {
      $("#search_name").val(localStorage.getItem('searchName'));
      $("#search_zip_code").val(localStorage.getItem('searchZipCode'));
      $("#search_address").val(localStorage.getItem('searchAddress'));
      $("#search_city").val(localStorage.getItem('searchCity'));
      $("#person_id").val(localStorage.getItem('person_id'));
      $("#name1").val(localStorage.getItem('name1'));
      $("#income_sum").val(localStorage.getItem('income_sum'));
      $("#package_number").val(localStorage.getItem('packageNumber'));
      var number = localStorage.getItem('number');
      $("#number").val(++number);
      $("#bank_account_id").val(localStorage.getItem('bankAccount'));
      var incomeDate = localStorage.getItem('incomeDate');

      if (incomeDate) {
        $("#income_date").val(incomeDate);
      }

      if (localStorage.hasOwnProperty('searchName') || localStorage.hasOwnProperty('searchZipCode') || localStorage.hasOwnProperty('searchAddress') || localStorage.hasOwnProperty('searchCity')) {
        Income.initSearch();
      }
    } // save new val


    var saveNewValOnInput = function saveNewValOnInput() {
      localStorage.setItem('dateToCompare', today);
      localStorage.setItem('searchName', $("#search_name").val());
      localStorage.setItem('searchZipCode', $("#search_zip_code").val());
      localStorage.setItem('searchAddress', $("#search_address").val());
      localStorage.setItem('searchCity', $("#search_city").val());
      localStorage.setItem('person_id', $("#person_id").val());
      localStorage.setItem('name1', $("#name1").val());
      localStorage.setItem('income_sum', $("#income_sum").val());
      localStorage.setItem('bankAccount', $("#bank_account_id").val());
      localStorage.setItem('packageNumber', $("#package_number").val());
      localStorage.setItem('incomeDate', $("#income_date").val());
      localStorage.setItem('number', $("#number").val());
    };

    var saveNewValOnSubmit = function saveNewValOnSubmit() {
      localStorage.setItem('dateToCompare', today);
      localStorage.setItem('searchName', "");
      localStorage.setItem('searchZipCode', "");
      localStorage.setItem('searchAddress', "");
      localStorage.setItem('searchCity', "");
      localStorage.setItem('person_id', "");
      localStorage.setItem('name1', "");
      localStorage.setItem('income_sum', "");
      localStorage.setItem('bankAccount', $("#bank_account_id").val());
      localStorage.setItem('packageNumber', $("#package_number").val());
      localStorage.setItem('incomeDate', $("#income_date").val());
      localStorage.setItem('number', $("#number").val());
    };

    $("#incomeForm").submit(saveNewValOnSubmit);
    $(document).on("input", "#search_name, #search_zip_code, #search_address, #search_city, #person_id, #name1, #income_sum, #income_date, #package_number, #number", function () {
      saveNewValOnInput();
    });
  },

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
    Income.clearSearchResults();
    Help.hidePreloader();
    Income.hideAddNewPersonOnIncome();

    if (search_name.length == 0 && search_zip_code.length == 0 && search_address.length == 0 && search_city.length == 0) {
      // alert("Zadajte parameter do vyhľadávania.");
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
        Income.populateSearchedPeople(data.people);
      } else {
        var r = confirm("Nič som nenašiel. Chcete vytvoriť nového používateľa?");

        if (r == true) {
          Income.clearSearchResults();
          Help.hidePreloader();
          Income.showAddNewPersonOnIncome();
        }
      }
    });
  },

  /*
  *
  *  HELPER:
  *  SIMPLY HIDE SEARCH RESULTS
  *
  */
  clearSearchResults: function clearSearchResults() {
    $(".income-search-results").hide();
  },

  /*
  *
  *  HELPER:
  *  SIMPLY HIDE SEARCH INPUTS
  *
  */
  toggleSearchInputs: function toggleSearchInputs() {
    $(".js-search-inputs").slideToggle();
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
      var personHtml = "\n\t\t\t\t\t<tr>\n\t\t\t\t\t\t<td>".concat(people[i].id, "</td>\n\t\t\t\t\t\t<td>").concat(people[i].name1, "</td>\n\t\t\t\t\t\t<td>").concat(people[i].address === null ? '' : people[i].address, "</td>\n\t\t\t\t\t\t<td>").concat(people[i].city, "</td>\n\t\t\t\t\t\t<td>").concat(people[i].zip_code, "</td>\n\t\t\t  \t\t\t<td class=\"icn-td\"><a href=\"javascript:void(0);\" class=\"populate-chosen-person\" title=\"Nahra\u0165 pr\xEDjem tejto osobe\" data-person-id=\"").concat(people[i].id, "\" data-person-name=\"").concat(people[i].name1, "\">\n\t\t\t\t\t\t\t<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-arrow-bar-up text-success\" viewBox=\"0 0 16 16\">\n\t\t\t\t\t\t\t\t<path fill-rule=\"evenodd\" d=\"M8 10a.5.5 0 0 0 .5-.5V3.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 3.707V9.5a.5.5 0 0 0 .5.5zm-7 2.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5z\"/>\n\t\t\t\t\t\t\t</svg> \n\t\t\t\t\t\t</a></td>\n\t\t\t\t\t\t<td class=\"icn-td\"><a href=\"javascript:void(0);\" class=\"view js-add-to-print-row\" data-person-id=\"").concat(people[i].id, "\" data-person-name=\"").concat(people[i].name1, "\" title=\"Prida\u0165 do zoznamu na tla\u010D\">\n\t\t\t\t\t\t\t<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-printer-fill\" viewBox=\"0 0 16 16\">\n\t\t\t\t\t\t\t\t<path d=\"M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z\"/>\n\t\t\t\t\t\t\t\t<path d=\"M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z\"/>\n\t\t\t\t\t\t\t</svg>\n\t\t\t\t\t\t</a></td>\n\t\t\t\t\t\t<td class=\"icn-td\"><a href=\"/dobrodinec/").concat(people[i].id, "/ucty\" class=\"edit\" title=\"Pozrie\u0165 detail\">\n\t\t\t\t\t\t\t<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-person-fill text-info\" viewBox=\"0 0 16 16\">\n\t\t\t\t\t\t\t\t<path d=\"M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z\"/>\n\t\t\t\t\t\t\t</svg>\n\t\t\t\t\t\t</a></td>\n\t\t\t\t\t\t<td class=\"icn-td\"><a href=\"javascript:void(0);\" class=\"income-delete-user\" data-person-id=\"").concat(people[i].id, "\" title=\"Vymaza\u0165\">\n\t\t\t\t\t\t\t<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-trash text-danger\" viewBox=\"0 0 16 16\">\n\t\t\t\t\t\t\t\t<path\n\t\t\t\t\t\t\t\t\td=\"M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z\" />\n\t\t\t\t\t\t\t\t<path fill-rule=\"evenodd\"\n\t\t\t\t\t\t\t\t\td=\"M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z\" />\n\t\t\t\t\t\t\t</svg>\n\t\t\t\t\t\t</a></td>\n\t\t\t\t\t</tr>\n\t\t\t\t");
      html += personHtml;
    }

    $(".income-search-results").show();
    $(".preloader").hide();
    $("#incomeSearchResults").html(html);
    Income.enableBrowseList();
  },

  /*
  *
  *  HELPER:
  *  ADD ACTIVE CLASS TO THE FIRST RESULT
  *
  */
  enableBrowseList: function enableBrowseList() {
    var search_results = $("#incomeSearchResults tr");

    if (search_results.length) {
      search_results.first().addClass("is-active");
    }
  },

  /*
  *
  *  HELPER:
  *  REMOVE ACTIVE CLASS FROM THE RESULTS
  *
  */
  disableBrowserList: function disableBrowserList() {
    $("#incomeSearchResults tr").removeClass("is-active");
    $("html, body").animate({
      scrollTop: 0
    });
  },

  /*
  *
  *  ENABLE KEYBOARD SHORTCUTS
  *  	- Alt + l
  *	- arrow up/down
  *	- Enter
  *	- Escape 
  *
  */
  initKeyboardShortcuts: function initKeyboardShortcuts(e) {
    if (e.altKey && e.key == "l") {
      // alt+l
      Income.enableBrowseList();
    }

    var activeTr = $("#incomeSearchResults tr.is-active");

    if (e.key == "ArrowDown" || e.key == "ArrowUp") {
      if (activeTr.length) {
        switch (e.key) {
          case "ArrowDown":
            // sipka dole
            Income.initSearchList("down");
            break;

          case "ArrowUp":
            // sipka hore
            Income.initSearchList("up");
            break;
        }
      }
    }

    if (e.key == "Enter") {
      if (activeTr.length) {
        var userId = activeTr.find(".populate-chosen-person").attr("data-person-id");
        var name = activeTr.find(".populate-chosen-person").attr("data-person-name");
        Income.populateChosenPerson(userId, name);
        Income.disableBrowserList();
      }
    }

    if (e.key == "Escape") {
      if (activeTr.length) {
        Income.disableBrowserList();
      }
    }
  },

  /*
  *
  *  HELPER:
  *  move the search up or down depending on key pressed
  *
  */
  initSearchList: function initSearchList(direction) {
    var activeTr = $("#incomeSearchResults tr.is-active");

    switch (direction) {
      case "down":
        activeTr.next().addClass("is-active").siblings().removeClass("is-active");
        break;

      case "up":
        activeTr.prev().addClass("is-active").siblings().removeClass("is-active");
        break;
    }
  },

  /*
  *
  *  HELPER:
  *  FILL THE PERSON INTO INCOME CHOSEN FROM THE SEARCH LIST
  *
  */
  populateChosenPerson: function populateChosenPerson(userId, name) {
    $("#person_id").val(userId);
    $("#name1").val(name); // Income.saveIncomeDataToLocalStorage();

    $("#income_sum").focus();
    $("#transfers").show();
    Income.clearSearchResults();
    Income.toggleSearchInputs();
    Income.loadPersonCredits(userId);
  },

  /*
  *
  *  HELPER:
  *  CHECK, IF THE TOTAL SUM OF INCOME IS FILLED
  *
  */
  validateIncome: function validateIncome() {
    var validIncome = true;
    var total = parseFloat($("#income_sum").val());

    if (!total) {
      validIncome = false;
    }

    return validIncome;
  },

  /*
  *
  *  DELETE PERSON DIRECTLY FROM THE SEARCH LIST
  *
  */
  deleteUser: function deleteUser(userId) {
    $.getJSON("/kartoteka/prijem/delete-person", {
      userId: userId
    }, function (data) {
      if (data.result) {
        $(".income-delete-user[data-person-id='" + userId + "']").closest("tr").remove();
        alert("Osoba je úspešne vymazaná.");
      }
    });
  },

  /*
  *
  *	HELPER:
  *   DISPLAY MODAL WINDOW WITH NEW PERSON FORM
  *
  */
  showAddNewPersonOnIncome: function showAddNewPersonOnIncome() {
    var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
      keyboard: false
    });
    myModal.show();
  },

  /*
  *
  *	HELPER:
  *   HIDE MODAL WINDOW WITH NEW PERSON FORM
  *
  */
  hideAddNewPersonOnIncome: function hideAddNewPersonOnIncome() {
    $('#myModal').removeClass("show").hide();
    $(".modal-backdrop").removeClass("show").remove();
    $("body").removeClass("modal-open");
  },

  /*
  *
  *   CREATE DYNAMICALLY NEW PERSON
  *	ADD HIM INTO THE DATABASE
  *
  */
  createNewUser: function createNewUser() {
    var category_id = $("#inc_category_id").val();
    var title = $("#inc_title").val();
    var name1 = $("#inc_name1").val();
    var name2 = $("#inc_name2").val();
    var address1 = $("#inc_address1").val();
    var address2 = $("#inc_address2").val();
    var organization = $("#inc_organization").val();
    var zip_code = $("#inc_zip_code").val();
    var city = $("#inc_city").val();
    var state = $("#inc_state").val();
    var email = $("#inc_email").val();
    var note = $("#inc_note").val();
    var tags = $("#inc_tags").val();
    $.getJSON("/kartoteka/prijem/create-new-person", {
      category_id: category_id,
      title: title,
      name1: name1,
      name2: name2,
      address1: address1,
      address2: address2,
      organization: organization,
      zip_code: zip_code,
      city: city,
      state: state,
      email: email,
      note: note,
      tags: tags
    }, function (data) {
      if (data.result == 1) {
        $("#create_user_dynamically input").val("");
        Income.hideAddNewPersonOnIncome();
        alert("Úspešne ste vytvorili užívateľa, môžete mu pridať zopár grošov.");
        Income.initSearch();
      }
    });
  },

  /*
  *
  *   ADD TO ALL TRANSFERS THE SAME DATE
  *	AS INCOME HAS
  *
  */
  populateAllGoalDatesByIncomeDate: function populateAllGoalDatesByIncomeDate() {
    if ($("#incomeForm").length) {
      var income_date = $("#income_date").val();
      $(".form-control[name*='transfer_date']").val(income_date);
    }
  },

  /*
  *
  *   LOAD CREDITS INFORMATION FOR CHOSEN PERSON
  *
  *
  */
  loadPersonCredits: function loadPersonCredits(personId) {
    $(".js-person-credits").empty();

    if (!personId) {
      return;
    }

    Help.showPreloader();
    $.getJSON("/kartoteka/prijem/load-person-credits", {
      personId: personId
    }, function (data) {
      if (data.result) {
        Help.hidePreloader();
      }

      var creditsHtml = "";

      if (data.peniaze_na_ceste) {
        var pnc = "<strong class=\"d-block mb-3\">Peniaze na ceste: ".concat(data.peniaze_na_ceste, " &euro;</strong>");
        creditsHtml += pnc;
      }

      if (data.periodical_credits) {
        for (var i = 0; i < data.periodical_credits.length; i++) {
          var credit = Help.beautifyDecimal(data.periodical_credits[i].credit);
          var pc = "<p class=\"mb-2 ".concat(credit < 0 ? 'text-danger' : '', "\">").concat(data.periodical_credits[i].name, ": ").concat(credit, " &euro;</p>");
          creditsHtml += pc;
        }
      }

      if (data.nonperiodical_credits) {
        for (var _i = 0; _i < data.nonperiodical_credits.length; _i++) {
          var _credit = Help.beautifyDecimal(data.nonperiodical_credits[_i].credit);

          var nc = "<p class=\"mb-2 ".concat(_credit < 0 ? 'text-danger' : '', "\">").concat(data.nonperiodical_credits[_i].name, ": ").concat(_credit, " &euro;</p>");
          creditsHtml += nc;
        }
      }

      $(".js-person-credits").show().html(creditsHtml);
    });
  }
}; //////////
// INIT
//////////

/* store to local storage */

if ($("#incomeForm").length) {
  Income.storeIncomeChars();
  $(document).on("keydown", function (e) {
    Income.initKeyboardShortcuts(e);
  });
} ///////////////////////

/* search */


var initSearchFn = debounce(function () {
  Income.initSearch();
}, 400);
$(document).on("input", "#search_name, #search_address, #search_zip_code, #search_city", initSearchFn); ///////////////////////

/* fill chosen person into the income form from the search list */

$(document).on("click", ".populate-chosen-person", function () {
  var userId = $(this).attr("data-person-id");
  var name = $(this).attr("data-person-name");
  Income.populateChosenPerson(userId, name);
}); ///////////////////////

/* very simple income validation */

$("#incomeForm").submit(function () {
  var valid = Income.validateIncome();

  if (!valid) {
    return false;
  }
}); ////////////////////////

/* delete user dynamically, directly from the search results */

$(document).on("click", ".income-delete-user", function () {
  var userId = $(this).attr("data-person-id");
  var r = confirm("Naozaj chcete túto osobu vymazať?");

  if (r == true) {
    Income.deleteUser(userId);
  }
}); ///////////////////////

/* create new person */

$("#create_user_dynamically").submit(function () {
  Income.createNewUser();
  return false;
}); //////////////////////

/* copy income date to all transfers */

Income.populateAllGoalDatesByIncomeDate(); // if income date changes, change all transfer dates, too

$(document).on("input", "#income_date", function () {
  Income.populateAllGoalDatesByIncomeDate();
}); //////////////////////

/* prefill transfer sums, if previous or total sum is set */

$(document).on("input", "#income_sum", function () {
  var sum = $(this).val();
  var $s1 = $("#s1");

  if (sum) {
    $("#transfer-1").show();
    $s1.val(sum);
  }
});
$(document).on("input", "#s1", function () {
  var total = parseInt($("#income_sum").val());
  var sum = parseInt($(this).val());
  var $s2 = $("#s2");

  if (sum) {
    $("#transfer-2").show();
    $s2.val(total - sum);
  }
});
$(document).on("input", "#s2", function () {
  var total = parseInt($("#income_sum").val());
  var sum1 = parseInt($("#s1").val());
  var sum2 = parseInt($(this).val());
  var $s3 = $("#s3");

  if (sum2) {
    $("#transfer-3").show();
    $s3.val(total - sum1 - sum2);
  }
});
$(document).on("input", "#s3", function () {
  var total = parseInt($("#income_sum").val());
  var sum1 = parseInt($("#s1").val());
  var sum2 = parseInt($("#s2").val());
  var sum3 = parseInt($(this).val());
  var $s4 = $("#s4");

  if (sum3) {
    $("#transfer-4").show();
    $s4.val(total - sum1 - sum2 - sum3);
  }
});
$(document).on("input", "#s4", function () {
  var total = parseInt($("#income_sum").val());
  var sum1 = parseInt($("#s1").val());
  var sum2 = parseInt($("#s2").val());
  var sum3 = parseInt($("#s3").val());
  var sum4 = parseInt($("#s4").val());
  var $s5 = $("#s5");

  if (sum4) {
    $("#transfer-5").show();
    $s5.val(total - sum1 - sum2 - sum3 - sum4);
  }
});
$(document).on("input", "#s5", function () {
  var total = parseInt($("#income_sum").val());
  var sum1 = parseInt($("#s1").val());
  var sum2 = parseInt($("#s2").val());
  var sum3 = parseInt($("#s3").val());
  var sum4 = parseInt($("#s4").val());
  var sum5 = parseInt($("#s5").val());
  var $s6 = $("#s6");

  if (sum5) {
    $("#transfer-6").show();
    $s6.val(total - sum1 - sum2 - sum3 - sum4 - sum5);
  }
}); ///////////////////////////////////////////

/* toggle search inputs */

$(document).on("click", ".js-toggle-search-inputs", function () {
  Income.toggleSearchInputs();
});
