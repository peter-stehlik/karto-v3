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
	beautifyDecimal: decimal => {
		let numArr = decimal.split(".");
		let num = numArr[0];

		if( numArr[1] != '00' ){
			num = numArr.join(',');
		}

		return num;
	},
	beautifyDate: date => {
		let rawDate = new Date(date);
		let dd = String(rawDate.getDate()).padStart(2, '0');
		let mm = String(rawDate.getMonth() + 1).padStart(2, '0'); //January is 0!
		let yyyy = rawDate.getFullYear();
		let correction_date = dd + '.' + mm + '.' + yyyy;

		return correction_date;
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
		
		if ($(".total-count-wrap").length) {
			$(".total-count-wrap").hide();
		}
	},
	hidePreloader: () => {
		if ($(".preloader").length) {
			$(".preloader").hide();
		}
		if ($(".total-count-wrap").length) {
			$(".total-count-wrap").show();
		}
	},
};