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
	}
}

//////////
// INIT
//////////
if ($("#incomeForm").length) {
	Income.storeIncomeChars();
}