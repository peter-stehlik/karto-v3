let Income = {
	/*
	*
	*  STORE TEMPORARILY INCOME CHARACTERS:
	*		- package_number
	*		- income_date
	*		- number
	*		- bank_account
	*  INTO LOCAL STORAGE.
	*  PREPOPULATED FOR NEXT INCOME, BUT ONLY AT THE SAME DAY.
	*
	*/
	storeIncomeChars: () => {
		// date to compare, if local storage contains active or old data
		let today = new Date().toJSON().slice(0, 10).replace(/-/g, '/');

		////////////////////
		// PACKAGE NUMBER
		////////////////////
		let savedPackageNumber = localStorage.getItem('packageNumber');
		let savedPackageNumberDate = localStorage.getItem('packageNumberDate');

		// prepopulate if active
		if (savedPackageNumberDate == today) {
			$("#package_number").val(savedPackageNumber);
		}

		// save new val
		$("#incomeForm").submit(() => {
			let packageNumber = $("#package_number").val();

			localStorage.setItem('packageNumberDate', today);
			localStorage.setItem('packageNumber', packageNumber);
		});

		////////////////////
		// INCOME DATE
		////////////////////
		let savedIncomeDate = localStorage.getItem('incomeDate');
		let savedIncomeDateDate = localStorage.getItem('incomeDateDate');

		// prepopulate if active
		if (savedIncomeDateDate == today) {
			$("#income_date").val(savedIncomeDate);
		}

		// save new val
		$("#incomeForm").submit(() => {
			let incomeDate = $("#income_date").val();

			localStorage.setItem('incomeDateDate', today);
			localStorage.setItem('incomeDate', incomeDate);
		});

		////////////////////
		// NUMBER
		////////////////////
		let savedNumber = localStorage.getItem('number');
		let savedNumberDate = localStorage.getItem('numberDate');

		// prepopulate if active
		if (savedNumberDate == today) {
			$("#number").val(++savedNumber);
		}

		// save new val
		$("#incomeForm").submit(() => {
			let number = $("#number").val();

			localStorage.setItem('numberDate', today);
			localStorage.setItem('number', number);
		});

		////////////////////
		// BANK ACCOUNT
		////////////////////
		let savedBankAccount = localStorage.getItem('bankAccount');
		let savedBankAccountDate = localStorage.getItem('bankAccountDate');

		// prepopulate if active
		if (savedBankAccountDate == today) {
			$("#bank_account_id").val(savedBankAccount);
		}

		// save new val
		$("#incomeForm").submit(() => {
			let bankAccount = $("#bank_account_id").val();

			localStorage.setItem('bankAccountDate', today);
			localStorage.setItem('bankAccount', bankAccount);
		});
	},
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

		Income.clearSearchResults();
		Help.hidePreloader();
		Income.hideAddNewPersonOnIncome();

		if (
			search_name.length == 0 &&
			search_zip_code.length == 0 &&
			search_address.length == 0 &&
			search_city.length == 0
		) {
			alert("Zadajte parameter do vyhľadávania.");

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
					Income.populateSearchedPeople(data.people);
				} else {
					let r = confirm(
						"Nič som nenašiel. Chcete vytvoriť nového používateľa?"
					);
					if (r == true) {
						Income.clearSearchResults();
						Help.hidePreloader();
						Income.showAddNewPersonOnIncome();
					}
				}
			}
		);
	},
	clearSearchResults: () => {
		$(".income-search-results").hide();
	},
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
			  			<td class="icn-td"><a href="javascript:void(0);" class="populate-chosen-person" title="Nahrať príjem tejto osobe" data-person-id="${people[i].id}" data-person-name="${people[i].name1}">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-bar-up text-success" viewBox="0 0 16 16">
								<path fill-rule="evenodd" d="M8 10a.5.5 0 0 0 .5-.5V3.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 3.707V9.5a.5.5 0 0 0 .5.5zm-7 2.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5z"/>
							</svg> 
						</a></td>
						<td class="icn-td"><a href="/backend/people/print/${people[i].id}" target="_blank" class="view" title="Tlačiť">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
								<path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
								<path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
							</svg>
						</a></td>
						<td class="icn-td"><a href="/backend/customer/detail/${people[i].id}" class="edit" title="Pozrieť detail">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill text-info" viewBox="0 0 16 16">
								<path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
							</svg>
						</a></td>
						<td class="icn-td"><a href="javascript:void(0);" class="income-delete-user" data-person-id="${people[i].id}" title="Vymazať">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash text-danger" viewBox="0 0 16 16">
								<path
									d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
								<path fill-rule="evenodd"
									d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
							</svg>
						</a></td>
					</tr>
				`;

			html += personHtml;
		}

		$(".income-search-results").show();
		$(".preloader").hide();

		$("#incomeSearchResults").html(html);

		Income.enableBrowseList();
	},
	enableBrowseList: () => {
		let search_results = $("#incomeSearchResults tr");

		if (search_results.length) {
			search_results.first().addClass("is-active");
		}
	},
	disableBrowserList: () => {
		$("#incomeSearchResults tr").removeClass("is-active");

		$("html, body").animate({
			scrollTop: 0
		});
	},
	initKeyboardShortcuts: e => {
		if (e.altKey && e.key == "l") {
			// alt+l
			Income.enableBrowseList();
		}

		let activeTr = $("#incomeSearchResults tr.is-active");
		if (e.key == "ArrowDown" || e.key == "ArrowUp") {
			if (activeTr.length) {
				switch (e.key) {
					case "ArrowDown":
						// sipka dole
						Income.initSearchList("down");
						break;
					case "ArrowUp":
						// sipka hore
						Income.initSearchList("up");
						break;
				}
			}
		}

		if (e.key == "Enter") {
			if (activeTr.length) {
				let userId = activeTr
					.find(".populate-chosen-person")
					.attr("data-person-id");
				let name = activeTr
					.find(".populate-chosen-person")
					.attr("data-person-name");
				Income.populateChosenPerson(userId, name);
				Income.disableBrowserList();
			}
		}

		if (e.key == "Escape") {
			if (activeTr.length) {
				Income.disableBrowserList();
			}
		}
	},
	initSearchList: direction => {
		let activeTr = $("#incomeSearchResults tr.is-active");

		switch (direction) {
			case "down":
				activeTr
					.next()
					.addClass("is-active")
					.siblings()
					.removeClass("is-active");
				break;
			case "up":
				activeTr
					.prev()
					.addClass("is-active")
					.siblings()
					.removeClass("is-active");
				break;
		}
	},
	populateChosenPerson: (userId, name) => {
		$("#person_id").val(userId);
		$("#name1").val(name);

		// Income.saveIncomeDataToLocalStorage();

		$("#income_sum").focus();
	},
	validateIncome: () => {
		let validIncome = true;
		let total = parseFloat($("#income_sum").val());

		if (!total) {
			validIncome = false;
		}

		return validIncome;
	},
	deleteUser: userId => {
		$.getJSON(
			"/kartoteka/prijem/delete-person",
			{
				userId: userId
			},
			function (data) {
				if (data.result) {
					$(".income-delete-user[data-person-id='" + userId + "']")
						.closest("tr")
						.remove();

					alert("Osoba je úspešne vymazaná.");
				}
			}
		);
	},
	showAddNewPersonOnIncome: () => {
		let myModal = new bootstrap.Modal(document.getElementById('myModal'), {
			keyboard: false
		});

		myModal.show();
	},
	hideAddNewPersonOnIncome: () => {
		$("#myModal").hide();
	},
	createNewUser: () => {
		let category_id = $("#inc_category_id").val();
		let title = $("#inc_title").val();
		let name1 = $("#inc_name1").val();
		let name2 = $("#inc_name2").val();
		let address1 = $("#inc_address1").val();
		let address2 = $("#inc_address2").val();
		let city = $("#inc_city").val();
		let zip_code = $("#inc_zip_code").val();
		let state = $("#inc_state").val();
		let phone = $("#inc_phone").val();
		let fax = $("#inc_fax").val();
		let bank_account = $("#inc_bank_account").val();
		let email = $("#inc_email").val();
		let note = $("#inc_note").val();
		let birthday = $("#inc_birthday").val();
		let anniversary = $("#inc_anniversary").val();

		$.getJSON(
			"/backend/people/create-ajax",
			{
				category_id: category_id,
				title: title,
				name1: name1,
				name2: name2,
				address1: address1,
				address2: address2,
				city: city,
				zip_code: zip_code,
				state: state,
				phone: phone,
				fax: fax,
				bank_account: bank_account,
				email: email,
				note: note,
				birthday: birthday,
				anniversary: anniversary
			},
			function (data) {
				if (data.result == 1) {
					$("#create_user_dynamically input").val("");

					Income.hideAddNewPersonOnIncome();

					alert(
						"Úspešne ste vytvorili užívateľa, môžete mu pridať zopár grošov."
					);

					Income.initSearch();
				}
			}
		);
	},
}

//////////
// INIT
//////////

/* store to local storage */
if ($("#incomeForm").length) {
	Income.storeIncomeChars();

	$(document).on("keydown", function (e) {
		Income.initKeyboardShortcuts(e);
	});
}

/* search */
let initSearchFn = debounce(function () {
	Income.initSearch();
}, 400);

$(document).on(
	"input",
	"#search_name, #search_address, #search_zip_code, #search_city",
	initSearchFn
);

$(document).on("click", ".populate-chosen-person", function () {
	let userId = $(this).attr("data-person-id");
	let name = $(this).attr("data-person-name");

	Income.populateChosenPerson(userId, name);
});

$("#incomeForm").submit(function () {
	let valid = Income.validateIncome();

	if (!valid) {
		return false;
	}
});

$(document).on("click", ".income-delete-user", function () {
	let userId = $(this).attr("data-person-id");

	let r = confirm("Naozaj chcete túto osobu vymazať?");

	if (r == true) {
		Income.deleteUser(userId);
	}
});