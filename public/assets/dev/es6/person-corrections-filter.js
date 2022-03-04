let PersonCorrectionsFilter = {
    emptySearchResults: () => {
      $("#personCorrectionsFilterTabulator").empty();
    },
    filterPersonCorrections: () => {
      Help.showPreloader();
      PersonCorrectionsFilter.emptySearchResults();
  
      let person_id = $("#person_id").val();
      let user_id = $("#user_id").val();
      let sum_from = $("#sum_from").val();
      let sum_to = $("#sum_to").val();
      let from_periodical_id = $("#from_periodical_id").val();
      let from_nonperiodical_id = $("#from_nonperiodical_id").val();
      let for_periodical_id = $("#for_periodical_id").val();
      let for_nonperiodical_id = $("#for_nonperiodical_id").val();
      let correction_date_from = $("#correction_date_from").val();
      let correction_date_to = $("#correction_date_to").val();

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
        correction_date_from.length == 0 &&
        correction_date_to.length == 0 &&
        user_id == 0
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
            correction_date_from: correction_date_from,
            correction_date_to: correction_date_to,
            user_id: user_id,
        },
        function (data) {
         if (data.corrections.length) {
            $("#totalCount").text(data.corrections.length);

            let table = new Tabulator("#personCorrectionsFilterTabulator", {
              layout: "fitColumns",
              pagination: "local",
              paginationSize: 20,
              paginationSizeSelector: [10, 20, 50, 100],
              data: data.corrections, //assign data to table
              columns: [
                {title:"ID", field:"correction_id", sorter:"number", width: 60},
                {title:"nahral(a)", field:"username", sorter:"string"},
                {title:"dátum opravy", field:"correction_date", sorter:"date", formatter: function(cell, formatterParams){
                  let value = cell.getValue();
                  let correction_date = Help.beautifyDate(value);

                  return correction_date;
                }},
                {title:"suma", field:"correction_sum", sorter:"number", formatter: function(cell, formatterParams){
                  let value = cell.getValue();
                  let correction_sum = Help.beautifyDecimal(value);
                  correction_sum += " &euro;"

                  return correction_sum;
                }},
                {title:"mesto od", field:"from_person_id_city", sorter:"string", visible: false},
                {title:"meno od", field:"from_person_id_name1", sorter:"string", formatter: function(cell, formatterParams){
                  let name_from = cell.getValue();
                  let city_from = cell.getRow().getCells()[4].getValue();
                  let person_from = name_from + "<br>" + city_from;

                  return person_from;
                }},
                {title:"mesto do", field:"for_person_id_city", sorter:"string", visible: false},
                {title:"meno pre", field:"for_person_id_name1", sorter:"string", formatter: function(cell, formatterParams){
                  let name_for = cell.getValue();
                  let city_for = cell.getRow().getCells()[6].getValue();
                  let person_for = name_for + "<br>" + city_for;

                  return person_for;
                }},
                {title:"periodikum od", field:"from_periodical_publications_name", sorter:"string", visible: false},
                {title:"neperiodikum od", field:"from_nonperiodical_publications_name", sorter:"string", visible: false},
                {title:"účel od", field:"transfer_from", sorter:"string", formatter: function(cell, formatterParams){
                  let pp_from = cell.getRow().getCells()[8].getValue();
                  let np_from = cell.getRow().getCells()[9].getValue();
                  let transfer_from = pp_from ? pp_from : np_from;

                  return transfer_from;
                }},
                {title:"periodikum do", field:"for_periodical_publications_name", sorter:"string", visible: false},
                {title:"neperiodikum do", field:"for_nonperiodical_publications_name", sorter:"string", visible: false},
                {title:"účel pre", field:"transfer_for", sorter:"string", formatter: function(cell, formatterParams){
                  let pp_for = cell.getRow().getCells()[11].getValue();
                  let np_for = cell.getRow().getCells()[12].getValue();
                  let transfer_for = pp_for ? pp_for : np_for;

                  return transfer_for;
                }},
                {title:"poznámka", field:"correction_note", sorter:"string"},
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
  