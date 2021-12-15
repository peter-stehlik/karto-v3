"use strict";

var Help = {
  beautifyZipCode: function beautifyZipCode(zip_code) {
    var zip = zip_code.replace(/\s/g, ''); // remove whitespaces if any

    var zip_code_arr = zip.split('');
    var beautifiedZip = zip_code;

    if (zip_code_arr.length > 3) {
      zip_code_arr.splice(3, 0, ' ');
      beautifiedZip = zip_code_arr.join('');
    }

    return beautifiedZip;
  },
  beautifyDecimal: function beautifyDecimal(decimal) {
    var numArr = decimal.split(".");
    var num = numArr[0];

    if (numArr[1] != '00') {
      num = numArr.join(',');
    }

    return num;
  },
  beautifyDate: function beautifyDate(date) {
    var rawDate = new Date(date);
    var dd = String(rawDate.getDate()).padStart(2, '0');
    var mm = String(rawDate.getMonth() + 1).padStart(2, '0'); //January is 0!

    var yyyy = rawDate.getFullYear();
    var correction_date = dd + '.' + mm + '.' + yyyy;
    return correction_date;
  },
  getTodayDate: function getTodayDate() {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!

    var yyyy = today.getFullYear();
    today = dd + '.' + mm + '.' + yyyy;
    return today;
  },
  showPreloader: function showPreloader() {
    if ($(".preloader").length) {
      $(".preloader").show();
    }

    if ($(".total-count-wrap").length) {
      $(".total-count-wrap").hide();
    }
  },
  hidePreloader: function hidePreloader() {
    if ($(".preloader").length) {
      $(".preloader").hide();
    }

    if ($(".total-count-wrap").length) {
      $(".total-count-wrap").show();
    }
  }
};
