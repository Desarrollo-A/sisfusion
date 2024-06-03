
var day;
var mes;

function generarPlanPago(fechaInicio, periodos, monto, tIniteres, periocidad, tipoPP, planPago, mensualidadPP, interesesSSI, ivaPP, porcentajeIva){


        periodos = parseInt(periodos);
        tIniteres = parseFloat(tIniteres);
        periocidad = parseInt(periocidad);
        tipoPP = parseInt(tipoPP);
        planPago = parseInt(planPago);

        mensualidadPP = mensualidadPP.replace(',', '');


        //let mensualidadPP = document.getElementById('mensualidadPP');
        fechaInicio = stringToDate(fechaInicio);
        mes = (new Date(fechaInicio).getMonth() + (1));
        day = (new Date(fechaInicio).getDate());
        var yearc;
        if(mes>12){
            yearc = new Date(fechaInicio).getFullYear();
            mes=12;
        }else{
            yearc = new Date(fechaInicio).getFullYear();
        }


        let totalMonto = monto;
        var rangoPlan=[];


        let  meses= parseInt(periodos);
        let  interes= (tIniteres/12); //se ingresa la taza anual
        interes = interes / 100;
        let  contadorInicial= 0;
        let  precioTotal = monto;
        let interes_plan;
        let capital = totalMonto/periodos;
        let sumatoriaIntereses = 0;
        let banderaContIter;
        let cantidadIva;
        porcentajeIva = (porcentajeIva/100) ;

        for (var i = 0; i < periodos; i++) {

            if( (mes == 13) || (mes == 14) || (mes == 15) ){


                if(mes == 13){

                    mes = '01';
                    yearc++;

                } else if (mes == 14) {
                    mes = '02';
                    yearc++;

                } else if (mes == 15) {
                    mes = '03';
                    yearc++;

                }


            }

            if(mes == 1){
                mes = '01';
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

            let fechaPlan = ((day<=10) ? '0'+day : day) + '-' + (mes) + '-' + yearc;

            let p2;
            let total;
            if(tIniteres == 0){
                p2 = 0;
                interes_plan = 0;
                banderaContIter = true;
                precioTotal = precioTotal - capital;
                cantidadIva = (ivaPP==1) ? capital * porcentajeIva : 0;
                total = capital+cantidadIva;
            }
            else{
                // p2 = (interes *  Math.pow(1 + interes, meses) * monto) / ( Math.pow(1 + interes, meses )-1);
               interes_plan = precioTotal*interes;
                banderaContIter = (interes_plan > 0) ? true : false;
                if(interesesSSI){

                    p2 = (interes *  Math.pow(1 + interes, meses) * precioTotal) / ( Math.pow(1 + interes, meses )-1);
                    capital = (precioTotal > (mensualidadPP - interes_plan)) ? (mensualidadPP - interes_plan) : precioTotal;
                    precioTotal = ((precioTotal - capital) <= 0) ? 0: (precioTotal - capital);
                    cantidadIva = (ivaPP==1) ? porcentajeIva * capital : 0;
                    total = capital + interes_plan + cantidadIva;
                }
                else{
                    p2 = (interes *  Math.pow(1 + interes, meses) * monto) / ( Math.pow(1 + interes, meses )-1);
                    capital = (p2 - interes_plan);
                    precioTotal = (precioTotal - capital);
                    cantidadIva = (ivaPP==1) ? porcentajeIva * capital : 0;
                    total = p2 + cantidadIva;
                }
                //mensualidadPP.value = formatMoney(p2.toFixed(2));

            }

            if(banderaContIter>0 ){
                rangoPlan.push({
                    "fecha" : fechaPlan,
                    "planPago": parseInt(planPago),
                    "pago" : i + 1,
                    "capital" : capital.toFixed(2), //capital = (precioTotal > (mensualidadPP - interes_plan)) ? (mensualidadPP - interes_plan) : precioTotal
                    "saldoCapital" : 0,
                    "interes" : interes_plan.toFixed(2),
                    "saldoInteres" : 0,
                    "iva" : cantidadIva.toFixed(2),
                    "saldoIva" : 0,
                    "total" : total.toFixed(2),
                    "saldo" : precioTotal.toFixed(2) ,//(precioTotal = ((precioTotal - capital) <= 0) ? 0 : (precioTotal - capital))
                });
                mes++;
            }

        }
        return JSON.stringify(rangoPlan);
}

function stringToDate(fechaInicio){
    let fechaString = fechaInicio;
    const fechaObjeto = new Date(fechaString);
    return fechaObjeto.setDate(fechaObjeto.getDate() + 1);
}