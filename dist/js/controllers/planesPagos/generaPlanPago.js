
var day;
var mes;

function generarPlanPago(fechaInicio, periodos, monto, tIniteres, periocidad, tipoPP, planPago, mensualidadPP, interesesSSI, ivaPP, porcentajeIva, idPlanPagoModal, saldoSiguienteModal, prioridadCalculo, numeroPlanPagoNormales){
    console.log('fechaInicio:', fechaInicio);
    console.log('periodos:', periodos);
    console.log('monto:', monto);
    console.log('tIniteres:', tIniteres);
    console.log('periocidad:', periocidad);
    console.log('tipoPP:', tipoPP);
    console.log('planPago:', planPago);
    console.log('mensualidadPP:', mensualidadPP);
    console.log('interesesSSI:', interesesSSI);
    console.log('ivaPP:', ivaPP);
    console.log('porcentajeIva:', porcentajeIva);
    console.log('idPlanPagoModal:', idPlanPagoModal);
    console.log('saldoSiguienteModal:', saldoSiguienteModal);
    console.log('prioridadCalculo:', prioridadCalculo);
    //prioridadCalculo: Es para ver como se va a cálcular, haciendole caso a la mensualidad o bien al número de periodos
    //1: por mensualidad Eje. totalMonto/mensualidad = numero de periodos
    //2: por periodos    Eje. totalMonto/periodos = valor de la mensualidad
    prioridadCalculo = parseInt(prioridadCalculo);
    idPlanPagoModal = parseInt(idPlanPagoModal);

    if(idPlanPagoModal > 0 || idPlanPagoModal != undefined){
        console.log('prioridadCalculo', prioridadCalculo);
        console.log('idPlanPagoModal :)', idPlanPagoModal);
        periodos = parseInt(periodos);
        tIniteres = parseFloat(tIniteres);
        periocidad = parseInt(periocidad);
        tipoPP = parseInt(tipoPP);
        planPago = parseInt(planPago);
        planPago = ( tipoPP==3 ) ? 5 : ((planPago == 5) ? numeroPlanPagoNormales : planPago);

        mensualidadPP = parseFloat(mensualidadPP);

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

        let totalMonto;
        if(tIniteres == 0 && tipoPP == 1){
            console.log('ti v1:', tIniteres);
            console.log('tipoPP v1:', tipoPP);
            console.log('monto v1:', monto);
            totalMonto = monto;
        }else if(tIniteres == 0 && tipoPP != 1){
            console.log('ti v2:', tIniteres);
            console.log('tipoPP v2:', tipoPP);
            console.log('monto v2:', monto);
            console.log('saldoSiguienteModal v2:', saldoSiguienteModal);
            totalMonto = monto - saldoSiguienteModal;
        }else if(tIniteres != 0 && tipoPP != 1){
            totalMonto = monto - saldoSiguienteModal;
        }

        var rangoPlan=[];

        if(prioridadCalculo == 1){
            periodos = Math.ceil(totalMonto/mensualidadPP);
            console.log('totalMonto ', totalMonto);
            console.log('mensualidadPP ', mensualidadPP);
            console.log('periodos ', periodos);
        }else if(prioridadCalculo == 2 && tIniteres==0){
            mensualidadPP = Math.ceil(totalMonto/periodos);
            console.log('prioridadCalculo v2: ', prioridadCalculo);

        }





        let  meses= parseInt(periodos);
        let  interes= (tIniteres/12); //se ingresa la taza anual
        interes = interes / 100;
        let  contadorInicial = 0;
        let  precioTotal = monto;
        let interes_plan;
        // let capital = totalMonto/periodos;
        let capital;
        let sumatoriaIntereses = 0;
        let banderaContIter;
        let cantidadIva;
        porcentajeIva = (porcentajeIva/100) ;
        // periodos = Math.ceil(monto/mensualidadPP);
        console.log('periodos: ', periodos);
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
            console.log('Periodos', fechaPlan);
            let p2;
            let total;
            if(tIniteres == 0){

                saldoSiguienteModal = Number(saldoSiguienteModal);
                if(i == 0){
                    precioTotal = precioTotal+saldoSiguienteModal;
                }
                p2 = 0;
                interes_plan = 0;
                banderaContIter = true;
                capital = mensualidadPP;

                cantidadIva = (ivaPP==1) ? capital * porcentajeIva : 0;
                totalMonto -= capital;
                capital = (totalMonto < mensualidadPP)  ? ((totalMonto<0) ? capital + (totalMonto ) : mensualidadPP): mensualidadPP;
                precioTotal = precioTotal - capital;
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
    else{
        periodos = parseInt(periodos);
        tIniteres = parseFloat(tIniteres);
        periocidad = parseInt(periocidad);
        tipoPP = parseInt(tipoPP);
        planPago = parseInt(planPago);
        // planPago = ( tipoPP==3 ) ? 5 : ((planPago == 5) ? numeroPlanPagoNormales + 1 : ((tipoPP == 2) ? numeroPlanPagoNormales+1:planPago));
        planPago = (tipoPP == 5) ? 5 : planPago
        console.log('Este plan pago es:', planPago);

        //prioridadCalculo
        //1: por mensualidad
        //2: por plazo (periodos)



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
        // let capital = totalMonto/periodos;
        let capital;

        if(prioridadCalculo == 1){
            console.log('entré aqui 1: ', prioridadCalculo);
            capital = mensualidadPP;
            if(tazaInteresPP.value == 0){
                periodos = Math.ceil(totalMonto/mensualidadPP);
            }
            if(Number.parseInt(tazaInteresPP.value) >= 0 && interesesSSI){
                periodos = Math.ceil(totalMonto/mensualidadPP);
            }
        }
        else if(prioridadCalculo == 2){
            console.log('entré aqui 2: ', prioridadCalculo);

            capital = totalMonto/periodos;

        }

        let sumatoriaIntereses = 0;
        let banderaContIter;
        let cantidadIva;
        porcentajeIva = (porcentajeIva/100) ;
        // for (var i = 0; i < periodos; i++) {
        for (var i = 0; i < 360; i++) { //360: plazo máximo para una corrida financiera
            if(precioTotal > 0){

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
                /*if(tIniteres == 0){
                    p2 = 0;
                    interes_plan = 0;
                    banderaContIter = true;
                    precioTotal = precioTotal - capital;
                    cantidadIva = (ivaPP==1) ? capital * porcentajeIva : 0;
                    total = capital+cantidadIva;
                }*/
                if(tIniteres == 0){
                    console.log('interes 0');
                    saldoSiguienteModal = Number(saldoSiguienteModal);
                    if(i == 0){
                        precioTotal = precioTotal+saldoSiguienteModal;
                    }
                    p2 = 0;
                    interes_plan = 0;
                    banderaContIter = true;
                    // capital = mensualidadPP;

                    cantidadIva = (ivaPP==1) ? capital * porcentajeIva : 0;
                    totalMonto -= capital;
                    capital = (totalMonto < capital)  ? ((totalMonto<0) ? capital + (totalMonto ) : capital): capital;
                    precioTotal = precioTotal - capital;
                    total = capital+cantidadIva;
                }
                else{
                    // console.log('interes más que 0');
                    // p2 = (interes *  Math.pow(1 + interes, meses) * monto) / ( Math.pow(1 + interes, meses )-1);
                   interes_plan = precioTotal*interes;
                    banderaContIter = (interes_plan > 0) ? true : false;
                    if(interesesSSI){



                        /*capital = (precioTotal > (capital - interes_plan)) ? (capital - interes_plan) : precioTotal;
                        p2 = (interes *  Math.pow(1 + interes, meses) * precioTotal) / ( Math.pow(1 + interes, meses )-1);
                        precioTotal = ((precioTotal - capital) <= 0) ? 0: (precioTotal - capital);
                        cantidadIva = (ivaPP==1) ? porcentajeIva * capital : 0;
                        total = capital + interes_plan + cantidadIva;*/
                        p2 = (interes *  Math.pow(1 + interes, meses) * precioTotal) / ( Math.pow(1 + interes, meses )-1);
                        capital = (precioTotal > (mensualidadPP - interes_plan)) ? (mensualidadPP - interes_plan) : precioTotal;
                        precioTotal = ((precioTotal - capital) <= 0) ? 0: (precioTotal - capital);
                        cantidadIva = (ivaPP==1) ? porcentajeIva * capital : 0;
                        total = capital + interes_plan + cantidadIva;
                    }
                    else{
                        // p2 = (interes *  Math.pow(1 + interes, periodos) * monto) / ( Math.pow(1 + interes, monto )-1);
                        p2 = (interes *  Math.pow(1 + interes, periodos) * monto) / ( Math.pow(1 + interes, periodos )-1);
                        capital = (p2 - interes_plan);
                        precioTotal = (precioTotal - capital);
                        cantidadIva = (ivaPP==1) ? porcentajeIva * capital : 0;
                        total = p2 + cantidadIva;
                    }
                    //mensualidadPP.value = formatMoney(p2.toFixed(2));

                }

                // console.log('banderaContIter', banderaContIter);
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
        }
        return JSON.stringify(rangoPlan);
    }
}

function stringToDate(fechaInicio){
    let fechaString = fechaInicio;
    const fechaObjeto = new Date(fechaString);
    return fechaObjeto.setDate(fechaObjeto.getDate() + 1);
}