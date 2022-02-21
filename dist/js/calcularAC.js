function calcularCF2(){

//INICIO FECHA
	var day;
	var month = (new Date().getMonth() + 1);
	var yearc = new Date().getFullYear();


	if (month == 1){
		day = '0' + 1;
	}
	if (month == 2){
		day = '0 '+ 2;
	}
	if (month == 3){
		day = '0' + 3;
	}
	if (month == 4){
		day = '0' + 6;
	}
	if (month == 5){
		day = '0' + 7;
	}
	if (month == 6){
		day = '0' + 8;
	}
	if (month == 7){
		day = 11;
	}
	if (month == 8){
		day = 12;
	}
	if (month == 9){
		day = 13;
	}
	if (month == 10){
		day = 14;
	}
	if (month == 11){
		day = 16;
	}
	if (month == 12){
		day = 17;
	}

	var mes = ($scope.apartado && $scope.mesesdiferir > 0) ? (new Date().getMonth() + 2) : (new Date().getMonth() + 3);

//FIN FECHA




/////////////////////////// ENGANCHE DIFERIDO ////////////////////////////////////

	if($scope.day && $scope.apartado && $scope.mesesdiferir > 0){

		var engd = (enganche - $scope.apartado);
		var engd2 = (engd/$scope.mesesdiferir);
		var saldoDif = ($scope.precioFinal - $scope.apartado);

		var rangEd=[];
		for (var e = 0; e < $scope.mesesdiferir; e++) {

			if(mes == 13){
				mes = '01';
				yearc++;
			}
			if(mes == 2){
				mes = '02';
			}
			if(mes == 3){
				mes = '03';
			}
			if(mes == 4){
				mes = '04';
			}
			if(mes == 5){
				mes = '05';
			}
			if(mes == 6){
				mes = '06';
			}
			if(mes == 7){
				mes = '07';
			}
			if(mes == 8){
				mes = '08';
			}
			if(mes == 9){
				mes = '09';
			}
			if(mes == 10){
				mes = '10';
			}
			if(mes == 11){
				mes = '11';
			}
			if(mes == 12){
				mes = '12';
			}

			$scope.dateCf = day + '-' + mes + '-' + yearc;

			if(e == 0){
				$scope.fechaPM = $scope.dateCf;
			}

			rangEd.push({
				"fecha" : $scope.dateCf,
				"pago" : e + 1,
				"capital" : engd2,
				"interes" : 0,
				"total" : engd2,
				"saldo" : saldoDif -= engd2,

			});
			mes++;
		}

		$scope.rangEd= rangEd;

	}

/////////////////////////// ENGANCHE DIFERIDO ////////////////////////////////////




	$scope.infoLote={

		precioTotal: r1,
		yPlan: $scope.age_plan,
		msn: $scope.msni,
		meses: ($scope.age_plan*12),
		mesesSinInteresP1: $scope.msni,
		mesesSinInteresP2: 120,
		mesesSinInteresP3: 60,
		interes_p1: 0,
		interes_p2: 0.01,
		interes_p3: 0.0125,
		contadorInicial: 0,
		capital: ($scope.mesesdiferir > 0) ? (r1 / (($scope.age_plan*12) - $scope.mesesdiferir)) : (r1 / ($scope.age_plan*12)),
		fechaActual: $scope.date = new Date(),
		engancheF: enganche
	}

	$scope.engancheFinal = ($scope.infoLote.engancheF);
	$scope.saldoFinal = $scope.infoLote.precioTotal;
	$scope.precioFinal = ($scope.infoLote.precioTotal + $scope.infoLote.engancheF);

	$scope.preciom2F = ($scope.preciom2);






	/////////// TABLES DE 1 A 3 AÑOS ////////////


	if($scope.infoLote.meses >=12 && $scope.infoLote.meses <= 36) {

		var range=[];
		ini = ($scope.mesesdiferir > 0) ? $scope.mesesdiferir : $scope.infoLote.contadorInicial;


		if($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <=35) {


			for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {

				if(mes == 13){
					mes = '01';
					yearc++;
				}

				if(mes == 2){
					mes = '02';
				}
				if(mes == 3){
					mes = '03';
				}
				if(mes == 4){
					mes = '04';
				}
				if(mes == 5){
					mes = '05';
				}
				if(mes == 6){
					mes = '06';
				}
				if(mes == 7){
					mes = '07';
				}
				if(mes == 8){
					mes = '08';
				}
				if(mes == 9){
					mes = '09';
				}
				if(mes == 10){
					mes = '10';
				}
				if(mes == 11){
					mes = '11';
				}
				if(mes == 12){
					mes = '12';
				}

				$scope.dateCf = day + '-' + mes + '-' + yearc;

				if(i == 0){
					$scope.fechaPM = $scope.dateCf;
				}

				range.push({

					"fecha" : $scope.dateCf,
					"pago" : i + 1,
					"capital" : $scope.infoLote.capital,
					"interes" : 0,
					"total" : $scope.infoLote.capital + $scope.infoLote.interes_p1,
					"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,

				});
				mes++;

				if (i == ($scope.infoLote.mesesSinInteresP1 - 1)){
					$scope.total2 = $scope.infoLote.precioTotal;
					$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;

				}

				$scope.finalMesesp1 = range.length;
				ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
			}
			$scope.range= range;

			//////////

			$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);

			var range2=[];

			for (var i = ini2; i < $scope.infoLote.meses; i++) {

				if(mes == 13){
					mes = '01';
					yearc++;
				}

				if(mes == 2){
					mes = '02';
				}
				if(mes == 3){
					mes = '03';
				}
				if(mes == 4){
					mes = '04';
				}
				if(mes == 5){
					mes = '05';
				}
				if(mes == 6){
					mes = '06';
				}
				if(mes == 7){
					mes = '07';
				}
				if(mes == 8){
					mes = '08';
				}
				if(mes == 9){
					mes = '09';
				}
				if(mes == 10){
					mes = '10';
				}
				if(mes == 11){
					mes = '11';
				}
				if(mes == 12){
					mes = '12';
				}


				$scope.dateCf = day + '-' + mes + '-' + yearc;

				$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
				$scope.capital2 = ($scope.p2 - $scope.interes_plan2);

				range2.push({

					"fecha" : $scope.dateCf,
					"pago" : i + 1,
					"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
					"interes" : ($scope.interes_plan2= ($scope.total2 * $scope.infoLote.interes_p2)),
					"total" : $scope.p2,
					"saldo" : ($scope.total2 = ($scope.total2 -$scope.capital2)),

				});
				mes++;


				if (i == ($scope.infoLote.meses - 1)){
					$scope.totalSegundoPlan = $scope.p2;

				}
				$scope.finalMesesp2 = (range2.length);
			}
			$scope.range2= range2;


			// $scope.alphaNumeric = $scope.rangEd.concat($scope.range);
			// $scope.alphaNumeric = $scope.dani.concat($scope.range2);
			// $scope.alphaNumeric = $scope.range.concat($scope.range2);


			$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
			$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2);



			$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
					{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
					{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
					{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
					{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
							//pageMargins [left, top, right, bottom]
							doc.pageMargins = [ 140, 40, 10, 50 ];
							doc.alignment = 'center';

						}},
				]
			).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});



		}


		if($scope.infoLote.mesesSinInteresP1 == 0) {

			$scope.infoLote.mesesSinInteresP1 = ($scope.mesesdiferir > 0 ) ? ($scope.infoLote.mesesSinInteresP1 + $scope.mesesdiferir) : ($scope.infoLote.mesesSinInteresP1);


			$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.infoLote.precioTotal)
				/ ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);

			var range2=[];

			for (var i = ini; i < $scope.infoLote.meses; i++) {

				if(mes == 13){
					mes = '01';
					yearc++;
				}

				if(mes == 2){
					mes = '02';
				}
				if(mes == 3){
					mes = '03';
				}
				if(mes == 4){
					mes = '04';
				}
				if(mes == 5){
					mes = '05';
				}
				if(mes == 6){
					mes = '06';
				}
				if(mes == 7){
					mes = '07';
				}
				if(mes == 8){
					mes = '08';
				}
				if(mes == 9){
					mes = '09';
				}
				if(mes == 10){
					mes = '10';
				}
				if(mes == 11){
					mes = '11';
				}
				if(mes == 12){
					mes = '12';
				}


				$scope.dateCf = day + '-' + mes + '-' + yearc;

				$scope.interes_plan2 = $scope.infoLote.precioTotal * ($scope.infoLote.interes_p2);
				$scope.capital2 = ($scope.p2 - $scope.interes_plan2);

				range2.push({

					"fecha" : $scope.dateCf,
					"pago" : i + 1,
					"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
					"interes" : ($scope.interes_plan2= ($scope.infoLote.precioTotal * $scope.infoLote.interes_p2)),
					"total" : $scope.p2,
					"saldo" : ($scope.infoLote.precioTotal = ($scope.infoLote.precioTotal -$scope.capital2)),

				});
				mes++;

				if (i == ($scope.infoLote.meses - 1)){
					$scope.totalSegundoPlan = $scope.p2;

				}
				$scope.finalMesesp2 = (range2.length);
			}
			$scope.range2= range2;

			$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
			$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range2);
			// $scope.alphaNumeric = $scope.range2;


			$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
					{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
					{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
					{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
					{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
							//pageMargins [left, top, right, bottom]
							doc.pageMargins = [ 140, 40, 10, 50 ];
							doc.alignment = 'center';

						}},
				]
			).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});



		}








		if($scope.infoLote.mesesSinInteresP1 == 36) {

			for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {

				if(mes == 13){
					mes = '01';
					yearc++;
				}

				if(mes == 2){
					mes = '02';
				}
				if(mes == 3){
					mes = '03';
				}
				if(mes == 4){
					mes = '04';
				}
				if(mes == 5){
					mes = '05';
				}
				if(mes == 6){
					mes = '06';
				}
				if(mes == 7){
					mes = '07';
				}
				if(mes == 8){
					mes = '08';
				}
				if(mes == 9){
					mes = '09';
				}
				if(mes == 10){
					mes = '10';
				}
				if(mes == 11){
					mes = '11';
				}
				if(mes == 12){
					mes = '12';
				}

				$scope.dateCf = day + '-' + mes + '-' + yearc;

				if(i == 0){
					$scope.fechaPM = $scope.dateCf;
				}

				range.push({

					"fecha" : $scope.dateCf,
					"pago" : i + 1,
					"capital" : $scope.infoLote.capital,
					"interes" : 0,
					"total" : $scope.infoLote.capital + $scope.infoLote.interes_p1,
					"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,

				});
				mes++;

				if (i == ($scope.infoLote.mesesSinInteresP1 - 1)){
					$scope.total2 = $scope.infoLote.precioTotal;
					$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;

				}

				$scope.finalMesesp1 = range.length;
				ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
			}
			$scope.range= range;

			//////////

			// $scope.alphaNumeric = $scope.rangEd.concat($scope.range);
			// $scope.alphaNumeric = $scope.dani.concat($scope.range2);
			// $scope.alphaNumeric = $scope.range.concat($scope.range2);


			$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
			$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range);



			$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
					{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
					{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
					{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
					{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
							//pageMargins [left, top, right, bottom]
							doc.pageMargins = [ 140, 40, 10, 50 ];
							doc.alignment = 'center';

						}},
				]
			).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});



		}




















	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	/////////// TABLES X 4 A 10 AÑOS ////////////


	if($scope.infoLote.meses >=48 && $scope.infoLote.meses <=120 ) {

		var range=[];

		ini = ($scope.mesesdiferir > 0) ? $scope.mesesdiferir : $scope.infoLote.contadorInicial;


		if($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <=35) {

			for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {

				if(mes == 13){
					mes = '01';
					yearc++;
				}


				if(mes == 2){
					mes = '02';
				}
				if(mes == 3){
					mes = '03';
				}
				if(mes == 4){
					mes = '04';
				}
				if(mes == 5){
					mes = '05';
				}
				if(mes == 6){
					mes = '06';
				}
				if(mes == 7){
					mes = '07';
				}
				if(mes == 8){
					mes = '08';
				}
				if(mes == 9){
					mes = '09';
				}
				if(mes == 10){
					mes = '10';
				}
				if(mes == 11){
					mes = '11';
				}
				if(mes == 12){
					mes = '12';
				}


				$scope.dateCf = day + '-' + mes + '-' + yearc;

				if(i == 0){
					$scope.fechaPM = $scope.dateCf;
				}

				range.push({

					"fecha" : $scope.dateCf,
					"pago" : i + 1,
					"capital" : $scope.infoLote.capital,
					"interes" : 0,
					"total" : $scope.infoLote.capital + $scope.infoLote.interes_p1,
					"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,

				});
				mes++;

				if (i == ($scope.infoLote.mesesSinInteresP1 - 1)){
					$scope.total2 = $scope.infoLote.precioTotal;
					$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;

				}
				$scope.finalMesesp1 = (range.length);
				ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;

			}
			$scope.range= range;

			//////////

			$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);

			var range2=[];


			for (var i = ini2; i < $scope.infoLote.meses; i++) {

				if(mes == 13){
					mes = '01';
					yearc++;
				}

				if(mes == 2){
					mes = '02';
				}
				if(mes == 3){
					mes = '03';
				}
				if(mes == 4){
					mes = '04';
				}
				if(mes == 5){
					mes = '05';
				}
				if(mes == 6){
					mes = '06';
				}
				if(mes == 7){
					mes = '07';
				}
				if(mes == 8){
					mes = '08';
				}
				if(mes == 9){
					mes = '09';
				}
				if(mes == 10){
					mes = '10';
				}
				if(mes == 11){
					mes = '11';
				}
				if(mes == 12){
					mes = '12';
				}


				$scope.dateCf = day + '-' + mes + '-' + yearc;


				$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
				$scope.capital2 = ($scope.p2 - $scope.interes_plan2);

				range2.push({

					"fecha" : $scope.dateCf,
					"pago" : i + 1,
					"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
					"interes" : ($scope.interes_plan2= ($scope.total2 * $scope.infoLote.interes_p2)),
					"total" : $scope.p2,
					"saldo" : ($scope.total2 = ($scope.total2 -$scope.capital2)),

				});

				mes++;

				if (i == ($scope.infoLote.meses - 1)){
					$scope.totalSegundoPlan = $scope.p2;

				}
				$scope.finalMesesp2 = (range2.length);


			}
			$scope.range2= range2;



			$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
			$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2);

			// $scope.alphaNumeric = $scope.range.concat($scope.range2);



			$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
					{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
					{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
					{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
					{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
							//pageMargins [left, top, right, bottom]
							doc.pageMargins = [ 140, 40, 10, 50 ];
							doc.alignment = 'center';

						}},
				]
			).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});




		}


		if($scope.infoLote.mesesSinInteresP1 == 0) {

			$scope.infoLote.mesesSinInteresP1 = ($scope.mesesdiferir > 0) ? ($scope.infoLote.mesesSinInteresP1 + $scope.mesesdiferir) : ($scope.infoLote.mesesSinInteresP1);

			$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.infoLote.precioTotal)
				/ ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);

			var range2=[];

			for (var i = ini; i < $scope.infoLote.meses; i++) {

				if(mes == 13){
					mes = '01';
					yearc++;
				}

				if(mes == 2){
					mes = '02';
				}
				if(mes == 3){
					mes = '03';
				}
				if(mes == 4){
					mes = '04';
				}
				if(mes == 5){
					mes = '05';
				}
				if(mes == 6){
					mes = '06';
				}
				if(mes == 7){
					mes = '07';
				}
				if(mes == 8){
					mes = '08';
				}
				if(mes == 9){
					mes = '09';
				}
				if(mes == 10){
					mes = '10';
				}
				if(mes == 11){
					mes = '11';
				}
				if(mes == 12){
					mes = '12';
				}


				$scope.dateCf = day + '-' + mes + '-' + yearc;

				$scope.interes_plan2 = $scope.infoLote.precioTotal * ($scope.infoLote.interes_p2);
				$scope.capital2 = ($scope.p2 - $scope.interes_plan2);

				range2.push({

					"fecha" : $scope.dateCf,
					"pago" : i + 1,
					"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
					"interes" : ($scope.interes_plan2= ($scope.infoLote.precioTotal * $scope.infoLote.interes_p2)),
					"total" : $scope.p2,
					"saldo" : ($scope.infoLote.precioTotal = ($scope.infoLote.precioTotal -$scope.capital2)),

				});
				mes++;

				if (i == ($scope.infoLote.meses - 1)){
					$scope.totalSegundoPlan = $scope.p2;

				}
				$scope.finalMesesp2 = (range2.length);
			}
			$scope.range2= range2;



			$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
			$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range2);

			// $scope.alphaNumeric = $scope.range2;



			$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
					{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
					{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
					{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
					{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
							//pageMargins [left, top, right, bottom]
							doc.pageMargins = [ 140, 40, 10, 50 ];
							doc.alignment = 'center';

						}},
				]
			).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});



		}





		if($scope.infoLote.mesesSinInteresP1 == 36) {

			for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {

				if(mes == 13){
					mes = '01';
					yearc++;
				}


				if(mes == 2){
					mes = '02';
				}
				if(mes == 3){
					mes = '03';
				}
				if(mes == 4){
					mes = '04';
				}
				if(mes == 5){
					mes = '05';
				}
				if(mes == 6){
					mes = '06';
				}
				if(mes == 7){
					mes = '07';
				}
				if(mes == 8){
					mes = '08';
				}
				if(mes == 9){
					mes = '09';
				}
				if(mes == 10){
					mes = '10';
				}
				if(mes == 11){
					mes = '11';
				}
				if(mes == 12){
					mes = '12';
				}


				$scope.dateCf = day + '-' + mes + '-' + yearc;

				if(i == 0){
					$scope.fechaPM = $scope.dateCf;
				}

				range.push({

					"fecha" : $scope.dateCf,
					"pago" : i + 1,
					"capital" : $scope.infoLote.capital,
					"interes" : 0,
					"total" : $scope.infoLote.capital + $scope.infoLote.interes_p1,
					"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,

				});
				mes++;

				if (i == ($scope.infoLote.mesesSinInteresP1 - 1)){
					$scope.total2 = $scope.infoLote.precioTotal;
					$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;

				}
				$scope.finalMesesp1 = (range.length);
				ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;

			}
			$scope.range= range;

//////////

			$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);

			var range2=[];


			for (var i = ini2; i < $scope.infoLote.meses; i++) {

				if(mes == 13){
					mes = '01';
					yearc++;
				}

				if(mes == 2){
					mes = '02';
				}
				if(mes == 3){
					mes = '03';
				}
				if(mes == 4){
					mes = '04';
				}
				if(mes == 5){
					mes = '05';
				}
				if(mes == 6){
					mes = '06';
				}
				if(mes == 7){
					mes = '07';
				}
				if(mes == 8){
					mes = '08';
				}
				if(mes == 9){
					mes = '09';
				}
				if(mes == 10){
					mes = '10';
				}
				if(mes == 11){
					mes = '11';
				}
				if(mes == 12){
					mes = '12';
				}


				$scope.dateCf = day + '-' + mes + '-' + yearc;


				$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
				$scope.capital2 = ($scope.p2 - $scope.interes_plan2);

				range2.push({

					"fecha" : $scope.dateCf,
					"pago" : i + 1,
					"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
					"interes" : ($scope.interes_plan2= ($scope.total2 * $scope.infoLote.interes_p2)),
					"total" : $scope.p2,
					"saldo" : ($scope.total2 = ($scope.total2 -$scope.capital2)),

				});

				mes++;

				if (i == ($scope.infoLote.meses - 1)){
					$scope.totalSegundoPlan = $scope.p2;

				}
				$scope.finalMesesp2 = (range2.length);


			}
			$scope.range2= range2;



			$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
			$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2);

			// $scope.alphaNumeric = $scope.range.concat($scope.range2);



			$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
					{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
					{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
					{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
					{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
//pageMargins [left, top, right, bottom]
							doc.pageMargins = [ 140, 40, 10, 50 ];
							doc.alignment = 'center';

						}},
				]
			).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});




		}










	}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/////////// TABLES X 11 A 15 AÑOS ////////////



	if($scope.infoLote.meses >= 132 && $scope.infoLote.meses <= 240) {

		var range=[];

		ini = ($scope.mesesdiferir > 0) ? $scope.mesesdiferir : $scope.infoLote.contadorInicial;

		if($scope.infoLote.mesesSinInteresP1 > 0 && $scope.infoLote.mesesSinInteresP1 <=35) {


			for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {

				if(mes == 13){
					mes = '01';
					yearc++;
				}



				if(mes == 2){
					mes = '02';
				}
				if(mes == 3){
					mes = '03';
				}
				if(mes == 4){
					mes = '04';
				}
				if(mes == 5){
					mes = '05';
				}
				if(mes == 6){
					mes = '06';
				}
				if(mes == 7){
					mes = '07';
				}
				if(mes == 8){
					mes = '08';
				}
				if(mes == 9){
					mes = '09';
				}
				if(mes == 10){
					mes = '10';
				}
				if(mes == 11){
					mes = '11';
				}
				if(mes == 12){
					mes = '12';
				}


				$scope.dateCf = day + '-' + mes + '-' + yearc;

				if(i == 0){
					$scope.fechaPM = $scope.dateCf;
				}


				range.push({

					"fecha" : $scope.dateCf,
					"pago" : i + 1,
					"capital" : $scope.infoLote.capital,
					"interes" : 0,
					"total" : $scope.infoLote.capital + $scope.infoLote.interes_p1,
					"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,

				});
				mes++;

				if (i == ($scope.infoLote.mesesSinInteresP1 - 1)){
					$scope.total2 = $scope.infoLote.precioTotal;
					$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;


				}
				ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
				$scope.finalMesesp1 = (range.length);

			}
			$scope.range= range;

			//////////

			$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);

			var range2=[];

			for (var i = ini2; i < 120; i++) {

				if(mes == 13){
					mes = '01';
					yearc++;
				}

				if(mes == 2){
					mes = '02';
				}
				if(mes == 3){
					mes = '03';
				}
				if(mes == 4){
					mes = '04';
				}
				if(mes == 5){
					mes = '05';
				}
				if(mes == 6){
					mes = '06';
				}
				if(mes == 7){
					mes = '07';
				}
				if(mes == 8){
					mes = '08';
				}
				if(mes == 9){
					mes = '09';
				}
				if(mes == 10){
					mes = '10';
				}
				if(mes == 11){
					mes = '11';
				}
				if(mes == 12){
					mes = '12';
				}


				$scope.dateCf = day + '-' + mes + '-' + yearc;


				$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
				$scope.capital2 = ($scope.p2 - $scope.interes_plan2);

				range2.push({

					"fecha" : $scope.dateCf,
					"pago" : i + 1,
					"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
					"interes" : ($scope.interes_plan2= ($scope.total2 * $scope.infoLote.interes_p2)),
					"total" : $scope.p2,
					"saldo" : ($scope.total2 = ($scope.total2 -$scope.capital2)),

				});
				mes++;


				if (i == 119){
					$scope.total3 = $scope.total2;
					$scope.totalSegundoPlan = $scope.p2;

				}
				$scope.finalMesesp2 = (range2.length);

			}
			$scope.range2= range2;



			//////////



			$scope.p3 = ($scope.infoLote.interes_p3 *  Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120) * $scope.total3) / ( Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120)-1);


			var range3=[];

			for (var i = 121; i < $scope.infoLote.meses + 1; i++) {

				if(mes == 13){
					mes = '01';
					yearc++;
				}

				if(mes == 2){
					mes = '02';
				}
				if(mes == 3){
					mes = '03';
				}
				if(mes == 4){
					mes = '04';
				}
				if(mes == 5){
					mes = '05';
				}
				if(mes == 6){
					mes = '06';
				}
				if(mes == 7){
					mes = '07';
				}
				if(mes == 8){
					mes = '08';
				}
				if(mes == 9){
					mes = '09';
				}
				if(mes == 10){
					mes = '10';
				}
				if(mes == 11){
					mes = '11';
				}
				if(mes == 12){
					mes = '12';
				}

				$scope.dateCf = day + '-' + mes + '-' + yearc;



				$scope.interes_plan3 = $scope.total3*($scope.infoLote.interes_p3);
				$scope.capital2 = ($scope.p3 - $scope.interes_plan3);

				range3.push({

					"fecha" : $scope.dateCf,
					"pago" : i,
					"capital" : ($scope.capital2 = ($scope.p3 - $scope.interes_plan3)),
					"interes" : ($scope.interes_plan3= ($scope.total3 * $scope.infoLote.interes_p3)),
					"total" : $scope.p3,
					"saldo" : ($scope.total3 = ($scope.total3 -$scope.capital2)),

				});
				mes++;


				if (i == 122){
					$scope.totalTercerPlan = $scope.p3;

				}
				$scope.finalMesesp3 = (range3.length);

			}

			$scope.range3= range3;

			$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
			$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2).concat($scope.range3);

			// $scope.alphaNumeric = $scope.range.concat($scope.range2).concat($scope.range3);

			$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
					{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
					{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
					{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
					{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
							//pageMargins [left, top, right, bottom]
							doc.pageMargins = [ 140, 40, 10, 50 ];
							doc.alignment = 'center';

						}},
				]
			).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});


		}





		if($scope.infoLote.mesesSinInteresP1 == 0) {

			$scope.infoLote.mesesSinInteresP1 = ($scope.mesesdiferir > 0) ? ($scope.infoLote.mesesSinInteresP1 + $scope.mesesdiferir) : ($scope.infoLote.mesesSinInteresP1);

			$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.infoLote.precioTotal)
				/ ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);

			var range2=[];

			for (var i = ini; i < 120; i++) {

				if(mes == 13){
					mes = '01';
					yearc++;
				}

				if(mes == 2){
					mes = '02';
				}
				if(mes == 3){
					mes = '03';
				}
				if(mes == 4){
					mes = '04';
				}
				if(mes == 5){
					mes = '05';
				}
				if(mes == 6){
					mes = '06';
				}
				if(mes == 7){
					mes = '07';
				}
				if(mes == 8){
					mes = '08';
				}
				if(mes == 9){
					mes = '09';
				}
				if(mes == 10){
					mes = '10';
				}
				if(mes == 11){
					mes = '11';
				}
				if(mes == 12){
					mes = '12';
				}


				$scope.dateCf = day + '-' + mes + '-' + yearc;

				$scope.interes_plan2 = $scope.infoLote.precioTotal * ($scope.infoLote.interes_p2);
				$scope.capital2 = ($scope.p2 - $scope.interes_plan2);

				range2.push({

					"fecha" : $scope.dateCf,
					"pago" : i + 1,
					"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
					"interes" : ($scope.interes_plan2= ($scope.infoLote.precioTotal * $scope.infoLote.interes_p2)),
					"total" : $scope.p2,
					"saldo" : ($scope.infoLote.precioTotal = ($scope.infoLote.precioTotal -$scope.capital2)),

				});
				mes++;

				if (i == 119){
					$scope.total3 = $scope.infoLote.precioTotal;
					$scope.totalSegundoPlan = $scope.p2;

				}
				$scope.finalMesesp2 = (range2.length);

			}
			$scope.range2= range2;



			//////////

			$scope.p3 = ($scope.infoLote.interes_p3 *  Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120) * $scope.total3) / ( Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120)-1);

			var range3=[];

			for (var i = 121; i < $scope.infoLote.meses + 1; i++) {

				if(mes == 13){
					mes = '01';
					yearc++;
				}

				if(mes == 2){
					mes = '02';
				}
				if(mes == 3){
					mes = '03';
				}
				if(mes == 4){
					mes = '04';
				}
				if(mes == 5){
					mes = '05';
				}
				if(mes == 6){
					mes = '06';
				}
				if(mes == 7){
					mes = '07';
				}
				if(mes == 8){
					mes = '08';
				}
				if(mes == 9){
					mes = '09';
				}
				if(mes == 10){
					mes = '10';
				}
				if(mes == 11){
					mes = '11';
				}
				if(mes == 12){
					mes = '12';
				}

				$scope.dateCf = day + '-' + mes + '-' + yearc;



				$scope.interes_plan3 = $scope.total3*($scope.infoLote.interes_p3);
				$scope.capital2 = ($scope.p3 - $scope.interes_plan3);

				range3.push({

					"fecha" : $scope.dateCf,
					"pago" : i,
					"capital" : ($scope.capital2 = ($scope.p3 - $scope.interes_plan3)),
					"interes" : ($scope.interes_plan3= ($scope.total3 * $scope.infoLote.interes_p3)),
					"total" : $scope.p3,
					"saldo" : ($scope.total3 = ($scope.total3 -$scope.capital2)),

				});
				mes++;


				if (i == 122){
					$scope.totalTercerPlan = $scope.p3;

				}
				$scope.finalMesesp3 = (range3.length);

			}

			$scope.range3= range3;


			$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
			$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range2).concat($scope.range3);

			//$scope.alphaNumeric = $scope.range2.concat($scope.range3);



			$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
					{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
					{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
					{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
					{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
							//pageMargins [left, top, right, bottom]
							doc.pageMargins = [ 140, 40, 10, 50 ];
							doc.alignment = 'center';

						}},
				]
			).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});





		}




		if($scope.infoLote.mesesSinInteresP1 == 36) {


			for (var i = ini; i < $scope.infoLote.mesesSinInteresP1; i++) {

				if(mes == 13){
					mes = '01';
					yearc++;
				}



				if(mes == 2){
					mes = '02';
				}
				if(mes == 3){
					mes = '03';
				}
				if(mes == 4){
					mes = '04';
				}
				if(mes == 5){
					mes = '05';
				}
				if(mes == 6){
					mes = '06';
				}
				if(mes == 7){
					mes = '07';
				}
				if(mes == 8){
					mes = '08';
				}
				if(mes == 9){
					mes = '09';
				}
				if(mes == 10){
					mes = '10';
				}
				if(mes == 11){
					mes = '11';
				}
				if(mes == 12){
					mes = '12';
				}


				$scope.dateCf = day + '-' + mes + '-' + yearc;

				if(i == 0){
					$scope.fechaPM = $scope.dateCf;
				}


				range.push({

					"fecha" : $scope.dateCf,
					"pago" : i + 1,
					"capital" : $scope.infoLote.capital,
					"interes" : 0,
					"total" : $scope.infoLote.capital + $scope.infoLote.interes_p1,
					"saldo" : $scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,

				});
				mes++;

				if (i == ($scope.infoLote.mesesSinInteresP1 - 1)){
					$scope.total2 = $scope.infoLote.precioTotal;
					$scope.totalPrimerPlan = $scope.infoLote.capital + $scope.infoLote.interes_p1;


				}
				ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
				$scope.finalMesesp1 = (range.length);

			}
			$scope.range= range;

			//////////

			$scope.p2 = ($scope.infoLote.interes_p2 *  Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoLote.interes_p2, $scope.infoLote.meses - $scope.infoLote.mesesSinInteresP1 )-1);

			var range2=[];

			for (var i = ini2; i < 120; i++) {

				if(mes == 13){
					mes = '01';
					yearc++;
				}

				if(mes == 2){
					mes = '02';
				}
				if(mes == 3){
					mes = '03';
				}
				if(mes == 4){
					mes = '04';
				}
				if(mes == 5){
					mes = '05';
				}
				if(mes == 6){
					mes = '06';
				}
				if(mes == 7){
					mes = '07';
				}
				if(mes == 8){
					mes = '08';
				}
				if(mes == 9){
					mes = '09';
				}
				if(mes == 10){
					mes = '10';
				}
				if(mes == 11){
					mes = '11';
				}
				if(mes == 12){
					mes = '12';
				}


				$scope.dateCf = day + '-' + mes + '-' + yearc;


				$scope.interes_plan2 = $scope.total2*($scope.infoLote.interes_p2);
				$scope.capital2 = ($scope.p2 - $scope.interes_plan2);

				range2.push({

					"fecha" : $scope.dateCf,
					"pago" : i + 1,
					"capital" : ($scope.capital2 = ($scope.p2 - $scope.interes_plan2)),
					"interes" : ($scope.interes_plan2= ($scope.total2 * $scope.infoLote.interes_p2)),
					"total" : $scope.p2,
					"saldo" : ($scope.total2 = ($scope.total2 -$scope.capital2)),

				});
				mes++;


				if (i == 119){
					$scope.total3 = $scope.total2;
					$scope.totalSegundoPlan = $scope.p2;

				}
				$scope.finalMesesp2 = (range2.length);

			}
			$scope.range2= range2;



			//////////



			$scope.p3 = ($scope.infoLote.interes_p3 *  Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120) * $scope.total3) / ( Math.pow(1 + $scope.infoLote.interes_p3, $scope.infoLote.meses - 120)-1);


			var range3=[];

			for (var i = 121; i < $scope.infoLote.meses + 1; i++) {

				if(mes == 13){
					mes = '01';
					yearc++;
				}

				if(mes == 2){
					mes = '02';
				}
				if(mes == 3){
					mes = '03';
				}
				if(mes == 4){
					mes = '04';
				}
				if(mes == 5){
					mes = '05';
				}
				if(mes == 6){
					mes = '06';
				}
				if(mes == 7){
					mes = '07';
				}
				if(mes == 8){
					mes = '08';
				}
				if(mes == 9){
					mes = '09';
				}
				if(mes == 10){
					mes = '10';
				}
				if(mes == 11){
					mes = '11';
				}
				if(mes == 12){
					mes = '12';
				}

				$scope.dateCf = day + '-' + mes + '-' + yearc;



				$scope.interes_plan3 = $scope.total3*($scope.infoLote.interes_p3);
				$scope.capital2 = ($scope.p3 - $scope.interes_plan3);

				range3.push({

					"fecha" : $scope.dateCf,
					"pago" : i,
					"capital" : ($scope.capital2 = ($scope.p3 - $scope.interes_plan3)),
					"interes" : ($scope.interes_plan3= ($scope.total3 * $scope.infoLote.interes_p3)),
					"total" : $scope.p3,
					"saldo" : ($scope.total3 = ($scope.total3 -$scope.capital2)),

				});
				mes++;


				if (i == 122){
					$scope.totalTercerPlan = $scope.p3;

				}
				$scope.finalMesesp3 = (range3.length);

			}

			$scope.range3= range3;

			$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
			$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2).concat($scope.range3);

			// $scope.alphaNumeric = $scope.range.concat($scope.range2).concat($scope.range3);

			$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
					{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
					{extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir', titleAttr: 'Imprimir'},
					{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
					{extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF', titleAttr: 'PDF', title: '', customize: function(doc) {
							//pageMargins [left, top, right, bottom]
							doc.pageMargins = [ 140, 40, 10, 50 ];
							doc.alignment = 'center';

						}},
				]
			).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});


		}


	}

}
/*
*
*
*
*                                             for(var n=0; n<posicionPago ; n++)
                                            {
                                                if($scope.alphaNumeric[n]['disp'] == 0 || $scope.alphaNumeric[n]['disp']=="0" )
                                                {
                                                    if($scope.alphaNumeric[n]['pago']<posicionPago)
                                                    {
                                                        console.log($scope.alphaNumeric[n]['pago']);
                                                        newSaldoTable = alphaOriginal[n]['saldo'];//alphaOriginal[n]['saldo']
                                                        console.log("este es el saldo " + alphaOriginal[n]['saldo'] + " en " + n)
                                                    }
                                                }
                                            }
                                            * */
