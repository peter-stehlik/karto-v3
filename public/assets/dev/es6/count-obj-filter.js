let CountObjFilter = {
    emptySearchResults: () => {
      $(".js-show-count-wrap").hide();
    },
    filterList: () => {
      Help.showPreloader();
      CountObjFilter.emptySearchResults();
  
      let periodical_publication_id = $("#periodical_publication_id").val();
      let month = $("#month").val();
      let year = $("#year").val();

      /***
       * VALIDATE IF SOME PARAMETER FILLED
       */
      if (
        month.length == 0 && 
        year.length == 0 &&
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
        "/vydavatelstvo/pocet-objednavok-filter",
        {
            month: month,
            year: year,
            periodical_publication_id: periodical_publication_id,
        },
        function (data) {
			if (data.count) {
				$("#showCount").text(data.count);

				$(".js-show-count-wrap").show();
        	} else {
            	alert("Nič som nenašiel.");
        	}
  
          	Help.hidePreloader();
        }
      );
    },
  };
  
  $(document).ready(function () {
    if ($(".js-show-count-wrap").length) {
      $(document).off("click", "#showCountFilter").on("click", "#showCountFilter", function () {
        CountObjFilter.filterList();
      });
    }
  });