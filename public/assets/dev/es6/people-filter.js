let Filter = {
    /* NOT USED, OLD WAY */
    emptySearchResults: () => {
      $("#personFilterTabulator").empty();
    },
    filterPeople: () => {
      Help.showPreloader();
      Filter.emptySearchResults();
  
      let person_id = $("#id").val();
      let category_id = $("#category_id").val();
      let name1 = $("#name1").val();
      let address1 = $("#address1").val();
      let zip_code = $("#zip_code").val();
      let city = $("#city").val();
      let bin = $("#bin").val();
  
      zip_code = Help.beautifyZipCode(zip_code);
  
      /***
       * VALIDATE IF SOME PARAMETER FILLED
       */
      if (
        person_id.length == 0 &&
        category_id == 0 &&
        name1.length == 0 &&
        address1.length == 0 &&
        zip_code.length == 0 &&
        city.length == 0 &&
        bin == 0
      ) {
        alert("Zadajte aspoň jeden parameter do vyhľadávania.");
  
        Help.hidePreloader();
  
        return;
      }
  
      /***
       * GET DATA FROM SERVER
       */
      $.getJSON(
        "/osoba/filter",
        {
          person_id: person_id,
          category_id: category_id,
          name1: name1,
          address1: address1,
          zip_code: zip_code,
          city: city,
          bin: bin
        },
        function (data) {
          if (data.people) {
            $("#totalCount").text(data.people.length);

            let table = new Tabulator("#personFilterTabulator", {
                layout: "fitColumns",
                pagination: "local",
                paginationSize: 20,
                paginationSizeSelector: [10, 20, 50, 100],
                data: data.people, //assign data to table
                columns: [
                  {title:"ID", field:"id", sorter:"number", width: 50},
                  {title:"titul", field:"title", sorter:"string", visible:false},
                  {title:"meno 1", field:"name1", sorter:"string", width:250, formatter: function(cell, formatterParams){
                    let value = cell.getValue();
                    let id = cell.getRow().getCells()[0].getValue();
                    let titul =cell.getRow().getCells()[1].getValue();
                    
                    if( titul === null ){
                      titul = "";
                    }
    
                    return "<a href='/dobrodinec/" + id + "/ucty' target='_blank'>" + titul + " " + value + "</a>";
                  }},
                  {title:"organizácia", field:"organization", sorter:"string"},
                  {title:"adresa 1", field:"address1", sorter:"string"},
                  {title:"PSČ", field:"zip_code", sorter:"string"},
                  {title:"mesto", field:"city", sorter:"string"},
                  {title:"štát", field:"state", sorter:"string"},
                  {title:"kategória", field:"category_name", sorter:"string"},
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
  
  $("document").ready(function () {
    if ($("#personFilterTabulator").length) {
      $(document).on("click", "#initFilter", function () {
        Filter.filterPeople();
      });
    }
  });
  