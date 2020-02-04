/*
*   Showing succ msg for  login.
*/
let successMsg = document.querySelector('.success');
if (successMsg) {
	setTimeout(function () {
		successMsg.style.display = 'none';
	}, 2000);
}
/*
*   Showing error msg for  login.
*/
let errorMsg = document.querySelector('.error');
if (errorMsg) {
	setTimeout(function () {
		errorMsg.style.display = 'none';
	}, 2000);
}

let role = document.querySelector('.role');
let subrole =  document.querySelector('.subrole');
let subsubrole =  document.querySelector('.subsubrole');

role.addEventListener('change', function (item) {

	let value = item.target.value;

	fetch('http://www.quantoxtest.com/user/getsubrolesajax', {
		method: 'post',
		headers: {
			"Content-type": "application/json; charset=UTF-8"
		},
		body: JSON.stringify({
			'role': value
		})
	})
	.then(response => {
		return response.json();
	})
	.then(data => {
		if(data.length > 0) {
			// subrole.innerHTML = '';
			// subsubrole.innerHTML = '';

			data.forEach(item => {
				let newOption = document.createElement("option");
				newOption.value = item.id_subroles;
				newOption.appendChild(document.createTextNode(item.sdescription));
				subrole.appendChild(newOption);
			})
		}
	})
	.catch(function(err) {
		console.log('Fetch Error :-S', err);
	});
	
});

subrole.addEventListener('change', function (item) {

	let value = item.target.value;

	fetch('http://www.quantoxtest.com/user/getsubsubroleajax', {
		method: 'post',
		headers: {
			"Content-type": "application/json; charset=UTF-8"
		},
		body: JSON.stringify({
			'subrole': value
		})
	})
	.then(response => {
		return response.json();
	})
	.then(data => {
		if(data.length > 0) {
			// subsubrole.innerHTML = '';

			data.forEach(item => {
				let newOption = document.createElement("option");
				newOption.value = item.id_sub_subroles;
				newOption.appendChild(document.createTextNode(item.ssdescription));
				subsubrole.appendChild(newOption);
			})
		}
	})
	.catch(function(err) {
		console.log('Fetch Error :-S', err);
	});
	
});