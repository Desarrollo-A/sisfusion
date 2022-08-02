/**/

function calculoMoratorioII(IM, importeSaldoI, posPay, PositionPago, diasRetardo, saldoInsoluto, minVal, maxVal, arrayCheckAllPost)
{
	$scope.mesesdiferir = 0;
	//INICIO FECHA
	var day;
	var month = (new Date().getMonth() + 1);
	var yearc = new Date().getFullYear();


	if (month == 1){
		day = '0' + 1;
	}
	if (month == 2){
		day = '0'+ 1;
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
	var day;
	var month = (new Date().getMonth() + 1);
	var yearc = new Date().getFullYear();
//FIN FECHA
	var mes = (new Date().getMonth() + 1);//($scope.apartado && $scope.mesesdiferir > 0) ? (new Date().getMonth() + 2) : (new Date().getMonth() + 3)
	/*nuevooooo*/
	let fecha_input = new Date($scope.fechaField);
	let dayCorrect = (fecha_input.getDate() < 10) ? '0'+fecha_input.getDate() : fecha_input.getDate();
	day = dayCorrect;


	let monthCorrect = ((fecha_input.getMonth()+ 1) < 10) ? '0'+(fecha_input.getMonth()+ 1) : (fecha_input.getMonth()+ 1);
	let yearCorrect = (fecha_input.getFullYear());
	console.log('fecha_input: ', fecha_input);
	console.log('día: ', dayCorrect);

	mes = monthCorrect;
	yearc = yearCorrect;
	/*termina nuevooooo*/
	$scope.infoMoratorio=
		{
			plazo:$scope.plazoField,
			im:$scope.imField,
			si:saldoInsoluto,
			fechapago:$scope.fechaField,
			mesesSinInteresP1: $scope.msiField,
			mesesSinInteresP2: 120,
			contadorInicial: 	0,
			capital: ($scope.SIField/$scope.plazoField),
			interes_p1: 0,
			interes_p2: 0.01,
			interes_p3: 0.0125,
			saldoNormal:$scope.SIField,
			precioTotal: $scope.SIField,
		};
	// console.log($scope.infoMoratorio);
	/*cálculo de mensualidades*/
	if ($scope.infoMoratorio.plazo > 0 && $scope.infoMoratorio.plazo <= 36) {
		var range = [];
		ini = ($scope.mesesdiferir > 0) ? $scope.mesesdiferir : $scope.infoMoratorio.contadorInicial;
		if ($scope.infoMoratorio.plazo >= 0 && $scope.infoMoratorio.plazo <= 36) {
			for (var i = ini; i <= $scope.infoMoratorio.mesesSinInteresP1 - 1; i++) {
				if (mes == 13) {
					mes = '01';
					yearc++;
				}
				if (mes == 2) {
					mes = '02';
				}
				if (mes == 3) {
					mes = '03';
				}
				if (mes == 4) {
					mes = '04';
				}
				if (mes == 5) {
					mes = '05';
				}
				if (mes == 6) {
					mes = '06';
				}
				if (mes == 7) {
					mes = '07';
				}
				if (mes == 8) {
					mes = '08';
				}
				if (mes == 9) {
					mes = '09';
				}
				if (mes == 10) {
					mes = '10';
				}
				if (mes == 11) {
					mes = '11';
				}
				if (mes == 12) {
					mes = '12';
				}

				$scope.fechapago = day + '-' + mes + '-' + yearc;

				if (i == 0) {
					$scope.fechaPM = $scope.fechapago;
				}

				/*nuevo código 27  de noviembre*/
				var interes = 0;
				var total = 0;
				var capital = 0;
				var saldo = 0;
				var importe = 0;
				var diasRetraso = 0;
				var interesMoratorio = 0;
				var check = 0;
				if ($scope.infoMoratorio.mesesSinInteresP1 == 0) {
					/*Esto no hace nada jajaja xdxdxd*/
					interes = ($scope.interes_plan = ($scope.infoMoratorio.si * $scope.infoMoratorio.interes_p2));
					capital = ($scope.infoMoratorio.capital = (($scope.infoMoratorio.interes_p2 * Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1) * $scope.infoMoratorio.si) / (Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1) - 1) - $scope.interes_plan));
					total = ($scope.infoMoratorio.interes_p2 * Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1) * $scope.infoMoratorio.si) / (Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1) - 1);
					console.log("Entraste a meses 0");
				} else {
					if (arrayCheckAllPost.includes((i))) {
						console.log("Este número si está: " + i);
						check = 1;
					} else {
						check = 0;
						console.log("Entré aqui II");
					}
					// document.getElementsByName('dRet'+i)[0].click();
					capital = $scope.infoMoratorio.capital;
					interes = 0;
					total = $scope.infoMoratorio.capital + $scope.infoMoratorio.interes_p1;
					var deudaMoratorio;
					/*new part 21219*/
					var alphaOriginal = [];
					alphaOriginal = $scope.alphaNumeric;
					if ($scope.alphaNumeric[i]['disp'] != 1) {
						/*Para verfificar donde se puso el pago a capital*/
						var vuelta = (i + 1);
						var posicionPago = (posPay + 1);
						if (vuelta == posicionPago) {
							if (posicionPago == 1) {
								if ($scope.alphaNumeric[posPay]['check'] == 1)
								{
									/*si hay un check (osea que no está pagado) dejar el total*/
									total = $scope.alphaNumeric[posPay]['total'] = $scope.infoMoratorio.total;
									saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1000000;
								}
								else {
									var dispPC;
									/* Este if es para ver si se descuenta la primera posicion*/
									// newSaldoTable = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'];
									// interesMoratorio = $scope.alphaNumeric[posPay]['interesMoratorio'] = $scope.infoMoratorio.interesMoratorio=IM;// $scope.alphaNumeric[posPay]['interesMoratorio'] = IM;
									// console.log('se descuenta de la primera posicion');
									saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'];//$scope.alphaNumeric[posPay]['saldo']=saldoInsoluto-$scope.alphaNumeric[posPay]['total']
									importe = $scope.alphaNumeric[posPay]['importe'] = $scope.infoMoratorio.importe = importeSaldoI;//$scope.alphaNumeric[posPay]['importe']
									diasRetraso = $scope.alphaNumeric[posPay]['diasRetraso'] = $scope.infoMoratorio.diasRetraso = diasRetardo; //$scope.alphaNumeric[posPay]['diasRetraso']
									// console.log(saldo);
									if (IM > 0) {
										if ($scope.alphaNumeric[posPay]['disp'] != 0 || $scope.alphaNumeric[posPay]['disp'] == 1) {
											// console.log(IM);
											var provA = $scope.alphaNumeric[posPay]['importe'] - IM;
											// total = $scope.alphaNumeric[posPay]['total'] = $scope.infoMoratorio.total = interesMoratorio + total;
											if (provA > 0) {
												console.log("dejar");
												// resultado = $scope.alphaNumeric[posPay]['deudaMoratorio'] - provA;
												if($scope.alphaNumeric[posPay]['deudaMoratorio']<provA){
													resultado=provA-$scope.alphaNumeric[posPay]['deudaMoratorio'];
												}else{
													resultado=$scope.alphaNumeric[posPay]['deudaMoratorio']-provA;
												}
												total = resultado;//total = $scope.alphaNumeric[posPay]['total'] - provA
												// console.log(provA);
												saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = saldo - provA;//saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si =  saldo+$scope.alphaNumeric[posPay]['total'];
												interesMoratorio = $scope.alphaNumeric[i]['interesMoratorio'] = IM;
												$scope.alphaNumeric[i]['total'] = 0;
												// console.log("interes Moratoprio: " + $scope.alphaNumeric[i]['interesMoratorio']);
												// $scope.alphaNumeric[posPay]['interesMoratorio'] = 0;
												deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = 0;
											}
											else {
												console.log("dejar II");
												/*sí en la primera posición el interes moratorio es mayor que el imprte*/

												var positivNumbe = Math.abs(provA);
												saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = saldo;
												var decNum = positivNumbe.toFixed(2);
												total = $scope.alphaNumeric[posPay]['total'] = 0;
												interesMoratorio = IM;
												$scope.alphaNumeric[i]['interesMoratorio'] = positivNumbe;
												deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = positivNumbe;
												$('#resMoratorioAdeuto').val(positivNumbe);
												$('#resMoratorioAdeuto').click();
												// console.log("interes Moratoprio: " + $scope.alphaNumeric[i]['interesMoratorio']);
											}
											dispPC = $scope.alphaNumeric[posPay]['disp'] = 1; //$scope.alphaNumeric[posPay]['disp'] = 1;
										}
									}
								}
							}
							else {
								/* Este else es para ver si se descuenta apartir de la segunda posicion*/
								console.log("Segunda posicion");
								importe = $scope.infoMoratorio.importe = $scope.alphaNumeric[posPay]['importe'] = importeSaldoI;
								diasRetraso = $scope.infoMoratorio.diasRetraso = $scope.alphaNumeric[posPay]['diasRetraso'] = diasRetardo;
								dispPC = $scope.infoMoratorio.disp = $scope.alphaNumeric[posPay]['disp'] = 1;
								if (IM > 0) {
									/*if($scope.alphaNumeric[posPay]['disp']!=0 || $scope.alphaNumeric[posPay]['disp']==1)
                                    {*/
									/*st new*/

									if ($scope.alphaNumeric[posPay]['disp'] != 0 || $scope.alphaNumeric[posPay]['disp'] == 1) {
										// var adedudoSuma=0;
										// for(var m=0; m <= posPay ; m++)
										// {
										// 	console.log("ACONTINUACION: ");
										// 	console.log($scope.alphaNumeric);
										// 	// console.log("Checando punto: " + m);
										// 	// console.log("Deuda en la posicion " + m + ": " +  $scope.alphaNumeric[m]['deudaMoratorio']);
										// 	if($scope.alphaNumeric[m]['interesMoratorio'] != 0 && $scope.alphaNumeric[m]['deudaMoratorio'] !=0)
										// 	{
										// 		adedudoSuma+=$scope.alphaNumeric[m]['deudaMoratorio'];
										// 		console.log(m);
										// 		console.log($scope.alphaNumeric[m]['deudaMoratorio']);
										// 	}
										// }
										// adedudoSuma=adedudoSuma.toFixed(2);
										var provA = $scope.alphaNumeric[posPay]['importe'] - IM;
										var billMoratorio;
										if ($scope.alphaNumeric[posPay]['deudaMoratorio'] != undefined) {
											var cumuloMoratorio = $('#acumuladoBruto').val();
											billMoratorio = cumuloMoratorio - provA;
										} else {
											// var neg = provA;
											billMoratorio = (-provA);
											// billMoratorio = Math.sign(billMoratorio);
										}
										// console.log(suma);
										if (provA > 0) {
											//total = provA;//total = $scope.alphaNumeric[posPay]['total'] - provA//UPD 24 de ENERO
											// saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si =  saldo-provA;
											// $scope.alphaNumeric[posPay]['interesMoratorio'] = 0;
											// console.log("interes Moratoprio: " + $scope.alphaNumeric[posPay]['interesMoratorio']);
											// deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio']=0;
											// $('#resMoratorioAdeuto').val(0);
											// $('#resMoratorioAdeuto').click();
											// alert(billMoratorio);
											if (billMoratorio > 0) {
												if (billMoratorio > 0)//El pago(importe) no liquido la deuda y se sigue endeudando
												{
													//descontar a capital
													$('#acumuladoBruto').val(billMoratorio.toFixed(2));
													// alert("Aún hay una deuda " + $scope.alphaNumeric[i]['deudaMoratorio'] + " pv " + provA);
													$('#resMoratorioAdeuto').val(billMoratorio);
													$('#resMoratorioAdeuto').click();
													interesMoratorio = IM;
													$scope.alphaNumeric[i]['interesMoratorio'] = billMoratorio;
													total = $scope.alphaNumeric[i]['total'] = 0;
													deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'] = billMoratorio;
													// break;
													//148
												} else {
													/*for(var b=0; b < $scope.alphaNumeric.length; b++)
                                                    {

                                                        $scope.alphaNumeric[i]['interesMoratorio'] = IM;
                                                        $scope.alphaNumeric[i]['deudaMoratorio'] = 0;
                                                        // delete $scope.alphaNumeric[i]["deudaMoratorio"];
                                                    }*/
													var importeLibreCapital;
													//añadir adeudo a moratorio porque no se cubrio
													//El valor llega negativo ya que el importe alcanzó a subrir el adeudo moratorio
													if (billMoratorio < 0) {
														importeLibreCapital = Math.abs(billMoratorio);
													} else {
														importeLibreCapital = billMoratorio;
													}
													// console.log("CHECK DE CONTROL ALV: " + importeLibreCapital);
													// alert("Tu pago genera más adeudo: "  + $scope.alphaNumeric[i]['deudaMoratorio']);
													total = $scope.alphaNumeric[i]['total'] = importeLibreCapital;
													saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.alphaNumeric[posPay]['saldo'] - total;
													// console.log("Se genero este adeudo: " + billMoratorio);
													// for(var q=0; q<$scope.alphaNumeric.length; q++)
													// {
													// 	$scope.alphaNumeric[q]['deudaMoratorio'] =importeLibreCapital;
													// 	console.log("Despues de tratar todo la posición: " + q + "tiene este adeudo:");
													// 	console.log($scope.alphaNumeric[q]['deudaMoratorio']);
													// }
												}
											} else {
												// alert("Liquidaste tu deuda ok");

												//cuando no hay adeudo pasa directamenta a descontar al capital
												//El valor llega negativo ya que no hay un adeudo y pasa negativo el restante (Importe-IM)
												var abonoLibre = Math.abs(billMoratorio);
												// alert("En este pago no hay un adeudo pendiente >> next" + provA + " : " + abonoLibre + " : " + billMoratorio);
												total = $scope.alphaNumeric[posPay]['total'] = abonoLibre;//pasalo a positivo
												saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.alphaNumeric[posPay]['saldo'] - abonoLibre;
												// deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = 0;
												interesMoratorio = IM;
												$('#resMoratorioAdeuto').val(0);
												$('#resMoratorioAdeuto').click();
												$('#acumuladoBruto').val(0);
												for (var b = 0; b < $scope.alphaNumeric.length; b++) {
													console.log(posPay + " <--pospay-postionB--> " + b);
													if (b >= posPay) {
														$scope.alphaNumeric[b]['interesMoratorio'] = 0;
														$scope.alphaNumeric[b]['deudaMoratorio'] = 0;
													} else {
														interesMoratorio = $scope.alphaNumeric[b]['interesMoratorio'] = IM;
														// $scope.alphaNumeric[i]['deudaMoratorio'] = positivNumbe;
														deudaMoratorio = $scope.alphaNumeric[b]['deudaMoratorio'] = 0;
													}
													console.log(b);
													console.log($scope.alphaNumeric[b]['deudaMoratorio']);
													console.log($scope.alphaNumeric[b]['interesMoratorio']);
												}
											}
										} else {	/*sí en la primera posición el interes moratorio es mayor que el imprte*/
											//Acumulacion de adeudos
											console.log("from else: " + provA);
											// break;
											var positivNumbe = Math.abs(provA);
											var decNum = positivNumbe.toFixed(2);
											//Se le setea 0 al total ya que no abono nada a la capital, genero más adeudo el moratorio
											total = $scope.alphaNumeric[i]['total'] = 0;
											saldo = $scope.alphaNumeric[i]['saldo'];

											interesMoratorio = IM;
											deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'] = positivNumbe;

											// console.log("IM " + IM);
											var sumAdeudos = 0;
											for (var b = 0; b < $scope.alphaNumeric.length; b++) {
												console.log(posPay + " <--pospay - postionB --> " + b);
												if (posPay != b) {
													$scope.alphaNumeric[i]['interesMoratorio'] = 0;
													$scope.alphaNumeric[i]['deudaMoratorio'] = 0;
													// delete $scope.alphaNumeric[i]["deudaMoratorio"];
													// delete $scope.alphaNumeric[i]["interesMoratorio"];
													// delete $scope.alphaNumeric[i]["deudaMoratorio"];
												} else {
													interesMoratorio = $scope.alphaNumeric[b]['interesMoratorio'] = IM;
													// $scope.alphaNumeric[i]['deudaMoratorio'] = positivNumbe;
													deudaMoratorio = $scope.alphaNumeric[b]['deudaMoratorio'] = positivNumbe;
												}
												//
												// console.log(b);
												console.log($scope.alphaNumeric[b]['deudaMoratorio']);
												console.log($scope.alphaNumeric[b]['interesMoratorio']);
												if ($scope.alphaNumeric[b]['deudaMoratorio'] != undefined && $scope.alphaNumeric[b]['interesMoratorio'] != 0) {
													sumAdeudos += $scope.alphaNumeric[b]['deudaMoratorio'];
												}
											}
											console.log("Suma total de valores: " + sumAdeudos);
											$('#acumuladoBruto').val(sumAdeudos.toFixed(2));
											/*setear el valor al input de prueba*/
											$('#resMoratorioAdeuto').val(sumAdeudos);
											$('#resMoratorioAdeuto').click();
											/*simular el click para que se detone el evento y le de formato de money*/
											document.getElementById('resMoratorioAdeuto').click();
											console.log($scope.alphaNumeric);
											// alert("Llegue aqui");
											// var chMD=$('#acumuladoBruto').val();
											// if(chMD == 0 || chMD =="")
											// {
											// 	deudaMoratorio = $scope.alphaNumeric[b]['deudaMoratorio'] = 0;
											// 	// delete $scope.alphaNumeric[g]["deudaMoratorio"];
											// 	// sumAdeudos=0;
											// }
										}
										dispPC = $scope.alphaNumeric[posPay]['disp'] = 1; //$scope.alphaNumeric[posPay]['disp'] = 1;
										saldo = $scope.alphaNumeric[i]['saldo'];
									}

									/*end new*/

									// console.log("Adeudos hasta este punto: " + $scope.alphaNumeric[x]['deudaMoratorio']);
								}
							}
						}
						else {
							// var saldoNormal =  $scope.infoMoratorio.precioTotal = $scope.infoMoratorio.precioTotal - $scope.infoMoratorio.capital;
							if ($scope.alphaNumeric[posPay]['interesMoratorio'] == 0)/*posionPago*/
							{/*Hace el calculo cuando es apartir de la tercera posición*/
								// newSaldoTable = $scope.infoMoratorio.si = $scope.infoMoratorio.si - $scope.infoMoratorio.capital;
								// saldo =  $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si=($scope.infoMoratorio.si-$scope.alphaNumeric[posPay]['total'])
								dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
								importe = $scope.alphaNumeric[posPay]['importe'] = 0;
								diasRetraso = $scope.alphaNumeric[posPay]['diasRetraso'] = 0;
								interesMoratorio = $scope.alphaNumeric[i]['interesMoratorio'] = 0;
								deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'] = 0;
								if ($scope.alphaNumeric[posPay]['importe'] == 0 && $scope.alphaNumeric[posPay]['diasRetraso'] == 0) {
									if ($scope.alphaNumeric[i]['pago'] > posicionPago) {
										saldo = $scope.alphaNumeric[posPay]['saldo'];//saldo =  $scope.infoMoratorio.si =(($scope.infoMoratorio.si-$scope.alphaNumeric[posPay]['total']) + $scope.alphaNumeric[posPay]['interesMoratorio']);
										deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'];
									} else {
										for (var x = 0; x < posicionPago; x++) {
											/*correcto*/
											//saldo=$scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];//$scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
											/*var target = angular.element(document.getElementById("#dRet" + x));
                                            if(document.getElementsByName("dRet"+(i+1))[0].value =="")//document.getElementsByName("dRet"+(i+1))[0].value ==""
                                            {
                                                saldo=$scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];//$scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
                                            }
                                            else
                                            {
                                                saldo=$scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];//$scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
                                            }*/
											/*En esta parte se le adigna el saldo a la posicion que noha sido afectada*/
											/*UPD actualizacion 24 ENERO, se coloca el saldo de la posicion anterior ya que se
                                            * descontara conforme a lo que se vaya dando (abonos a capital)*/
											saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];//$scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
											deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'] = 0;

										}
									}
								} else {
									saldo = $scope.infoMoratorio.si = $scope.infoMoratorio.si - $scope.alphaNumeric[posPay]['total'];//saldo =  $scope.infoMoratorio.si =$scope.infoMoratorio.si-$scope.alphaNumeric[posPay]['total']
									deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'] = 0;
								}
							} else {
								if ($scope.alphaNumeric[posPay]['pago'] >= posicionPago || $scope.alphaNumeric[posPay]['pago'] <= posicionPago) {
									if ($scope.alphaNumeric[posicionPago]['disp'] == 1) {
										/*aqui se coloca cuando se hay pagos abajo del nuevo, ejemplo Pago 5:550 y se quiere colocar uno en el 2*/
										dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
										saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'];
										importe = $scope.alphaNumeric[posPay]['importe'] = $scope.alphaNumeric[posPay]['importe'];
										diasRetraso = $scope.alphaNumeric[posPay]['diasRetraso'] = $scope.alphaNumeric[posPay]['diasRetraso'];
										interesMoratorio = $scope.alphaNumeric[posPay]['interesMoratorio'] = $scope.alphaNumeric[posPay]['interesMoratorio'];
									} else {/*se coloca un valor cuando nohay nada(el resto de los campos, apartir de la segunda posicion, else de la primera posicion*/
										// newSaldoTable = $scope.infoMoratorio. si = $scope.infoMoratorio.si - $scope.infoMoratorio.capital;
										saldo = $scope.alphaNumeric[posPay]['saldo'];//saldo = $scope.infoMoratorio.si = (($scope.infoMoratorio.si-$scope.alphaNumeric[(posPay)]['total']))
										dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
										//saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo']
										deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'] = $scope.alphaNumeric[i]['deudaMoratorio'];
									}
								} else {
									/*cuando se salta un espacio en la tabla*/
									saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1;
									deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'];
								}
							}
						}
						range.push({
							"fecha": $scope.fechapago,
							"pago": i + 1,
							"capital": capital,
							"interes": interes,
							"importe": importe,
							"diasRetraso": diasRetraso,
							"interesMoratorio": interesMoratorio,
							"deudaMoratorio": deudaMoratorio,
							"total": total, //$scope.infoMoratorio.capital + $scope.infoMoratorio.interes_p1
							"saldo": saldo,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,
							"saldoNormal": $scope.alphaNumeric[i]['saldoNormal'],/*se coloca la misma informaición que al inicio para respetar la corrida financiera original*/
							"disp": dispPC,
							"min": minVal,
							"max": maxVal,
							"check": check
						});
					} else {
						/*Entra cuando te saltas espacios despues de la primera posicion*/
						range.push({
							"fecha": $scope.fechapago,
							"pago": i + 1,
							"capital": $scope.alphaNumeric[i]['capital'],
							"interes": $scope.alphaNumeric[i]['interes'],
							"importe": $scope.alphaNumeric[i]['importe'],
							"diasRetraso": $scope.alphaNumeric[i]['diasRetraso'],
							"interesMoratorio": $scope.alphaNumeric[i]['interesMoratorio'],
							"deudaMoratorio": $scope.alphaNumeric[i]['deudaMoratorio'],
							"total": $scope.alphaNumeric[i]['total'], //$scope.infoMoratorio.capital + $scope.infoMoratorio.interes_p1
							"saldo": $scope.alphaNumeric[i]['saldo'],//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
							"saldoNormal": $scope.alphaNumeric[i]['saldoNormal'],//$scope.alphaNumeric[i]['saldoNormal']
							"disp": $scope.alphaNumeric[i]['disp'],
							"check": $scope.alphaNumeric[i]['check']
						});
					}
				}
				mes++;

				if (i == ($scope.infoMoratorio.mesesSinInteresP1 - 1)) {

					$scope.total2 = saldo;//$scope.alphaNumeric[posPay]['saldo'] = $scope.alphaNumeric[posPay]['saldo']-$scope.alphaNumeric[posPay]['total']
					$scope.totalPrimerPlan = $scope.infoMoratorio.capital + $scope.infoMoratorio.interes_p1;
				}
				$scope.finalMesesp1 = range.length;
				ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
			}
			$scope.range = range;
			ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
			// console.log($scope.alphaNumeric);
			//////////
			// var siVal = document.getElementsByName("si"+posPay)[0].value
			// $scope.total2 = siVal;
			$scope.p2 = ($scope.infoMoratorio.interes_p2 * Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1) * $scope.total2) / (Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1) - 1);
			// alert($scope.total2);

			var range2 = [];
			for (var i = ini2; i < $scope.infoMoratorio.plazo; i++) {
				if (mes == 13) {
					mes = '01';
					yearc++;
				}
				if (mes == 2) {
					mes = '02';
				}
				if (mes == 3) {
					mes = '03';
				}
				if (mes == 4) {
					mes = '04';
				}
				if (mes == 5) {
					mes = '05';
				}
				if (mes == 6) {
					mes = '06';
				}
				if (mes == 7) {
					mes = '07';
				}
				if (mes == 8) {
					mes = '08';
				}
				/**/
				if (mes == 9) {
					mes = '09';
				}
				if (mes == 10) {
					mes = '10';
				}
				if (mes == 11) {
					mes = '11';
				}
				if (mes == 12) {
					mes = '12';
				}


				$scope.fechapago = day + '-' + mes + '-' + yearc;
				if (i == 0) {
					$scope.fechaPM = $scope.fechapago;
				}
				var interes = 0;
				var total = 0;
				var capital = 0;
				var saldo = 0;
				var importe = 0;
				var diasRetraso = 0;
				var interesMoratorio = 0;
				var check = 0;
				// if($scope.infoMoratorio.mesesSinInteresP1 == 0)
				// {
				// $scope.interes_plan2 = $scope.total2*($scope.infoMoratorio.interes_p2);

				interes = $scope.interes_plan2 = $scope.infoMoratorio.saldoNormal * $scope.infoMoratorio.interes_p2;
				// capital = $scope.capital2 = ($scope.p2 - $scope.interes_plan2);
				total = $scope.p2;
				var deudaMoratorio;
				/*new part 21219*/
				var alphaOriginal = [];
				alphaOriginal = $scope.alphaNumeric;
				if ($scope.alphaNumeric[i]['disp'] != 1) {
					/*Para verfificar donde se puso el pago a capital*/
					var vuelta = (i + 1);
					var posicionPago = (posPay + 1);
					if (vuelta == posicionPago) {
						if (posicionPago == 1) {
							/*
                            var dispPC;
                             // Este if es para ver si se descuenta la primera posicion
                            interesMoratorio = $scope.alphaNumeric[posPay]['interesMoratorio'] = $scope.infoMoratorio.interesMoratorio=IM;// $scope.alphaNumeric[posPay]['interesMoratorio'] = IM;
                            saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'];//saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si-$scope.alphaNumeric[posPay]['capital']
                            importe			= $scope.alphaNumeric[posPay]['importe'] = $scope.infoMoratorio.importe	= importeSaldoI;//$scope.alphaNumeric[posPay]['importe']
                            diasRetraso		= $scope.alphaNumeric[posPay]['diasRetraso'] = $scope.infoMoratorio.diasRetraso = diasRetardo; //$scope.alphaNumeric[posPay]['diasRetraso']
                            interes = $scope.alphaNumeric[posPay]['interes'];
                            capital = $scope.alphaNumeric[posPay]['capital'];
                            console.log(saldo);

                            console.log("I entered here, first position");
                            if(IM > 0)
                            {
                                if($scope.alphaNumeric[posPay]['disp']!=0 || $scope.alphaNumeric[posPay]['disp']==1)
                                {
                                    total = $scope.alphaNumeric[posPay]['total'] = $scope.infoMoratorio.total = interesMoratorio + total;
                                    saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si =  saldo;
                                    dispPC = $scope.alphaNumeric[posPay]['disp']=  1;
                                }
                            }*/
							/*new part*/
							var dispPC;
							// Este if es para ver si se descuenta la primera posicion

							//No se colocan el saldo e interesMoratorio ya que no se requiere mostrar cuando este no se adeude
							// interesMoratorio = $scope.alphaNumeric[posPay]['interesMoratorio'] = $scope.infoMoratorio.interesMoratorio=IM;// $scope.alphaNumeric[posPay]['interesMoratorio'] = IM;
							// saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'];//saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si-$scope.alphaNumeric[posPay]['capital']
							importe = $scope.alphaNumeric[posPay]['importe'] = $scope.infoMoratorio.importe = importeSaldoI;//$scope.alphaNumeric[posPay]['importe']
							diasRetraso = $scope.alphaNumeric[posPay]['diasRetraso'] = $scope.infoMoratorio.diasRetraso = diasRetardo; //$scope.alphaNumeric[posPay]['diasRetraso']
							interes = $scope.alphaNumeric[posPay]['interes'];
							capital = $scope.alphaNumeric[posPay]['capital'];

							if ($scope.alphaNumeric[posPay]['check'] == 1) {
								/*si hay un check (osea que no está pagado) dejar el total*/
								total = $scope.alphaNumeric[posPay]['total'] = $scope.infoMoratorio.total;
								saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1000000;
							} else {
								var positivNumbe;
								/* Este if es para ver si se descuenta la primera posicion*/
								// newSaldoTable = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'];
								// interesMoratorio = $scope.alphaNumeric[posPay]['interesMoratorio'] = $scope.infoMoratorio.interesMoratorio=IM;// $scope.alphaNumeric[posPay]['interesMoratorio'] = IM;
								// console.log('se descuenta de la primera posicion');
								saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'];//$scope.alphaNumeric[posPay]['saldo']=saldoInsoluto-$scope.alphaNumeric[posPay]['total']
								importe = $scope.alphaNumeric[posPay]['importe'] = $scope.infoMoratorio.importe = importeSaldoI;//$scope.alphaNumeric[posPay]['importe']
								diasRetraso = $scope.alphaNumeric[posPay]['diasRetraso'] = $scope.infoMoratorio.diasRetraso = diasRetardo; //$scope.alphaNumeric[posPay]['diasRetraso']
								// console.log(saldo);
								if (IM > 0) {
									if ($scope.alphaNumeric[posPay]['disp'] != 0 || $scope.alphaNumeric[posPay]['disp'] == 1) {
										console.log(IM);
										var provA = $scope.alphaNumeric[posPay]['importe'] - IM;
										// total = $scope.alphaNumeric[posPay]['total'] = $scope.infoMoratorio.total = interesMoratorio + total;
										if (provA > 0) {
											total = provA;//total = $scope.alphaNumeric[posPay]['total'] - provA
											saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = saldo - provA;

											$scope.alphaNumeric[i]['interesMoratorio'] = 0;
											$scope.alphaNumeric[i]['total'] = 0;
											deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = 0;
										} else {
											/*sí en la primera posición el interes moratorio es mayor que el imprte*/
											positivNumbe = Math.abs(provA);
											saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = saldo;
											total = $scope.alphaNumeric[posPay]['total'] = 0;
											var decNum = positivNumbe.toFixed(2);
											interesMoratorio = $scope.alphaNumeric[i]['interesMoratorio'] = positivNumbe;
											// console.log("interes Moratoprio: " + $scope.alphaNumeric[i]['interesMoratorio']);
											deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = positivNumbe;
										}
										dispPC = $scope.alphaNumeric[posPay]['disp'] = 1; //$scope.alphaNumeric[posPay]['disp'] = 1;
									}
								}
							}
							// console.log("check: " + positivNumbe);
							/*termina new part*/

						}
						else {/* Este else es para ver si se descuenta apartir de la segunda posicion*/
							console.log("Segunda posicion");
							console.log("SALDOÑÑ", saldo);

							var siVal = document.getElementsByName("si" + posPay)[0].value
							capital = $scope.alphaNumeric[i]['capital']; //$scope.capital2 = ($scope.p2 - $scope.interes_plan2);

							interes = $scope.alphaNumeric[i]['interes'];//$scope.alphaNumeric[posPay]['interes'] = siVal*$scope.infoMoratorio.interes_p2
							deudaOrdinario = 0;


							importe = $scope.infoMoratorio.importe = $scope.alphaNumeric[posPay]['importe'] = importeSaldoI;
							diasRetraso = $scope.infoMoratorio.diasRetraso = $scope.alphaNumeric[posPay]['diasRetraso'] = diasRetardo;
							dispPC = $scope.infoMoratorio.disp = $scope.alphaNumeric[posPay]['disp'] = 1;
							interesMoratorio = IM;
							if (IM > 0) {
								/*27DIC*/
								// alert('llegué aqui ' + IM);
								if ($scope.alphaNumeric[posPay]['saldo'] == $scope.alphaNumeric[posPay]['saldo']) {
									if (posPay == 0) {
										// alert('I');
										interes = $scope.alphaNumeric[(posPay)]['saldoNormal'] * $scope.infoMoratorio.interes_p2;//$scope.alphaNumeric.sal* $scope.infoMoratorio.interes_p2
										capital = 0;
									} else {
										// alert('II');
										// $scope.p2 = ($scope.infoMoratorio.interes_p2 *  Ma9th.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1) * $scope.alphaNumeric[(posPay-1)]['saldoNormal']) / ( Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1 )-1);
										interes = $scope.alphaNumeric[(posPay - 1)]['saldoNormal'] * $scope.infoMoratorio.interes_p2;//$scope.alphaNumeric.sal* $scope.infoMoratorio.interes_p2
										capital = $scope.alphaNumeric[i]['capital'];
									}
									// interes = $scope.alphaNumeric[(posPay-1)]['saldoNormal'] * $scope.infoMoratorio.interes_p2;//$scope.alphaNumeric.sal* $scope.infoMoratorio.interes_p2
									var provA = $scope.alphaNumeric[posPay]['importe'] - IM;
									if (provA > 0) {
										// alert("PROVA: " + provA + "===== DEUDA MORATORIO " +  $('#resMoratorioAdeuto').val());
										// console.log("Deudas de moratorios: " + $scope.alphaNumeric[posPay]['deudaMoratorio']);
										interesMoratorio = IM;
										/*newcode*/
										if ($scope.alphaNumeric[posPay]['deudaMoratorio'] >= 0 || $scope.alphaNumeric[posPay]['deudaMoratorio'] != "") {
											resultado = $scope.alphaNumeric[posPay]['deudaMoratorio'] - provA;
											// alert($scope.alphaNumeric[posPay]['deudaMoratorio']);
											// alert(provA);
											// saldo=$scope.infoMoratorio.si=$scope.alphaNumeric[x]['saldo']=$scope.alphaNumeric[x]['saldo'];
											console.log('Llegue a descontar a los adeudos moratorios');
											// var positivRes=Math.abs(resultado);
											if (resultado > 0) {
												console.log("Este debe de ser positivo: " + resultado);
												$('#resMoratorioAdeuto').val(resultado);
												$('#resMoratorioAdeuto').click();
												deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = resultado;
												total = $scope.alphaNumeric[posPay]['total'] = 0;
											} else {
												// console.log("Este dbe ser negativo: " + resultado);
												var abonoLimpio = Math.abs(resultado);
												$('#resMoratorioAdeuto').val(0);
												$('#resMoratorioAdeuto').click();
												deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = 0;
												// limpiaAdeudoMoratorio();
												console.log("Libres para abonar a capital: " + abonoLimpio);
												console.log("Interes para descontar en el abono limpio:", interes);
												total = 0;//total = $scope.alphaNumeric[posPay]['total'] + abonoLimpio
												// alert('Esto se debe descontar al interes ordinario ' + abonoLimpio);
												//vamoaver
												var intLessAbonoLimpio = interes - abonoLimpio;


												console.log('LOG: ' + intLessAbonoLimpio);
												var cumuloOrdinario = $('#resOrdinarioAdeuto').val();
												var deudaOrdinario;
												var deudaOrdinarioSuma;
												if (Math.sign(intLessAbonoLimpio) == 1)//si el numero es positivo
												{
													// alert('hanumaaaaaa MATH.SIGN');
													//si sale positivo es porque quedo interes por pagar
													deudaOrdinario = $scope.alphaNumeric[posPay]['deudaOrdinario'] = intLessAbonoLimpio;
													deudaOrdinarioSuma = sumaOrdinarios();
													$('#resOrdinarioAdeuto').val(deudaOrdinarioSuma);
													$('#resOrdinarioAdeuto').click();
													saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[x - 1]['saldo'];
												} else {
													deudaOrdinario = $scope.alphaNumeric[posPay]['deudaOrdinario'] = 0;

													//si sale negativo es porque quedo algo libre para capital
													// saldo=$scope.infoMoratorio.si=$scope.alphaNumeric[x]['saldo']=$scope.alphaNumeric[x]['saldo']-intLessAbonoLimpio;
													// alert(intLessAbonoLimpio + " MATH.ABS: " + Math.abs(intLessAbonoLimpio) + " deudaORD" + deudaOrdinario);
													// alert("PARA CAPITAL " + (Math.abs(intLessAbonoLimpio) - deudaOrdinarioSuma));
													/*VERIFICAR SI DIO NEGATIVO Y POSITIVO ALV, SI SALE NEGATIVO AUN QUEDA DEUDA, SI SALE POSITIVO QUEDA LIBRE*/
													var posintLessAbonoLimpio;
													deudaOrdinarioSuma = sumaOrdinarios();
													console.log("deudaOrdinarioSuma: ", deudaOrdinarioSuma);
													if (deudaOrdinarioSuma > 0) {
														posintLessAbonoLimpio = Math.abs(intLessAbonoLimpio) - deudaOrdinarioSuma;
													} else {
														posintLessAbonoLimpio = Math.abs(intLessAbonoLimpio);
													}
													console.log("posintLessAbonoLimpio: ", posintLessAbonoLimpio);


													if (posintLessAbonoLimpio >= 0) {
														// posintLessAbonoLimpio = Math.abs(posintLessAbonoLimpio);
														// if(sumaOrdinarios()>0)
														// {
														// 	posintLessAbonoLimpio = posintLessAbonoLimpio - sumaOrdinarios();
														// }
														$('#resOrdinarioAdeuto').val(0);
														$('#resOrdinarioAdeuto').click();
														limpiaAdeudoOrdinario();
														total = posintLessAbonoLimpio;
														saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[x]['saldo'] - posintLessAbonoLimpio;
														// alert('CHECKPOINT');
													} else {
														// posintLessAbonoLimpio = Math.abs(posintLessAbonoLimpio);
														// alert('AUN QUEDA DEUDA NEGATIVO ' + posintLessAbonoLimpio);
														$('#resOrdinarioAdeuto').val(posintLessAbonoLimpio);
														$('#resOrdinarioAdeuto').click();
														saldo = $scope.alphaNumeric[x]['saldo'];

													}


													/*var posintLessAbonoLimpio = Math.abs(intLessAbonoLimpio) - deudaOrdinarioSuma;
                                                    alert(posintLessAbonoLimpio);
                                                    posintLessAbonoLimpio = Math.abs(posintLessAbonoLimpio);
                                                    saldo=$scope.infoMoratorio.si=$scope.alphaNumeric[x]['saldo']=$scope.alphaNumeric[x]['saldo']-posintLessAbonoLimpio;
                                                    deudaOrdinario = $scope.alphaNumeric[posPay]['deudaOrdinario']=0;
                                                    limpiaAdeudoOrdinario();
                                                    total = posintLessAbonoLimpio;
                                                    $('#resOrdinarioAdeuto').val(0);
                                                    $('#resOrdinarioAdeuto').click();*/
												}
												//vamoaver
											}
											console.log("resultado tratado" + resultado);
											console.log(provA);
											console.log($scope.alphaNumeric[posPay]['deudaMoratorio']);
											console.log("SSSAAALDO", saldo);
										} else {
											// total = $scope.infoMoratorio.total =total-provA; /*orioginal de la funcion*/
											total = $scope.alphaNumeric[posPay]['total'] - provA;
											saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[x]['saldo'] = $scope.alphaNumeric[x]['saldo'] + provA;
											console.log('Llegue a NO descontar a los adeudos moratorios');
											interesMoratorio = IM;
										}
										/*exitcode*/
									} else {
										/*sí en la segunda posición el interes moratorio es mayor que el importe*/
										//empieza val
										if ($scope.alphaNumeric[posPay]['disp'] != 0 || $scope.alphaNumeric[posPay]['disp'] == 1) {
											var provA = $scope.alphaNumeric[posPay]['importe'] - IM;
											if (provA > 0) {

												total = provA;
												saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = saldo + provA;
												$scope.alphaNumeric[i]['interesMoratorio'] = 0;
												console.log("interes Moratoprio: " + $scope.alphaNumeric[i]['interesMoratorio']);
												$scope.alphaNumeric[posPay]['interesMoratorio'] = 0;
												deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = 0;
												interesMoratorio = IM;
											} else/*5654.61;*/
											{
												// alert('ASDFGH ' + $scope.alphaNumeric[posPay]['importe']);
												/*sí en la primera posición el interes moratorio es mayor que el imprte*/
												var positivNumbe = Math.abs(provA);
												var decNum = positivNumbe.toFixed(2);
												total = $scope.alphaNumeric[posPay]['total'] = 0;
												$scope.alphaNumeric[posPay]['interesMoratorio'] = positivNumbe;
												interesMoratorio = IM;
												console.log("IM " + IM);
												deudaOrdinario = $scope.alphaNumeric[posPay]['deudaOrdinario'] = interes;
												var resultado = 0;
												for (var b = 0; b <= posPay; b++) {
													// console.log("LAP: " + b);
													// console.log($scope.alphaNumeric[b]['interesMoratorio']);
													if ($scope.alphaNumeric[b]['interesMoratorio'] != 0 || $scope.alphaNumeric[b]['interesMoratorio'] != "") {
														resultado += $scope.alphaNumeric[b]['interesMoratorio'];
													} else {
														resultado += 0;
														console.log("En la vuelta " + b + "sumer un cero porque no había nada alv");
													}
													console.log("Suma total de valores: " + resultado);
												}
												/*setear el valor al input de prueba*/
												var sumaAdeudosOrdinario = sumaOrdinarios();
												$('#resMoratorioAdeuto').val(resultado.toFixed(2));
												$('#resOrdinarioAdeuto').val(sumaAdeudosOrdinario);
												$('#resOrdinarioAdeuto').click();//darle formato a ese campo
												// $('#resMoratorioAdeuto').click();
												/*simular el click para que se detone el evento y le de formato de money*/
												document.getElementById('resMoratorioAdeuto').click();
												deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = resultado;
												console.log($scope.alphaNumeric);
												// saldo = $scope.alphaNumeric[x]['saldo'] = $scope.infoMoratorio.si =  saldo;
												// interes
												//Moratorio = resultado;
												//
												saldo = $scope.alphaNumeric[i]['saldo'];

											}
											dispPC = $scope.alphaNumeric[posPay]['disp'] = 1; //$scope.alphaNumeric[posPay]['disp'] = 1;
										}
										//termina val
									}
									console.log("El cúmulo de interes hasta el punto es: " + $scope.alphaNumeric[i]['deudaMoratorio']);
									/*******************/
									/*}*/
								}
								/*END*/
								/*st new
                                for(var x=0; x<posicionPago; x++)
                                {

                                }
                                end new*/
								console.log("disp de esta posicion:" + $scope.alphaNumeric[posPay]['disp']);
							}
							/*fin de new part*/
						}
					}
					else {
						deudaOrdinario = 0;
						if ($scope.alphaNumeric[posicionPago]['interesMoratorio'] == 0) {
							//Hace el calculo cuando es apartir de la tercera posición
							dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
							importe = $scope.alphaNumeric[posPay]['importe'] = 0;
							diasRetraso = $scope.alphaNumeric[posPay]['diasRetraso'] = 0;
							interesMoratorio = $scope.alphaNumeric[posPay]['interesMoratorio'] = 0;
							// interes = $scope.alphaNumeric[i]['interes'];
							capital = $scope.alphaNumeric[(i)]['capital'];

							var siVal = $scope.infoMoratorio.si;
							interes = $scope.alphaNumeric[i]['interes'];
							// saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'];
							total = $scope.infoMoratorio.total = $scope.alphaNumeric[i]['capital'] + $scope.alphaNumeric[i]['interes'];

							if ($scope.alphaNumeric[posPay]['importe'] == 0 && $scope.alphaNumeric[posPay]['diasRetraso'] == 0) {
								if ($scope.alphaNumeric[i]['pago'] > posicionPago) {
									//$scope.infoMoratorio.si
									// saldo =  $scope.infoMoratorio.si =(($scope.infoMoratorio.si-$scope.alphaNumeric[i]['capital']))
									// saldo = $scope.alphaNumeric[posPay]['saldo'] - provA;
									// console.log(provA);
									if ($('#msiField').val() < posicionPago) {
										saldo = $scope.alphaNumeric[x]['saldo'];
										// saldo=$scope.alphaNumeric[posPay]['saldo'];
										if ($scope.alphaNumeric[i]['pago'] > posicionPago) {
											saldo = $scope.alphaNumeric[posPay]['saldo'];
										}
									} else {
										saldo = $scope.alphaNumeric[posPay]['saldo'];
										// saldo=$scope.alphaNumeric[x]['saldo'];
									}
									//
									// console.log("saldo:", saldo);
									//REVISAR QUE ESTÁ PASANDO CON EL TOTAL EN ESTE PUNTO ANTES DE IR A COMER FUGAAA
									// console.log("saldo", saldo);

								} else {
									//cambia todos los que están antes de ese pago
									for (var x = 0; x < posicionPago; x++) {
										saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
									}
								}
							} else {
								saldo = $scope.infoMoratorio.si = $scope.infoMoratorio.si - $scope.alphaNumeric[posPay]['total'];
							}
							// console.log("TTP IF", saldo);
						} else {
							if ($scope.alphaNumeric[posPay]['pago'] >= posicionPago || $scope.alphaNumeric[posPay]['pago'] <= posicionPago) {
								if ($scope.alphaNumeric[posicionPago]['disp'] == 1) {
									//aqui se coloca cuando se hay pagos abajo del nuevo, ejemplo Pago 5:550 y se quiere colocar uno en el 2
									dispPC = $scope.alphaNumeric[posPay]['disp'] = 1;
									saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
									importe = $scope.alphaNumeric[posPay]['importe'] = $scope.alphaNumeric[posPay]['importe'];
									diasRetraso = $scope.alphaNumeric[posPay]['diasRetraso'] = $scope.alphaNumeric[posPay]['diasRetraso'];
									interesMoratorio = $scope.alphaNumeric[posPay]['interesMoratorio'] = $scope.alphaNumeric[posPay]['interesMoratorio'];
								} else {//se coloca un valor cuando nohay nada(el resto de los campos, apartir de la segunda posicion, else de la primera posicion
									dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
								}
							} else {
								//cuando se salta un espacio en la tabla
								saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1;
								total = 90;
							}
							console.log("TTPII ELSE", saldo);

						}
					}

					// var siVal = document.getElementsByName("si"+i)[0].value
					// interes = siVal*$scope.infoMoratorio.interes_p2
					$scope.interes_plan2 = $scope.alphaNumeric[i]['saldoNormal'] * ($scope.infoMoratorio.interes_p2);
					$scope.capital2 = ($scope.p2 - $scope.interes_plan2);
					range2.push({
						"fecha": $scope.fechapago,
						"pago": i + 1,
						"capital": capital,
						"interes": interes,
						"importe": importe,
						"diasRetraso": diasRetraso,
						"interesMoratorio": interesMoratorio,
						"deudaMoratorio": deudaMoratorio,
						"deudaOrdinario": deudaOrdinario,
						"total": total, //$scope.infoMoratorio.capital + $scope.infoMoratorio.interes_p1
						"saldo": saldo,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
						"saldoNormal": $scope.alphaNumeric[i]['saldoNormal'],
						"disp": dispPC,
						"min": minVal,
						"max": maxVal
					});
				} else {
					/*Entra cuando te saltas espacios despues de la primera posicion*/
					range2.push({
						"fecha": $scope.fechapago,
						"pago": i + 1,
						"capital": $scope.alphaNumeric[i]['capital'],
						"interes": $scope.alphaNumeric[i]['interes'],
						"importe": $scope.alphaNumeric[i]['importe'],
						"diasRetraso": $scope.alphaNumeric[i]['diasRetraso'],
						"interesMoratorio": $scope.alphaNumeric[i]['interesMoratorio'],
						"deudaMoratorio": $scope.alphaNumeric[i]['deudaMoratorio'],
						"deudaOrdinario": $scope.alphaNumeric[i]['deudaOrdinario'],
						"total": $scope.alphaNumeric[i]['total'], //$scope.infoMoratorio.capital + $scope.infoMoratorio.interes_p1
						"saldo": $scope.alphaNumeric[i]['saldo'],//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
						"saldoNormal": $scope.alphaNumeric[i]['saldoNormal'],
						"disp": $scope.alphaNumeric[i]['disp']
					});
				}
				// }
				// else
				// {
				// 	/*Cuando estén combinados MSI y MCI*/
				// 	range2.push({
				// 			"fecha" :$scope.fechapago,
				// 			"pago" : i+1,
				// 			"capital" : ($scope.infoMoratorio.capital=($scope.p2 - $scope.interes_plan2)),
				// 			"interes" : ($scope.interes_plan2=($scope.total2*$scope.infoMoratorio.interes_p2)),
				// 			"importe" : 0,
				// 			"diasRetraso" : 0,
				// 			"interesMoratorio" : 0,
				// 			"total" : $scope.p2,
				// 			"saldo" : $scope.total2=($scope.total2 - $scope.capital2),//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
				// 			"disp" : disp
				// 		});
				// }


				/*original*/
				// $scope.interes_plan2 = $scope.total2*($scope.infoMoratorio.interes_p2);
				// $scope.capital2 = ($scope.p2 - $scope.interes_plan2);
				// range2.push({
				// 	"fecha" :$scope.fechapago,
				// 	"pago" : i+1,
				// 	"capital" : ($scope.infoMoratorio.capital=($scope.p2 - $scope.interes_plan2)),
				// 	"interes" : ($scope.interes_plan2=($scope.total2*$scope.infoMoratorio.interes_p2)),
				// 	"importe" : 0,
				// 	"diasRetraso" : 0,
				// 	"interesMoratorio" : 0,
				// 	"total" : $scope.p2,
				// 	"saldo" : $scope.total2=($scope.total2 - $scope.capital2),//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
				// 	"disp" : disp
				// });

				mes++;

				if (i == ($scope.infoMoratorio.plazo - 1)) {
					$scope.totalSegundoPlan = $scope.p2;
				}
				$scope.finalMesesp2 = (range2.length);
			}
			$scope.range2 = range2;
			$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
			$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2);
			/**/
			// console.log($scope.alphaNumeric);
			$scope.dtoptions = DTOptionsBuilder;
			$scope.dtColumns = [
				DTColumnBuilder.newColumn('fecha').withTitle('Fechas'),
				DTColumnBuilder.newColumn('amc').withTitle('Pagados')
					.renderWith(
						function (data, type, full, meta) {
							// console.log(full['check']);
							if (full['check'] == 1) {
								var inputCapital = '<input name="checkAd' + full["pago"] + '" type="checkbox" id="ckNoPay' + full["pago"] + '" checked disabled>';//onchange="pagoCapChange('+full["pago"]+')"
								return inputCapital;
							} else {
								var inputCapital = '<input name="checkAd' + full["pago"] + '" type="checkbox" id="ckNoPay' + full["pago"] + '" onchange="noPayMen(' + full["pago"] + ')">';//onchange="pagoCapChange('+full["pago"]+')"
								return inputCapital;
							}
							// var inputCapital = '<input name="checkAd' + full["pago"] + '" type="checkbox" id="ckNoPay' + full["pago"] + '" onchange="noPayMen(' + full["pago"] + ')">';//onchange="pagoCapChange('+full["pago"]+')"
							// return inputCapital;
						},
					),
				DTColumnBuilder.newColumn('pago').withTitle('Pago #'),
				DTColumnBuilder.newColumn('capital').withTitle('Capital').renderWith(
					function (data, type, full) {
						var showDescMens;
						if (full['importe'] < full['interesMoratorio']) {
							showDescMens = '<br><span style="color:red;font-size: 0.8em"><i>No se abonó nada a capital</i></span>';
						} else {
							if (full['importe'] == "" || full['importe'] == 0) {
								showDescMens = '<br><span style="color:red;font-size: 0.8em"><i>No se abonó nada a capital</i></span>';
							} else {
								// showDescMens = '<br><span style="color:red;font-size: 0.8em"><i>'+full['total'].toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})+'</i></span>';
								var intOrd = full['interes'];
								if (intOrd == 0 || intOrd == "") {
									showDescMens = '<br><span style="color:red;font-size: 0.8em"><i>' + full['total'].toLocaleString('es-MX', {
										style: 'currency',
										currency: 'MXN'
									}) + '</i></span>';
								} else {

									showDescMens = '<br><span style="color:red;font-size: 0.8em"><i>Primero descuenta a Intereses ordinarios</i></span>';

									// showDescMens = '<br><span style="color:red;font-size: 0.8em"><i>Primero descuenta a Intereses ordinarios</i></span>';
								}
							}
						}
						return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})) + showDescMens
					}),
				DTColumnBuilder.newColumn('interes').withTitle('Intereses').renderWith(function (data, type, full) {
					var showDescInt;
					var intOrd = full['interes'];
					if (intOrd <= full['total']) {
						showDescInt = '<br><span style="color:red;font-size: 0.8em"><i>' + full['interes'].toLocaleString('es-MX', {
							style: 'currency',
							currency: 'MXN'
						}) + '</i></span>';
					} else {
						if(full['deudaOrdinario'] <= 0 || full['deudaOrdinario']==undefined)//si no hay nada en el adeudo
						{
							let deudaOrdinario= (full['deudaOrdinario']==undefined) ? 0 : full['deudaOrdinario'];
							showDescInt = '<br><span style="color:red;font-size: 0.8em"><i>Se liquidó el interes: '+deudaOrdinario.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})+'</i></span>';

						}
						else
						{
							showDescInt = '<br><span style="color:red;font-size: 0.8em"><i>No se liquidó este interes: '+full['deudaOrdinario'].toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})+'</i></span>';
						}
						// showDescInt = '<br><span style="color:red;font-size: 0.8em"><i>No se liquidó este interes: '+full['deudaOrdinario'].toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})+'</i></span>';
					}
					// var inputOrdAdeudo = '<input type="text" id="adeudoOrd'+full['pago']+'">';
					return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})) + showDescInt;
				}),
				DTColumnBuilder.newColumn('importe').withTitle('Importe')
					.renderWith(
						function (data, type, full, meta) {
							// var inputCapital = '<input name="importe'+full["pago"]+'" type="number" id="idImporte'+full["pago"]+'"   placeholder="Importe" class="form-control">';//onchange="pagoCapChange('+full["pago"]+')"
							// var numberPay	 = '<input name="numberPay'+full["pago"]+'" type="hidden" id="payNum'+full["pago"]+'" value="'+full["pago"]+'">';

							// return inputCapital+numberPay;
							if ($scope.alphaNumeric[(full['pago'] - 1)]['disp'] == 1 && $scope.alphaNumeric[(full['pago'] - 1)]['importe'] != "" && full['importe'] != "")//
							{
								// var inputCapital = '<input name="importe' + full["pago"] + '"  id="idImporte' + full["pago"] + '"   placeholder="Importe" class="form-control" value="' +full['importe'] + '" type="tel" pattern="^\\$\\d{1,3}(,\\d{3})*(\\.\\d+)?$"  data-type="currency" >';//onchange="pagoCapChange('+full["pago"]+')"
								var input_val = full['importe'];

								// don't validate empty input
								if (input_val === "") {
									return;
								}

								// original length
								var original_len = input_val.length;


								// check for decimal
								if (input_val.indexOf(".") >= 0) {

									// get position of first decimal
									// this prevents multiple decimals from
									// being entered
									var decimal_pos = input_val.indexOf(".");

									// split number by decimal point
									var left_side = input_val.substring(0, decimal_pos);
									var right_side = input_val.substring(decimal_pos);

									// add commas to left side of number
									left_side = formatNumber(left_side);

									// validate right side
									right_side = formatNumber(right_side);

									// On blur make sure 2 numbers after decimal
									if (blur === "blur") {
										right_side += "00";
									}

									// Limit decimal to only 2 digits
									right_side = right_side.substring(0, 2);

									// join number by .
									input_val = "$" + left_side + "." + right_side;

								} else {
									// no decimal entered
									// add commas to number
									// remove all non-digits
									input_val = formatNumber(input_val);
									input_val = "$" + input_val;

									// final formatting
									if (blur === "blur") {
										input_val += ".00";
									}
								}
								// console.log(input_val);
								var inputCapital = input_val;
								// let importeMoney = formatNumber(full['importe']);
								// console.log(importeMoney);
								var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
								return inputCapital + numberPay;
							} else {
								if (full['check'] == 1) {
									var inputCapital = '<input name="importe' + full["pago"] + '" type="number" id="idImporte' + full["pago"] + '"  disabled placeholder="Importe" class="form-control">';//onchange="pagoCapChange('+full["pago"]+')"
									var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '"  value="' + full["pago"] + '">';
									return inputCapital + numberPay;
								} else {
									var inputCapital = '<input name="importe' + full["pago"] + '" type="number" id="idImporte' + full["pago"] + '"   placeholder="Importe" class="form-control">';//onchange="pagoCapChange('+full["pago"]+')"
									var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '"  value="' + full["pago"] + '">';
									return inputCapital + numberPay;
								}
							}
						},
					),
				DTColumnBuilder.newColumn('diasRetraso').withTitle('Días de retraso')
					.renderWith(
						function (data, type, full, meta) {
							/*Original vars*/
							var inputCapital;

							/*add vars*/
							var dateCurrent = full['fecha'];
							var datePays = dateCurrent.split("-").reverse().join("-");

							var dayPay;
							var posicionDate = dateCurrent.split('-');
							var mesPay = posicionDate[1];
							var anioPay = posicionDate[2];
							dayPay = daysInMonth(mesPay, anioPay);
							/*close add vars*/

							if ($scope.alphaNumeric[(full['pago'] - 1)]['disp'] == 1 && $scope.alphaNumeric[(full['pago'] - 1)]['diasRetraso'] != "" && full['diasRetraso'] != "")//
							{
								/*original content*/
								/*inputCapital = '<input name="dRet' + full["pago"] + '" type="number" id="idDiasRet' + full["pago"] + '"  onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Días retardo" class="form-control" value="' + full['diasRetraso'] + '">';
                                return inputCapital;*/
								/*close original content*/

								/*new content*/
								/*var currentDateRow = '<input name="pagoDia'+full["pago"]+'" id="payDay'+full["pago"]+'" type="hidden" value="'+datePays+'"> ';
                                var inputCapital = '<input name="dRet'+full["pago"]+'" type="date" id="idDiasRet'+full["pago"]+'" onchange="pagoCapChange('+full["pago"]+')" min="'+anioPay+'-'+mesPay+'-01" max="'+anioPay+'-'+mesPay+'-'+dayPay+'"  placeholder="Días retardo" class="form-control" disabled>';
                                return inputCapital+currentDateRow;*/
								inputCapital = '<input name="dRet' + full["pago"] + '" type="number" id="idDiasRet' + full["pago"] + '"   placeholder="Días retardo" value="' + full['diasRetraso'] + '" class="form-control"  disabled>';
								return inputCapital;
								/*close new content*/
							} else {
								if (full['check'] == 1) {
									/*original content*/
									inputCapital = '<input name="dRet' + full["pago"] + '" type="number" id="idDiasRet' + full["pago"] + '"   placeholder="Días retardo" class="form-control"  disabled>';
									return inputCapital;
									/*close original content*/

									/*new content*/

									/*close new content*/
								} else {
									/*original content*/
									/* inputCapital = '<input name="dRet' + full["pago"] + '" type="number" id="idDiasRet' + full["pago"] + '"  onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Días retardo" class="form-control">';
                                    return inputCapital;*/
									/*close original content*/

									/*new content*/
									var currentDateRow = '<input name="pagoDia' + full["pago"] + '" id="payDay' + full["pago"] + '" type="hidden" value="' + datePays + '"> ';
									var inputCapital = '<input name="dRet' + full["pago"] + '" type="date" id="idDiasRet' + full["pago"] + '" onchange="pagoCapChange(' + full["pago"] + ')" min="' + anioPay + '-' + mesPay + '-01"  placeholder="Días retardo" class="form-control">';/*max="'+anioPay+'-'+mesPay+'-'+dayPay+'" */
									return inputCapital + currentDateRow;
									/*close new content*/
								}
							}
						},
					),
				DTColumnBuilder.newColumn('interesMoratorio').withTitle('Interés Moratorio').renderWith(
					function (data, type, full) {
						// return (IM).toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})
						// console.log($scope.alphaNumeric[(full['pago']-1)]);
						if ($scope.alphaNumeric[(full['pago'] - 1)]['disp'] == 1 && $scope.alphaNumeric[(full['pago'] - 1)]['interesMoratorio'] != "" && full['interesMoratorio'] != "")//
						{
							return $scope.alphaNumeric[(full['pago'] - 1)]['interesMoratorio'].toLocaleString('es-MX', {
								style: 'currency',
								currency: 'MXN'
							});
							// return $scope.alphaNumeric[(full['pago']-1)]['interesMoratorio'];
						} else {
							return ((0.00).toFixed(2)).toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})
						}
					}
				),
				DTColumnBuilder.newColumn('total').withTitle('Total').renderWith(function (data, type, full) {
					return (data).toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})
				}),
				DTColumnBuilder.newColumn('saldo').withTitle('Saldo Moratorio').renderWith(function (data, type, full) {
					var numberFix = data.toFixed(2);
					var saldoInsolutoCR = '<input name="si' + full["pago"] + '" type="hidden" id="idSi' + full["pago"] + '"  value="' + numberFix + '" class="form-control">'
					if ($scope.alphaNumeric[full['pago'] - 1]['saldo'] <= 0) {
						$scope.alphaNumeric[full['pago'] - 1]['saldo'] = 0;
					}
					return (data).toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}) + saldoInsolutoCR;
				}),
				DTColumnBuilder.newColumn('saldoNormal').withTitle('Saldo').renderWith(function (data, type, full) {
					var saldoInsolutoCRNormal = '<input name="siNormal' + full["pago"] + '" type="hidden" id="idSiNormal' + full["pago"] + '"  value="' + full['saldoNormal'] + '" class="form-control">';//onchange="pagoCapChange('+full["pago"]+')"

					return (data).toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}) + saldoInsolutoCRNormal;
				}),
			];
			/**/
			$scope.dtoptions = DTOptionsBuilder.newOptions().withOption('aaData', $scope.alphaNumeric).withOption('order', [1, 'asc']).withDisplayLength(240).withDOM("<'pull-right'B><l><t><'pull-left'i><p>").withButtons([
					{extend: 'copy', text: '<i class="fa fa-files-o"></i> Copiar'},
					{
						extend: 'print',
						text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
						titleAttr: 'Imprimir'
					},
					{extend: 'excel', text: '<i class="fa fa-file-excel-o"></i> Excel', titleAttr: 'Excel'},
					{
						extend: 'pdfHtml5',
						text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF',
						titleAttr: 'PDF',
						title: '',
						customize: function (doc) {
							//pageMargins [left, top, right, bottom]
							doc.pageMargins = [140, 40, 10, 50];
							doc.alignment = 'center';
						}
					},
				]
			).withLanguage({"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"});
		}
	}
	/*termina calculo de mensualidades*/


	/*cálculo de mensualidades*/
	if($scope.infoMoratorio.plazo >= 37 && $scope.infoMoratorio.plazo  <= 120) {
		var range=[];
		ini = ($scope.mesesdiferir > 0) ? $scope.mesesdiferir : $scope.infoMoratorio.contadorInicial;
		if($scope.infoMoratorio.plazo >= 0 && $scope.infoMoratorio.plazo <=120)
		{
			for (var i = ini; i <= $scope.infoMoratorio.mesesSinInteresP1-1; i++)
			{
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

				$scope.fechapago = day + '-' + mes + '-' + yearc;

				if(i == 0){
					$scope.fechaPM = $scope.fechapago;
				}

				/*nuevo código 27  de noviembre*/
				var interes = 0;
				var total = 0;
				var capital =0;
				var saldo=0;
				var	importe=0;
				var diasRetraso=0;
				var interesMoratorio=0;
				if($scope.infoMoratorio.mesesSinInteresP1 == 0)
				{
					/*Esto no hace nada jajaja xdxdxd*/
					interes = ($scope.interes_plan=($scope.infoMoratorio.si*$scope.infoMoratorio.interes_p2));
					capital = ($scope.infoMoratorio.capital=(($scope.infoMoratorio.interes_p2 *  Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1) * $scope.infoMoratorio.si) / ( Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1 )-1) - $scope.interes_plan));
					total = ($scope.infoMoratorio.interes_p2 *  Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1) * $scope.infoMoratorio.si) / ( Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1 )-1);
					console.log("Entraste a meses 0");
				}
				else
				{
					if(arrayCheckAllPost.includes((i)))
					{
						console.log("Este número si está: " + i);
						check=1;
					}
					else
					{
						check=0;
						console.log("Entré aqui II");
					}
					capital = $scope.alphaNumeric[i]['capital'];
					interes=0;
					total = $scope.alphaNumeric[i]['capital'] + $scope.infoMoratorio.interes_p1;
					/*new part 21219*/
					var alphaOriginal=[];
					alphaOriginal=$scope.alphaNumeric;
					if($scope.alphaNumeric[i]['disp'] != 1)
					{
						/*Para verfificar donde se puso el pago a capital*/
						var vuelta = (i + 1);
						var posicionPago = (posPay + 1);
						if (vuelta == posicionPago)
						{
							if (posicionPago == 1)
							{
								if($scope.alphaNumeric[posPay]['check'] ==1)
								{
									/*si hay un check (osea que no está pagado) dejar el total*/
									total = $scope.alphaNumeric[posPay]['total'] = $scope.infoMoratorio.total ;
									saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si=1000000 ;
								}
								else
								{
									var dispPC;
									/* Este if es para ver si se descuenta la primera posicion*/
									// newSaldoTable = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'];
									// interesMoratorio = $scope.alphaNumeric[posPay]['interesMoratorio'] = $scope.infoMoratorio.interesMoratorio=IM;// $scope.alphaNumeric[posPay]['interesMoratorio'] = IM;
									// console.log('se descuenta de la primera posicion');
									saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'];//$scope.alphaNumeric[posPay]['saldo']=saldoInsoluto-$scope.alphaNumeric[posPay]['total']
									importe			=	 $scope.alphaNumeric[posPay]['importe'] = $scope.infoMoratorio.importe	= importeSaldoI;//$scope.alphaNumeric[posPay]['importe']
									diasRetraso		=	 $scope.alphaNumeric[posPay]['diasRetraso'] = $scope.infoMoratorio.diasRetraso = diasRetardo; //$scope.alphaNumeric[posPay]['diasRetraso']
									// console.log(saldo);
									if(IM > 0)
									{
										if($scope.alphaNumeric[posPay]['disp']!=0 || $scope.alphaNumeric[posPay]['disp']==1)
										{
											// console.log(IM);
											var provA = $scope.alphaNumeric[posPay]['importe'] - IM;
											// total = $scope.alphaNumeric[posPay]['total'] = $scope.infoMoratorio.total = interesMoratorio + total;
											if(provA>0)
											{
												console.log("deudaMoratorio", $scope.alphaNumeric[posPay]['deudaMoratorio']);
												console.log("provA", provA);
												// resultado=$scope.alphaNumeric[posPay]['deudaMoratorio']-provA;

												if($scope.alphaNumeric[posPay]['deudaMoratorio']<provA){
													resultado=provA-$scope.alphaNumeric[posPay]['deudaMoratorio'];
												}else{
													resultado=$scope.alphaNumeric[posPay]['deudaMoratorio']-provA;
												}
												total = resultado;//total = $scope.alphaNumeric[posPay]['total'] - provA
												// console.log(provA);
												saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si =  saldo - provA;//saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si =  saldo+$scope.alphaNumeric[posPay]['total'];
												// $scope.alphaNumeric[posPay]['interesMoratorio'] = IM;
												$scope.alphaNumeric[i]['total'] = 0;
												interesMoratorio = IM;
												// console.log("interes Moratoprio: " + $scope.alphaNumeric[i]['interesMoratorio']);
												// $scope.alphaNumeric[posPay]['interesMoratorio'] = 0;
												deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio']=0;
												console.log($scope.alphaNumeric);
											}
											else
											{
												/*sí en la primera posición el interes moratorio es mayor que el imprte*/

												var positivNumbe=Math.abs(provA);
												saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si =  saldo;
												var decNum= positivNumbe.toFixed(2);
												total = $scope.alphaNumeric[posPay]['total'] = 0;
												interesMoratorio = IM;
												$scope.alphaNumeric[i]['interesMoratorio'] = positivNumbe;
												deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = positivNumbe;
												$('#resMoratorioAdeuto').val(positivNumbe);
												$('#resMoratorioAdeuto').click();
												// console.log("interes Moratoprio: " + $scope.alphaNumeric[i]['interesMoratorio']);
											}
											dispPC = $scope.alphaNumeric[posPay]['disp']=  1; //$scope.alphaNumeric[posPay]['disp'] = 1;
										}
									}
								}
							}
							else
							{
								/* Este else es para ver si se descuenta apartir de la segunda posicion*/
								console.log("Segunda posicion");
								importe			= $scope.infoMoratorio.importe		= $scope.alphaNumeric[posPay]['importe'] = importeSaldoI;
								diasRetraso		= $scope.infoMoratorio.diasRetraso	= $scope.alphaNumeric[posPay]['diasRetraso'] = diasRetardo;
								dispPC		= $scope.infoMoratorio.disp	= $scope.alphaNumeric[posPay]['disp'] = 1;
								if(IM > 0)
								{
									if($scope.alphaNumeric[posPay]['disp']!=0 || $scope.alphaNumeric[posPay]['disp']==1)
									{
										var provA = $scope.alphaNumeric[posPay]['importe'] - IM;
										var billMoratorio;
										if($scope.alphaNumeric[posPay]['deudaMoratorio']!=undefined)
										{
											var cumuloMoratorio = $('#acumuladoBruto').val();
											billMoratorio = cumuloMoratorio - provA;
										}
										else
										{
											// var neg = provA;
											billMoratorio = (-provA);
											// billMoratorio = Math.sign(billMoratorio);
										}
										// console.log(suma);
										if(provA>0)
										{
											if(billMoratorio>0)
											{
												if(billMoratorio>0)//El pago(importe) no liquido la deuda y se sigue endeudando
												{
													//descontar a capital
													$('#acumuladoBruto').val(billMoratorio.toFixed(2));
													// alert("Aún hay una deuda " + $scope.alphaNumeric[i]['deudaMoratorio'] + " pv " + provA);
													$('#resMoratorioAdeuto').val(billMoratorio);
													$('#resMoratorioAdeuto').click();
													interesMoratorio = IM;
													$scope.alphaNumeric[i]['interesMoratorio'] = billMoratorio;
													total = $scope.alphaNumeric[i]['total'] = 0;
													deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'] = billMoratorio;
													// break;
													//148

												}
												else
												{
													var importeLibreCapital;
													//añadir adeudo a moratorio porque no se cubrio
													//El valor llega negativo ya que el importe alcanzó a subrir el adeudo moratorio
													if(billMoratorio < 0)
													{
														importeLibreCapital = Math.abs(billMoratorio);
													}
													else
													{
														importeLibreCapital = billMoratorio;
													}
													// console.log("CHECK DE CONTROL ALV: " + importeLibreCapital);
													// alert("Tu pago genera más adeudo: "  + $scope.alphaNumeric[i]['deudaMoratorio']);
													total = $scope.alphaNumeric[i]['total'] = importeLibreCapital;
													saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.alphaNumeric[posPay]['saldo'] - total;
												}
											}
											else
											{
												// alert("Liquidaste tu deuda ok");

												//cuando no hay adeudo pasa directamenta a descontar al capital
												//El valor llega negativo ya que no hay un adeudo y pasa negativo el restante (Importe-IM)
												var abonoLibre = Math.abs(billMoratorio);
												// alert("En este pago no hay un adeudo pendiente >> next" + provA + " : " + abonoLibre + " : " + billMoratorio);
												total = $scope.alphaNumeric[posPay]['total'] = abonoLibre;//pasalo a positivo
												saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.alphaNumeric[posPay]['saldo'] - abonoLibre;
												// deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = 0;
												interesMoratorio = IM;
												$('#resMoratorioAdeuto').val(0);
												$('#resMoratorioAdeuto').click();
												$('#acumuladoBruto').val(0);
												for(var b=0; b < $scope.alphaNumeric.length; b++)
												{
													console.log(posPay + " <--pospay-postionB--> " + b);
													if (b>=posPay) {
														$scope.alphaNumeric[b]['interesMoratorio'] = 0;
														$scope.alphaNumeric[b]['deudaMoratorio'] = 0;
													}
													else
													{
														interesMoratorio = $scope.alphaNumeric[b]['interesMoratorio'] = IM;
														// $scope.alphaNumeric[i]['deudaMoratorio'] = positivNumbe;
														deudaMoratorio = $scope.alphaNumeric[b]['deudaMoratorio'] = 0;
													}
													console.log(b);
													console.log($scope.alphaNumeric[b]['deudaMoratorio']);
													console.log($scope.alphaNumeric[b]['interesMoratorio']);
												}
											}
										}
										else
										{	/*sí en la primera posición el interes moratorio es mayor que el imprte*/
											//Acumulacion de adeudos
											console.log("from else: " + provA);
											// break;
											var positivNumbe=Math.abs(provA);
											var decNum= positivNumbe.toFixed( 2);
											//Se le setea 0 al total ya que no abono nada a la capital, genero más adeudo el moratorio
											total = $scope.alphaNumeric[i]['total'] = 0;
											saldo = $scope.alphaNumeric[i]['saldo'];

											interesMoratorio = IM;
											deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'] = positivNumbe;

											// console.log("IM " + IM);
											var sumAdeudos=0;
											for(var b=0; b < $scope.alphaNumeric.length; b++)
											{
												console.log(posPay + " <--pospay - postionB --> " + b);
												if (posPay != b) {
													$scope.alphaNumeric[i]['interesMoratorio'] = 0;
													$scope.alphaNumeric[i]['deudaMoratorio'] = 0;
													// delete $scope.alphaNumeric[i]["deudaMoratorio"];
													// delete $scope.alphaNumeric[i]["interesMoratorio"];
													// delete $scope.alphaNumeric[i]["deudaMoratorio"];
												}
												else
												{
													interesMoratorio = $scope.alphaNumeric[b]['interesMoratorio'] = IM;
													// $scope.alphaNumeric[i]['deudaMoratorio'] = positivNumbe;
													deudaMoratorio = $scope.alphaNumeric[b]['deudaMoratorio'] = positivNumbe;
												}
												//
												// console.log(b);
												console.log($scope.alphaNumeric[b]['deudaMoratorio']);
												console.log($scope.alphaNumeric[b]['interesMoratorio']);
												if($scope.alphaNumeric[b]['deudaMoratorio'] != undefined && $scope.alphaNumeric[b]['interesMoratorio'] != 0)
												{
													sumAdeudos += $scope.alphaNumeric[b]['deudaMoratorio'];
												}
											}
											console.log("Suma total de valores: " + sumAdeudos);
											$('#acumuladoBruto').val(sumAdeudos.toFixed(2));
											/*setear el valor al input de prueba*/
											$('#resMoratorioAdeuto').val(sumAdeudos);
											$('#resMoratorioAdeuto').click();
											/*simular el click para que se detone el evento y le de formato de money*/
											document.getElementById('resMoratorioAdeuto').click();
											console.log($scope.alphaNumeric);
											// alert("Llegue aqui");
											// var chMD=$('#acumuladoBruto').val();
											// if(chMD == 0 || chMD =="")
											// {
											// 	deudaMoratorio = $scope.alphaNumeric[b]['deudaMoratorio'] = 0;
											// 	// delete $scope.alphaNumeric[g]["deudaMoratorio"];
											// 	// sumAdeudos=0;
											// }
										}
										dispPC = $scope.alphaNumeric[posPay]['disp']=  1; //$scope.alphaNumeric[posPay]['disp'] = 1;
										saldo= $scope.alphaNumeric[i]['saldo'];
									}

									/*end new*/

									// console.log("Adeudos hasta este punto: " + $scope.alphaNumeric[x]['deudaMoratorio']);
								}
							}
						}
						else
						{
							// var saldoNormal =  $scope.infoMoratorio.precioTotal = $scope.infoMoratorio.precioTotal - $scope.infoMoratorio.capital;
							if ($scope.alphaNumeric[posPay]['interesMoratorio'] == 0)/*posionPago*/
							{/*Hace el calculo cuando es apartir de la tercera posición*/
								// newSaldoTable = $scope.infoMoratorio.si = $scope.infoMoratorio.si - $scope.infoMoratorio.capital;
								// saldo =  $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si=($scope.infoMoratorio.si-$scope.alphaNumeric[posPay]['total'])
								dispPC = $scope.alphaNumeric[posPay]['disp'] =0;
								importe			= $scope.alphaNumeric[posPay]['importe']=0;
								diasRetraso		= $scope.alphaNumeric[posPay]['diasRetraso']=0;
								interesMoratorio = $scope.alphaNumeric[i]['interesMoratorio']=0;
								deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'] = 0;
								if($scope.alphaNumeric[posPay]['importe'] ==0 && $scope.alphaNumeric[posPay]['diasRetraso']==0)
								{
									if($scope.alphaNumeric[i]['pago'] > posicionPago) //coloca un total moratorio - en el restante del actual hacia abajo
									{
										saldo = $scope.alphaNumeric[posPay]['saldo'];//saldo =  $scope.infoMoratorio.si =(($scope.infoMoratorio.si-$scope.alphaNumeric[posPay]['total']) + $scope.alphaNumeric[posPay]['interesMoratorio']);
										deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'];
									}
									else
									{
										for(var x=0; x<posicionPago; x++)//este es el total moratorio hacia arriba del pago actual
										{
											/*correcto*/
											//saldo=$scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];//$scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
											/*var target = angular.element(document.getElementById("#dRet" + x));
											if(document.getElementsByName("dRet"+(i+1))[0].value =="")//document.getElementsByName("dRet"+(i+1))[0].value ==""
											{
												saldo=$scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];//$scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
											}
											else
											{
												saldo=$scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];//$scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
											}*/
											/*En esta parte se le adigna el saldo a la posicion que noha sido afectada*/
											/*UPD actualizacion 24 ENERO, se coloca el saldo de la posicion anterior ya que se
											* descontara conforme a lo que se vaya dando (abonos a capital)*/
											saldo=$scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];//$scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
											deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'] = 0;

										}
									}
								}
								else
								{
									saldo =  $scope.infoMoratorio.si =$scope.infoMoratorio.si-$scope.alphaNumeric[posPay]['total'];//saldo =  $scope.infoMoratorio.si =$scope.infoMoratorio.si-$scope.alphaNumeric[posPay]['total']
									deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'] = 0;
								}
							}
							else
							{
								if ($scope.alphaNumeric[posPay]['pago'] >= posicionPago || $scope.alphaNumeric[posPay]['pago'] <= posicionPago)
								{
									if ($scope.alphaNumeric[posicionPago]['disp'] == 1)
									{
										/*aqui se coloca cuando se hay pagos abajo del nuevo, ejemplo Pago 5:550 y se quiere colocar uno en el 2*/
										dispPC = $scope.alphaNumeric[posPay]['disp']=  1;
										saldo =  $scope.infoMoratorio.si =$scope.alphaNumeric[posPay]['saldo'];
										importe			= $scope.alphaNumeric[posPay]['importe'] = $scope.alphaNumeric[posPay]['importe'];
										diasRetraso		= $scope.alphaNumeric[posPay]['diasRetraso'] = $scope.alphaNumeric[posPay]['diasRetraso'];
										interesMoratorio = $scope.alphaNumeric[posPay]['interesMoratorio'] = $scope.alphaNumeric[posPay]['interesMoratorio'];
									}
									else
									{/*se coloca un valor cuando nohay nada(el resto de los campos, apartir de la segunda posicion, else de la primera posicion*/
										// newSaldoTable = $scope.infoMoratorio. si = $scope.infoMoratorio.si - $scope.infoMoratorio.capital;
										saldo = $scope.alphaNumeric[posPay]['saldo'];//saldo = $scope.infoMoratorio.si = (($scope.infoMoratorio.si-$scope.alphaNumeric[(posPay)]['total']))
										dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
										//saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo']
										deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'] = $scope.alphaNumeric[i]['deudaMoratorio'];
									}
								}
								else
								{
									/*cuando se salta un espacio en la tabla*/
									saldo =  $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1;
									deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'];
								}
							}
						}
						range.push({
							"fecha" :$scope.fechapago,
							"pago" : i + 1,
							"capital" : capital,
							"interes" : interes,
							"importe" : importe,
							"diasRetraso" : diasRetraso,
							"interesMoratorio" : interesMoratorio,
							"deudaMoratorio": deudaMoratorio,
							"total" : total, //$scope.infoMoratorio.capital + $scope.infoMoratorio.interes_p1
							"saldo" : saldo,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,
							"saldoNormal":  $scope.alphaNumeric[i]['saldoNormal'],/*se coloca la misma informaición que al inicio para respetar la corrida financiera original*/
							"disp" : dispPC,
							"min" : minVal,
							"max": maxVal,
							"check":check
						});
					}
					else
					{
						/*Entra cuando te saltas espacios despues de la primera posicion*/
						range.push({
							"fecha" :$scope.fechapago,
							"pago" : i + 1,
							"capital" : $scope.alphaNumeric[i]['capital'],
							"interes" : $scope.alphaNumeric[i]['interes'],
							"importe" : $scope.alphaNumeric[i]['importe'],
							"diasRetraso" :  $scope.alphaNumeric[i]['diasRetraso'],
							"interesMoratorio" : $scope.alphaNumeric[i]['interesMoratorio'],
							"deudaMoratorio" : $scope.alphaNumeric[i]['deudaMoratorio'],
							"total" : $scope.alphaNumeric[i]['total'], //$scope.infoMoratorio.capital + $scope.infoMoratorio.interes_p1
							"saldo" : $scope.alphaNumeric[i]['saldo'],//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
							"saldoNormal":  $scope.alphaNumeric[i]['saldoNormal'],//$scope.alphaNumeric[i]['saldoNormal']
							"disp" : $scope.alphaNumeric[i]['disp'],
							"check" : $scope.alphaNumeric[i]['check']
						});
					}
				}
				mes++;

				if (i-1 == ($scope.infoMoratorio.mesesSinInteresP1-1))//($scope.infoMoratorio.mesesSinInteresP1 - 1)
				{
					$scope.total2 = saldo;
					$scope.totalPrimerPlan = $scope.infoMoratorio.capital + $scope.infoMoratorio.interes_p1;
				}
				$scope.finalMesesp1 = range.length;
				ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
			}
			$scope.range= range;
			ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
			// console.log($scope.alphaNumeric);
			//////////
			$scope.p2 = ($scope.infoMoratorio.interes_p2 *  Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1) * $scope.total2) / ( Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1 )-1);
			var range2=[];
			for (var i = ini2; i < $scope.infoMoratorio.plazo; i++) {
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
				/**/
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


				$scope.fechapago = day + '-' + mes + '-' + yearc;
				if(i == 0){
					$scope.fechaPM = $scope.fechapago;
				}
				var interes = 0;
				var total = 0;
				var capital =0;
				var saldo=0;
				var	importe=0;
				var diasRetraso=0;
				var interesMoratorio=0;
				var check=0;
				// if($scope.infoMoratorio.mesesSinInteresP1 == 0)
				// {
				// $scope.interes_plan2 = $scope.total2*($scope.infoMoratorio.interes_p2);
				interes = $scope.interes_plan2=$scope.infoMoratorio.saldoNormal*$scope.infoMoratorio.interes_p2;
				// capital = $scope.capital2 = ($scope.p2 - $scope.interes_plan2);
				total = $scope.p2;
				var deudaMoratorio;
				/*new part 21219*/
				var alphaOriginal=[];
				alphaOriginal=$scope.alphaNumeric;
				if($scope.alphaNumeric[i]['disp'] != 1)
				{
					/*Para verfificar donde se puso el pago a capital*/
					var vuelta = (i + 1);
					var posicionPago = (posPay + 1);
					if (vuelta == posicionPago)
					{
						if (posicionPago == 1)
						{
							console.log('FIRST POSTICONASD');
							// var siVal = document.getElementsByName("si"+posPay)[0].value;
							capital = $scope.alphaNumeric[i]['capital'] ; //$scope.capital2 = ($scope.p2 - $scope.interes_plan2);

							interes = $scope.alphaNumeric[i]['interes'];//$scope.alphaNumeric[posPay]['interes'] = siVal*$scope.infoMoratorio.interes_p2
							deudaOrdinario=0;



							importe			= $scope.infoMoratorio.importe		= $scope.alphaNumeric[posPay]['importe'] = importeSaldoI;
							diasRetraso		= $scope.infoMoratorio.diasRetraso	= $scope.alphaNumeric[posPay]['diasRetraso'] = diasRetardo;
							dispPC		= $scope.infoMoratorio.disp	= $scope.alphaNumeric[posPay]['disp'] = 1;
							interesMoratorio = IM;
							if(IM > 0)
							{
								/*27DIC*/
								// alert('llegué aqui ' + IM);
								if($scope.alphaNumeric[posPay]['saldo']==$scope.alphaNumeric[posPay]['saldo'])
								{
									if(posPay==0)
									{
										// alert('I');
										interes = $scope.alphaNumeric[(posPay)]['saldoNormal'] * $scope.infoMoratorio.interes_p2;//$scope.alphaNumeric.sal* $scope.infoMoratorio.interes_p2
										capital=$scope.alphaNumeric[i]['capital'];
									}
									else
									{
										// alert('II');
										// $scope.p2 = ($scope.infoMoratorio.interes_p2 *  Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1) * $scope.alphaNumeric[(posPay-1)]['saldoNormal']) / ( Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1 )-1);
										interes = $scope.alphaNumeric[(posPay-1)]['saldoNormal'] * $scope.infoMoratorio.interes_p2;//$scope.alphaNumeric.sal* $scope.infoMoratorio.interes_p2
										capital=$scope.alphaNumeric[i]['capital'];
									}
									// interes = $scope.alphaNumeric[(posPay-1)]['saldoNormal'] * $scope.infoMoratorio.interes_p2;//$scope.alphaNumeric.sal* $scope.infoMoratorio.interes_p2
									var provA = $scope.alphaNumeric[posPay]['importe'] - IM;
									if(provA>0)
									{
										// alert("PROVA: " + provA + "===== DEUDA MORATORIO " +  $('#resMoratorioAdeuto').val());
										// console.log("Deudas de moratorios: " + $scope.alphaNumeric[posPay]['deudaMoratorio']);
										interesMoratorio = IM;
										/*newcode*/
										if($scope.alphaNumeric[posPay]['deudaMoratorio']>=0 || $scope.alphaNumeric[posPay]['deudaMoratorio']!="")
										{
											resultado=$scope.alphaNumeric[posPay]['deudaMoratorio']-provA;
											// alert($scope.alphaNumeric[posPay]['deudaMoratorio']);
											// alert(provA);
											// saldo=$scope.infoMoratorio.si=$scope.alphaNumeric[x]['saldo']=$scope.alphaNumeric[x]['saldo'];
											console.log('Llegue a descontar a los adeudos moratorios');

											// var positivRes=Math.abs(resultado);
											if(resultado > 0)
											{
												console.log("Este debe de ser positivo: " + resultado);
												$('#resMoratorioAdeuto').val(resultado);
												$('#resMoratorioAdeuto').click();
												deudaMoratorio =$scope.alphaNumeric[posPay]['deudaMoratorio'] = resultado;
												total = $scope.alphaNumeric[posPay]['total'] = 0;
												alert('PPP');
											}
											else
											{
												// alert('QQQ');
												// console.log("Este dbe ser negativo: " + resultado);
												var abonoLimpio = Math.abs(resultado);
												$('#resMoratorioAdeuto').val(0);
												$('#resMoratorioAdeuto').click();
												deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = 0;
												// limpiaAdeudoMoratorio();
												console.log("Libres para abonar a capital: " + abonoLimpio);
												total = 0;//total = $scope.alphaNumeric[posPay]['total'] + abonoLimpio
												// alert('Esto se debe descontar al interes ordinario ' + abonoLimpio);
												//vamoaver
												var intLessAbonoLimpio = interes - abonoLimpio;
												console.log('LOG: ' + intLessAbonoLimpio);
												var cumuloOrdinario = $('#resOrdinarioAdeuto').val();
												var deudaOrdinario;
												var deudaOrdinarioSuma;
												if (Math.sign(intLessAbonoLimpio) == 1)//si el numero es positivo
												{

													// alert('hanumaaaaaa MATH.SIGN');
													//si sale positivo es porque quedo interes por pagar
													deudaOrdinario = $scope.alphaNumeric[posPay]['deudaOrdinario'] = intLessAbonoLimpio;
													deudaOrdinarioSuma=sumaOrdinarios();
													$('#resOrdinarioAdeuto').val(deudaOrdinarioSuma);
													$('#resOrdinarioAdeuto').click();
													saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[x]['saldo'] = $scope.alphaNumeric[x]['saldo'];
													console.log($scope.alphaNumeric);
												}
												else
												{
													//si sale negativo es porque quedo algo libre para capital
													// saldo=$scope.infoMoratorio.si=$scope.alphaNumeric[x]['saldo']=$scope.alphaNumeric[x]['saldo']-intLessAbonoLimpio;
													// alert(intLessAbonoLimpio + " MATH.ABS: " + Math.abs(intLessAbonoLimpio) + " deudaORD" + deudaOrdinario);
													// alert("PARA CAPITAL " + (Math.abs(intLessAbonoLimpio) - deudaOrdinarioSuma));
													/*VERIFICAR SI DIO NEGATIVO Y POSITIVO ALV, SI SALE NEGATIVO AUN QUEDA DEUDA, SI SALE POSITIVO QUEDA LIBRE*/
													// deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = 0;
													var posintLessAbonoLimpio;
													if(deudaOrdinarioSuma>0)
													{
														posintLessAbonoLimpio = Math.abs(intLessAbonoLimpio) - deudaOrdinarioSuma;
													}
													else
													{
														posintLessAbonoLimpio = Math.abs(intLessAbonoLimpio);
													}


													if (posintLessAbonoLimpio >= 0)
													{
														posintLessAbonoLimpio = Math.abs(posintLessAbonoLimpio);
														if(sumaOrdinarios()>0)
														{
															// alert('SMN HDTRPM LLEGASTE AQUI');
															posintLessAbonoLimpio = posintLessAbonoLimpio - sumaOrdinarios();
														}

														// posintLessAbonoLimpio = Math.abs(posintLessAbonoLimpio);
														// alert("ALV JAJA" + $('#resMoratorioAdeuto').val());
														// alert('POSITIVO ' + posintLessAbonoLimpio);
														$('#resOrdinarioAdeuto').val(0);
														$('#resOrdinarioAdeuto').click();
														limpiaAdeudoOrdinario();
														total = posintLessAbonoLimpio;
														saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'] = $scope.alphaNumeric[posPay]['saldo'] - posintLessAbonoLimpio;

														// alert('CHECKPOINT');

														//ORIGINAL12FEB
														// posintLessAbonoLimpio = Math.abs(posintLessAbonoLimpio);
														// alert("ALV JAJA" + $('#resMoratorioAdeuto').val());
														// alert('POSITIVO ' + posintLessAbonoLimpio);
														// $('#resOrdinarioAdeuto').val(0);
														// $('#resOrdinarioAdeuto').click();
														// limpiaAdeudoOrdinario();
														// total = posintLessAbonoLimpio;
														// saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[x]['saldo'] = $scope.alphaNumeric[x]['saldo'] - posintLessAbonoLimpio;
													}
													else
													{
														// posintLessAbonoLimpio = Math.abs(posintLessAbonoLimpio);
														// alert('AUN QUEDA DEUDA NEGATIVO ' + posintLessAbonoLimpio);
														$('#resOrdinarioAdeuto').val(posintLessAbonoLimpio);
														$('#resOrdinarioAdeuto').click();
													}




													/*var posintLessAbonoLimpio = Math.abs(intLessAbonoLimpio) - deudaOrdinarioSuma;
													alert(posintLessAbonoLimpio);
													posintLessAbonoLimpio = Math.abs(posintLessAbonoLimpio);
													saldo=$scope.infoMoratorio.si=$scope.alphaNumeric[x]['saldo']=$scope.alphaNumeric[x]['saldo']-posintLessAbonoLimpio;
													deudaOrdinario = $scope.alphaNumeric[posPay]['deudaOrdinario']=0;
													limpiaAdeudoOrdinario();
													total = posintLessAbonoLimpio;
													$('#resOrdinarioAdeuto').val(0);
													$('#resOrdinarioAdeuto').click();*/
												}
												//vamoaver
											}
											// console.log("resultado tratado" + resultado);
											// console.log(provA);
											// console.log($scope.alphaNumeric[posPay]['deudaMoratorio']);
										}
										else
										{
											// total = $scope.infoMoratorio.total =total-provA; /*orioginal de la funcion*/
											total = $scope.alphaNumeric[posPay]['total'] - provA;
											saldo=$scope.infoMoratorio.si=$scope.alphaNumeric[x]['saldo']=$scope.alphaNumeric[x]['saldo']+provA;
											// console.log('Llegue a NO descontar a los adeudos moratorios');
											interesMoratorio = IM;
										}
										/*exitcode*/
									}
									else
									{
										/*sí en la segunda posición el interes moratorio es mayor que el importe*/
										//empieza val
										if($scope.alphaNumeric[posPay]['disp']!=0 || $scope.alphaNumeric[posPay]['disp']==1)
										{
											var provA = $scope.alphaNumeric[posPay]['importe'] - IM;
											if(provA>0)
											{
												// alert('QWERTY');
												total = provA;
												saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si =  saldo+provA;
												$scope.alphaNumeric[i]['interesMoratorio'] = 0;
												console.log("interes Moratoprio: " + $scope.alphaNumeric[i]['interesMoratorio']);
												$scope.alphaNumeric[posPay]['interesMoratorio'] = 0;
												deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio']=0;
												interesMoratorio = IM;
											}
											else/*5654.61;*/
											{
												// alert('ASDFGH ' + $scope.alphaNumeric[posPay]['importe']);
												/*sí en la primera posición el interes moratorio es mayor que el imprte*/
												var positivNumbe=Math.abs(provA);
												var decNum= positivNumbe.toFixed(2);
												total = $scope.alphaNumeric[posPay]['total'] = 0;
												$scope.alphaNumeric[posPay]['interesMoratorio'] = positivNumbe;
												interesMoratorio = IM;
												console.log("IM " + IM);
												deudaOrdinario = $scope.alphaNumeric[posPay]['deudaOrdinario'] = interes;
												var resultado=0;
												for(var b=0; b<=posPay; b++)
												{
													// console.log("LAP: " + b);
													// console.log($scope.alphaNumeric[b]['interesMoratorio']);
													if($scope.alphaNumeric[b]['interesMoratorio'] != 0 || $scope.alphaNumeric[b]['interesMoratorio'] != "")
													{
														resultado += $scope.alphaNumeric[b]['interesMoratorio'];
													}
													else
													{
														resultado +=0;
														console.log("En la vuelta " + b + "sumer un cero porque no había nada alv");
													}
													console.log("Suma total de valores: " + resultado);
												}
												/*setear el valor al input de prueba*/
												var sumaAdeudosOrdinario = sumaOrdinarios();
												$('#resMoratorioAdeuto').val(resultado.toFixed(2));
												$('#resOrdinarioAdeuto').val(sumaAdeudosOrdinario);
												$('#resOrdinarioAdeuto').click();//darle formato a ese campo
												// $('#resMoratorioAdeuto').click();
												/*simular el click para que se detone el evento y le de formato de money*/
												document.getElementById('resMoratorioAdeuto').click();
												deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio']=resultado;
												console.log($scope.alphaNumeric);
												// saldo = $scope.alphaNumeric[x]['saldo'] = $scope.infoMoratorio.si =  saldo;
												// interes
												//Moratorio = resultado;
												//
												saldo=$scope.alphaNumeric[posPay]['saldo'];

											}
											dispPC = $scope.alphaNumeric[posPay]['disp']=  1; //$scope.alphaNumeric[posPay]['disp'] = 1;
										}
										//termina val
									}
									console.log("El cúmulo de interes hasta el punto es: " + $scope.alphaNumeric[i]['deudaMoratorio']);
									/*******************/
									/*}*/
								}
								/*END*/
								/*st new
								for(var x=0; x<posicionPago; x++)
								{

								}
								end new*/
								console.log("disp de esta posicion:" + $scope.alphaNumeric[posPay]['disp']);
							}
						}
						else
						{/* Este else es para ver si se descuenta apartir de la segunda posicion*/
							// alert("Segunda posicion");
							console.log('SEUNGA POSTICONASD');
							var siVal = document.getElementsByName("si"+posPay)[0].value
							capital = $scope.alphaNumeric[i]['capital'] ; //$scope.capital2 = ($scope.p2 - $scope.interes_plan2);

							interes = $scope.alphaNumeric[i]['interes'];//$scope.alphaNumeric[posPay]['interes'] = siVal*$scope.infoMoratorio.interes_p2
							deudaOrdinario=0;



							importe			= $scope.infoMoratorio.importe		= $scope.alphaNumeric[posPay]['importe'] = importeSaldoI;
							diasRetraso		= $scope.infoMoratorio.diasRetraso	= $scope.alphaNumeric[posPay]['diasRetraso'] = diasRetardo;
							dispPC		= $scope.infoMoratorio.disp	= $scope.alphaNumeric[posPay]['disp'] = 1;
							interesMoratorio = IM;
							if(IM > 0)
							{
								/*27DIC*/
								// alert('llegué aqui ' + IM);
								if($scope.alphaNumeric[posPay]['saldo']==$scope.alphaNumeric[posPay]['saldo'])
								{
									if(posPay==0)
									{
										// alert('I');
										interes = $scope.alphaNumeric[(posPay)]['saldoNormal'] * $scope.infoMoratorio.interes_p2;//$scope.alphaNumeric.sal* $scope.infoMoratorio.interes_p2
										capital=$scope.alphaNumeric[i]['capital'];
									}
									else
									{
										// alert('II');
										// $scope.p2 = ($scope.infoMoratorio.interes_p2 *  Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1) * $scope.alphaNumeric[(posPay-1)]['saldoNormal']) / ( Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1 )-1);
										interes = $scope.alphaNumeric[(posPay-1)]['saldoNormal'] * $scope.infoMoratorio.interes_p2;//$scope.alphaNumeric.sal* $scope.infoMoratorio.interes_p2
										capital=$scope.alphaNumeric[i]['capital'];
									}
									// interes = $scope.alphaNumeric[(posPay-1)]['saldoNormal'] * $scope.infoMoratorio.interes_p2;//$scope.alphaNumeric.sal* $scope.infoMoratorio.interes_p2
									var provA = $scope.alphaNumeric[posPay]['importe'] - IM;
									if(provA>0)
									{
										// alert("PROVA: " + provA + "===== DEUDA MORATORIO " +  $('#resMoratorioAdeuto').val());
										// console.log("Deudas de moratorios: " + $scope.alphaNumeric[posPay]['deudaMoratorio']);
										interesMoratorio = IM;
										/*newcode*/
										if($scope.alphaNumeric[posPay]['deudaMoratorio']>=0 || $scope.alphaNumeric[posPay]['deudaMoratorio']!="")
										{
											resultado=$scope.alphaNumeric[posPay]['deudaMoratorio']-provA;
											// alert($scope.alphaNumeric[posPay]['deudaMoratorio']);
											// alert(provA);
											// saldo=$scope.infoMoratorio.si=$scope.alphaNumeric[x]['saldo']=$scope.alphaNumeric[x]['saldo'];
											console.log('Llegue a descontar a los adeudos moratorios');

											// var positivRes=Math.abs(resultado);
											if(resultado > 0)
											{
												console.log("Este debe de ser positivo: " + resultado);
												$('#resMoratorioAdeuto').val(resultado);
												$('#resMoratorioAdeuto').click();
												deudaMoratorio =$scope.alphaNumeric[posPay]['deudaMoratorio'] = resultado;
												total = $scope.alphaNumeric[posPay]['total'] = 0;
												alert('PPP');
											}
											else
											{
												// alert('QQQ');
												// console.log("Este dbe ser negativo: " + resultado);
												var abonoLimpio = Math.abs(resultado);
												$('#resMoratorioAdeuto').val(0);
												$('#resMoratorioAdeuto').click();
												deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = 0;
												// limpiaAdeudoMoratorio();
												console.log("Libres para abonar a capital: " + abonoLimpio);
												total = 0;//total = $scope.alphaNumeric[posPay]['total'] + abonoLimpio
												// alert('Esto se debe descontar al interes ordinario ' + abonoLimpio);
												//vamoaver
												var intLessAbonoLimpio = interes - abonoLimpio;
												console.log('LOG: ' + intLessAbonoLimpio);
												var cumuloOrdinario = $('#resOrdinarioAdeuto').val();
												var deudaOrdinario;
												var deudaOrdinarioSuma;
												if (Math.sign(intLessAbonoLimpio) == 1)//si el numero es positivo
												{

													// alert('hanumaaaaaa MATH.SIGN');
													//si sale positivo es porque quedo interes por pagar
													deudaOrdinario = $scope.alphaNumeric[posPay]['deudaOrdinario'] = intLessAbonoLimpio;
													deudaOrdinarioSuma=sumaOrdinarios();
													$('#resOrdinarioAdeuto').val(deudaOrdinarioSuma);
													$('#resOrdinarioAdeuto').click();
													saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[x]['saldo'] = $scope.alphaNumeric[x]['saldo'];
													console.log($scope.alphaNumeric);
												}
												else
												{
													//si sale negativo es porque quedo algo libre para capital
													// saldo=$scope.infoMoratorio.si=$scope.alphaNumeric[x]['saldo']=$scope.alphaNumeric[x]['saldo']-intLessAbonoLimpio;
													// alert(intLessAbonoLimpio + " MATH.ABS: " + Math.abs(intLessAbonoLimpio) + " deudaORD" + deudaOrdinario);
													// alert("PARA CAPITAL " + (Math.abs(intLessAbonoLimpio) - deudaOrdinarioSuma));
													/*VERIFICAR SI DIO NEGATIVO Y POSITIVO ALV, SI SALE NEGATIVO AUN QUEDA DEUDA, SI SALE POSITIVO QUEDA LIBRE*/
													// deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = 0;
													var posintLessAbonoLimpio;
													if(deudaOrdinarioSuma>0)
													{
														posintLessAbonoLimpio = Math.abs(intLessAbonoLimpio) - deudaOrdinarioSuma;
													}
													else
													{
														posintLessAbonoLimpio = Math.abs(intLessAbonoLimpio);
													}


													if (posintLessAbonoLimpio >= 0)
													{
														posintLessAbonoLimpio = Math.abs(posintLessAbonoLimpio);
														if(sumaOrdinarios()>0)
														{
															// alert('SMN HDTRPM LLEGASTE AQUI');
															posintLessAbonoLimpio = posintLessAbonoLimpio - sumaOrdinarios();
														}

														// posintLessAbonoLimpio = Math.abs(posintLessAbonoLimpio);
														// alert("ALV JAJA" + $('#resMoratorioAdeuto').val());
														// alert('POSITIVO ' + posintLessAbonoLimpio);
														$('#resOrdinarioAdeuto').val(0);
														$('#resOrdinarioAdeuto').click();
														limpiaAdeudoOrdinario();
														total = posintLessAbonoLimpio;
														saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'] = $scope.alphaNumeric[posPay]['saldo'] - posintLessAbonoLimpio;

														// alert('CHECKPOINT');

														//ORIGINAL12FEB
														// posintLessAbonoLimpio = Math.abs(posintLessAbonoLimpio);
														// alert("ALV JAJA" + $('#resMoratorioAdeuto').val());
														// alert('POSITIVO ' + posintLessAbonoLimpio);
														// $('#resOrdinarioAdeuto').val(0);
														// $('#resOrdinarioAdeuto').click();
														// limpiaAdeudoOrdinario();
														// total = posintLessAbonoLimpio;
														// saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[x]['saldo'] = $scope.alphaNumeric[x]['saldo'] - posintLessAbonoLimpio;
													}
													else
													{
														// posintLessAbonoLimpio = Math.abs(posintLessAbonoLimpio);
														// alert('AUN QUEDA DEUDA NEGATIVO ' + posintLessAbonoLimpio);
														$('#resOrdinarioAdeuto').val(posintLessAbonoLimpio);
														$('#resOrdinarioAdeuto').click();
													}




													/*var posintLessAbonoLimpio = Math.abs(intLessAbonoLimpio) - deudaOrdinarioSuma;
													alert(posintLessAbonoLimpio);
													posintLessAbonoLimpio = Math.abs(posintLessAbonoLimpio);
													saldo=$scope.infoMoratorio.si=$scope.alphaNumeric[x]['saldo']=$scope.alphaNumeric[x]['saldo']-posintLessAbonoLimpio;
													deudaOrdinario = $scope.alphaNumeric[posPay]['deudaOrdinario']=0;
													limpiaAdeudoOrdinario();
													total = posintLessAbonoLimpio;
													$('#resOrdinarioAdeuto').val(0);
													$('#resOrdinarioAdeuto').click();*/
												}
												//vamoaver
											}
											console.log("resultado tratado" + resultado);
											console.log(provA);
											console.log($scope.alphaNumeric[posPay]['deudaMoratorio']);
										}
										else
										{
											// total = $scope.infoMoratorio.total =total-provA; /*orioginal de la funcion*/
											total = $scope.alphaNumeric[posPay]['total'] - provA;
											saldo=$scope.infoMoratorio.si=$scope.alphaNumeric[x]['saldo']=$scope.alphaNumeric[x]['saldo']+provA;
											console.log('Llegue a NO descontar a los adeudos moratorios');
											interesMoratorio = IM;
										}
										/*exitcode*/
									}
									else
									{
										/*sí en la segunda posición el interes moratorio es mayor que el importe*/
										//empieza val
										if($scope.alphaNumeric[posPay]['disp']!=0 || $scope.alphaNumeric[posPay]['disp']==1)
										{
											var provA = $scope.alphaNumeric[posPay]['importe'] - IM;
											if(provA>0)
											{
												// alert('QWERTY');
												total = provA;
												saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si =  saldo+provA;
												$scope.alphaNumeric[i]['interesMoratorio'] = 0;
												console.log("interes Moratoprio: " + $scope.alphaNumeric[i]['interesMoratorio']);
												$scope.alphaNumeric[posPay]['interesMoratorio'] = 0;
												deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio']=0;
												interesMoratorio = IM;
											}
											else/*5654.61;*/
											{
												// alert('ASDFGH ' + $scope.alphaNumeric[posPay]['importe']);
												/*sí en la primera posición el interes moratorio es mayor que el imprte*/
												var positivNumbe=Math.abs(provA);
												var decNum= positivNumbe.toFixed(2);
												total = $scope.alphaNumeric[posPay]['total'] = 0;
												$scope.alphaNumeric[posPay]['interesMoratorio'] = positivNumbe;
												interesMoratorio = IM;
												console.log("IM " + IM);
												deudaOrdinario = $scope.alphaNumeric[posPay]['deudaOrdinario'] = interes;
												var resultado=0;
												for(var b=0; b<=posPay; b++)
												{
													// console.log("LAP: " + b);
													// console.log($scope.alphaNumeric[b]['interesMoratorio']);
													if($scope.alphaNumeric[b]['interesMoratorio'] != 0 || $scope.alphaNumeric[b]['interesMoratorio'] != "")
													{
														resultado += $scope.alphaNumeric[b]['interesMoratorio'];
													}
													else
													{
														resultado +=0;
														console.log("En la vuelta " + b + "sumer un cero porque no había nada alv");
													}
													console.log("Suma total de valores: " + resultado);
												}
												/*setear el valor al input de prueba*/
												var sumaAdeudosOrdinario = sumaOrdinarios();
												$('#resMoratorioAdeuto').val(resultado.toFixed(2));
												$('#resOrdinarioAdeuto').val(sumaAdeudosOrdinario);
												$('#resOrdinarioAdeuto').click();//darle formato a ese campo
												// $('#resMoratorioAdeuto').click();
												/*simular el click para que se detone el evento y le de formato de money*/
												document.getElementById('resMoratorioAdeuto').click();
												deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio']=resultado;
												console.log($scope.alphaNumeric);
												// saldo = $scope.alphaNumeric[x]['saldo'] = $scope.infoMoratorio.si =  saldo;
												// interes
												//Moratorio = resultado;
												//
												saldo=$scope.alphaNumeric[posPay]['saldo'];

											}
											dispPC = $scope.alphaNumeric[posPay]['disp']=  1; //$scope.alphaNumeric[posPay]['disp'] = 1;
										}
										//termina val
									}
									console.log("El cúmulo de interes hasta el punto es: " + $scope.alphaNumeric[i]['deudaMoratorio']);
									/*******************/
									/*}*/
								}
								/*END*/
								/*st new
								for(var x=0; x<posicionPago; x++)
								{

								}
								end new*/
								console.log("disp de esta posicion:" + $scope.alphaNumeric[posPay]['disp']);
							}
							/*fin de new part*/
						}
					}
					else
					{
						deudaOrdinario=0;
						if ($scope.alphaNumeric[posicionPago]['interesMoratorio'] == 0)
						{
							//Hace el calculo cuando es apartir de la tercera posición
							dispPC = $scope.alphaNumeric[posPay]['disp'] =0;
							importe			= $scope.alphaNumeric[posPay]['importe']=0;
							diasRetraso		= $scope.alphaNumeric[posPay]['diasRetraso']=0;
							interesMoratorio = $scope.alphaNumeric[posPay]['interesMoratorio']=0;
							// interes = $scope.alphaNumeric[i]['interes'];
							capital = $scope.alphaNumeric[(i)]['capital'];

							var siVal =$scope.infoMoratorio.si;
							interes = $scope.alphaNumeric[i]['interes'];
							// saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'];
							total = $scope.infoMoratorio.total= $scope.alphaNumeric[i]['capital'] + $scope.alphaNumeric[i]['interes'];

							if($scope.alphaNumeric[posPay]['importe'] == 0 && $scope.alphaNumeric[posPay]['diasRetraso']==0)
							{
								if($scope.alphaNumeric[i]['pago'] > posicionPago)
								{
									//$scope.infoMoratorio.si
									//saldo =  $scope.infoMoratorio.si =(($scope.infoMoratorio.si-$scope.alphaNumeric[i]['capital']))

									if($('#msiField').val()< posicionPago )
									{
										if ($scope.alphaNumeric[i]['pago'] > posicionPago) {
											saldo = $scope.alphaNumeric[posPay]['saldo'];
										}else{
											saldo=$scope.alphaNumeric[x]['saldo'];
										}
									}
									else
									{
										saldo=$scope.alphaNumeric[posPay]['saldo'];

									}

									// if($('#msiField').val()>0)
									// {
									// 	if($scope.total2 > 0)
									// 	{
									// 		saldo=$scope.total2;
									// 	}
									// 	else
									// 	{
									// 		saldo=$scope.alphaNumeric[x]['saldo'];
									// 	}
									// }
									// else
									// {
									// 	console.log('VAMOSA VER KEONDA: ', $scope.alphaNumeric);
									// 	console.log('SITIO posicionPago: ', posicionPago);
									// 	console.log("$scope.alphaNumeric[posPay]['importe']: ", $scope.alphaNumeric[posPay]['importe']);
									// 	console.log("$scope.alphaNumeric[posPay]['diasRetraso']: ", $scope.alphaNumeric[posPay]['diasRetraso']);
									// 	saldo=$scope.alphaNumeric[(posicionPago-1)]['saldo'];
									//
									// }
									// alert(i + " this is saldo " + $scope.alphaNumeric[x]['saldo']);
								}
								else
								{
									for(var x=0; x < posicionPago ; x++)
									{
										saldo= $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
										//test fields
										// total = $scope.alphaNumeric[i]['capital']+$scope.alphaNumeric[i]['interes'];
										// interes = $scope.alphaNumeric[i]['interes'];
										// capital = $scope.alphaNumeric[i]['capital'];
										// total = $scope.alphaNumeric[i]['total'];
									}
								}
							}
							else
							{
								saldo =  $scope.infoMoratorio.si =$scope.infoMoratorio.si-$scope.alphaNumeric[posPay]['total'];
							}
						}
						else
						{
							if ($scope.alphaNumeric[posPay]['pago'] >= posicionPago || $scope.alphaNumeric[posPay]['pago'] <= posicionPago)
							{
								if ($scope.alphaNumeric[posicionPago]['disp'] == 1)
								{
									//aqui se coloca cuando se hay pagos abajo del nuevo, ejemplo Pago 5:550 y se quiere colocar uno en el 2
									dispPC = $scope.alphaNumeric[posPay]['disp']=  1;
									saldo =  $scope.infoMoratorio.si =$scope.alphaNumeric[i]['saldo'];
									importe			= $scope.alphaNumeric[posPay]['importe'] = $scope.alphaNumeric[posPay]['importe'];
									diasRetraso		= $scope.alphaNumeric[posPay]['diasRetraso'] = $scope.alphaNumeric[posPay]['diasRetraso'];
									interesMoratorio = $scope.alphaNumeric[posPay]['interesMoratorio'] = $scope.alphaNumeric[posPay]['interesMoratorio'];
								}
								else
								{//se coloca un valor cuando nohay nada(el resto de los campos, apartir de la segunda posicion, else de la primera posicion
									dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
								}
							}
							else
							{
								//cuando se salta un espacio en la tabla
								saldo =  $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1;
								total = 90;
							}
						}
					}
					$scope.interes_plan2 =$scope.alphaNumeric[i]['saldoNormal']* ($scope.infoMoratorio.interes_p2);
					$scope.capital2 = ($scope.p2 - $scope.interes_plan2);
					range2.push({
						"fecha" :$scope.fechapago,
						"pago" : i + 1,
						"capital" :capital,
						"interes" : interes,
						"importe" : importe,
						"diasRetraso" : diasRetraso,
						"interesMoratorio" : interesMoratorio,
						"deudaMoratorio": deudaMoratorio,
						"deudaOrdinario" : deudaOrdinario,
						"total" : total, //$scope.infoMoratorio.capital + $scope.infoMoratorio.interes_p1
						"saldo" : saldo,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
						"saldoNormal" : $scope.alphaNumeric[i]['saldoNormal'],
						"disp" : dispPC,
						"min" : minVal,
						"max": maxVal
					});
				}
				else
				{
					/*Entra cuando te saltas espacios despues de la primera posicion*/
					range2.push({
						"fecha": $scope.fechapago,
						"pago": i + 1,
						"capital": $scope.alphaNumeric[i]['capital'],
						"interes": $scope.alphaNumeric[i]['interes'],
						"importe": $scope.alphaNumeric[i]['importe'],
						"diasRetraso": $scope.alphaNumeric[i]['diasRetraso'],
						"interesMoratorio": $scope.alphaNumeric[i]['interesMoratorio'],
						"deudaMoratorio" : $scope.alphaNumeric[i]['deudaMoratorio'],
						"deudaOrdinario" : $scope.alphaNumeric[i]['deudaOrdinario'],
						"total": $scope.alphaNumeric[i]['total'], //$scope.infoMoratorio.capital + $scope.infoMoratorio.interes_p1
						"saldo": $scope.alphaNumeric[i]['saldo'],//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
						"saldoNormal" : $scope.alphaNumeric[i]['saldoNormal'],
						"disp": $scope.alphaNumeric[i]['disp']
					});
				}
				// }
				// else
				// {
				// 	/*Cuando estén combinados MSI y MCI*/
				// 	range2.push({
				// 			"fecha" :$scope.fechapago,
				// 			"pago" : i+1,
				// 			"capital" : ($scope.infoMoratorio.capital=($scope.p2 - $scope.interes_plan2)),
				// 			"interes" : ($scope.interes_plan2=($scope.total2*$scope.infoMoratorio.interes_p2)),
				// 			"importe" : 0,
				// 			"diasRetraso" : 0,
				// 			"interesMoratorio" : 0,
				// 			"total" : $scope.p2,
				// 			"saldo" : $scope.total2=($scope.total2 - $scope.capital2),//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
				// 			"disp" : disp
				// 		});
				// }



				/*original*/
				// $scope.interes_plan2 = $scope.total2*($scope.infoMoratorio.interes_p2);
				// $scope.capital2 = ($scope.p2 - $scope.interes_plan2);
				// range2.push({
				// 	"fecha" :$scope.fechapago,
				// 	"pago" : i+1,
				// 	"capital" : ($scope.infoMoratorio.capital=($scope.p2 - $scope.interes_plan2)),
				// 	"interes" : ($scope.interes_plan2=($scope.total2*$scope.infoMoratorio.interes_p2)),
				// 	"importe" : 0,
				// 	"diasRetraso" : 0,
				// 	"interesMoratorio" : 0,
				// 	"total" : $scope.p2,
				// 	"saldo" : $scope.total2=($scope.total2 - $scope.capital2),//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
				// 	"disp" : disp
				// });
				console.log("Part of range II de JS EXTERNO");
				mes++;

				if (i == ($scope.infoMoratorio.plazo - 1))
				{
					$scope.totalSegundoPlan = $scope.p2;
				}
				$scope.finalMesesp2 = (range2.length);
			}
			$scope.range2= range2;
			$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
			$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2);
			/**/
			// console.log($scope.alphaNumeric);
			$scope.dtoptions = DTOptionsBuilder;
			$scope.dtColumns = [
				DTColumnBuilder.newColumn('fecha').withTitle('Fechas'),
				DTColumnBuilder.newColumn('amc').withTitle('Pagados')
					.renderWith(
						function (data, type, full, meta) {
							// console.log(full['check']);
							if(full['check'] == 1)
							{
								var inputCapital = '<input name="checkAd' + full["pago"] + '" type="checkbox" id="ckNoPay' + full["pago"] + '" checked disabled>';//onchange="pagoCapChange('+full["pago"]+')"
								return inputCapital;
							}
							else
							{
								var inputCapital = '<input name="checkAd' + full["pago"] + '" type="checkbox" id="ckNoPay' + full["pago"] + '" onchange="noPayMen(' + full["pago"] + ')">';//onchange="pagoCapChange('+full["pago"]+')"
								return inputCapital;
							}
							// var inputCapital = '<input name="checkAd' + full["pago"] + '" type="checkbox" id="ckNoPay' + full["pago"] + '" onchange="noPayMen(' + full["pago"] + ')">';//onchange="pagoCapChange('+full["pago"]+')"
							// return inputCapital;
						},
					),
				DTColumnBuilder.newColumn('pago').withTitle('Pago #'),
				DTColumnBuilder.newColumn('capital').withTitle('Capital').renderWith(
					function (data, type, full)
					{
						var showDescMens;
						if(full['importe']<full['interesMoratorio'])
						{
							showDescMens = '<br><span style="color:red;font-size: 0.8em"><i>No se abonó nada a capital</i></span>';
						}
						else
						{
							if(full['importe']=="" || full['importe']==0)
							{
								showDescMens = '<br><span style="color:red;font-size: 0.8em"><i>No se abonó nada a capital</i></span>';
							}
							else
							{
								// showDescMens = '<br><span style="color:red;font-size: 0.8em"><i>'+full['total'].toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})+'</i></span>';
								var intOrd = full['interes'];
								if(intOrd==0 || intOrd=="")
								{
									showDescMens = '<br><span style="color:red;font-size: 0.8em"><i>'+full['total'].toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})+'</i></span>';
								}
								else
								{

									showDescMens = '<br><span style="color:red;font-size: 0.8em"><i>Primero descuenta a Intereses ordinarios</i></span>';

									// showDescMens = '<br><span style="color:red;font-size: 0.8em"><i>Primero descuenta a Intereses ordinarios</i></span>';
								}
							}
						}
						return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})) + showDescMens
					}),
				DTColumnBuilder.newColumn('interes').withTitle('Intereses').renderWith(function (data, type, full)
				{
					var showDescInt;
					var intOrd = full['interes'];
					if(intOrd<=full['total'])
					{
						showDescInt = '<br><span style="color:red;font-size: 0.8em"><i>'+full['interes'].toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})+'</i></span>';
					}
					else
					{
						if(full['deudaOrdinario'] <= 0 || full['deudaOrdinario']==undefined)//si no hay nada en el adeudo
						{
							let deudaOrdinario= (full['deudaOrdinario']==undefined) ? 0 : full['deudaOrdinario'];
							showDescInt = '<br><span style="color:red;font-size: 0.8em"><i>Se liquidó el interes: '+deudaOrdinario.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})+'</i></span>';
							console.log("if liquido", full['deudaOrdinario']);

						}
						else
						{
							console.log("else", full['deudaOrdinario']);
							showDescInt = '<br><span style="color:red;font-size: 0.8em"><i>No se liquidó este interes: '+full['deudaOrdinario'].toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})+'</i></span>';
						}
						// showDescInt = '<br><span style="color:red;font-size: 0.8em"><i>No se liquidó este interes: '+full['deudaOrdinario'].toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})+'</i></span>';
					}
					// var inputOrdAdeudo = '<input type="text" id="adeudoOrd'+full['pago']+'">';
					return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})) + showDescInt;
				}),
				DTColumnBuilder.newColumn('importe').withTitle('Importe')
					.renderWith(
						function(data, type, full, meta)
						{
							// var inputCapital = '<input name="importe'+full["pago"]+'" type="number" id="idImporte'+full["pago"]+'"   placeholder="Importe" class="form-control">';//onchange="pagoCapChange('+full["pago"]+')"
							// var numberPay	 = '<input name="numberPay'+full["pago"]+'" type="hidden" id="payNum'+full["pago"]+'" value="'+full["pago"]+'">';

							// return inputCapital+numberPay;
							if($scope.alphaNumeric[(full['pago']-1)]['disp']==1 && $scope.alphaNumeric[(full['pago']-1)]['importe']!="" && full['importe']!="")//
							{
								// var inputCapital = '<input name="importe' + full["pago"] + '"  id="idImporte' + full["pago"] + '"   placeholder="Importe" class="form-control" value="' +full['importe'] + '" type="tel" pattern="^\\$\\d{1,3}(,\\d{3})*(\\.\\d+)?$"  data-type="currency" >';//onchange="pagoCapChange('+full["pago"]+')"
								var input_val = full['importe'];

								// don't validate empty input
								if (input_val === "") { return; }

								// original length
								var original_len = input_val.length;



								// check for decimal
								if (input_val.indexOf(".") >= 0) {

									// get position of first decimal
									// this prevents multiple decimals from
									// being entered
									var decimal_pos = input_val.indexOf(".");

									// split number by decimal point
									var left_side = input_val.substring(0, decimal_pos);
									var right_side = input_val.substring(decimal_pos);

									// add commas to left side of number
									left_side = formatNumber(left_side);

									// validate right side
									right_side = formatNumber(right_side);

									// On blur make sure 2 numbers after decimal
									if (blur === "blur") {
										right_side += "00";
									}

									// Limit decimal to only 2 digits
									right_side = right_side.substring(0, 2);

									// join number by .
									input_val = "$" + left_side + "." + right_side;

								} else {
									// no decimal entered
									// add commas to number
									// remove all non-digits
									input_val = formatNumber(input_val);
									input_val = "$" + input_val;

									// final formatting
									if (blur === "blur") {
										input_val += ".00";
									}
								}
								// console.log(input_val);
								var inputCapital = input_val;
								// let importeMoney = formatNumber(full['importe']);
								// console.log(importeMoney);
								var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
								return inputCapital + numberPay;
							}
							else
							{
								if(full['check'] ==1)
								{
									var inputCapital = '<input name="importe' + full["pago"] + '" type="number" id="idImporte' + full["pago"] + '"  disabled placeholder="Importe" class="form-control">';//onchange="pagoCapChange('+full["pago"]+')"
									var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '"  value="'+full["pago"]+'">';
									return inputCapital + numberPay;
								}
								else
								{
									var inputCapital = '<input name="importe' + full["pago"] + '" type="number" id="idImporte' + full["pago"] + '"   placeholder="Importe" class="form-control">';//onchange="pagoCapChange('+full["pago"]+')"
									var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '"  value="'+full["pago"]+'">';
									return inputCapital + numberPay;
								}
							}
						},
					),
				DTColumnBuilder.newColumn('diasRetraso').withTitle('Días de retraso')
					.renderWith(
						function(data, type, full, meta)
						{
							/*Original vars*/
							var inputCapital;

							/*add vars*/
							var dateCurrent = full['fecha'];
							var datePays = dateCurrent.split("-").reverse().join("-");

							var dayPay;
							var posicionDate = dateCurrent.split('-');
							var mesPay = posicionDate[1];
							var anioPay = posicionDate[2];
							dayPay=daysInMonth(mesPay, anioPay);
							/*close add vars*/

							if($scope.alphaNumeric[(full['pago']-1)]['disp']==1 && $scope.alphaNumeric[(full['pago']-1)]['diasRetraso']!="" && full['diasRetraso']!="")//
							{
								/*original content*/
								/*inputCapital = '<input name="dRet' + full["pago"] + '" type="number" id="idDiasRet' + full["pago"] + '"  onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Días retardo" class="form-control" value="' + full['diasRetraso'] + '">';
                                return inputCapital;*/
								/*close original content*/

								/*new content*/
								/*var currentDateRow = '<input name="pagoDia'+full["pago"]+'" id="payDay'+full["pago"]+'" type="hidden" value="'+datePays+'"> ';
                                var inputCapital = '<input name="dRet'+full["pago"]+'" type="date" id="idDiasRet'+full["pago"]+'" onchange="pagoCapChange('+full["pago"]+')" min="'+anioPay+'-'+mesPay+'-01" max="'+anioPay+'-'+mesPay+'-'+dayPay+'"  placeholder="Días retardo" class="form-control" disabled>';
                                return inputCapital+currentDateRow;*/
								inputCapital = '<input name="dRet' + full["pago"] + '" type="number" id="idDiasRet' + full["pago"] + '"   placeholder="Días retardo" value="'+full['diasRetraso']+'" class="form-control"  disabled>';
								return inputCapital;
								/*close new content*/
							}
							else
							{
								if(full['check'] ==1)
								{
									/*original content*/
									inputCapital = '<input name="dRet' + full["pago"] + '" type="number" id="idDiasRet' + full["pago"] + '"   placeholder="Días retardo" class="form-control"  disabled>';
									return inputCapital;
									/*close original content*/

									/*new content*/

									/*close new content*/
								}
								else
								{
									/*original content*/
									/* inputCapital = '<input name="dRet' + full["pago"] + '" type="number" id="idDiasRet' + full["pago"] + '"  onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Días retardo" class="form-control">';
                                    return inputCapital;*/
									/*close original content*/

									/*new content*/
									var currentDateRow = '<input name="pagoDia'+full["pago"]+'" id="payDay'+full["pago"]+'" type="hidden" value="'+datePays+'"> ';
									var inputCapital = '<input name="dRet'+full["pago"]+'" type="date" id="idDiasRet'+full["pago"]+'" onchange="pagoCapChange('+full["pago"]+')" min="'+anioPay+'-'+mesPay+'-01"  placeholder="Días retardo" class="form-control">';/*max="'+anioPay+'-'+mesPay+'-'+dayPay+'" */
									return inputCapital+currentDateRow;
									/*close new content*/
								}
							}
						},
					),
				DTColumnBuilder.newColumn('interesMoratorio').withTitle('Interés Moratorio').renderWith(
					function (data, type, full)
					{
						// return (IM).toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})
						// console.log($scope.alphaNumeric[(full['pago']-1)]);
						if($scope.alphaNumeric[(full['pago']-1)]['disp']==1 && $scope.alphaNumeric[(full['pago']-1)]['interesMoratorio']!="" && full['interesMoratorio']!="")//
						{
							return $scope.alphaNumeric[(full['pago']-1)]['interesMoratorio'].toLocaleString('es-MX', {style: 'currency', currency: 'MXN'});
							// return $scope.alphaNumeric[(full['pago']-1)]['interesMoratorio'];
						}
						else {
							return ((0.00).toFixed(2)).toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})
						}
					}
				),
				DTColumnBuilder.newColumn('total').withTitle('Total').renderWith(function (data, type, full)
				{return (data).toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})} ),
				DTColumnBuilder.newColumn('saldo').withTitle('Saldo Moratorio').renderWith(function (data, type, full)
				{
					var numberFix = data.toFixed(2);
					var saldoInsolutoCR = '<input name="si'+full["pago"]+'" type="hidden" id="idSi'+full["pago"]+'"  value="'+numberFix+'" class="form-control">'
					if($scope.alphaNumeric[full['pago']-1]['saldo'] <= 0)
					{
						$scope.alphaNumeric[full['pago']-1]['saldo'] = 0;
					}
					return (data).toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}) + saldoInsolutoCR;
				}),
				DTColumnBuilder.newColumn('saldoNormal').withTitle('Saldo').renderWith(function (data, type, full)
				{
					var saldoInsolutoCRNormal = '<input name="siNormal'+full["pago"]+'" type="hidden" id="idSiNormal'+full["pago"]+'"  value="'+full['saldoNormal']+'" class="form-control">';//onchange="pagoCapChange('+full["pago"]+')"

					return (data).toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}) + saldoInsolutoCRNormal;
				} ),
			];
			/**/
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
	/*termina calculo de mensualidades*/

	/*Calculo de mensualidades*/
	if($scope.infoMoratorio.plazo >= 121 && $scope.infoMoratorio.plazo  <= 240) {
		// alert('ALV NOTEPASESDELANZABANDAAAAAAAAA');
		var range=[];
		ini = ($scope.mesesdiferir > 0) ? $scope.mesesdiferir : $scope.infoMoratorio.contadorInicial;
		if($scope.infoMoratorio.plazo >= 0 && $scope.infoMoratorio.plazo <=240)
		{
			for (var i = ini; i <= $scope.infoMoratorio.mesesSinInteresP1-1; i++)
			{
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

				$scope.fechapago = day + '-' + mes + '-' + yearc;

				if(i == 0){
					$scope.fechaPM = $scope.fechapago;
				}

				/*nuevo código 27  de noviembre*/
				var interes = 0;
				var total = 0;
				var capital =0;
				var saldo=0;
				var	importe=0;
				var diasRetraso=0;
				var interesMoratorio=0;
				if($scope.infoMoratorio.mesesSinInteresP1 == 0)
				{
					/*Esto no hace nada jajaja xdxdxd*/
					interes = ($scope.interes_plan=($scope.infoMoratorio.si*$scope.infoMoratorio.interes_p2));
					capital = ($scope.infoMoratorio.capital=(($scope.infoMoratorio.interes_p2 *  Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1) * $scope.infoMoratorio.si) / ( Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1 )-1) - $scope.interes_plan));
					total = ($scope.infoMoratorio.interes_p2 *  Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1) * $scope.infoMoratorio.si) / ( Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1 )-1);
					console.log("Entraste a meses 0");
				}
				else
				{
					if(arrayCheckAllPost.includes((i)))
					{
						console.log("Este número si está: " + i);
						check=1;
					}
					else
					{
						check=0;
						console.log("Entré aqui II");
					}
					capital = $scope.infoMoratorio.capital;
					interes=0;
					total = $scope.infoMoratorio.capital + $scope.infoMoratorio.interes_p1;
					/*new part 21219*/
					var alphaOriginal=[];
					alphaOriginal=$scope.alphaNumeric;
					if($scope.alphaNumeric[i]['disp'] != 1)
					{
						/*Para verfificar donde se puso el pago a capital*/
						var vuelta = (i + 1);
						var posicionPago = (posPay + 1);
						if (vuelta == posicionPago)
						{
							if (posicionPago == 1)
							{
								if($scope.alphaNumeric[posPay]['check'] ==1)
								{
									/*si hay un check (osea que no está pagado) dejar el total*/
									total = $scope.alphaNumeric[posPay]['total'] = $scope.infoMoratorio.total ;
									saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si=1000000 ;
								}
								else
								{
									var dispPC;
									/* Este if es para ver si se descuenta la primera posicion*/
									// newSaldoTable = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'];
									// interesMoratorio = $scope.alphaNumeric[posPay]['interesMoratorio'] = $scope.infoMoratorio.interesMoratorio=IM;// $scope.alphaNumeric[posPay]['interesMoratorio'] = IM;
									// console.log('se descuenta de la primera posicion');
									saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'];//$scope.alphaNumeric[posPay]['saldo']=saldoInsoluto-$scope.alphaNumeric[posPay]['total']
									importe			=	 $scope.alphaNumeric[posPay]['importe'] = $scope.infoMoratorio.importe	= importeSaldoI;//$scope.alphaNumeric[posPay]['importe']
									diasRetraso		=	 $scope.alphaNumeric[posPay]['diasRetraso'] = $scope.infoMoratorio.diasRetraso = diasRetardo; //$scope.alphaNumeric[posPay]['diasRetraso']
									// console.log(saldo);
									if(IM > 0)
									{
										if($scope.alphaNumeric[posPay]['disp']!=0 || $scope.alphaNumeric[posPay]['disp']==1)
										{
											// console.log(IM);
											var provA = $scope.alphaNumeric[posPay]['importe'] - IM;
											// total = $scope.alphaNumeric[posPay]['total'] = $scope.infoMoratorio.total = interesMoratorio + total;
											if(provA>0)
											{
												resultado=$scope.alphaNumeric[posPay]['deudaMoratorio']-provA;
												total = resultado;//total = $scope.alphaNumeric[posPay]['total'] - provA
												// console.log(provA);
												saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si =  saldo - provA;//saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si =  saldo+$scope.alphaNumeric[posPay]['total'];
												$scope.alphaNumeric[i]['interesMoratorio'] = 0;
												$scope.alphaNumeric[i]['total'] = 0;
												// console.log("interes Moratoprio: " + $scope.alphaNumeric[i]['interesMoratorio']);
												// $scope.alphaNumeric[posPay]['interesMoratorio'] = 0;
												deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = 0;
											}
											else
											{
												/*sí en la primera posición el interes moratorio es mayor que el imprte*/

												var positivNumbe=Math.abs(provA);
												saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si =  saldo;
												var decNum= positivNumbe.toFixed(2);
												total = $scope.alphaNumeric[posPay]['total'] = 0;
												interesMoratorio = IM;
												$scope.alphaNumeric[i]['interesMoratorio'] = positivNumbe;
												deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = positivNumbe;
												$('#resMoratorioAdeuto').val(positivNumbe);
												$('#resMoratorioAdeuto').click();
												// console.log("interes Moratoprio: " + $scope.alphaNumeric[i]['interesMoratorio']);
											}
											dispPC = $scope.alphaNumeric[posPay]['disp']=  1; //$scope.alphaNumeric[posPay]['disp'] = 1;
										}
									}
								}
							}
							else
							{
								/* Este else es para ver si se descuenta apartir de la segunda posicion*/
								console.log("Segunda posicion");
								importe			= $scope.infoMoratorio.importe		= $scope.alphaNumeric[posPay]['importe'] = importeSaldoI;
								diasRetraso		= $scope.infoMoratorio.diasRetraso	= $scope.alphaNumeric[posPay]['diasRetraso'] = diasRetardo;
								dispPC		= $scope.infoMoratorio.disp	= $scope.alphaNumeric[posPay]['disp'] = 1;
								if(IM > 0)
								{
									if($scope.alphaNumeric[posPay]['disp']!=0 || $scope.alphaNumeric[posPay]['disp']==1)
									{
										var provA = $scope.alphaNumeric[posPay]['importe'] - IM;
										var billMoratorio;
										if($scope.alphaNumeric[posPay]['deudaMoratorio']!=undefined)
										{
											var cumuloMoratorio = $('#acumuladoBruto').val();
											billMoratorio = cumuloMoratorio - provA;
										}
										else
										{
											// var neg = provA;
											billMoratorio = (-provA);
											// billMoratorio = Math.sign(billMoratorio);
										}
										// console.log(suma);
										if(provA>0)
										{
											if(billMoratorio>0)
											{
												if(billMoratorio>0)//El pago(importe) no liquido la deuda y se sigue endeudando
												{
													//descontar a capital
													$('#acumuladoBruto').val(billMoratorio.toFixed(2));
													// alert("Aún hay una deuda " + $scope.alphaNumeric[i]['deudaMoratorio'] + " pv " + provA);
													$('#resMoratorioAdeuto').val(billMoratorio);
													$('#resMoratorioAdeuto').click();
													interesMoratorio = IM;
													$scope.alphaNumeric[i]['interesMoratorio'] = billMoratorio;
													total = $scope.alphaNumeric[i]['total'] = 0;
													deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'] = billMoratorio;
													// break;
													//148
												}
												else
												{
													var importeLibreCapital;
													//añadir adeudo a moratorio porque no se cubrio
													//El valor llega negativo ya que el importe alcanzó a subrir el adeudo moratorio
													if(billMoratorio < 0)
													{
														importeLibreCapital = Math.abs(billMoratorio);
													}
													else
													{
														importeLibreCapital = billMoratorio;
													}
													// console.log("CHECK DE CONTROL ALV: " + importeLibreCapital);
													// alert("Tu pago genera más adeudo: "  + $scope.alphaNumeric[i]['deudaMoratorio']);
													total = $scope.alphaNumeric[i]['total'] = importeLibreCapital;
													saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.alphaNumeric[posPay]['saldo'] - total;
												}
											}
											else
											{
												// alert("Liquidaste tu deuda ok");

												//cuando no hay adeudo pasa directamenta a descontar al capital
												//El valor llega negativo ya que no hay un adeudo y pasa negativo el restante (Importe-IM)
												var abonoLibre = Math.abs(billMoratorio);
												// alert("En este pago no hay un adeudo pendiente >> next" + provA + " : " + abonoLibre + " : " + billMoratorio);
												total = $scope.alphaNumeric[posPay]['total'] = abonoLibre;//pasalo a positivo
												saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.alphaNumeric[posPay]['saldo'] - abonoLibre;
												// deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = 0;
												interesMoratorio = IM;
												$('#resMoratorioAdeuto').val(0);
												$('#resMoratorioAdeuto').click();
												$('#acumuladoBruto').val(0);
												for(var b=0; b < $scope.alphaNumeric.length; b++)
												{
													console.log(posPay + " <--pospay-postionB--> " + b);
													if (b>=posPay) {
														$scope.alphaNumeric[b]['interesMoratorio'] = 0;
														$scope.alphaNumeric[b]['deudaMoratorio'] = 0;
													}
													else
													{
														interesMoratorio = $scope.alphaNumeric[b]['interesMoratorio'] = IM;
														// $scope.alphaNumeric[i]['deudaMoratorio'] = positivNumbe;
														deudaMoratorio = $scope.alphaNumeric[b]['deudaMoratorio'] = 0;
													}
													console.log(b);
													console.log($scope.alphaNumeric[b]['deudaMoratorio']);
													console.log($scope.alphaNumeric[b]['interesMoratorio']);
												}
											}
										}
										else
										{	/*sí en la primera posición el interes moratorio es mayor que el imprte*/
											//Acumulacion de adeudos
											console.log("from else: " + provA);
											// break;
											var positivNumbe=Math.abs(provA);
											var decNum= positivNumbe.toFixed( 2);
											//Se le setea 0 al total ya que no abono nada a la capital, genero más adeudo el moratorio
											total = $scope.alphaNumeric[i]['total'] = 0;
											saldo = $scope.alphaNumeric[i]['saldo'];

											interesMoratorio = IM;
											deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'] = positivNumbe;

											// console.log("IM " + IM);
											var sumAdeudos=0;
											for(var b=0; b < $scope.alphaNumeric.length; b++)
											{
												console.log(posPay + " <--pospay - postionB --> " + b);
												if (posPay != b) {
													$scope.alphaNumeric[i]['interesMoratorio'] = 0;
													$scope.alphaNumeric[i]['deudaMoratorio'] = 0;
													// delete $scope.alphaNumeric[i]["deudaMoratorio"];
													// delete $scope.alphaNumeric[i]["interesMoratorio"];
													// delete $scope.alphaNumeric[i]["deudaMoratorio"];
												}
												else
												{
													interesMoratorio = $scope.alphaNumeric[b]['interesMoratorio'] = IM;
													// $scope.alphaNumeric[i]['deudaMoratorio'] = positivNumbe;
													deudaMoratorio = $scope.alphaNumeric[b]['deudaMoratorio'] = positivNumbe;
												}
												//
												// console.log(b);
												console.log($scope.alphaNumeric[b]['deudaMoratorio']);
												console.log($scope.alphaNumeric[b]['interesMoratorio']);
												if($scope.alphaNumeric[b]['deudaMoratorio'] != undefined && $scope.alphaNumeric[b]['interesMoratorio'] != 0)
												{
													sumAdeudos += $scope.alphaNumeric[b]['deudaMoratorio'];
												}
											}
											console.log("Suma total de valores: " + sumAdeudos);
											$('#acumuladoBruto').val(sumAdeudos.toFixed(2));
											/*setear el valor al input de prueba*/
											$('#resMoratorioAdeuto').val(sumAdeudos);
											$('#resMoratorioAdeuto').click();
											/*simular el click para que se detone el evento y le de formato de money*/
											document.getElementById('resMoratorioAdeuto').click();
											console.log($scope.alphaNumeric);
											// alert("Llegue aqui");
											// var chMD=$('#acumuladoBruto').val();
											// if(chMD == 0 || chMD =="")
											// {
											// 	deudaMoratorio = $scope.alphaNumeric[b]['deudaMoratorio'] = 0;
											// 	// delete $scope.alphaNumeric[g]["deudaMoratorio"];
											// 	// sumAdeudos=0;
											// }
										}
										dispPC = $scope.alphaNumeric[posPay]['disp']=  1; //$scope.alphaNumeric[posPay]['disp'] = 1;
										saldo= $scope.alphaNumeric[i]['saldo'];
									}

									/*end new*/

									// console.log("Adeudos hasta este punto: " + $scope.alphaNumeric[x]['deudaMoratorio']);
								}
							}
						}
						else
						{
							// var saldoNormal =  $scope.infoMoratorio.precioTotal = $scope.infoMoratorio.precioTotal - $scope.infoMoratorio.capital;
							if ($scope.alphaNumeric[posPay]['interesMoratorio'] == 0)/*posionPago*/
							{/*Hace el calculo cuando es apartir de la tercera posición*/
								// newSaldoTable = $scope.infoMoratorio.si = $scope.infoMoratorio.si - $scope.infoMoratorio.capital;
								// saldo =  $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si=($scope.infoMoratorio.si-$scope.alphaNumeric[posPay]['total'])
								dispPC = $scope.alphaNumeric[posPay]['disp'] =0;
								importe			= $scope.alphaNumeric[posPay]['importe']=0;
								diasRetraso		= $scope.alphaNumeric[posPay]['diasRetraso']=0;
								interesMoratorio = $scope.alphaNumeric[i]['interesMoratorio']=0;
								deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'] = 0;
								if($scope.alphaNumeric[posPay]['importe'] ==0 && $scope.alphaNumeric[posPay]['diasRetraso']==0)
								{
									if($scope.alphaNumeric[i]['pago'] > posicionPago)
									{
										saldo = $scope.alphaNumeric[posPay]['saldo'];//saldo =  $scope.infoMoratorio.si =(($scope.infoMoratorio.si-$scope.alphaNumeric[posPay]['total']) + $scope.alphaNumeric[posPay]['interesMoratorio']);
										deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'];
									}
									else
									{
										for(var x=0; x<posicionPago; x++)
										{
											/*correcto*/
											//saldo=$scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];//$scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
											/*var target = angular.element(document.getElementById("#dRet" + x));
											if(document.getElementsByName("dRet"+(i+1))[0].value =="")//document.getElementsByName("dRet"+(i+1))[0].value ==""
											{
												saldo=$scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];//$scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
											}
											else
											{
												saldo=$scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];//$scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
											}*/
											/*En esta parte se le adigna el saldo a la posicion que noha sido afectada*/
											/*UPD actualizacion 24 ENERO, se coloca el saldo de la posicion anterior ya que se
											* descontara conforme a lo que se vaya dando (abonos a capital)*/
											saldo=$scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];//$scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
											deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'] = 0;

										}
									}
								}
								else
								{
									saldo =  $scope.infoMoratorio.si =$scope.infoMoratorio.si-$scope.alphaNumeric[posPay]['total'];//saldo =  $scope.infoMoratorio.si =$scope.infoMoratorio.si-$scope.alphaNumeric[posPay]['total']
									deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'] = 0;
								}
							}
							else
							{
								if ($scope.alphaNumeric[posPay]['pago'] >= posicionPago || $scope.alphaNumeric[posPay]['pago'] <= posicionPago)
								{
									if ($scope.alphaNumeric[posicionPago]['disp'] == 1)
									{
										/*aqui se coloca cuando se hay pagos abajo del nuevo, ejemplo Pago 5:550 y se quiere colocar uno en el 2*/
										dispPC = $scope.alphaNumeric[posPay]['disp']=  1;
										saldo =  $scope.infoMoratorio.si =$scope.alphaNumeric[posPay]['saldo'];
										importe			= $scope.alphaNumeric[posPay]['importe'] = $scope.alphaNumeric[posPay]['importe'];
										diasRetraso		= $scope.alphaNumeric[posPay]['diasRetraso'] = $scope.alphaNumeric[posPay]['diasRetraso'];
										interesMoratorio = $scope.alphaNumeric[posPay]['interesMoratorio'] = $scope.alphaNumeric[posPay]['interesMoratorio'];
									}
									else
									{/*se coloca un valor cuando nohay nada(el resto de los campos, apartir de la segunda posicion, else de la primera posicion*/
										// newSaldoTable = $scope.infoMoratorio. si = $scope.infoMoratorio.si - $scope.infoMoratorio.capital;
										saldo = $scope.alphaNumeric[posPay]['saldo'];//saldo = $scope.infoMoratorio.si = (($scope.infoMoratorio.si-$scope.alphaNumeric[(posPay)]['total']))
										dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
										//saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo']
										deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'] = $scope.alphaNumeric[i]['deudaMoratorio'];
									}
								}
								else
								{
									/*cuando se salta un espacio en la tabla*/
									saldo =  $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1;
									deudaMoratorio = $scope.alphaNumeric[i]['deudaMoratorio'];
								}
							}
						}
						range.push({
							"fecha" :$scope.fechapago,
							"pago" : i + 1,
							"capital" : capital,
							"interes" : interes,
							"importe" : importe,
							"diasRetraso" : diasRetraso,
							"interesMoratorio" : interesMoratorio,
							"deudaMoratorio": deudaMoratorio,
							"total" : total, //$scope.infoMoratorio.capital + $scope.infoMoratorio.interes_p1
							"saldo" : saldo,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital,
							"saldoNormal":  $scope.alphaNumeric[i]['saldoNormal'],/*se coloca la misma informaición que al inicio para respetar la corrida financiera original*/
							"disp" : dispPC,
							"min" : minVal,
							"max": maxVal,
							"check":check
						});
					}
					else
					{
						/*Entra cuando te saltas espacios despues de la primera posicion*/
						range.push({
							"fecha" :$scope.fechapago,
							"pago" : i + 1,
							"capital" : $scope.alphaNumeric[i]['capital'],
							"interes" : $scope.alphaNumeric[i]['interes'],
							"importe" : $scope.alphaNumeric[i]['importe'],
							"diasRetraso" :  $scope.alphaNumeric[i]['diasRetraso'],
							"interesMoratorio" : $scope.alphaNumeric[i]['interesMoratorio'],
							"deudaMoratorio" : $scope.alphaNumeric[i]['deudaMoratorio'],
							"total" : $scope.alphaNumeric[i]['total'], //$scope.infoMoratorio.capital + $scope.infoMoratorio.interes_p1
							"saldo" : $scope.alphaNumeric[i]['saldo'],//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
							"saldoNormal":  $scope.alphaNumeric[i]['saldoNormal'],//$scope.alphaNumeric[i]['saldoNormal']
							"disp" : $scope.alphaNumeric[i]['disp'],
							"check" : $scope.alphaNumeric[i]['check']
						});
					}
				}
				mes++;

				if (i-1 == ($scope.infoMoratorio.mesesSinInteresP1-1))//($scope.infoMoratorio.mesesSinInteresP1 - 1)
				{
					$scope.total2 = saldo;
					$scope.totalPrimerPlan = $scope.infoMoratorio.capital + $scope.infoMoratorio.interes_p1;
				}
				$scope.finalMesesp1 = range.length;
				ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
			}
			$scope.range= range;
			ini2 = ($scope.mesesdiferir > 0) ? (range.length + $scope.mesesdiferir) : range.length;
			// console.log($scope.alphaNumeric);
			//////////
			$scope.p2 = ($scope.infoMoratorio.interes_p2 *  Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1) * $scope.infoMoratorio.saldoNormal) / ( Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1 )-1);
			var range2=[];
			for (var i = ini2; i < $scope.infoMoratorio.plazo; i++) {
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
				/**/
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


				$scope.fechapago = day + '-' + mes + '-' + yearc;
				if(i == 0){
					$scope.fechaPM = $scope.fechapago;
				}
				var interes = 0;
				var total = 0;
				var capital =0;
				var saldo=0;
				var	importe=0;
				var diasRetraso=0;
				var interesMoratorio=0;
				var check=0;
				// if($scope.infoMoratorio.mesesSinInteresP1 == 0)
				// {
				// $scope.interes_plan2 = $scope.total2*($scope.infoMoratorio.interes_p2);
				interes = $scope.interes_plan2=$scope.infoMoratorio.saldoNormal*$scope.infoMoratorio.interes_p2;
				// capital = $scope.capital2 = ($scope.p2 - $scope.interes_plan2);
				total = $scope.p2;
				var deudaMoratorio;
				/*new part 21219*/
				var alphaOriginal=[];
				alphaOriginal=$scope.alphaNumeric;
				if($scope.alphaNumeric[i]['disp'] != 1)
				{
					/*Para verfificar donde se puso el pago a capital*/
					var vuelta = (i + 1);
					var posicionPago = (posPay + 1);
					if (vuelta == posicionPago)
					{
						if (posicionPago == 1)
						{
							console.log('Entre aqui');
							/*
							var dispPC;
							 // Este if es para ver si se descuenta la primera posicion
							interesMoratorio = $scope.alphaNumeric[posPay]['interesMoratorio'] = $scope.infoMoratorio.interesMoratorio=IM;// $scope.alphaNumeric[posPay]['interesMoratorio'] = IM;
							saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'];//saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si-$scope.alphaNumeric[posPay]['capital']
							importe			= $scope.alphaNumeric[posPay]['importe'] = $scope.infoMoratorio.importe	= importeSaldoI;//$scope.alphaNumeric[posPay]['importe']
							diasRetraso		= $scope.alphaNumeric[posPay]['diasRetraso'] = $scope.infoMoratorio.diasRetraso = diasRetardo; //$scope.alphaNumeric[posPay]['diasRetraso']
							interes = $scope.alphaNumeric[posPay]['interes'];
							capital = $scope.alphaNumeric[posPay]['capital'];
							console.log(saldo);

							console.log("I entered here, first position");
							if(IM > 0)
							{
								if($scope.alphaNumeric[posPay]['disp']!=0 || $scope.alphaNumeric[posPay]['disp']==1)
								{
									total = $scope.alphaNumeric[posPay]['total'] = $scope.infoMoratorio.total = interesMoratorio + total;
									saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si =  saldo;
									dispPC = $scope.alphaNumeric[posPay]['disp']=  1;
								}
							}*/
							/*new part*/
							var dispPC;
							// Este if es para ver si se descuenta la primera posicion

							//No se colocan el saldo e interesMoratorio ya que no se requiere mostrar cuando este no se adeude
							// interesMoratorio = $scope.alphaNumeric[posPay]['interesMoratorio'] = $scope.infoMoratorio.interesMoratorio=IM;// $scope.alphaNumeric[posPay]['interesMoratorio'] = IM;
							// saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'];//saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si-$scope.alphaNumeric[posPay]['capital']
							importe			= $scope.alphaNumeric[posPay]['importe'] = $scope.infoMoratorio.importe	= importeSaldoI;//$scope.alphaNumeric[posPay]['importe']
							diasRetraso		= $scope.alphaNumeric[posPay]['diasRetraso'] = $scope.infoMoratorio.diasRetraso = diasRetardo; //$scope.alphaNumeric[posPay]['diasRetraso']
							interes = $scope.alphaNumeric[posPay]['interes'];
							capital = $scope.alphaNumeric[posPay]['capital'];

							if ($scope.alphaNumeric[posPay]['check'] == 1) {
								/*si hay un check (osea que no está pagado) dejar el total*/
								total = $scope.alphaNumeric[posPay]['total'] = $scope.infoMoratorio.total;
								saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1000000;
							} else {
								var positivNumbe;
								/* Este if es para ver si se descuenta la primera posicion*/
								// newSaldoTable = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'];
								// interesMoratorio = $scope.alphaNumeric[posPay]['interesMoratorio'] = $scope.infoMoratorio.interesMoratorio=IM;// $scope.alphaNumeric[posPay]['interesMoratorio'] = IM;
								// console.log('se descuenta de la primera posicion');
								saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'];//$scope.alphaNumeric[posPay]['saldo']=saldoInsoluto-$scope.alphaNumeric[posPay]['total']
								importe = $scope.alphaNumeric[posPay]['importe'] = $scope.infoMoratorio.importe = importeSaldoI;//$scope.alphaNumeric[posPay]['importe']
								diasRetraso = $scope.alphaNumeric[posPay]['diasRetraso'] = $scope.infoMoratorio.diasRetraso = diasRetardo; //$scope.alphaNumeric[posPay]['diasRetraso']
								// console.log(saldo);
								if (IM > 0) {
									if ($scope.alphaNumeric[posPay]['disp'] != 0 || $scope.alphaNumeric[posPay]['disp'] == 1) {
										console.log(IM);
										var provA = $scope.alphaNumeric[posPay]['importe'] - IM;
										provA = provA - interes;
										// total = $scope.alphaNumeric[posPay]['total'] = $scope.infoMoratorio.total = interesMoratorio + total;
										console.log('provA', provA);
										console.log("interes", interes);
										if (provA > 0) {
											total =  provA;//total = $scope.alphaNumeric[posPay]['total'] - provA
											saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = saldo - provA;

											interesMoratorio = $scope.alphaNumeric[i]['interesMoratorio'] = IM;
											$scope.alphaNumeric[i]['total'] = 0;
											deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = 0;
										}
										else {
											/*sí en la primera posición el interes moratorio es mayor que el imprte*/
											positivNumbe = Math.abs(provA);
											saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = saldo;
											total = $scope.alphaNumeric[posPay]['total'] = 0;
											var decNum = positivNumbe.toFixed(2);
											interesMoratorio = $scope.alphaNumeric[i]['interesMoratorio'] = positivNumbe;
											// console.log("interes Moratoprio: " + $scope.alphaNumeric[i]['interesMoratorio']);
											deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = positivNumbe;
										}
										dispPC = $scope.alphaNumeric[posPay]['disp'] = 1; //$scope.alphaNumeric[posPay]['disp'] = 1;
									}
								}
							}
							// console.log("check: " + positivNumbe);
							/*termina new part*/

						}
						else
						{/* Este else es para ver si se descuenta apartir de la segunda posicion*/
							// alert("Segunda posicion");
							var siVal = document.getElementsByName("si"+posPay)[0].value
							capital = $scope.alphaNumeric[i]['capital'] ; //$scope.capital2 = ($scope.p2 - $scope.interes_plan2);

							interes = $scope.alphaNumeric[i]['interes'];//$scope.alphaNumeric[posPay]['interes'] = siVal*$scope.infoMoratorio.interes_p2
							deudaOrdinario=0;



							importe			= $scope.infoMoratorio.importe		= $scope.alphaNumeric[posPay]['importe'] = importeSaldoI;
							diasRetraso		= $scope.infoMoratorio.diasRetraso	= $scope.alphaNumeric[posPay]['diasRetraso'] = diasRetardo;
							dispPC		= $scope.infoMoratorio.disp	= $scope.alphaNumeric[posPay]['disp'] = 1;
							interesMoratorio = IM;
							if(IM > 0)
							{
								/*27DIC*/
								// alert('llegué aqui ' + IM);
								if($scope.alphaNumeric[posPay]['saldo']==$scope.alphaNumeric[posPay]['saldo'])
								{
									if(posPay==0)
									{
										// alert('I');
										interes = $scope.alphaNumeric[(posPay)]['saldoNormal'] * $scope.infoMoratorio.interes_p2;//$scope.alphaNumeric.sal* $scope.infoMoratorio.interes_p2
										capital=0;
									}
									else
									{
										// alert('II');
										// $scope.p2 = ($scope.infoMoratorio.interes_p2 *  Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1) * $scope.alphaNumeric[(posPay-1)]['saldoNormal']) / ( Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1 )-1);
										interes = $scope.alphaNumeric[(posPay-1)]['saldoNormal'] * $scope.infoMoratorio.interes_p2;//$scope.alphaNumeric.sal* $scope.infoMoratorio.interes_p2
										capital=$scope.alphaNumeric[i]['capital'];
									}
									// interes = $scope.alphaNumeric[(posPay-1)]['saldoNormal'] * $scope.infoMoratorio.interes_p2;//$scope.alphaNumeric.sal* $scope.infoMoratorio.interes_p2
									var provA = $scope.alphaNumeric[posPay]['importe'] - IM;
									if(provA>0)
									{
										// alert("PROVA: " + provA + "===== DEUDA MORATORIO " +  $('#resMoratorioAdeuto').val());
										// console.log("Deudas de moratorios: " + $scope.alphaNumeric[posPay]['deudaMoratorio']);
										interesMoratorio = IM;
										/*newcode*/
										if($scope.alphaNumeric[posPay]['deudaMoratorio']>=0 || $scope.alphaNumeric[posPay]['deudaMoratorio']!="")
										{
											resultado=$scope.alphaNumeric[posPay]['deudaMoratorio']-provA;
											// alert($scope.alphaNumeric[posPay]['deudaMoratorio']);
											// alert(provA);
											// saldo=$scope.infoMoratorio.si=$scope.alphaNumeric[x]['saldo']=$scope.alphaNumeric[x]['saldo'];
											console.log('Llegue a descontar a los adeudos moratorios');

											// var positivRes=Math.abs(resultado);
											if(resultado > 0)
											{
												console.log("Este debe de ser positivo: " + resultado);
												$('#resMoratorioAdeuto').val(resultado);
												$('#resMoratorioAdeuto').click();
												deudaMoratorio =$scope.alphaNumeric[posPay]['deudaMoratorio'] = resultado;
												total = $scope.alphaNumeric[posPay]['total'] = 0;
												// alert('PPP');
											}
											else
											{
												// alert('QQQ');
												// console.log("Este dbe ser negativo: " + resultado);
												var abonoLimpio = Math.abs(resultado);
												$('#resMoratorioAdeuto').val(0);
												$('#resMoratorioAdeuto').click();
												deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = 0;
												// limpiaAdeudoMoratorio();
												console.log("Libres para abonar a capital: " + abonoLimpio);
												total = 0;//total = $scope.alphaNumeric[posPay]['total'] + abonoLimpio
												// alert('Esto se debe descontar al interes ordinario ' + abonoLimpio);
												//vamoaver
												var intLessAbonoLimpio = interes - abonoLimpio;
												console.log('LOG: ' + intLessAbonoLimpio);
												var cumuloOrdinario = $('#resOrdinarioAdeuto').val();
												var deudaOrdinario;
												var deudaOrdinarioSuma;
												if (Math.sign(intLessAbonoLimpio) == 1)//si el numero es positivo
												{

													// alert('hanumaaaaaa MATH.SIGN');
													//si sale positivo es porque quedo interes por pagar
													deudaOrdinario = $scope.alphaNumeric[posPay]['deudaOrdinario'] = intLessAbonoLimpio;
													deudaOrdinarioSuma=sumaOrdinarios();
													$('#resOrdinarioAdeuto').val(deudaOrdinarioSuma);
													$('#resOrdinarioAdeuto').click();
													saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[x]['saldo'] = $scope.alphaNumeric[x]['saldo'];
													console.log($scope.alphaNumeric);
												}
												else
												{
													//si sale negativo es porque quedo algo libre para capital
													// saldo=$scope.infoMoratorio.si=$scope.alphaNumeric[x]['saldo']=$scope.alphaNumeric[x]['saldo']-intLessAbonoLimpio;
													// alert(intLessAbonoLimpio + " MATH.ABS: " + Math.abs(intLessAbonoLimpio) + " deudaORD" + deudaOrdinario);
													// alert("PARA CAPITAL " + (Math.abs(intLessAbonoLimpio) - deudaOrdinarioSuma));
													/*VERIFICAR SI DIO NEGATIVO Y POSITIVO ALV, SI SALE NEGATIVO AUN QUEDA DEUDA, SI SALE POSITIVO QUEDA LIBRE*/
													// deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = 0;
													var posintLessAbonoLimpio;
													if(deudaOrdinarioSuma>0)
													{
														posintLessAbonoLimpio = Math.abs(intLessAbonoLimpio) - deudaOrdinarioSuma;
													}
													else
													{
														posintLessAbonoLimpio = Math.abs(intLessAbonoLimpio);
													}


													if (posintLessAbonoLimpio >= 0)
													{
														// posintLessAbonoLimpio = Math.abs(posintLessAbonoLimpio);
														if(sumaOrdinarios()>0)
														{
															// alert('SMN HDTRPM LLEGASTE AQUI');
															posintLessAbonoLimpio = posintLessAbonoLimpio - sumaOrdinarios();
														}

														// posintLessAbonoLimpio = Math.abs(posintLessAbonoLimpio);
														// alert("ALV JAJA" + $('#resMoratorioAdeuto').val());
														// alert('POSITIVO ' + posintLessAbonoLimpio);
														$('#resOrdinarioAdeuto').val(0);
														$('#resOrdinarioAdeuto').click();
														limpiaAdeudoOrdinario();
														total = posintLessAbonoLimpio;
														// alert("Total alv: " + total);
														saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'] = $scope.alphaNumeric[posPay]['saldo'] - posintLessAbonoLimpio;

														// alert('CHECKPOINT');

														//ORIGINAL12FEB
														// posintLessAbonoLimpio = Math.abs(posintLessAbonoLimpio);
														// alert("ALV JAJA" + $('#resMoratorioAdeuto').val());
														// alert('POSITIVO ' + posintLessAbonoLimpio);
														// $('#resOrdinarioAdeuto').val(0);
														// $('#resOrdinarioAdeuto').click();
														// limpiaAdeudoOrdinario();
														// total = posintLessAbonoLimpio;
														// saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[x]['saldo'] = $scope.alphaNumeric[x]['saldo'] - posintLessAbonoLimpio;
													}
													else
													{
														// posintLessAbonoLimpio = Math.abs(posintLessAbonoLimpio);
														// alert('AUN QUEDA DEUDA NEGATIVO ' + posintLessAbonoLimpio);
														$('#resOrdinarioAdeuto').val(posintLessAbonoLimpio);
														$('#resOrdinarioAdeuto').click();
														saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
													}




													/*var posintLessAbonoLimpio = Math.abs(intLessAbonoLimpio) - deudaOrdinarioSuma;
													alert(posintLessAbonoLimpio);
													posintLessAbonoLimpio = Math.abs(posintLessAbonoLimpio);
													saldo=$scope.infoMoratorio.si=$scope.alphaNumeric[x]['saldo']=$scope.alphaNumeric[x]['saldo']-posintLessAbonoLimpio;
													deudaOrdinario = $scope.alphaNumeric[posPay]['deudaOrdinario']=0;
													limpiaAdeudoOrdinario();
													total = posintLessAbonoLimpio;
													$('#resOrdinarioAdeuto').val(0);
													$('#resOrdinarioAdeuto').click();*/
												}
												//vamoaver
											}
											console.log("resultado tratado" + resultado);
											console.log(provA);
											console.log($scope.alphaNumeric[posPay]['deudaMoratorio']);
										}
										else
										{
											// total = $scope.infoMoratorio.total =total-provA; /*orioginal de la funcion*/
											total = $scope.alphaNumeric[posPay]['total'] - provA;
											saldo=$scope.infoMoratorio.si=$scope.alphaNumeric[x]['saldo']=$scope.alphaNumeric[x]['saldo']+provA;
											console.log('Llegue a NO descontar a los adeudos moratorios');
											interesMoratorio = IM;
										}
										/*exitcode*/
									}
									else
									{
										/*sí en la segunda posición el interes moratorio es mayor que el importe*/
										//empieza val
										if($scope.alphaNumeric[posPay]['disp']!=0 || $scope.alphaNumeric[posPay]['disp']==1)
										{
											var provA = $scope.alphaNumeric[posPay]['importe'] - IM;
											if(provA>0)
											{
												// alert('QWERTY');
												total = provA;
												saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si =  saldo+provA;
												$scope.alphaNumeric[i]['interesMoratorio'] = 0;
												console.log("interes Moratoprio: " + $scope.alphaNumeric[i]['interesMoratorio']);
												$scope.alphaNumeric[posPay]['interesMoratorio'] = 0;
												deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio']=0;
												interesMoratorio = IM;
											}
											else/*5654.61;*/
											{
												// alert('ASDFGH ' + $scope.alphaNumeric[posPay]['importe']);
												/*sí en la primera posición el interes moratorio es mayor que el imprte*/
												var positivNumbe=Math.abs(provA);
												var decNum= positivNumbe.toFixed(2);
												total = $scope.alphaNumeric[posPay]['total'] = 0;
												$scope.alphaNumeric[posPay]['interesMoratorio'] = positivNumbe;
												interesMoratorio = IM;
												console.log("IM " + IM);
												deudaOrdinario = $scope.alphaNumeric[posPay]['deudaOrdinario'] = interes;
												var resultado=0;
												for(var b=0; b<=posPay; b++)
												{
													// console.log("LAP: " + b);
													// console.log($scope.alphaNumeric[b]['interesMoratorio']);
													if($scope.alphaNumeric[b]['interesMoratorio'] != 0 || $scope.alphaNumeric[b]['interesMoratorio'] != "")
													{
														resultado += $scope.alphaNumeric[b]['interesMoratorio'];
													}
													else
													{
														resultado +=0;
														console.log("En la vuelta " + b + "sumer un cero porque no había nada alv");
													}
													console.log("Suma total de valores: " + resultado);
												}
												/*setear el valor al input de prueba*/
												var sumaAdeudosOrdinario = sumaOrdinarios();
												$('#resMoratorioAdeuto').val(resultado.toFixed(2));
												$('#resOrdinarioAdeuto').val(sumaAdeudosOrdinario);
												$('#resOrdinarioAdeuto').click();//darle formato a ese campo
												// $('#resMoratorioAdeuto').click();
												/*simular el click para que se detone el evento y le de formato de money*/
												document.getElementById('resMoratorioAdeuto').click();
												deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio']=resultado;
												console.log($scope.alphaNumeric);
												// saldo = $scope.alphaNumeric[x]['saldo'] = $scope.infoMoratorio.si =  saldo;
												// interes
												//Moratorio = resultado;
												//
												saldo=$scope.alphaNumeric[posPay]['saldo'];

											}
											dispPC = $scope.alphaNumeric[posPay]['disp']=  1; //$scope.alphaNumeric[posPay]['disp'] = 1;
										}
										//termina val
									}
									console.log("El cúmulo de interes hasta el punto es: " + $scope.alphaNumeric[i]['deudaMoratorio']);
									/*******************/
									/*}*/
								}
								/*END*/
								/*st new
								for(var x=0; x<posicionPago; x++)
								{

								}
								end new*/
								console.log("disp de esta posicion:" + $scope.alphaNumeric[posPay]['disp']);
							}
							/*fin de new part*/
						}
					}
					else
					{
						deudaOrdinario=0;
						if ($scope.alphaNumeric[posicionPago]['interesMoratorio'] == 0)
						{
							//Hace el calculo cuando es apartir de la tercera posición
							dispPC = $scope.alphaNumeric[posPay]['disp'] =0;
							importe			= $scope.alphaNumeric[posPay]['importe']=0;
							diasRetraso		= $scope.alphaNumeric[posPay]['diasRetraso']=0;
							interesMoratorio = $scope.alphaNumeric[posPay]['interesMoratorio']=0;
							// interes = $scope.alphaNumeric[i]['interes'];
							capital = $scope.alphaNumeric[(i)]['capital'];

							var siVal =$scope.infoMoratorio.si;
							interes = $scope.alphaNumeric[i]['interes'];
							// saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'];
							total = $scope.infoMoratorio.total= $scope.alphaNumeric[i]['capital'] + $scope.alphaNumeric[i]['interes'];

							if($scope.alphaNumeric[posPay]['importe'] ==0 && $scope.alphaNumeric[posPay]['diasRetraso']==0)
							{
								if($scope.alphaNumeric[i]['pago'] > posicionPago)
								{
									if($('#msiField').val()< posicionPago )
									{
										if ($scope.alphaNumeric[i]['pago'] > posicionPago) {
											saldo = $scope.alphaNumeric[posPay]['saldo'];
										}else{
											saldo=$scope.alphaNumeric[x]['saldo'];
										}
									}
									else
									{
										saldo=$scope.alphaNumeric[posPay]['saldo'];

									}
									// anterior al 25 julio 2022
									// if($('#msiField').val()>0)
									// {
									// 	if($scope.total2 > 0)
									// 	{
									// 		saldo=$scope.total2;
									// 	}
									// 	else
									// 	{
									// 		saldo=$scope.alphaNumeric[x]['saldo'];
									// 	}
									// }
									// else
									// {
									// 	saldo=$scope.alphaNumeric[x]['saldo'];
									// }

								}
								else
								{
									for(var x=0; x < posicionPago ; x++)
									{
										saldo= $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
										//test fields
										// total = $scope.alphaNumeric[i]['capital']+$scope.alphaNumeric[i]['interes'];
										// interes = $scope.alphaNumeric[i]['interes'];
										// capital = $scope.alphaNumeric[i]['capital'];
										// total = $scope.alphaNumeric[i]['total'];
									}
								}
							}
							else
							{
								saldo =  $scope.infoMoratorio.si =$scope.infoMoratorio.si-$scope.alphaNumeric[posPay]['total'];
							}
						}
						else
						{
							if ($scope.alphaNumeric[posPay]['pago'] >= posicionPago || $scope.alphaNumeric[posPay]['pago'] <= posicionPago)
							{
								if ($scope.alphaNumeric[posicionPago]['disp'] == 1)
								{
									//aqui se coloca cuando se hay pagos abajo del nuevo, ejemplo Pago 5:550 y se quiere colocar uno en el 2
									dispPC = $scope.alphaNumeric[posPay]['disp']=  1;
									saldo =  $scope.infoMoratorio.si =$scope.alphaNumeric[i]['saldo'];
									importe			= $scope.alphaNumeric[posPay]['importe'] = $scope.alphaNumeric[posPay]['importe'];
									diasRetraso		= $scope.alphaNumeric[posPay]['diasRetraso'] = $scope.alphaNumeric[posPay]['diasRetraso'];
									interesMoratorio = $scope.alphaNumeric[posPay]['interesMoratorio'] = $scope.alphaNumeric[posPay]['interesMoratorio'];
								}
								else
								{//se coloca un valor cuando nohay nada(el resto de los campos, apartir de la segunda posicion, else de la primera posicion
									dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
								}
							}
							else
							{
								//cuando se salta un espacio en la tabla
								saldo =  $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1;
								total = 90;
							}
						}
					}
					$scope.interes_plan2 =$scope.alphaNumeric[i]['saldoNormal']* ($scope.infoMoratorio.interes_p2);
					$scope.capital2 = ($scope.p2 - $scope.interes_plan2);
					range2.push({
						"fecha" :$scope.fechapago,
						"pago" : i + 1,
						"capital" :capital,
						"interes" : interes,
						"importe" : importe,
						"diasRetraso" : diasRetraso,
						"interesMoratorio" : interesMoratorio,
						"deudaMoratorio": deudaMoratorio,
						"deudaOrdinario" : deudaOrdinario,
						"total" : total, //$scope.infoMoratorio.capital + $scope.infoMoratorio.interes_p1
						"saldo" : saldo,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
						"saldoNormal" : $scope.alphaNumeric[i]['saldoNormal'],
						"disp" : dispPC,
						"min" : minVal,
						"max": maxVal
					});
				}
				else
				{
					/*Entra cuando te saltas espacios despues de la primera posicion*/
					range2.push({
						"fecha": $scope.fechapago,
						"pago": i + 1,
						"capital": $scope.alphaNumeric[i]['capital'],
						"interes": $scope.alphaNumeric[i]['interes'],
						"importe": $scope.alphaNumeric[i]['importe'],
						"diasRetraso": $scope.alphaNumeric[i]['diasRetraso'],
						"interesMoratorio": $scope.alphaNumeric[i]['interesMoratorio'],
						"deudaMoratorio" : $scope.alphaNumeric[i]['deudaMoratorio'],
						"deudaOrdinario" : $scope.alphaNumeric[i]['deudaOrdinario'],
						"total": $scope.alphaNumeric[i]['total'], //$scope.infoMoratorio.capital + $scope.infoMoratorio.interes_p1
						"saldo": $scope.alphaNumeric[i]['saldo'],//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
						"saldoNormal" : $scope.alphaNumeric[i]['saldoNormal'],
						"disp": $scope.alphaNumeric[i]['disp']
					});
				}
				// }
				// else
				// {
				// 	/*Cuando estén combinados MSI y MCI*/
				// 	range2.push({
				// 			"fecha" :$scope.fechapago,
				// 			"pago" : i+1,
				// 			"capital" : ($scope.infoMoratorio.capital=($scope.p2 - $scope.interes_plan2)),
				// 			"interes" : ($scope.interes_plan2=($scope.total2*$scope.infoMoratorio.interes_p2)),
				// 			"importe" : 0,
				// 			"diasRetraso" : 0,
				// 			"interesMoratorio" : 0,
				// 			"total" : $scope.p2,
				// 			"saldo" : $scope.total2=($scope.total2 - $scope.capital2),//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
				// 			"disp" : disp
				// 		});
				// }



				/*original*/
				// $scope.interes_plan2 = $scope.total2*($scope.infoMoratorio.interes_p2);
				// $scope.capital2 = ($scope.p2 - $scope.interes_plan2);
				// range2.push({
				// 	"fecha" :$scope.fechapago,
				// 	"pago" : i+1,
				// 	"capital" : ($scope.infoMoratorio.capital=($scope.p2 - $scope.interes_plan2)),
				// 	"interes" : ($scope.interes_plan2=($scope.total2*$scope.infoMoratorio.interes_p2)),
				// 	"importe" : 0,
				// 	"diasRetraso" : 0,
				// 	"interesMoratorio" : 0,
				// 	"total" : $scope.p2,
				// 	"saldo" : $scope.total2=($scope.total2 - $scope.capital2),//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
				// 	"disp" : disp
				// });
				console.log("Part of range II de JS EXTERNO");
				mes++;

				if (i == ($scope.infoMoratorio.plazo - 1))
				{
					// $scope.totalSegundoPlan = $scope.p2;
					$scope.total3 = $scope.total2;
					$scope.totalSegundoPlan = $scope.p2;
				}
				$scope.finalMesesp2 = (range2.length);
			}
			$scope.range2= range2;
			/////////////
			$scope.p3 = ($scope.infoMoratorio.interes_p3 *  Math.pow(1 + $scope.infoMoratorio.interes_p3, $scope.infoMoratorio.meses - 120) * $scope.total3) / ( Math.pow(1 + $scope.infoMoratorio.interes_p3, $scope.infoMoratorio.meses - 120)-1);


			var range3=[];

			for (var i = 121; i < $scope.infoMoratorio.meses + 1; i++) {

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

				var interes = 0;
				var total = 0;
				var capital =0;
				var saldo=0;
				var	importe=0;
				var diasRetraso=0;
				var interesMoratorio=0;
				var check=0;
				// if($scope.infoMoratorio.mesesSinInteresP1 == 0)
				// {
				// $scope.interes_plan2 = $scope.total2*($scope.infoMoratorio.interes_p2);
				interes = $scope.interes_plan2=$scope.infoMoratorio.saldoNormal*$scope.infoMoratorio.interes_p2;
				// capital = $scope.capital2 = ($scope.p2 - $scope.interes_plan2);
				total = $scope.p2;
				var deudaMoratorio;
				/*new part 21219*/
				var alphaOriginal=[];
				alphaOriginal=$scope.alphaNumeric;
				if($scope.alphaNumeric[i]['disp'] != 1)
				{
					/*Para verfificar donde se puso el pago a capital*/
					var vuelta = (i + 1);
					var posicionPago = (posPay + 1);
					if (vuelta == posicionPago)
					{
						if (posicionPago == 1)
						{
							/*
							var dispPC;
							 // Este if es para ver si se descuenta la primera posicion
							interesMoratorio = $scope.alphaNumeric[posPay]['interesMoratorio'] = $scope.infoMoratorio.interesMoratorio=IM;// $scope.alphaNumeric[posPay]['interesMoratorio'] = IM;
							saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'];//saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si-$scope.alphaNumeric[posPay]['capital']
							importe			= $scope.alphaNumeric[posPay]['importe'] = $scope.infoMoratorio.importe	= importeSaldoI;//$scope.alphaNumeric[posPay]['importe']
							diasRetraso		= $scope.alphaNumeric[posPay]['diasRetraso'] = $scope.infoMoratorio.diasRetraso = diasRetardo; //$scope.alphaNumeric[posPay]['diasRetraso']
							interes = $scope.alphaNumeric[posPay]['interes'];
							capital = $scope.alphaNumeric[posPay]['capital'];
							console.log(saldo);

							console.log("I entered here, first position");
							if(IM > 0)
							{
								if($scope.alphaNumeric[posPay]['disp']!=0 || $scope.alphaNumeric[posPay]['disp']==1)
								{
									total = $scope.alphaNumeric[posPay]['total'] = $scope.infoMoratorio.total = interesMoratorio + total;
									saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si =  saldo;
									dispPC = $scope.alphaNumeric[posPay]['disp']=  1;
								}
							}*/
							/*new part*/
							var dispPC;
							// Este if es para ver si se descuenta la primera posicion

							//No se colocan el saldo e interesMoratorio ya que no se requiere mostrar cuando este no se adeude
							// interesMoratorio = $scope.alphaNumeric[posPay]['interesMoratorio'] = $scope.infoMoratorio.interesMoratorio=IM;// $scope.alphaNumeric[posPay]['interesMoratorio'] = IM;
							// saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'];//saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si-$scope.alphaNumeric[posPay]['capital']
							importe			= $scope.alphaNumeric[posPay]['importe'] = $scope.infoMoratorio.importe	= importeSaldoI;//$scope.alphaNumeric[posPay]['importe']
							diasRetraso		= $scope.alphaNumeric[posPay]['diasRetraso'] = $scope.infoMoratorio.diasRetraso = diasRetardo; //$scope.alphaNumeric[posPay]['diasRetraso']
							interes = $scope.alphaNumeric[posPay]['interes'];
							capital = $scope.alphaNumeric[posPay]['capital'];

							if ($scope.alphaNumeric[posPay]['check'] == 1) {
								/*si hay un check (osea que no está pagado) dejar el total*/
								total = $scope.alphaNumeric[posPay]['total'] = $scope.infoMoratorio.total;
								saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1000000;
							} else {
								var positivNumbe;
								/* Este if es para ver si se descuenta la primera posicion*/
								// newSaldoTable = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'];
								// interesMoratorio = $scope.alphaNumeric[posPay]['interesMoratorio'] = $scope.infoMoratorio.interesMoratorio=IM;// $scope.alphaNumeric[posPay]['interesMoratorio'] = IM;
								// console.log('se descuenta de la primera posicion');
								saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'];//$scope.alphaNumeric[posPay]['saldo']=saldoInsoluto-$scope.alphaNumeric[posPay]['total']
								importe = $scope.alphaNumeric[posPay]['importe'] = $scope.infoMoratorio.importe = importeSaldoI;//$scope.alphaNumeric[posPay]['importe']
								diasRetraso = $scope.alphaNumeric[posPay]['diasRetraso'] = $scope.infoMoratorio.diasRetraso = diasRetardo; //$scope.alphaNumeric[posPay]['diasRetraso']
								// console.log(saldo);
								if (IM > 0) {
									if ($scope.alphaNumeric[posPay]['disp'] != 0 || $scope.alphaNumeric[posPay]['disp'] == 1) {
										console.log(IM);
										var provA = $scope.alphaNumeric[posPay]['importe'] - IM;
										// total = $scope.alphaNumeric[posPay]['total'] = $scope.infoMoratorio.total = interesMoratorio + total;
										if (provA > 0) {
											total =  provA;//total = $scope.alphaNumeric[posPay]['total'] - provA
											saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = saldo - provA;

											$scope.alphaNumeric[i]['interesMoratorio'] = 0;
											$scope.alphaNumeric[i]['total'] = 0;
											deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = 0;
										} else {
											/*sí en la primera posición el interes moratorio es mayor que el imprte*/
											positivNumbe = Math.abs(provA);
											saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = saldo;
											total = $scope.alphaNumeric[posPay]['total'] = 0;
											var decNum = positivNumbe.toFixed(2);
											interesMoratorio = $scope.alphaNumeric[i]['interesMoratorio'] = positivNumbe;
											// console.log("interes Moratoprio: " + $scope.alphaNumeric[i]['interesMoratorio']);
											deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = positivNumbe;
										}
										dispPC = $scope.alphaNumeric[posPay]['disp'] = 1; //$scope.alphaNumeric[posPay]['disp'] = 1;
									}
								}
							}
							// console.log("check: " + positivNumbe);
							/*termina new part*/

						}
						else
						{/* Este else es para ver si se descuenta apartir de la segunda posicion*/
							// alert("Segunda posicion");

							var siVal = document.getElementsByName("si"+posPay)[0].value
							capital = $scope.alphaNumeric[i]['capital'] ; //$scope.capital2 = ($scope.p2 - $scope.interes_plan2);

							interes = $scope.alphaNumeric[i]['interes'];//$scope.alphaNumeric[posPay]['interes'] = siVal*$scope.infoMoratorio.interes_p2
							deudaOrdinario=0;



							importe			= $scope.infoMoratorio.importe		= $scope.alphaNumeric[posPay]['importe'] = importeSaldoI;
							diasRetraso		= $scope.infoMoratorio.diasRetraso	= $scope.alphaNumeric[posPay]['diasRetraso'] = diasRetardo;
							dispPC		= $scope.infoMoratorio.disp	= $scope.alphaNumeric[posPay]['disp'] = 1;
							interesMoratorio = IM;
							if(IM > 0)
							{
								/*27DIC*/
								// alert('llegué aqui ' + IM);
								if($scope.alphaNumeric[posPay]['saldo']==$scope.alphaNumeric[posPay]['saldo'])
								{
									if(posPay==0)
									{
										// alert('I');
										interes = $scope.alphaNumeric[(posPay)]['saldoNormal'] * $scope.infoMoratorio.interes_p2;//$scope.alphaNumeric.sal* $scope.infoMoratorio.interes_p2
										capital=0;
									}
									else
									{
										// alert('II');
										// $scope.p2 = ($scope.infoMoratorio.interes_p2 *  Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1) * $scope.alphaNumeric[(posPay-1)]['saldoNormal']) / ( Math.pow(1 + $scope.infoMoratorio.interes_p2, $scope.infoMoratorio.plazo - $scope.infoMoratorio.mesesSinInteresP1 )-1);
										interes = $scope.alphaNumeric[(posPay-1)]['saldoNormal'] * $scope.infoMoratorio.interes_p2;//$scope.alphaNumeric.sal* $scope.infoMoratorio.interes_p2
										capital=$scope.alphaNumeric[i]['capital'];
									}
									// interes = $scope.alphaNumeric[(posPay-1)]['saldoNormal'] * $scope.infoMoratorio.interes_p2;//$scope.alphaNumeric.sal* $scope.infoMoratorio.interes_p2
									var provA = $scope.alphaNumeric[posPay]['importe'] - IM;
									if(provA>0)
									{
										// alert("PROVA: " + provA + "===== DEUDA MORATORIO " +  $('#resMoratorioAdeuto').val());
										// console.log("Deudas de moratorios: " + $scope.alphaNumeric[posPay]['deudaMoratorio']);
										interesMoratorio = IM;
										/*newcode*/
										if($scope.alphaNumeric[posPay]['deudaMoratorio']>=0 || $scope.alphaNumeric[posPay]['deudaMoratorio']!="")
										{
											resultado=$scope.alphaNumeric[posPay]['deudaMoratorio']-provA;
											// alert($scope.alphaNumeric[posPay]['deudaMoratorio']);
											// alert(provA);
											// saldo=$scope.infoMoratorio.si=$scope.alphaNumeric[x]['saldo']=$scope.alphaNumeric[x]['saldo'];
											console.log('Llegue a descontar a los adeudos moratorios');

											// var positivRes=Math.abs(resultado);
											if(resultado > 0)
											{
												console.log("Este debe de ser positivo: " + resultado);
												$('#resMoratorioAdeuto').val(resultado);
												$('#resMoratorioAdeuto').click();
												deudaMoratorio =$scope.alphaNumeric[posPay]['deudaMoratorio'] = resultado;
												total = $scope.alphaNumeric[posPay]['total'] = 0;
												// alert('PPP');
											}
											else
											{
												// alert('QQQ');
												// console.log("Este dbe ser negativo: " + resultado);
												var abonoLimpio = Math.abs(resultado);
												$('#resMoratorioAdeuto').val(0);
												$('#resMoratorioAdeuto').click();
												deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = 0;
												// limpiaAdeudoMoratorio();
												console.log("Libres para abonar a capital: " + abonoLimpio);
												total = 0;//total = $scope.alphaNumeric[posPay]['total'] + abonoLimpio
												// alert('Esto se debe descontar al interes ordinario ' + abonoLimpio);
												//vamoaver
												var intLessAbonoLimpio = interes - abonoLimpio;
												console.log('LOG: ' + intLessAbonoLimpio);
												var cumuloOrdinario = $('#resOrdinarioAdeuto').val();
												var deudaOrdinario;
												var deudaOrdinarioSuma;
												if (Math.sign(intLessAbonoLimpio) == 1)//si el numero es positivo
												{

													// alert('hanumaaaaaa MATH.SIGN');
													//si sale positivo es porque quedo interes por pagar
													deudaOrdinario = $scope.alphaNumeric[posPay]['deudaOrdinario'] = intLessAbonoLimpio;
													deudaOrdinarioSuma=sumaOrdinarios();
													$('#resOrdinarioAdeuto').val(deudaOrdinarioSuma);
													$('#resOrdinarioAdeuto').click();
													saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[x]['saldo'] = $scope.alphaNumeric[x]['saldo'];
													console.log($scope.alphaNumeric);
												}
												else
												{
													//si sale negativo es porque quedo algo libre para capital
													// saldo=$scope.infoMoratorio.si=$scope.alphaNumeric[x]['saldo']=$scope.alphaNumeric[x]['saldo']-intLessAbonoLimpio;
													// alert(intLessAbonoLimpio + " MATH.ABS: " + Math.abs(intLessAbonoLimpio) + " deudaORD" + deudaOrdinario);
													// alert("PARA CAPITAL " + (Math.abs(intLessAbonoLimpio) - deudaOrdinarioSuma));
													/*VERIFICAR SI DIO NEGATIVO Y POSITIVO ALV, SI SALE NEGATIVO AUN QUEDA DEUDA, SI SALE POSITIVO QUEDA LIBRE*/
													// deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio'] = 0;
													var posintLessAbonoLimpio;
													if(deudaOrdinarioSuma>0)
													{
														posintLessAbonoLimpio = Math.abs(intLessAbonoLimpio) - deudaOrdinarioSuma;
													}
													else
													{
														posintLessAbonoLimpio = Math.abs(intLessAbonoLimpio);
													}


													if (posintLessAbonoLimpio >= 0)
													{
														// posintLessAbonoLimpio = Math.abs(posintLessAbonoLimpio);
														if(sumaOrdinarios()>0)
														{
															// alert('SMN HDTRPM LLEGASTE AQUI');
															posintLessAbonoLimpio = posintLessAbonoLimpio - sumaOrdinarios();
														}

														// posintLessAbonoLimpio = Math.abs(posintLessAbonoLimpio);
														// alert("ALV JAJA" + $('#resMoratorioAdeuto').val());
														// alert('POSITIVO ' + posintLessAbonoLimpio);
														$('#resOrdinarioAdeuto').val(0);
														$('#resOrdinarioAdeuto').click();
														limpiaAdeudoOrdinario();
														total = posintLessAbonoLimpio;
														// alert("Total alv: " + total);
														saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[x]['saldo'] = $scope.alphaNumeric[x]['saldo'] - posintLessAbonoLimpio;

														// alert('CHECKPOINT');

														//ORIGINAL12FEB
														// posintLessAbonoLimpio = Math.abs(posintLessAbonoLimpio);
														// alert("ALV JAJA" + $('#resMoratorioAdeuto').val());
														// alert('POSITIVO ' + posintLessAbonoLimpio);
														// $('#resOrdinarioAdeuto').val(0);
														// $('#resOrdinarioAdeuto').click();
														// limpiaAdeudoOrdinario();
														// total = posintLessAbonoLimpio;
														// saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[x]['saldo'] = $scope.alphaNumeric[x]['saldo'] - posintLessAbonoLimpio;
													}
													else
													{
														// posintLessAbonoLimpio = Math.abs(posintLessAbonoLimpio);
														// alert('AUN QUEDA DEUDA NEGATIVO ' + posintLessAbonoLimpio);
														$('#resOrdinarioAdeuto').val(posintLessAbonoLimpio);
														$('#resOrdinarioAdeuto').click();
														saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
													}




													/*var posintLessAbonoLimpio = Math.abs(intLessAbonoLimpio) - deudaOrdinarioSuma;
													alert(posintLessAbonoLimpio);
													posintLessAbonoLimpio = Math.abs(posintLessAbonoLimpio);
													saldo=$scope.infoMoratorio.si=$scope.alphaNumeric[x]['saldo']=$scope.alphaNumeric[x]['saldo']-posintLessAbonoLimpio;
													deudaOrdinario = $scope.alphaNumeric[posPay]['deudaOrdinario']=0;
													limpiaAdeudoOrdinario();
													total = posintLessAbonoLimpio;
													$('#resOrdinarioAdeuto').val(0);
													$('#resOrdinarioAdeuto').click();*/
												}
												//vamoaver
											}
											console.log("resultado tratado" + resultado);
											console.log(provA);
											console.log($scope.alphaNumeric[posPay]['deudaMoratorio']);
										}
										else
										{
											// total = $scope.infoMoratorio.total =total-provA; /*orioginal de la funcion*/
											total = $scope.alphaNumeric[posPay]['total'] - provA;
											saldo=$scope.infoMoratorio.si=$scope.alphaNumeric[x]['saldo']=$scope.alphaNumeric[x]['saldo']+provA;
											console.log('Llegue a NO descontar a los adeudos moratorios');
											interesMoratorio = IM;
										}
										/*exitcode*/
									}
									else
									{
										/*sí en la segunda posición el interes moratorio es mayor que el importe*/
										//empieza val
										if($scope.alphaNumeric[posPay]['disp']!=0 || $scope.alphaNumeric[posPay]['disp']==1)
										{
											var provA = $scope.alphaNumeric[posPay]['importe'] - IM;
											if(provA>0)
											{
												// alert('QWERTY');
												total = provA;
												saldo = $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si =  saldo+provA;
												$scope.alphaNumeric[i]['interesMoratorio'] = 0;
												console.log("interes Moratoprio: " + $scope.alphaNumeric[i]['interesMoratorio']);
												$scope.alphaNumeric[posPay]['interesMoratorio'] = 0;
												deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio']=0;
												interesMoratorio = IM;
											}
											else/*5654.61;*/
											{
												// alert('ASDFGH ' + $scope.alphaNumeric[posPay]['importe']);
												/*sí en la primera posición el interes moratorio es mayor que el imprte*/
												var positivNumbe=Math.abs(provA);
												var decNum= positivNumbe.toFixed(2);
												total = $scope.alphaNumeric[posPay]['total'] = 0;
												$scope.alphaNumeric[posPay]['interesMoratorio'] = positivNumbe;
												interesMoratorio = IM;
												console.log("IM " + IM);
												deudaOrdinario = $scope.alphaNumeric[posPay]['deudaOrdinario'] = interes;
												var resultado=0;
												for(var b=0; b<=posPay; b++)
												{
													// console.log("LAP: " + b);
													// console.log($scope.alphaNumeric[b]['interesMoratorio']);
													if($scope.alphaNumeric[b]['interesMoratorio'] != 0 || $scope.alphaNumeric[b]['interesMoratorio'] != "")
													{
														resultado += $scope.alphaNumeric[b]['interesMoratorio'];
													}
													else
													{
														resultado +=0;
														console.log("En la vuelta " + b + "sumer un cero porque no había nada alv");
													}
													console.log("Suma total de valores: " + resultado);
												}
												/*setear el valor al input de prueba*/
												var sumaAdeudosOrdinario = sumaOrdinarios();
												$('#resMoratorioAdeuto').val(resultado.toFixed(2));
												$('#resOrdinarioAdeuto').val(sumaAdeudosOrdinario);
												$('#resOrdinarioAdeuto').click();//darle formato a ese campo
												// $('#resMoratorioAdeuto').click();
												/*simular el click para que se detone el evento y le de formato de money*/
												document.getElementById('resMoratorioAdeuto').click();
												deudaMoratorio = $scope.alphaNumeric[posPay]['deudaMoratorio']=resultado;
												console.log($scope.alphaNumeric);
												// saldo = $scope.alphaNumeric[x]['saldo'] = $scope.infoMoratorio.si =  saldo;
												// interes
												//Moratorio = resultado;
												//
												saldo=$scope.alphaNumeric[posPay]['saldo'];

											}
											dispPC = $scope.alphaNumeric[posPay]['disp']=  1; //$scope.alphaNumeric[posPay]['disp'] = 1;
										}
										//termina val
									}
									console.log("El cúmulo de interes hasta el punto es: " + $scope.alphaNumeric[i]['deudaMoratorio']);
									/*******************/
									/*}*/
								}
								/*END*/
								/*st new
								for(var x=0; x<posicionPago; x++)
								{

								}
								end new*/
								console.log("disp de esta posicion:" + $scope.alphaNumeric[posPay]['disp']);
							}
							/*fin de new part*/
						}
					}
					else
					{
						deudaOrdinario=0;
						if ($scope.alphaNumeric[posicionPago]['interesMoratorio'] == 0)
						{
							//Hace el calculo cuando es apartir de la tercera posición
							dispPC = $scope.alphaNumeric[posPay]['disp'] =0;
							importe			= $scope.alphaNumeric[posPay]['importe']=0;
							diasRetraso		= $scope.alphaNumeric[posPay]['diasRetraso']=0;
							interesMoratorio = $scope.alphaNumeric[posPay]['interesMoratorio']=0;
							// interes = $scope.alphaNumeric[i]['interes'];
							capital = $scope.alphaNumeric[(i)]['capital'];

							var siVal =$scope.infoMoratorio.si;
							interes = $scope.alphaNumeric[i]['interes'];
							// saldo = $scope.infoMoratorio.si = $scope.alphaNumeric[posPay]['saldo'];
							total = $scope.infoMoratorio.total= $scope.alphaNumeric[i]['capital'] + $scope.alphaNumeric[i]['interes'];

							if($scope.alphaNumeric[posPay]['importe'] ==0 && $scope.alphaNumeric[posPay]['diasRetraso']==0)
							{
								if($scope.alphaNumeric[i]['pago'] > posicionPago)
								{
									//$scope.infoMoratorio.si
									//saldo =  $scope.infoMoratorio.si =(($scope.infoMoratorio.si-$scope.alphaNumeric[i]['capital']))

									if($('#msiField').val()>0)
									{
										if($scope.total2 > 0)
										{
											saldo=$scope.total2;
										}
										else
										{
											saldo=$scope.alphaNumeric[x]['saldo'];
										}
									}
									else
									{
										saldo=$scope.alphaNumeric[x]['saldo'];
									}
									// alert(i + " this is saldo " + $scope.alphaNumeric[x]['saldo']);
								}
								else
								{
									for(var x=0; x < posicionPago ; x++)
									{
										saldo= $scope.infoMoratorio.si = $scope.alphaNumeric[i]['saldo'];
										//test fields
										// total = $scope.alphaNumeric[i]['capital']+$scope.alphaNumeric[i]['interes'];
										// interes = $scope.alphaNumeric[i]['interes'];
										// capital = $scope.alphaNumeric[i]['capital'];
										// total = $scope.alphaNumeric[i]['total'];
									}
								}
							}
							else
							{
								saldo =  $scope.infoMoratorio.si =$scope.infoMoratorio.si-$scope.alphaNumeric[posPay]['total'];
							}
						}
						else
						{
							if ($scope.alphaNumeric[posPay]['pago'] >= posicionPago || $scope.alphaNumeric[posPay]['pago'] <= posicionPago)
							{
								if ($scope.alphaNumeric[posicionPago]['disp'] == 1)
								{
									//aqui se coloca cuando se hay pagos abajo del nuevo, ejemplo Pago 5:550 y se quiere colocar uno en el 2
									dispPC = $scope.alphaNumeric[posPay]['disp']=  1;
									saldo =  $scope.infoMoratorio.si =$scope.alphaNumeric[i]['saldo'];
									importe			= $scope.alphaNumeric[posPay]['importe'] = $scope.alphaNumeric[posPay]['importe'];
									diasRetraso		= $scope.alphaNumeric[posPay]['diasRetraso'] = $scope.alphaNumeric[posPay]['diasRetraso'];
									interesMoratorio = $scope.alphaNumeric[posPay]['interesMoratorio'] = $scope.alphaNumeric[posPay]['interesMoratorio'];
								}
								else
								{//se coloca un valor cuando nohay nada(el resto de los campos, apartir de la segunda posicion, else de la primera posicion
									dispPC = $scope.alphaNumeric[posPay]['disp'] = 0;
								}
							}
							else
							{
								//cuando se salta un espacio en la tabla
								saldo =  $scope.alphaNumeric[posPay]['saldo'] = $scope.infoMoratorio.si = 1;
								total = 90;
							}
						}
					}
					// $scope.interes_plan2 =$scope.alphaNumeric[i]['saldoNormal']* ($scope.infoMoratorio.interes_p2);
					// $scope.capital2 = ($scope.p2 - $scope.interes_plan2);
					$scope.interes_plan3 = $scope.alphaNumeric[i]['saldoNormal']*($scope.infoLote.interes_p3);
					$scope.capital2 = ($scope.p3 - $scope.interes_plan3);
					range3.push({
						"fecha" :$scope.fechapago,
						"pago" : i + 1,
						"capital" :capital,
						"interes" : interes,
						"importe" : importe,
						"diasRetraso" : diasRetraso,
						"interesMoratorio" : interesMoratorio,
						"deudaMoratorio": deudaMoratorio,
						"deudaOrdinario" : deudaOrdinario,
						"total" : total, //$scope.infoMoratorio.capital + $scope.infoMoratorio.interes_p1
						"saldo" : saldo,//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
						"saldoNormal" : $scope.alphaNumeric[i]['saldoNormal'],
						"disp" : dispPC,
						"min" : minVal,
						"max": maxVal
					});
				}
				else
				{
					/*Entra cuando te saltas espacios despues de la primera posicion*/
					range3.push({
						"fecha": $scope.fechapago,
						"pago": i + 1,
						"capital": $scope.alphaNumeric[i]['capital'],
						"interes": $scope.alphaNumeric[i]['interes'],
						"importe": $scope.alphaNumeric[i]['importe'],
						"diasRetraso": $scope.alphaNumeric[i]['diasRetraso'],
						"interesMoratorio": $scope.alphaNumeric[i]['interesMoratorio'],
						"deudaMoratorio" : $scope.alphaNumeric[i]['deudaMoratorio'],
						"deudaOrdinario" : $scope.alphaNumeric[i]['deudaOrdinario'],
						"total": $scope.alphaNumeric[i]['total'], //$scope.infoMoratorio.capital + $scope.infoMoratorio.interes_p1
						"saldo": $scope.alphaNumeric[i]['saldo'],//$scope.infoLote.precioTotal = $scope.infoLote.precioTotal - $scope.infoLote.capital
						"saldoNormal" : $scope.alphaNumeric[i]['saldoNormal'],
						"disp": $scope.alphaNumeric[i]['disp']
					});
				}

				/*$scope.interes_plan3 = $scope.total3*($scope.infoLote.interes_p3);
				$scope.capital2 = ($scope.p3 - $scope.interes_plan3);
				range3.push({

					"fecha" : $scope.dateCf,
					"pago" : i,
					"capital" : ($scope.capital2 = ($scope.p3 - $scope.interes_plan3)),
					"interes" : ($scope.interes_plan3= ($scope.total3 * $scope.infoLote.interes_p3)),
					"total" : $scope.p3,
					"saldo" : ($scope.total3 = ($scope.total3 -$scope.capital2)),
					"pagoCapital"	:	"",
				});*/
				mes++;


				if (i == 122){
					$scope.totalTercerPlan = $scope.p3;

				}
				$scope.finalMesesp3 = (range3.length);

			}

			$scope.range3= range3;
			/////////////

			$scope.validaEngDif = ($scope.mesesdiferir > 0) ? $scope.rangEd : [];
			$scope.alphaNumeric = $scope.validaEngDif.concat($scope.range).concat($scope.range2).concat($scope.range3);
			/**/
			// console.log($scope.alphaNumeric);
			$scope.dtoptions = DTOptionsBuilder;
			$scope.dtColumns = [
				DTColumnBuilder.newColumn('fecha').withTitle('Fechas'),
				DTColumnBuilder.newColumn('amc').withTitle('Pagados')
					.renderWith(
						function (data, type, full, meta) {
							// console.log(full['check']);
							if(full['check'] == 1)
							{
								var inputCapital = '<input name="checkAd' + full["pago"] + '" type="checkbox" id="ckNoPay' + full["pago"] + '" checked disabled>';//onchange="pagoCapChange('+full["pago"]+')"
								return inputCapital;
							}
							else
							{
								var inputCapital = '<input name="checkAd' + full["pago"] + '" type="checkbox" id="ckNoPay' + full["pago"] + '" onchange="noPayMen(' + full["pago"] + ')">';//onchange="pagoCapChange('+full["pago"]+')"
								return inputCapital;
							}
							// var inputCapital = '<input name="checkAd' + full["pago"] + '" type="checkbox" id="ckNoPay' + full["pago"] + '" onchange="noPayMen(' + full["pago"] + ')">';//onchange="pagoCapChange('+full["pago"]+')"
							// return inputCapital;
						},
					),
				DTColumnBuilder.newColumn('pago').withTitle('Pago #'),
				DTColumnBuilder.newColumn('capital').withTitle('Capital').renderWith(
					function (data, type, full)
					{
						var showDescMens;
						if(full['importe']<full['interesMoratorio'])
						{
							showDescMens = '<br><span style="color:red;font-size: 0.8em"><i>No se abonó nada a capital</i></span>';
						}
						else
						{
							if(full['importe']=="" || full['importe']==0)
							{
								showDescMens = '<br><span style="color:red;font-size: 0.8em"><i>No se abonó nada a capital</i></span>';
							}
							else
							{
								// showDescMens = '<br><span style="color:red;font-size: 0.8em"><i>'+full['total'].toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})+'</i></span>';
								var intOrd = full['interes'];
								if(intOrd==0 || intOrd=="")
								{
									showDescMens = '<br><span style="color:red;font-size: 0.8em"><i>'+full['total'].toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})+'</i></span>';
								}
								else
								{

									showDescMens = '<br><span style="color:red;font-size: 0.8em"><i>Primero descuenta a Intereses ordinarios</i></span>';

									// showDescMens = '<br><span style="color:red;font-size: 0.8em"><i>Primero descuenta a Intereses ordinarios</i></span>';
								}
							}
						}
						return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})) + showDescMens
					}),
				DTColumnBuilder.newColumn('interes').withTitle('Intereses').renderWith(function (data, type, full)
				{
					var showDescInt;
					var intOrd = full['interes'];
					if(intOrd<=full['total'])
					{
						showDescInt = '<br><span style="color:red;font-size: 0.8em"><i>'+full['interes'].toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})+'</i></span>';
					}
					else
					{

						if(full['deudaOrdinario'] <= 0 || full['deudaOrdinario']==undefined)//si no hay nada en el adeudo
						{
							let deudaOrdinario= (full['deudaOrdinario']==undefined) ? 0 : full['deudaOrdinario'];
							showDescInt = '<br><span style="color:red;font-size: 0.8em"><i>Se liquidó el interes: '+deudaOrdinario.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})+'</i></span>';
							console.log("if liquido", full['deudaOrdinario']);

						}
						else
						{
							console.log("else", full['deudaOrdinario']);
							showDescInt = '<br><span style="color:red;font-size: 0.8em"><i>No se liquidó este interes: '+full['deudaOrdinario'].toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})+'</i></span>';
						}
						// showDescInt = '<br><span style="color:red;font-size: 0.8em"><i>No se liquidó este interes: '+full['deudaOrdinario'].toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})+'</i></span>';
					}
					// var inputOrdAdeudo = '<input type="text" id="adeudoOrd'+full['pago']+'">';
					return (data.toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})) + showDescInt;
				}),
				DTColumnBuilder.newColumn('importe').withTitle('Importe')
					.renderWith(
						function(data, type, full, meta)
						{
							// var inputCapital = '<input name="importe'+full["pago"]+'" type="number" id="idImporte'+full["pago"]+'"   placeholder="Importe" class="form-control">';//onchange="pagoCapChange('+full["pago"]+')"
							// var numberPay	 = '<input name="numberPay'+full["pago"]+'" type="hidden" id="payNum'+full["pago"]+'" value="'+full["pago"]+'">';

							// return inputCapital+numberPay;
							if($scope.alphaNumeric[(full['pago']-1)]['disp']==1 && $scope.alphaNumeric[(full['pago']-1)]['importe']!="" && full['importe']!="")//
							{
								// var inputCapital = '<input name="importe' + full["pago"] + '"  id="idImporte' + full["pago"] + '"   placeholder="Importe" class="form-control" value="' +full['importe'] + '" type="tel" pattern="^\\$\\d{1,3}(,\\d{3})*(\\.\\d+)?$"  data-type="currency" >';//onchange="pagoCapChange('+full["pago"]+')"
								var input_val = full['importe'];

								// don't validate empty input
								if (input_val === "") { return; }

								// original length
								var original_len = input_val.length;



								// check for decimal
								if (input_val.indexOf(".") >= 0) {

									// get position of first decimal
									// this prevents multiple decimals from
									// being entered
									var decimal_pos = input_val.indexOf(".");

									// split number by decimal point
									var left_side = input_val.substring(0, decimal_pos);
									var right_side = input_val.substring(decimal_pos);

									// add commas to left side of number
									left_side = formatNumber(left_side);

									// validate right side
									right_side = formatNumber(right_side);

									// On blur make sure 2 numbers after decimal
									if (blur === "blur") {
										right_side += "00";
									}

									// Limit decimal to only 2 digits
									right_side = right_side.substring(0, 2);

									// join number by .
									input_val = "$" + left_side + "." + right_side;

								} else {
									// no decimal entered
									// add commas to number
									// remove all non-digits
									input_val = formatNumber(input_val);
									input_val = "$" + input_val;

									// final formatting
									if (blur === "blur") {
										input_val += ".00";
									}
								}
								// console.log(input_val);
								var inputCapital = input_val;
								// let importeMoney = formatNumber(full['importe']);
								// console.log(importeMoney);
								var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '" value="' + full["pago"] + '">';
								return inputCapital + numberPay;
							}
							else
							{
								if(full['check'] ==1)
								{
									var inputCapital = '<input name="importe' + full["pago"] + '" type="number" id="idImporte' + full["pago"] + '"  disabled placeholder="Importe" class="form-control">';//onchange="pagoCapChange('+full["pago"]+')"
									var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '"  value="'+full["pago"]+'">';
									return inputCapital + numberPay;
								}
								else
								{
									var inputCapital = '<input name="importe' + full["pago"] + '" type="number" id="idImporte' + full["pago"] + '"   placeholder="Importe" class="form-control">';//onchange="pagoCapChange('+full["pago"]+')"
									var numberPay = '<input name="numberPay' + full["pago"] + '" type="hidden" id="payNum' + full["pago"] + '"  value="'+full["pago"]+'">';
									return inputCapital + numberPay;
								}
							}
						},
					),
				DTColumnBuilder.newColumn('diasRetraso').withTitle('Días de retraso')
					.renderWith(
						function(data, type, full, meta)
						{
							/*Original vars*/
							var inputCapital;

							/*add vars*/
							var dateCurrent = full['fecha'];
							var datePays = dateCurrent.split("-").reverse().join("-");

							var dayPay;
							var posicionDate = dateCurrent.split('-');
							var mesPay = posicionDate[1];
							var anioPay = posicionDate[2];
							dayPay=daysInMonth(mesPay, anioPay);
							/*close add vars*/

							if($scope.alphaNumeric[(full['pago']-1)]['disp']==1 && $scope.alphaNumeric[(full['pago']-1)]['diasRetraso']!="" && full['diasRetraso']!="")//
							{
								/*original content*/
								/*inputCapital = '<input name="dRet' + full["pago"] + '" type="number" id="idDiasRet' + full["pago"] + '"  onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Días retardo" class="form-control" value="' + full['diasRetraso'] + '">';
                                return inputCapital;*/
								/*close original content*/

								/*new content*/
								/*var currentDateRow = '<input name="pagoDia'+full["pago"]+'" id="payDay'+full["pago"]+'" type="hidden" value="'+datePays+'"> ';
                                var inputCapital = '<input name="dRet'+full["pago"]+'" type="date" id="idDiasRet'+full["pago"]+'" onchange="pagoCapChange('+full["pago"]+')" min="'+anioPay+'-'+mesPay+'-01" max="'+anioPay+'-'+mesPay+'-'+dayPay+'"  placeholder="Días retardo" class="form-control" disabled>';
                                return inputCapital+currentDateRow;*/
								inputCapital = '<input name="dRet' + full["pago"] + '" type="number" id="idDiasRet' + full["pago"] + '"   placeholder="Días retardo" value="'+full['diasRetraso']+'" class="form-control"  disabled>';
								return inputCapital;
								/*close new content*/
							}
							else
							{
								if(full['check'] ==1)
								{
									/*original content*/
									inputCapital = '<input name="dRet' + full["pago"] + '" type="number" id="idDiasRet' + full["pago"] + '"   placeholder="Días retardo" class="form-control"  disabled>';
									return inputCapital;
									/*close original content*/

									/*new content*/

									/*close new content*/
								}
								else
								{
									/*original content*/
									/* inputCapital = '<input name="dRet' + full["pago"] + '" type="number" id="idDiasRet' + full["pago"] + '"  onchange="pagoCapChange(' + full["pago"] + ')" placeholder="Días retardo" class="form-control">';
                                    return inputCapital;*/
									/*close original content*/

									/*new content*/
									var currentDateRow = '<input name="pagoDia'+full["pago"]+'" id="payDay'+full["pago"]+'" type="hidden" value="'+datePays+'"> ';
									var inputCapital = '<input name="dRet'+full["pago"]+'" type="date" id="idDiasRet'+full["pago"]+'" onchange="pagoCapChange('+full["pago"]+')" min="'+anioPay+'-'+mesPay+'-01"  placeholder="Días retardo" class="form-control">';/*max="'+anioPay+'-'+mesPay+'-'+dayPay+'" */
									return inputCapital+currentDateRow;
									/*close new content*/
								}
							}
						},
					),
				DTColumnBuilder.newColumn('interesMoratorio').withTitle('Interés Moratorio').renderWith(
					function (data, type, full)
					{
						// return (IM).toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})
						// console.log($scope.alphaNumeric[(full['pago']-1)]);
						if($scope.alphaNumeric[(full['pago']-1)]['disp']==1 && $scope.alphaNumeric[(full['pago']-1)]['interesMoratorio']!="" && full['interesMoratorio']!="")//
						{
							return $scope.alphaNumeric[(full['pago']-1)]['interesMoratorio'].toLocaleString('es-MX', {style: 'currency', currency: 'MXN'});
							// return $scope.alphaNumeric[(full['pago']-1)]['interesMoratorio'];
						}
						else {
							return ((0.00).toFixed(2)).toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})
						}
					}
				),
				DTColumnBuilder.newColumn('total').withTitle('Total').renderWith(function (data, type, full)
				{return (data).toLocaleString('es-MX', {style: 'currency', currency: 'MXN'})} ),
				DTColumnBuilder.newColumn('saldo').withTitle('Saldo Moratorio').renderWith(function (data, type, full)
				{
					var numberFix = data.toFixed(2);
					var saldoInsolutoCR = '<input name="si'+full["pago"]+'" type="hidden" id="idSi'+full["pago"]+'"  value="'+numberFix+'" class="form-control">'
					if($scope.alphaNumeric[full['pago']-1]['saldo'] <= 0)
					{
						$scope.alphaNumeric[full['pago']-1]['saldo'] = 0;
					}
					return (data).toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}) + saldoInsolutoCR;
				}),
				DTColumnBuilder.newColumn('saldoNormal').withTitle('Saldo').renderWith(function (data, type, full)
				{
					var saldoInsolutoCRNormal = '<input name="siNormal'+full["pago"]+'" type="hidden" id="idSiNormal'+full["pago"]+'"  value="'+full['saldoNormal']+'" class="form-control">';//onchange="pagoCapChange('+full["pago"]+')"

					return (data).toLocaleString('es-MX', {style: 'currency', currency: 'MXN'}) + saldoInsolutoCRNormal;
				} ),
			];
			/**/
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
function sumaOrdinarios()
{
	var sumaCompletaOrdinario=0;
	for(var r=0; r<$scope.alphaNumeric.length; r++)
	{
		if($scope.alphaNumeric[r]['deudaOrdinario']!=0 && $scope.alphaNumeric[r]['deudaOrdinario']!=undefined)
		{
			sumaCompletaOrdinario +=$scope.alphaNumeric[r]['deudaOrdinario'];
			// alert($scope.alphaNumeric[r]['deudaOrdinario']);
		}
	}
	return sumaCompletaOrdinario;
}
// function checkAdeudoOrdinario()
// {
// 	var sumaAlv;
// 	for(var p=0; p<$scope.alphaNumeric.length; p++)
// 	{
// 		if($scope.alphaNumeric[p]['deudaOrdinario']!=0)
// 		{
// 			sumaAlv +=$scope.alphaNumeric[p]['deudaOrdinario'];
// 		}
// 	}
// 	return sumaAlv.toFixed(2);
// }
function limpiaAdeudoOrdinario()
{
	for(var r=0; r<$scope.alphaNumeric.length; r++)
	{
		// if($scope.alphaNumeric[r]['deudaOrdinario']!=0)
		// {
		// delete $scope.alphaNumeric[r]['deudaOrdinario'];
		if($scope.alphaNumeric[r]['deudaOrdinario']==0 || $scope.alphaNumeric[r]['deudaOrdinario']==undefined) {
			$scope.alphaNumeric[r]['deudaOrdinario'] = 0;
			// alert("Resete los valores del arreglo en la posicion: "+r+ ": " + $scope.alphaNumeric[r]['deudaOrdinario']);
		}
		// }
	}

	// return $scope.alphaNumeric;
}
// function limpiaAdeudoMoratorio()
// {
// 	for(var r=0; r<$scope.alphaNumeric.length; r++)
// 	{
// 		// $scope.alphaNumeric[r]['deudaMoratorio'] = 0;
// 		$scope.alphaNumeric[r]['deudaMoratorio'].push(0);
// 	}
// 	// return $scope.alphaNumeric;
// 	alert("Resete los valores del arreglo moratorio " + $scope.alphaNumeric[r]['deudaMoratorio']);
// }
