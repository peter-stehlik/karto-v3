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
    var niceDate = rawDate.toLocaleDateString('sk-SK', {
      timeZone: 'UTC'
    });
    return niceDate;
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
  },
  hidePreloader: function hidePreloader() {
    if ($(".preloader").length) {
      $(".preloader").hide();
    }
  }
};
