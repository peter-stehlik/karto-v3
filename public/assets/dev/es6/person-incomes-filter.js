let PersonIncomesFilter = {
    emptySearchResults: () => {
      $("#personIncomeFilterTableResults").empty();
    },
    filterPersonIncomes: () => {
      Help.showPreloader();
      PersonIncomesFilter.emptySearchResults();
  
      let person_id = $("#person_id").val();
      let user_id = $("#user_id").val();
      let sum_from = $("#sum_from").val();
      let sum_to = $("#sum_to").val();
      let bank_account_id = $("#bank_account_id").val();
      let number_from = $("#number_from").val();
      let number_to = $("#number_to").val();
      let package_number = $("#package_number").val();
      let invoice = $("#invoice").val();
      let accounting_date_from = $("#accounting_date_from").val();
      let accounting_date_to = $("#accounting_date_to").val();
      let income_date_from = $("#income_date_from").val();
      let income_date_to = $("#income_date_to").val();
  
      /***
       * VALIDATE IF SOME PARAMETER FILLED
       */
      if (
        person_id.length == 0 &&
        user_id == 0 &&
        sum_from.length == 0 &&
        sum_to.length == 0 &&
        bank_account_id == 0 &&
        number_from.length == 0 &&
        number_to.length == 0 &&
        package_number.length == 0 &&
        invoice.length == 0 &&
        accounting_date_from.length == 0 &&
        accounting_date_to.length == 0 &&
        income_date_from.length == 0 &&
        income_date_to.length == 0
      ) {
        alert("Zadajte aspoň jeden parameter do vyhľadávania.");
  
        Help.hidePreloader();
  
        return;
      }
  
      /***
       * GET DATA FROM SERVER
       */
      $.getJSON(
        "/dobrodinec/prijmy-filter",
        {
            person_id: person_id,
            user_id: user_id,
            sum_from: sum_from,
            sum_to: sum_to,
            bank_account_id: bank_account_id,
            number_from: number_from,
            number_to: number_to,
            package_number: package_number,
            invoice: invoice,
            accounting_date_from: accounting_date_from,
            accounting_date_to: accounting_date_to,
            income_date_from: income_date_from,
            income_date_to: income_date_to
        },
        function (data) {
          if (data.incomes.length) {
            PersonIncomesFilter.populateSearchedPeople(data.incomes);
          } else {
            alert("Nič som nenašiel.");
          }
  
          Help.hidePreloader();
        }
      );
    },
    populateSearchedPeople: incomes => {
      if (incomes) {
        let htmlResults = "";
  
        for (let i = 0; i < incomes.length; i++) {
          let income_id = incomes[i].income_id;
          let username = incomes[i].username;
          let income_sum = Help.beautifyDecimal(incomes[i].income_sum);
          let bank_name = incomes[i].bank_name;
          let number = incomes[i].number;
          let package_number = incomes[i].package_number;
          let invoice = incomes[i].invoice;
          let accounting_date = Help.beautifyDate(incomes[i].accounting_date);
          let note = incomes[i].note;
          let income_date = Help.beautifyDate(incomes[i].income_date);
  
          let row = `
            <tr class="income-row">
              <td>${income_id}</td>
              <td>${username}</td>
              <td>${income_sum} &euro;</td>
              <td>${bank_name}</td>
              <td>${number}</td>
              <td>${package_number}</td>
              <td>${invoice}</td>
              <td>${accounting_date}</td>
              <td>${note}</td>
              <td>${income_date}</td>
              <td><a class="js-toggle-transfers btn btn-primary btn-sm" href="javascript:void(0);" data-income-id="${income_id}">prevody</a></td>
            </tr>
            <tr class="transfers-row bg-light" style="display: none;">
              <td id="income-${income_id}" colspan="11"></td>
            </tr>
          `;
  
          htmlResults += row;
        }
  
        $("#personIncomeFilterTableResults").html(htmlResults);
        PersonIncomesFilter.toggleTransfers();
      }
    },
    toggleTransfers: () => {
      $(document).off("click", ".js-toggle-transfers").on("click", ".js-toggle-transfers", function(){
        Help.showPreloader();

        let income_id = parseInt($(this).attr("data-income-id"));
        let $incomeRow = $(this).closest(".income-row");
        $incomeRow.toggleClass("bg-light").next(".transfers-row").slideToggle();

        if( $incomeRow.next(".transfers-row").find(".transfers-list").length ){
          Help.hidePreloader();

          return;
        }

        /***
         * GET DATA FROM SERVER
         */
        $.getJSON(
          "/dobrodinec/prijmy-filter-zobraz-prevody",
          {
              income_id: income_id,
          },
          function (data) {
            if (data.transfers.length) {
              PersonIncomesFilter.populateTransfers(data.transfers);
            } else {
              alert("Nič som nenašiel.");
            }
    
            Help.hidePreloader();
          }
        );
      });
    },
    populateTransfers: transfers => {
      if (transfers) {
        let htmlResults = "<ul class='transfers-list'>";
        let income_id;
  
        for (let i = 0; i < transfers.length; i++) {
          income_id = transfers[i].income_id;
          let pp_name = transfers[i].pp_name;
          let np_name = transfers[i].np_name;
          let sum = Help.beautifyDecimal(transfers[i].sum);
          let note = transfers[i].note;
          let transfer_date = Help.beautifyDate(transfers[i].transfer_date);
          let goal = pp_name ? pp_name : np_name;

          let row = `
              <li>${goal}: <strong>${sum} &euro;</strong>, <span class="text-secondary">${transfer_date}</span> ${note}</li>
          `;
  
          htmlResults += row;
        }
        htmlResults += "</ul>";
  
        console.log(htmlResults);

        $("#income-" + income_id + "").html(htmlResults);
      }
    },
  };
  
  $(document).ready(function () {
    if ($("#personIncomeFilterTable").length) {
      $(document).off("click", "#initPersonIncomesFilter").on("click", "#initPersonIncomesFilter", function () {
        PersonIncomesFilter.filterPersonIncomes();
      });
    }
  });
  