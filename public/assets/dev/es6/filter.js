let Filter = {
    emptySearchResults: () => {
      $("#filterResults").empty();
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
            Filter.populateSearchedPeople(data.people);
          } else {
            alert("Nič som nenašiel.");
          }
  
          Help.hidePreloader();
        }
      );
    },
    populateSearchedPeople: people => {
      if (people) {
        var htmlResults = "";
  
        for (var i = 0; i < people.length; i++) {
          var id = people[i].id;
          var name1 = people[i].name1;
          var address1 = people[i].address1 + ", " + people[i].zip_code + " " + people[i].city;
          var note = people[i].note;
          var category = people[i].category_name;
  
          var row = `
            <tr>
              <td>${id}</td>
              <td><a href="/dobrodinec/${id}/ucty" target="_blank">${name1}</a></td>
              <td>${address1}</td>
              <td>${category}</td>
              <td>${note}</td>
            </tr>
          `;
  
          htmlResults += row;
        }
  
        $("#filterResults").html(htmlResults);
      }
    }
  };
  
  $("document").ready(function () {
    if ($("#filterTable").length) {
      $(document).on("click", "#initFilter", function () {
        Filter.filterPeople();
      });
    }
  });
  