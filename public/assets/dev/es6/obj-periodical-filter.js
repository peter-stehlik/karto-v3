let ObjPeriodicalFilter = {
    emptySearchResults: () => {
      $("#objPeriodicalFilterTabulator").empty();
    },
    filterList: () => {
      Help.showPreloader();
      ObjPeriodicalFilter.emptySearchResults();
  
      let count_from = $("#count_from").val();
      let count_to = $("#count_to").val();
      let periodical_publication_id = $("#periodical_publication_id").val();

      /***
       * VALIDATE IF SOME PARAMETER FILLED
       */
      if (
        count_from.length == 0 && 
        count_to.length == 0 &&
        periodical_publication_id == 0
      ) {
        alert("Zadajte aspoň jeden parameter do vyhľadávania.");
  
        Help.hidePreloader();
  
        return;
      }
  
      /***
       * GET DATA FROM SERVER
       */
      $.getJSON(
        "/vydavatelstvo/objednavky-periodicke-filter",
        {
            count_from: count_from,
            count_to: count_to,
            periodical_publication_id: periodical_publication_id,
        },
        function (data) {
         if (data.obj_periodical.length) {
            let table = new Tabulator("#objPeriodicalFilterTabulator", {
              layout: "fitColumns",
              pagination: "local",
              paginationSize: 20,
              paginationSizeSelector: [10, 20, 50, 100],
              data: data.obj_periodical, //assign data to table
              columns: [
                {title:"ID", field:"person_id", sorter:"number", width: 60},
				{title:"titul", field:"title", sorter:"string", visible:false},
				{title:"meno", field:"name1", sorter:"string", formatter: function(cell, formatterParams){
                    let value = cell.getValue();
                    let id = cell.getRow().getCells()[0].getValue();
                    let titul = cell.getRow().getCells()[1].getValue();
    
                    return "<a href='/dobrodinec/" + id + "/ucty' target='_blank'>" + titul + " " + value + "</a>";
                }},
				{title:"adresa", field:"address1", sorter:"string"},
				{title:"mesto", field:"city", sorter:"string"},
				{title:"PSČ", field:"zip_code", sorter:"string"},
				{title:"publikácia", field:"name", sorter:"string"},
				{title:"ks", field:"count", sorter:"number", width: 60},
                {title:"platné od", field:"valid_from", sorter:"date", formatter: function(cell, formatterParams){
                  let value = cell.getValue();
                  let outcome_date = Help.beautifyDate(value);

                  return outcome_date;
                }},
				{title:"platné do", field:"valid_to", sorter:"date", formatter: function(cell, formatterParams){
					let value = cell.getValue();
					let outcome_date = Help.beautifyDate(value);
  
					return outcome_date;
				}},
				{title:"poznámka", field:"note", sorter:"string"},
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
    if ($("#objPeriodicalFilterTabulator").length) {
      $(document).off("click", "#initObjPeriodicalFilter").on("click", "#initObjPeriodicalFilter", function () {
        ObjPeriodicalFilter.filterList();
      });
    }
  });