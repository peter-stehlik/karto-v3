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
  }
}; //////////
// INIT
//////////

Income.storeIncomeChars();
