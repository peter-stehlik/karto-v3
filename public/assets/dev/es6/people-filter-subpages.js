/**
 * search for person
 * similar to income search
 * but adapted more universally
 * 
 */

let PeopleSearch = {
	/*
	*
	*  AUTOCOMPLETE SEARCH FOR PERSON FROM DATABASE:
	*  LIST FOUND RESULTS.
	*
	*/
	initSearch: () => {
		let search_name = $("#search_name").val();
		let search_zip_code = $("#search_zip_code").val();
		let search_address = $("#search_address").val();
		let search_city = $("#search_city").val();

		search_zip_code = Help.beautifyZipCode(search_zip_code);

		Help.hidePreloader();

		if (
			search_name.length == 0 &&
			search_zip_code.length == 0 &&
			search_address.length == 0 &&
			search_city.length == 0
		) {
			return;
		}

		Help.showPreloader();

		$.getJSON(
			"/kartoteka/prijem/autocomplete",
			{
				search_name: search_name,
				search_zip_code: search_zip_code,
				search_address: search_address,
				search_city: search_city
			},
			function (data) {
				if (data.people) {
					PeopleSearch.populateSearchedPeople(data.people);
				} else {
					alert(
						"Nič som nenašiel. Skontrolujte, čo vyhľadávate. Hlavne v žiadnom prípade nepíšte programátorovi ;-)"
					);
				}
				Help.hidePreloader();
			}
		);
	},
	/*
	*
	*  HELPER:
	*  SIMPLY HIDE SEARCH RESULTS
	*
	*/
	clearSearchResults: () => {
		$(".people-search-results").hide();
		$("#searchBox").hide();
	},
	/*
	*
	*  HELPER:
	*  DISPLAY ALL PEOPLE FOUND IN DATABASE IN HTML TABLE
	*
	*/
	populateSearchedPeople: people => {
		let html = "";
		for (let i = 0; i < people.length; i++) {
			let personHtml = `
					<tr>
						<td>${people[i].id}</td>
						<td>${people[i].name1}</td>
						<td>${people[i].address}</td>
						<td>${people[i].city}</td>
						<td>${people[i].zip_code}</td>
			  			<td class="icn-td">
						  	<a class="populate-chosen-person btn btn-sm btn-info" href="javascript:void(0);" title="použiť" data-person-id="${people[i].id}" data-person-name="${people[i].name1}">
								použiť
							</a>
						</td>
					</tr>
				`;

			html += personHtml;
		}

		$(".people-search-results").show();
		$(".preloader").hide();

		$("#peopleSearchResults").html(html);
	},
	/*
	*
	*  HELPER:
	*  FILL THE PERSON INTO INCOME CHOSEN FROM THE SEARCH LIST
	*
	*/
	populateChosenPerson: (userId, name) => {
		$("#for_person_id").val(userId);
		$("#name1").val(name);

		PeopleSearch.clearSearchResults();
	},
}

//////////
// INIT
//////////

/* search */
let initSearchFn = debounce(function () {
	PeopleSearch.initSearch();
}, 400);

$(document).on(
	"input",
	"#search_name, #search_address, #search_zip_code, #search_city",
	initSearchFn
);
///////////////////////

/* fill chosen person into the income form from the search list */
$(document).on("click", ".populate-chosen-person", function () {
	let userId = $(this).attr("data-person-id");
	let name = $(this).attr("data-person-name");

	PeopleSearch.populateChosenPerson(userId, name);
});
///////////////////////

