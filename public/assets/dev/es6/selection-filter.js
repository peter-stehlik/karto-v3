let SelectionFilter = {
    emptySearchResults: () => {
      $("#selectionFilterTabulator").empty();
    },
    filterList: () => {
      Help.showPreloader();
      SelectionFilter.emptySearchResults();
  
      let date_from = $("#date_from").val();
      let date_to = $("#date_to").val();
      let transfer = $("#transfer").val();
      let category = $("#category").val();
      let category_excluded = $("#category_excluded").val();
      let periodical_publication_id = $("#periodical_publication_ids").val();
      let nonperiodical_publication_id = $("#nonperiodical_publication_ids").val();

      /***
       * VALIDATE IF SOME PARAMETER FILLED
       */
      if (
        date_from.length == 0 &&
        date_to.length == 0 &&
        category == 0 &&
        category_excluded == 0 &&
        periodical_publication_id.length == 0 &&
        nonperiodical_publication_id.length == 0
      ) {
        alert("Zadajte aspoň jeden parameter do vyhľadávania.");
  
        Help.hidePreloader();
  
        return;
      }
  
      /***
       * GET DATA FROM SERVER
       */
      $.getJSON(
        "/kancelaria/selekcie-filter",
        {
            date_from: date_from,
            date_to: date_to,
            category_id: category,
            category_excluded_id: category_excluded,
            periodical_publication_id: periodical_publication_id,
            nonperiodical_publication_id: nonperiodical_publication_id,
        },
        function (data) {
         if (data.selection.length) {
            let table = new Tabulator("#selectionFilterTabulator", {
              layout: "fitColumns",
              pagination: "local",
              paginationSize: 20,
              paginationSizeSelector: [10, 20, 50, 100],
              data: data.selection, //assign data to table
              columns: [
                {title:"ID", field:"person_id", sorter:"number", width: 60},
				{title:"titul", field:"title", sorter:"string", visible:false},
				{title:"meno", field:"name1", sorter:"string", formatter: function(cell, formatterParams){
                    let value = cell.getValue();
                    let id = cell.getRow().getCells()[0].getValue();
                    let titul = cell.getRow().getCells()[1].getValue();
                    
                    if( titul === null ){
                      titul = "";
                    }

                    return "<a href='/dobrodinec/" + id + "/ucty' target='_blank'>" + titul + " " + value + "</a>";
                }},
				{title:"adresa", field:"address1", sorter:"string"},
				{title:"mesto", field:"city", sorter:"string"},
				{title:"PSČ", field:"zip_code", sorter:"string"},
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
    preFillTransfers: () => {
      $("#transfer").change(function(){
        let val = $(this).val();

        if( !val ){
            return;
        }

        let per = [];
        let nonper = [];
        let removeFirstChar = str => {
          return str.substring(1);
        };

        for( var i=0; i<val.length; i++ ){
          if( val[i].startsWith("p") ){
            per.push(removeFirstChar(val[i]));
          }

          if( val[i].startsWith("n") ){
            nonper.push(removeFirstChar(val[i]));
          }
        }

        $("#periodical_publication_ids").val( per.join(",") );
        $("#nonperiodical_publication_ids").val( nonper.join(",") );
      });
    },
  };
  
  $(document).ready(function () {
    SelectionFilter.preFillTransfers();

    if ($("#selectionFilterTabulator").length) {
      $(document).off("click", "#initSelectionFilter").on("click", "#initSelectionFilter", function () {
        SelectionFilter.filterList();
      });
    }
  });