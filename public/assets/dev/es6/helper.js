let Help = {
	beautifyZipCode: zip_code => {
		let zip = zip_code.replace(/\s/g, ''); // remove whitespaces if any
		let zip_code_arr = zip.split('');
		let beautifiedZip = zip_code;

		if (zip_code_arr.length > 3) {
			zip_code_arr.splice(3, 0, ' ');
			beautifiedZip = zip_code_arr.join('');
		}

		return beautifiedZip;
	},
	getTodayDate: () => {
		let today = new Date();
		let dd = String(today.getDate()).padStart(2, '0');
		let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
		let yyyy = today.getFullYear();
		today = dd + '.' + mm + '.' + yyyy;

		return today;
	},
	showPreloader: () => {
		if ($(".preloader").length) {
			$(".preloader").show();
		}
	},
	hidePreloader: () => {
		if ($(".preloader").length) {
			$(".preloader").hide();
		}
	},
};