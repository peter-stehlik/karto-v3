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
    var today = new Date().toJSON().slice(0, 10).replace(/-/g, '/'); ////////////////////
    // PACKAGE NUMBER
    ////////////////////

    var savedPackageNumber = localStorage.getItem('packageNumber');
    var savedPackageNumberDate = localStorage.getItem('packageNumberDate'); // prepopulate if active

    if (savedPackageNumberDate == today) {
      $("#package_number").val(savedPackageNumber);
    } // save new val


    $("#incomeForm").submit(function () {
      var packageNumber = $("#package_number").val();
      localStorage.setItem('packageNumberDate', today);
      localStorage.setItem('packageNumber', packageNumber);
    }); ////////////////////
    // INCOME DATE
    ////////////////////

    var savedIncomeDate = localStorage.getItem('incomeDate');
    var savedIncomeDateDate = localStorage.getItem('incomeDateDate'); // prepopulate if active

    if (savedIncomeDateDate == today) {
      $("#income_date").val(savedIncomeDate);
    } // save new val


    $("#incomeForm").submit(function () {
      var incomeDate = $("#income_date").val();
      localStorage.setItem('incomeDateDate', today);
      localStorage.setItem('incomeDate', incomeDate);
    }); ////////////////////
    // NUMBER
    ////////////////////

    var savedNumber = localStorage.getItem('number');
    var savedNumberDate = localStorage.getItem('numberDate'); // prepopulate if active

    if (savedNumberDate == today) {
      $("#number").val(++savedNumber);
    } // save new val


    $("#incomeForm").submit(function () {
      var number = $("#number").val();
      localStorage.setItem('numberDate', today);
      localStorage.setItem('number', number);
    }); ////////////////////
    // BANK ACCOUNT
    ////////////////////

    var savedBankAccount = localStorage.getItem('bankAccount');
    var savedBankAccountDate = localStorage.getItem('bankAccountDate'); // prepopulate if active

    if (savedBankAccountDate == today) {
      $("#bank_account_id").val(savedBankAccount);
    } // save new val


    $("#incomeForm").submit(function () {
      var bankAccount = $("#bank_account_id").val();
      localStorage.setItem('bankAccountDate', today);
      localStorage.setItem('bankAccount', bankAccount);
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
      alert("Zadajte parameter do vyhľadávania.");
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
  clearSearchResults: function clearSearchResults() {
    $(".income-search-results").hide();
  },
  populateSearchedPeople: function populateSearchedPeople(people) {
    var html = "";

    for (var i = 0; i < people.length; i++) {
      var personHtml = "\n\t\t\t\t\t<tr>\n\t\t\t\t\t\t<td>".concat(people[i].id, "</td>\n\t\t\t\t\t\t<td>").concat(people[i].name1, "</td>\n\t\t\t\t\t\t<td>").concat(people[i].address, "</td>\n\t\t\t\t\t\t<td>").concat(people[i].city, "</td>\n\t\t\t\t\t\t<td>").concat(people[i].zip_code, "</td>\n\t\t\t  \t\t\t<td class=\"icn-td\"><a href=\"javascript:void(0);\" class=\"populate-chosen-person\" title=\"Nahra\u0165 pr\xEDjem tejto osobe\" data-person-id=\"").concat(people[i].id, "\" data-person-name=\"").concat(people[i].name1, "\">\n\t\t\t\t\t\t\t<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-arrow-bar-up text-success\" viewBox=\"0 0 16 16\">\n\t\t\t\t\t\t\t\t<path fill-rule=\"evenodd\" d=\"M8 10a.5.5 0 0 0 .5-.5V3.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 3.707V9.5a.5.5 0 0 0 .5.5zm-7 2.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5z\"/>\n\t\t\t\t\t\t\t</svg> \n\t\t\t\t\t\t</a></td>\n\t\t\t\t\t\t<td class=\"icn-td\"><a href=\"/backend/people/print/").concat(people[i].id, "\" target=\"_blank\" class=\"view\" title=\"Tla\u010Di\u0165\">\n\t\t\t\t\t\t\t<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-printer-fill\" viewBox=\"0 0 16 16\">\n\t\t\t\t\t\t\t\t<path d=\"M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z\"/>\n\t\t\t\t\t\t\t\t<path d=\"M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z\"/>\n\t\t\t\t\t\t\t</svg>\n\t\t\t\t\t\t</a></td>\n\t\t\t\t\t\t<td class=\"icn-td\"><a href=\"/backend/customer/detail/").concat(people[i].id, "\" class=\"edit\" title=\"Pozrie\u0165 detail\">\n\t\t\t\t\t\t\t<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-person-fill text-info\" viewBox=\"0 0 16 16\">\n\t\t\t\t\t\t\t\t<path d=\"M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z\"/>\n\t\t\t\t\t\t\t</svg>\n\t\t\t\t\t\t</a></td>\n\t\t\t\t\t\t<td class=\"icn-td\"><a href=\"javascript:void(0);\" class=\"income-delete-user\" data-person-id=\"").concat(people[i].id, "\" title=\"Vymaza\u0165\">\n\t\t\t\t\t\t\t<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-trash text-danger\" viewBox=\"0 0 16 16\">\n\t\t\t\t\t\t\t\t<path\n\t\t\t\t\t\t\t\t\td=\"M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z\" />\n\t\t\t\t\t\t\t\t<path fill-rule=\"evenodd\"\n\t\t\t\t\t\t\t\t\td=\"M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z\" />\n\t\t\t\t\t\t\t</svg>\n\t\t\t\t\t\t</a></td>\n\t\t\t\t\t</tr>\n\t\t\t\t");
      html += personHtml;
    }

    $(".income-search-results").show();
    $(".preloader").hide();
    $("#incomeSearchResults").html(html);
    Income.enableBrowseList();
  },
  enableBrowseList: function enableBrowseList() {
    var search_results = $("#incomeSearchResults tr");

    if (search_results.length) {
      search_results.first().addClass("is-active");
    }
  },
  disableBrowserList: function disableBrowserList() {
    $("#incomeSearchResults tr").removeClass("is-active");
    $("html, body").animate({
      scrollTop: 0
    });
  },
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
  populateChosenPerson: function populateChosenPerson(userId, name) {
    $("#person_id").val(userId);
    $("#name1").val(name); // Income.saveIncomeDataToLocalStorage();

    $("#income_sum").focus();
  },
  validateIncome: function validateIncome() {
    var validIncome = true;
    var total = parseFloat($("#income_sum").val());

    if (!total) {
      validIncome = false;
    }

    return validIncome;
  },
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
  showAddNewPersonOnIncome: function showAddNewPersonOnIncome() {
    var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
      keyboard: false
    });
    myModal.show();
  },
  hideAddNewPersonOnIncome: function hideAddNewPersonOnIncome() {
    $("#myModal").hide();
  },
  createNewUser: function createNewUser() {
    var category_id = $("#inc_category_id").val();
    var title = $("#inc_title").val();
    var name1 = $("#inc_name1").val();
    var name2 = $("#inc_name2").val();
    var address1 = $("#inc_address1").val();
    var address2 = $("#inc_address2").val();
    var city = $("#inc_city").val();
    var zip_code = $("#inc_zip_code").val();
    var state = $("#inc_state").val();
    var phone = $("#inc_phone").val();
    var fax = $("#inc_fax").val();
    var bank_account = $("#inc_bank_account").val();
    var email = $("#inc_email").val();
    var note = $("#inc_note").val();
    var birthday = $("#inc_birthday").val();
    var anniversary = $("#inc_anniversary").val();
    $.getJSON("/backend/people/create-ajax", {
      category_id: category_id,
      title: title,
      name1: name1,
      name2: name2,
      address1: address1,
      address2: address2,
      city: city,
      zip_code: zip_code,
      state: state,
      phone: phone,
      fax: fax,
      bank_account: bank_account,
      email: email,
      note: note,
      birthday: birthday,
      anniversary: anniversary
    }, function (data) {
      if (data.result == 1) {
        $("#create_user_dynamically input").val("");
        Income.hideAddNewPersonOnIncome();
        alert("Úspešne ste vytvorili užívateľa, môžete mu pridať zopár grošov.");
        Income.initSearch();
      }
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
}
/* search */


var initSearchFn = debounce(function () {
  Income.initSearch();
}, 400);
$(document).on("input", "#search_name, #search_address, #search_zip_code, #search_city", initSearchFn);
$(document).on("click", ".populate-chosen-person", function () {
  var userId = $(this).attr("data-person-id");
  var name = $(this).attr("data-person-name");
  Income.populateChosenPerson(userId, name);
});
$("#incomeForm").submit(function () {
  var valid = Income.validateIncome();

  if (!valid) {
    return false;
  }
});
$(document).on("click", ".income-delete-user", function () {
  var userId = $(this).attr("data-person-id");
  var r = confirm("Naozaj chcete túto osobu vymazať?");

  if (r == true) {
    Income.deleteUser(userId);
  }
});
