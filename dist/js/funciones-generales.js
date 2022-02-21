$().ready(function() {
	myFunctions =
		{
			validateEmptyField(field) {
				if (field == null || field == undefined || field == "") {
					return "N/A"
				} else {
					return field;
				}
			},
			number_format (number, decimals, dec_point, thousands_sep) {
				// Strip all characters but numerical ones.
				number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
				var n = !isFinite(+number) ? 0 : +number,
					prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
					sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
					dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
					s = '',
					toFixedFix = function (n, prec) {
						var k = Math.pow(10, prec);
						return '' + Math.round(n * k) / k;
					};
				// Fix for IE parseFloat(0.55).toFixed(0) = 0;
				s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
				if (s[0].length > 3) {
					s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
				}
				if ((s[1] || '').length < prec) {
					s[1] = s[1] || '';
					s[1] += new Array(prec - s[1].length + 1).join('0');
				}
				return s.join(dec);
			},
			 muestraAlerta(title, message, type)
			{
				//tipos: warning, success, error, info
				swal({
					title: title,
					text: message,
					buttonsStyling: false,
					confirmButtonClass: "btn btn-success",
					type:type,
					confirmButtonText: 'Si, entiendo'
				});
			},
			validateEmptyFieldDocs(field) {
				if (field == null || field == undefined || field == "") {
					return ""
				} else {
					return field;
				}
			}

		}
});

function onlyNumbers(e){
	key = e.keyCode || e.which;
	tecla = String.fromCharCode(key);
	letras = " 0123456789";
	especiales = [8, 37, 39, 46];

	tecla_especial = false
	for(var i in especiales) {
		if(key == especiales[i]) {
			tecla_especial = true;
			break;
		}
	}

	if(letras.indexOf(tecla) == -1 && !tecla_especial)
		return false;
}

//Fn change full date to format (dd/mm/yyyy) : AA
function convertDate(inputFormat) {
	function pad(s) { return (s < 10) ? '0' + s : s; }
	var d = new Date(inputFormat)
	var date = [pad(d.getDate()), pad(d.getMonth()+1), d.getFullYear()].join('/')
	var formated = date.replace(/(..)\/(..)\/(....)/, "$2/$1/$3");
	return formated;
}