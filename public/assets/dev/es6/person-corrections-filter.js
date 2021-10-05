let PersonCorrectionsFilter = {
    emptySearchResults: () => {
      $("#personCorrectionsFilterTabulator").empty();
    },
    filterPersonCorrections: () => {
      Help.showPreloader();
      PersonCorrectionsFilter.emptySearchResults();
  
      let person_id = $("#person_id").val();
      let sum_from = $("#sum_from").val();
      let sum_to = $("#sum_to").val();
      let from_periodical_id = $("#from_periodical_id").val();
      let from_nonperiodical_id = $("#from_nonperiodical_id").val();
      let for_periodical_id = $("#for_periodical_id").val();
      let for_nonperiodical_id = $("#for_nonperiodical_id").val();
      let corrections_date_from = $("#corrections_date_from").val();
      let corrections_date_to = $("#corrections_date_to").val();
  
      /***
       * VALIDATE IF SOME PARAMETER FILLED
       */
      if (
        person_id == 0 &&
        sum_from.length == 0 &&
        sum_to.length == 0 &&
        from_periodical_id == 0 &&
        from_nonperiodical_id == 0 &&
        for_periodical_id == 0 &&
        for_nonperiodical_id == 0 &&
        corrections_date_from.length == 0 &&
        corrections_date_to.length == 0
      ) {
        alert("Zadajte aspoň jeden parameter do vyhľadávania.");
  
        Help.hidePreloader();
  
        return;
      }
  
      /***
       * GET DATA FROM SERVER
       */
      $.getJSON(
        "/dobrodinec/opravy-filter",
        {
            person_id: person_id,
            sum_from: sum_from,
            sum_to: sum_to,
            from_periodical_id: from_periodical_id,
            from_nonperiodical_id: from_nonperiodical_id,
            for_periodical_id: for_periodical_id,
            for_nonperiodical_id: for_nonperiodical_id,
            corrections_date_from: corrections_date_from,
            corrections_date_to: corrections_date_to
        },
        function (data) {
          if (data.corrections.length) {
            let table = new Tabulator("#personCorrectionsFilterTabulator", {
              layout: "fitColumns",
              pagination: "local",
              paginationSize: 20,
              paginationSizeSelector: [10, 20, 50, 100],
              data: data.corrections, //assign data to table
              rowFormatter:function(row){
                let data = row.getData(); //get data object for row
                let transfer_id = data["transfer_id"];
                let html_id = "transfer-" + transfer_id;

                row.getElement().setAttribute("id", html_id);
              },
              columns: [
                {title:"ID", field:"transfer_id", sorter:"number", width: 60},
                {title:"income_id", field:"income_id", sorter:"string", visible:false},
                {title:"meno", field:"name1", sorter:"string"},
                {title:"mesto", field:"city", sorter:"string"},
                {title:"dátum prevodu", field:"transfer_date", sorter:"date", formatter: function(cell, formatterParams){
                  let value = cell.getValue();
                  let transfer_date = Help.beautifyDate(value);

                  return transfer_date;
                }},
                {title:"suma", field:"transfer_sum", sorter:"number", formatter: function(cell, formatterParams){
                  let value = cell.getValue();
                  let transfer_sum = Help.beautifyDecimal(value);
                  transfer_sum += " &euro;"

                  return transfer_sum;
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
          } else {
            alert("Nič som nenašiel.");
          }
  
          Help.hidePreloader();
        }
      );
    },
  };
  
  $(document).ready(function () {
    if ($("#personCorrectionsFilterTabulator").length) {
      $(document).off("click", "#initPersonCorrectionsFilter").on("click", "#initPersonCorrectionsFilter", function () {
        PersonCorrectionsFilter.filterPersonCorrections();
      });
    }
  });
  