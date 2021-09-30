let PersonTransfersFilter = {
    emptySearchResults: () => {
      $("#personTransferFilterTableResults").empty();
    },
    filterPersonTransfers: () => {
      Help.showPreloader();
      PersonTransfersFilter.emptySearchResults();
  
      let person_id = $("#person_id").val();
      let sum_from = $("#sum_from").val();
      let sum_to = $("#sum_to").val();
      let periodical_publication_id = $("#periodical_publication_id").val();
      let nonperiodical_publication_id = $("#nonperiodical_publication_id").val();
      let transfer_date_from = $("#transfer_date_from").val();
      let transfer_date_to = $("#transfer_date_to").val();
  
      /***
       * VALIDATE IF SOME PARAMETER FILLED
       */
      if (
        person_id == 0 &&
        sum_from.length == 0 &&
        sum_to.length == 0 &&
        periodical_publication_id == 0 &&
        nonperiodical_publication_id == 0 &&
        transfer_date_from.length == 0 &&
        transfer_date_to.length == 0
      ) {
        alert("Zadajte aspoň jeden parameter do vyhľadávania.");
  
        Help.hidePreloader();
  
        return;
      }
  
      /***
       * GET DATA FROM SERVER
       */
      $.getJSON(
        "/dobrodinec/prevody-filter",
        {
            person_id: person_id,
            sum_from: sum_from,
            sum_to: sum_to,
            periodical_publication_id: periodical_publication_id,
            nonperiodical_publication_id: nonperiodical_publication_id,
            transfer_date_from: transfer_date_from,
            transfer_date_to: transfer_date_to
        },
        function (data) {
          if (data.transfers.length) {
            PersonTransfersFilter.populateSearchedTransfers(data.transfers);

            let table = new Tabulator("#personTransfersFilterTabulator", {
              layout: "fitColumns",
              pagination: "local",
              paginationSize: 20,
              paginationSizeSelector: [10, 20, 50, 100],
              data: data.transfers, //assign data to table
              rowFormatter:function(row){
                let data = row.getData(); //get data object for row
                let transfer_id = data["transfer_id"];
                let html_id = "transfer-" + transfer_id;

                row.getElement().setAttribute("id", html_id);
              },
              columns: [
                {title:"ID", field:"transfer_id", sorter:"number", width: 60},
                {title:"income_id", field:"income_id", sorter:"string", visible:false},
                {title:"dátum prevodu", field:"transfer_date", sorter:"date", formatter: function(cell, formatterParams){
                  let value = cell.getValue();
                  let transfer_date = Help.beautifyDate(value);

                  return transfer_date;
                }},
                {title:"suma", field:"transfer_sum", sorter:"number", formatter: function(cell, formatterParams){
                  let value = cell.getValue();
                  let transfer_sum = Help.beautifyDecimal(value);

                  return transfer_sum + " &euro;";
                }},
                {title:"periodikum", field:"pp_name", sorter:"string"},
                {title:"neperiodikum", field:"np_name", sorter:"string"},
                {title:"poznámka", field:"note", sorter:"string"},
                {title:"príjem", field: "income", width: 300, formatter: function(cell, formatterParams){
                  let transfer_id = cell.getRow().getCells()[0].getValue();
                  let income_id = cell.getRow().getCells()[1].getValue();


                  return "<a class='js-toggle-income btn btn-primary btn-sm' href='javascript:void(0);' data-transfer-id='" + transfer_id + "' data-income-id='" + income_id + "'>zobraziť</a>";
                } },
              ],
              locale: "sk",
              langs: {
                "sk": {
                  "pagination":{
                    "first":"prvá",
                    "first_title":"prvá strana",
                    "last":"posledná",
                    "last_title":"posledná strana",
                    "prev":"predošlá",
                    "prev_title":"predošlá strana",
                    "next":"ďalšia",
                    "next_title":"ďalšia strana",
                    "all":"všetky",
                    "page_size": "počet na stranu",
                  },
                }
              },
            });

            PersonTransfersFilter.toggleIncome();
          } else {
            alert("Nič som nenašiel.");
          }
  
          Help.hidePreloader();
        }
      );
    },
    /**
     * NOT USED, OLD WAY, REPLACED BY TABULATOR.JS
     */
    populateSearchedTransfers: transfers => {
      if (transfers) {
        let htmlResults = "";
  
        for (let i = 0; i < transfers.length; i++) {
          let income_id = transfers[i].income_id;
          let transfer_id = transfers[i].transfer_id;
          let transfer_sum = Help.beautifyDecimal(transfers[i].transfer_sum);
          let pp_name = transfers[i].pp_name;
          let np_name = transfers[i].np_name;
          let transfer_date = Help.beautifyDate(transfers[i].transfer_date);
          let note = transfers[i].note;
  
          let row = `
            <tr class="transfer-row">
              <td>${transfer_id}</td>
              <td>${transfer_sum} &euro;</td>
              <td>${pp_name ? pp_name : ''}</td>
              <td>${np_name ? np_name : ''}</td>
              <td>${note}</td>
              <td>${transfer_date}</td>
              <td><a class="js-toggle-income btn btn-primary btn-sm" href="javascript:void(0);" data-income-id="${income_id}" data-transfer-id="${transfer_id}">príjem</a></td>
            </tr>
            <tr class="income-row bg-light" style="display: none;">
              <td id="transfer-${transfer_id}" colspan="11"></td>
            </tr>
          `;
  
          htmlResults += row;
        }
  
        $("#personTransferFilterTableResults").html(htmlResults);
        PersonTransfersFilter.toggleIncome();
      }
    },
    toggleIncome: () => {
      $(document).off("click", ".js-toggle-income").on("click", ".js-toggle-income", function(){
        Help.showPreloader();

        let transfer_id = parseInt($(this).attr("data-transfer-id"));
        let income_id = parseInt($(this).attr("data-income-id"));

        // OLD WAY
        /*let $transferRow = $(this).closest(".transfer-row");
        $transferRow.toggleClass("bg-light").next(".income-row").slideToggle();

        if( $transferRow.next(".income-row").find(".income-list").length ){
          Help.hidePreloader();

          return;
        }*/

        /***
         * GET DATA FROM SERVER
         */
        $.getJSON(
          "/dobrodinec/prevody-filter-zobraz-prijem",
          {
              transfer_id: transfer_id,
              income_id: income_id,
          },
          function (data) {
            if (data.income.length) {
              PersonTransfersFilter.populateIncome(data.income);
            } else {
              alert("Nič som nenašiel.");
            }
    
            Help.hidePreloader();
          }
        );
      });
    },
    populateIncome: income => {
      if (income) {
        let htmlResults = "<ul class='income-list' style='margin: 0; padding: 0;'>";
		let transfer_id;

        for (let i = 0; i < income.length; i++) {
          transfer_id = income[i].transfer_id;
          let sum = Help.beautifyDecimal(income[i].sum);
          let username = income[i].username;
          let bank_account_name = income[i].bank_account_name;
          let number = income[i].number;
          let package_number = income[i].package_number;
          let invoice = income[i].invoice;
          let note = income[i].note;
          let accounting_date = Help.beautifyDate(income[i].accounting_date);

          let row = `
              <li>Nahral(a): ${username}, <br> bankový účet: ${bank_account_name}, <strong>${sum} &euro;</strong>, <br> číslo: ${number}, balík: ${package_number}, <br> faktúra: ${invoice}, <br> <span class="text-secondary">${accounting_date}</span> ${note}</li>
          `;
  
          htmlResults += row;
        }
        htmlResults += "</ul>";

        // OLD WAY $("#transfer-" + transfer_id + "").html(htmlResults);

        $("#transfer-" + transfer_id + " .tabulator-cell").css("height", "auto");
        $("#transfer-" + transfer_id + " .tabulator-cell[tabulator-field='income']").prepend(htmlResults);
        $("#transfer-" + transfer_id + " .tabulator-cell[tabulator-field='income']").find(".js-toggle-income").remove();
      }
    },
  };
  
  $(document).ready(function () {
    if ($("#personTransfersFilterTabulator").length) {
      $(document).off("click", "#initPersonTransfersFilter").on("click", "#initPersonTransfersFilter", function () {
        PersonTransfersFilter.filterPersonTransfers();
      });
    }
  });
  