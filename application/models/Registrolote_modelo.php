<?php class Registrolote_modelo extends CI_Model{

    public function __construct()
    {
        parent::__construct();

    }

	public function insertaRegistroCliente($dato){
		$this->db->insert('cliente',$dato);
		return true;

	}

	public function Bitacora($dato){

		$this->db->insert('bitacora',$dato);
		return true;

	}

	public function insertBitacorarreglo($dato){

		//var_dump($dato);
		$this->db->insert('bitacora',$dato);
		return true;

	}

	public function editaRegistroCliente($id,$dato){

		$this->db->where("id_cliente",$id);
		$this->db->update('clientes',$dato);
		return true;

	}

    public function editaRegistroClienteDS_EA($idCliente,$arreglo, $arreglo2){
        $this->db->where("idCliente",$idCliente);
        $this->db->update('cliente_consulta',$arreglo);
        $this->db->where("idCliente",$idCliente);
        $this->db->update('deposito_seriedad_consulta',$arreglo2);
        return true;
    }

	public function getLotesGral_DS($condominio) {
        $query = $this->db->query("SELECT lc.idLote, nombreLote, idStatusLote FROM deposito_seriedad_consulta ds
                                INNER JOIN cliente_consulta cc ON cc.idCliente = ds.idCliente 
                                INNER JOIN lotes_consulta lc ON lc.idCliente = cc.idCliente 
                                WHERE lc.status = 1 AND lc.idCondominio = ".$condominio."");
        if($query){
            $query = $query->result_array();
            return $query;
        }
    }

    public function getLotesGral_CL($condominio) {
        $query = $this->db->query("SELECT lc.idLote, nombreLote, idStatusLote FROM clientes cc
                                INNER JOIN lotes lc ON lc.idCliente = cc.id_cliente 
                                WHERE lc.status = 1 AND cc.status = 1 AND lc.idCondominio = ".$condominio."");
        if($query){
            $query = $query->result_array();
            return $query;
        }
    }

    public function getdp_CL($lotes){
        $query = $this->db-> query("SELECT cl.id_cliente, l.idLote, l.idCliente, l.nombreLote, c.nombre, r.nombreResidencial, cl.nombre nomCliente, cl.apellido_paterno, cl.apellido_materno,
                                CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor,
                                CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) coordinador,
                                CONCAT(uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) gerente FROM lotes l 
                                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                                LEFT JOIN usuarios u ON u.id_usuario = cl.id_asesor
                                LEFT JOIN usuarios uu ON uu.id_usuario = cl.id_coordinador
                                LEFT JOIN usuarios uuu ON uuu.id_usuario = cl.id_gerente
                                WHERE l.idLote = ".$lotes);
        return $query->result_array();
    }

	public function selectDS_ds($idCliente){
        /**/$query= $this->db-> query("SELECT cliente_consulta.idCliente, primerNombre, segundoNombre, apellidoPaterno, apellidoMaterno, cliente_consulta.rfc, razonSocial, cliente_consulta.fechaNacimiento, telefono1, telefono2, calle, numero, colonia, cliente_consulta.municipio, estado, cliente_consulta.correo, referencia1, telreferencia1,
                                referencia2, telreferencia2, nombreLote, lotes_consulta.nombreLote, lotes_consulta.idLote, nombreResidencial, condominios.nombre as nombreCondominio, lotes_consulta.sup,
                                lotes_consulta.precio, deposito_seriedad_consulta.nombreConyuge, id, clave, desarrollo,camp_desarrollo, tipoLote, idOficial_pf, idDomicilio_pf, actaMatrimonio_pf, 
                                actaConstitutiva_pm, poder_pm, idOficialApoderado_pm, idDomicilio_pm, deposito_seriedad_consulta.rfc as rfcDS, nombre, 
                                nacionalidad, originario, estadoCivil, nombreConyuge, regimen, ocupacion, empresaLabora, puesto, antigueda, edadFirma, domicilioEmpresa,
                                ladaTelEmpresa, telefonoEmp, casa, noLote, cluster, super, noRefPago, costoM2, proyecto, deposito_seriedad_consulta.municipio as municipioDS,
                                importOferta, letraImport, cantidad, letraCantidad, saldoDeposito, aportMensualOfer, fecha1erAport, plazo, fechaLiquidaDepo, fecha2daAport,
                                municipio2, dia, mes, año, nombreFirOfertante, observacion, parentescoReferen, parentescoReferen2, nombreFirmaasesor, email2, nombreFirmaAutoriza,
                                precioFianza, montoFianza, preMenlSegVida, montoSegVida, acepto, acepto2, fechaCrate, deposito_seriedad_consulta.idCliente, deposito_seriedad_consulta.clave,
                                lotes_consulta.referencia, deposito_seriedad_consulta.domicilio_particular, costom2f,
                                deposito_seriedad_consulta.nombrecliente,
                                deposito_seriedad_consulta.espectacular,
                                deposito_seriedad_consulta.volante,
                                deposito_seriedad_consulta.radio,
                                deposito_seriedad_consulta.periodico,
                                deposito_seriedad_consulta.revista,
                                deposito_seriedad_consulta.redes,
                                deposito_seriedad_consulta.punto,
                                deposito_seriedad_consulta.invitacion,
                                deposito_seriedad_consulta.emailing,
                                deposito_seriedad_consulta.pagina,
                                deposito_seriedad_consulta.recomendacion,
                                deposito_seriedad_consulta.convenio,
                                deposito_seriedad_consulta.marketing,
                                deposito_seriedad_consulta.otro1,
                                deposito_seriedad_consulta.especificar,
                                deposito_seriedad_consulta.pase,
                                deposito_seriedad_consulta.modulo,
                                deposito_seriedad_consulta.paseevento,
                                deposito_seriedad_consulta.pasedesarrollo,
                                deposito_seriedad_consulta.call,
                                deposito_seriedad_consulta.pasedirecto,
                                deposito_seriedad_consulta.casaCheck,
                                deposito_seriedad_consulta.oficina,
                                deposito_seriedad_consulta.whatsapp,
                                deposito_seriedad_consulta.email,
                                deposito_seriedad_consulta.otro2,
								deposito_seriedad_consulta.fecha_modificacion,
                                gerente1.nombreGerente as gerente1, gerente2.nombreGerente as gerente2, gerente3.nombreGerente as gerente3, asesor_consulta1.nombreasesor as asesor, 
                                asesor_consulta2.nombreasesor as asesor2, asesor_consulta3.nombreasesor as asesor3,
                                residenciales.idResidencial, condominios.tipo_lote, CONCAT(primerNombre, '', segundoNombre, ' ', apellidoPaterno, ' ', apellidoMaterno) nombreCliente FROM cliente_consulta
                                INNER JOIN lotes_consulta ON cliente_consulta.idLote = lotes_consulta.idLote
                                INNER JOIN condominios ON lotes_consulta.idcondominio = condominios.idcondominio
                                INNER JOIN residenciales ON condominios.idresidencial = residenciales.idresidencial
                                LEFT JOIN asesor_consulta ON cliente_consulta.idasesor= asesor_consulta.idasesor
                                LEFT JOIN asesor_consulta as asesor_consulta1 ON asesor_consulta1.idasesor = cliente_consulta.idasesor
                                LEFT JOIN asesor_consulta as asesor_consulta2 ON asesor_consulta2.idasesor = cliente_consulta.idasesor2
                                LEFT JOIN asesor_consulta as asesor_consulta3 ON asesor_consulta3.idasesor = cliente_consulta.idasesor3
                                LEFT JOIN gerente_consulta ON cliente_consulta.idGerente = gerente_consulta.idGerente
                                LEFT JOIN gerente_consulta as gerente1 ON gerente1.idGerente = cliente_consulta.idGerente
                                LEFT JOIN gerente_consulta as gerente2 ON gerente2.idGerente = cliente_consulta.idGerente2
                                LEFT JOIN gerente_consulta as gerente3 ON gerente3.idGerente = cliente_consulta.idGerente3
                                INNER JOIN deposito_seriedad_consulta ON cliente_consulta.idcliente = deposito_seriedad_consulta.idcliente
                                WHERE cliente_consulta.idCliente = ".$idCliente);


        return $query->row();

    }
    public function getdp_DS($lotes){
        $query = $this->db-> query("SELECT TOP(1)  'Depósito de seriedad versión anterior' expediente, 'DEPÓSITO DE SERIEDAD' movimiento,
		'VENTAS-ASESOR' primerNom, 'VENTAS' ubic, l.nombreLote, CONCAT(cl.primerNombre, ' ', cl.segundoNombre) nomCliente, cl.apellidoPaterno apellido_paterno, cl.apellidoMaterno apellido_materno, cl.rfc,
		cond.nombre, res.nombreResidencial, cl.fechaApartado, cl.idCliente id_cliente, cl.idCliente idDocumento, ds.fechaCrate modificado,
        l.idLote
		FROM cliente_consulta cl
		INNER JOIN lotes_consulta l ON l.idLote = cl.idLote
		INNER JOIN deposito_seriedad_consulta ds ON ds.idCliente = cl.idCliente
		INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio
		INNER JOIN residenciales res ON res.idResidencial = cond.idResidencial
		WHERE cl.status=1 AND l.status=1 AND cl.idLote=".$lotes);
        return $query->result_array();
    }

    
	public function registroCliente()
	{

		/*$this->db->select('cliente.idCliente, primerNombre, segundoNombre, apellidoPaterno, apellidoMaterno,
						fechaNacimiento, telefono1, telefono2, telefono3, calle, numero, colonia, municipio,
						estado, cliente.correo, referencia1, telreferencia1,
						referencia2, telreferencia2, engancheCliente, fechaEnganche, prorroga, comentarioDescuentos,
						expediente, nombreClienteExpediente, nombreLote, enterado, especifiqueEnt, primerContacto,
						gerente1.nombreGerente as gerente1, gerente2.nombreGerente as gerente2,
						gerente3.nombreGerente as gerente3, gerente4.nombreGerente as gerente4,
						gerente5.nombreGerente as gerente5, asesor1.nombreAsesor as asesor,
						asesor2.nombreAsesor as asesor2, asesor3.nombreAsesor as asesor3,
						asesor4.nombreAsesor as asesor4, asesor5.nombreAsesor as asesor5,
						fechaApartado, fechaVencimiento, rfc, razonSocial, noRecibo, tipopago.tipo, noAcuse,
						nombreResidencial, condominio.nombre as nombreCondominio, cliente.status');

		$this->db->join('lotes', 'cliente.idLote = lotes.idLote');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->join('tipopago', 'cliente.idTipoPago = tipopago.idTipoPago');
		$this->db->join('asesor', 'cliente.idAsesor = asesor.idAsesor');
		$this->db->join('asesor as asesor1', 'asesor1.idAsesor = cliente.idAsesor', 'left');
		$this->db->join('asesor as asesor2', 'asesor2.idAsesor = cliente.idAsesor2', 'left');
		$this->db->join('asesor as asesor3', 'asesor3.idAsesor = cliente.idAsesor3', 'left');
		$this->db->join('asesor as asesor4', 'asesor4.idAsesor = cliente.idAsesor4', 'left');
		$this->db->join('asesor as asesor5', 'asesor5.idAsesor = cliente.idAsesor5', 'left');
		$this->db->join('gerente', 'asesor.idGerente = gerente.idGerente');
		$this->db->join('gerente as gerente1', 'asesor1.idGerente = gerente1.idGerente', 'left');
		$this->db->join('gerente as gerente2', 'asesor2.idGerente = gerente2.idGerente', 'left');
		$this->db->join('gerente as gerente3', 'asesor3.idGerente = gerente3.idGerente', 'left');
		$this->db->join('gerente as gerente4', 'asesor4.idGerente = gerente4.idGerente', 'left');
		$this->db->join('gerente as gerente5', 'asesor5.idGerente = gerente5.idGerente', 'left');
		$this->db->where('cliente.status', 1);
		$this->db->where('lotes.idStatusContratacion <>', 15);
		$this->db->order_by('cliente.idCliente', 'desc');
		$query = $this->db->get('cliente');
		return $query->result();*/
		/*		   $query = $this->db-> query("SELECT id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
				cl.apellido_materno ,personalidad_juridica ,nacionalidad ,rfc ,curp ,cl.correo ,telefono1
			  ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,cl.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge ,calle ,numero
			  ,colonia ,municipio ,estado ,codigo_postal ,tipo_vivienda ,ocupacion ,empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa ,originario ,noRecibo
			  ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por,
			  fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio,
			  (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
			  (SELECT CONCAT(uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno)) AS gerente ,
			  (SELECT CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno)) AS coordinador
			  FROM clientes cl
			  LEFT JOIN usuarios us ON cl.id_asesor=us.id_usuario
			  LEFT JOIN lotes lotes ON lotes.idLote=cl.idLote
			  LEFT JOIN condominios cond ON lotes.idCondominio=cond.idCondominio
			  LEFT JOIN residenciales residencial ON cond.idResidencial=residencial.idResidencial
			  LEFT JOIN tipopago tp ON cl.idTipoPago=tp.idTipoPago
			  LEFT JOIN usuarios uu ON uu.id_usuario = us.id_lider
			  LEFT JOIN usuarios uuu ON uuu.id_usuario = uu.id_lider");

				   return ($query->num_rows >0) ? $query->result(): NULL;*/
		/*$this->db->select("cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
		cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
      ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
      ,domicilio_particular ,tipo_vivienda ,ocupacion ,empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa ,originario ,noRecibo
      ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, 
	  cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
	  (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
	  (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
	  (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador");
		/*
		 * (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
			  (SELECT CONCAT(uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno)) AS gerente ,
			  (SELECT CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno)) AS coordinador
		*/
		/*$this->db->join('usuarios as us', 'cl.id_asesor=us.id_usuario', 'LEFT');
		$this->db->join('lotes as lotes', 'lotes.idLote=cl.idLote', 'LEFT');
		$this->db->join('condominios as cond', 'lotes.idCondominio=cond.idCondominio', 'LEFT');
		$this->db->join('residenciales as residencial', 'cond.idResidencial=residencial.idResidencial', 'LEFT');
		$this->db->join('referencias as ref', 'ref.id_cliente=cl.id_cliente', 'LEFT');
		$this->db->join('tipopago as tp', 'cl.idTipoPago=tp.idTipoPago', 'LEFT');
		/*$this->db->join('usuarios as uu', 'uu.id_usuario = us.id_lider', 'LEFT');
		$this->db->join('usuarios uuu', 'uuu.id_usuario = uu.id_lider', 'LEFT');*/
		/*$this->db->where('cl.status', 1);
		$this->db->where('lotes.idStatusContratacion <>', 15);
		$this->db->order_by('cl.id_cliente', 'desc');
		$query = $this->db->get('clientes as cl');*/
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                where cl.status = 1 order by cl.id_cliente desc");

        return $query->result();
        /*AND lotes.idStatusContratacion <> 15*/

	}

	public function getReferenciasCliente($id_cliente)
	{
		$schema = 'referencias';
		$this->db->select("*");
		$this->db->where('id_cliente', $id_cliente);
		$query = $this->db->get('referencias');
		return $query->result();
	}

	public function getPrimerContactoCliente($id_opcion)//recibe la opcion en la tabla de clientes
	{
		$this->db->select("*");
		$this->db->where('id_catalogo', 9); /*le indicamos el catalogo de prospeccion*/
		$this->db->where('id_opcion', $id_opcion);
		$query = $this->db->get('opcs_x_cats');
		return $query->row_array();
	}
	public function getVentasCompartidas($id_cliente)//recibe la opcion en la tabla de clientes
	{
		$this->db->select("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as nombre");
		$this->db->where('id_cliente', $id_cliente);/*le indicamos el cliente para ver si hay ventas compartidas*/
		$this->db->join('usuarios as u', 'u.id_usuario=vc.id_asesor', 'LEFT');
		$query = $this->db->get('ventas_compartidas vc');
		return $query->result();
	}

	public function selectNombreLote($id){

		$this->db->select('cliente.idCliente, primerNombre, segundoNombre, apellidoPaterno, apellidoMaterno, rfc, razonSocial,  
        	fechaNacimiento, telefono1, telefono2, telefono3, calle, numero, colonia, municipio, estado, cliente.correo, referencia1, telreferencia1,
        	referencia2, telreferencia2, nombreLote, enterado, especifiqueEnt, lotes.nombreLote, primerContacto, lotes.idLote, asesor.nombreAsesor, gerente.nombreGerente');
		$this->db->join('lotes', 'cliente.idLote = lotes.idLote');
		$this->db->join('asesor', 'cliente.idAsesor = asesor.idAsesor');
		$this->db->join('gerente', 'asesor.idGerente = gerente.idGerente');
		$this->db->where("cliente.idCliente",$id);
		$query= $this->db->get("cliente");
		return $query->row();

	}

	public function selectRegistroCliente($id){

		$this->db->where("idCliente",$id);
		$query= $this->db->get("cliente");
		return $query->row();

	}

	public function selectClientebitacora($id){

		$this->db->where("idcliente",$id);
		$query= $this->db->get("bitacora");
		return ($query->num_rows>0) ? $query->row(): NULL;

	}

	public function insertaRegistroLote($dato){

		$this->db->insert('lote',$dato);
		return true;

	}

	public function selectRegistroLoteCaja($id){

		$this->db->select('cliente.id_cliente, lotes.nombreLote, lotes.idLote, lotes.usuario, lotes.perfil, lotes.fechaVenc, 
		lotes.idCondominio, lotes.modificado, lotes.fechaSolicitudValidacion, condominio.nombre, 
		residencial.nombreResidencial, lotes.contratoArchivo, lotes.fechaRL, lotes.totalNeto, lotes.totalValidado, lotes.totalNeto2');

		$this->db->join('clientes cliente', 'cliente.idLote = lotes.idLote');
		$this->db->join('condominios condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residenciales residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where("lotes.idLote",$id);
		$this->db->where("cliente.status", 1);
		$this->db->where("lotes.status", 1);


		$query = $this->db->get('lotes');
		return $query->row();

	}

	public function selectRegistroLoteCaja2($id){

		$this->db->where("lotes.idLote",$id);
		$this->db->where("lotes.status", 1);
		$query = $this->db->get('lotes');
		return $query->row();

	}

	public function editaRegistroLoteCaja($idLote,$dato){
		$this->db->where("idLote",$idLote);
		$this->db->update('lotes',$dato);
		$this->db->join('clientes cl', 'lotes.idLote = cl.idLote');
		return true;
	}

	public function getTipoPago(){

		$this->db->select('idTipoPago, tipo');
		$this->db->from('tipopago');
		$this->db->order_by('tipo','asc');
		$query = $this->db->get();
		return $query->result_array();

	}

// filtro de asesores por gerente

	public function getGerente()
	{
		$this->db->select("gerente.id_usuario, (SELECT CONCAT(gerente.nombre, ' ', gerente.apellido_paterno, ' ', gerente.apellido_materno)) as nombreGerente");
		$this->db->from('usuarios as gerente');
		$this->db->where('gerente.estatus', '1');
		$this->db->where('gerente.id_rol', '3');
		$this->db->order_by('nombreGerente', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function getGerenteBySede($id_sede)
	{
		$this->db->select("gerente.id_usuario, (SELECT CONCAT(gerente.nombre, ' ', gerente.apellido_paterno, ' ', gerente.apellido_materno)) as nombreGerente");
		$this->db->from('usuarios as gerente');
		$this->db->where('gerente.estatus', '1');
		$this->db->where('gerente.id_rol', '3');
		$this->db->where('gerente.id_sede', $id_sede);
		$this->db->order_by('nombreGerente', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function getCoordinadoresByGerente($id_gerente)
	{
		$this->db->select("coord.id_usuario, (SELECT CONCAT(coord.nombre, ' ', coord.apellido_paterno, ' ', coord.apellido_materno)) as nombreCoordinador");
		$this->db->from('usuarios as coord');
		$this->db->where('coord.estatus', '1');
		$this->db->where('coord.id_rol', '9');
		$this->db->where('coord.id_lider', $id_gerente);
		$this->db->order_by('nombreCoordinador', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getAsesores($gerent){

		$this->db->select('idAsesor, nombreAsesor');
		$this->db->from('asesor');
		$this->db->where('status','1');
		$this->db->order_by('nombreAsesor','asc');
		$this->db->where("idGerente",$gerent);
		$query = $this->db->get();
		return $query->result_array();

	}

///	fin filtro de asesores por gerente
// filtro de condominios por residencial

	public function getResidencial(){

		$this->db->select('idResidencial, nombreResidencial, descripcion');
		$this->db->from('residenciales');
		$this->db->where('status','1');
		// $this->db->where_in('idResidencial', array('1','2','3', '4', '5', '6','7','8','9'));
		$this->db->order_by('nombreResidencial','asc');
		$query = $this->db->get();
		return $query->result_array();

	}

	public function getCondominio($residencial)
	{
		$this->db->select('idCondominio, nombre');
		$this->db->from('condominios');
		$this->db->where('status', '1');
		$this->db->order_by('nombre', 'asc');
		$this->db->where("idResidencial", $residencial);
		$query = $this->db->get();
		return $query->result_array();
	}

///	fin filtro de condominios por residencial
// filtro de lote por condominios y residencial

	public function getLotes($condominio,$residencial)
	{

		$this->db->select('idLote,nombreLote, idStatusLote');
		$this->db->where('idCondominio', $condominio);
		$this->db->where('lotes.status', 1);
		$this->db->where_in('idStatusLote', array('1'));
		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;
		}

	}


///	fin filtro de lote por condominios y residencial
// filtro de lotes2 por condominios y residencial (para el historial)

	public function getLotes2($condominio,$residencial)
	{

		$this->db->select('idLote,nombreLote');
		$this->db->where('idCondominio', $condominio);
		$this->db->where('lotes.status', 1);
		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;
		}

	}

	///	fin filtro de lotes2 por condominios y residencial(para el historial)

	public function getStatusLote() {
		$query = $this->db-> query('SELECT idStatusLote,nombre FROM statuslote  WHERE idStatusLote IN (9, 8, 7, 3, 10) ');
		return $query->result();

	}

	public function getLote(){
		$query = $this->db-> query('SELECT idLote, lote, condominio, nombreResidencial,
    FROM lotes inner join residenciales
    on lotes.idResidencial = residenciales.idResidencial');
		return ($query->num_rows >0) ? $query->result(): NULL;
	}


	public function registroLote()
	{
		$this->db->select('idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo, modalidad_1, 
		modalidad_2, referencia, comentarioLiberacion, fechaLiberacion, l.status, s.nombre, 
		c.nombre as nombreCondominio, res.nombreResidencial');

		$this->db->join('statuslote s', 'l.idStatusLote = s.idStatusLote');
		$this->db->join('condominios c', 'l.idCondominio = c.idCondominio');
		$this->db->join('residenciales res', 'c.idResidencial = res.idResidencial');
		$this->db->where('l.status', 1);
		$query = $this->db->get('lotes l');
		if ($query) {
			$query = $query->result();
			return $query;
		}
	}

//        public function clienteDocumentos(){
//     $query = $this->db-> query('SELECT idCliente, primerNombre, segundoNombre,
// apellidoPaterno, apellidoMaterno, corrida, ife, nombreLote, rfc, razonSocial, condominio.nombre AS nombreCondominio, residencial.nombreResidencial, lotes.idStatusContratacion, lotes.idMovimiento
//  FROM [cliente] INNER JOIN [lotes] ON cliente.idLote = lotes.idLote
//  INNER JOIN [condominio] ON lotes.idCondominio = condominio.idCondominio INNER JOIN [residencial] ON condominio.idResidencial = residencial.idResidencial where cliente.status = 1');
// 	return $query->result();
//       }

	public function ConsultJuridico($cliente){

		$this->db->where("idCliente",$cliente);
		$this->db->where('perfil','juridico');
		$query= $this->db->get("bitacora");
		return ($query->num_rows>0) ? $query->result(): NULL;

	}

	public function ConsultClienteBitacora($cliente){

		$this->db->where("idCliente",$cliente);
		$query= $this->db->get("bitacora");
		return ($query->num_rows>0) ? $query->result(): NULL;

	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function getCajaStatus1() {

		$query = $this->db-> query('SELECT idStatusContratacion,nombreStatus FROM statuscontratacion where idStatusContratacion = 1');
		return $query->result_array();

	}

	public function getAsistentesStatus2() {

		$query = $this->db-> query('SELECT idStatusContratacion,nombreStatus FROM statuscontratacion where idStatusContratacion = 2');
		return $query->result_array();

	}

	public function getJuridicoStatus3() {

		$query = $this->db-> query('SELECT idStatusContratacion,nombreStatus FROM statuscontratacion where idStatusContratacion = 3');
		return $query->result_array();

	}

	public function getPostventaStatus4() {

		$query = $this->db-> query('SELECT idStatusContratacion,nombreStatus FROM statuscontratacion where idStatusContratacion = 4');
		return $query->result_array();

	}

	public function getContraloriaStatus5() {

		$query = $this->db-> query('SELECT idStatusContratacion,nombreStatus FROM statuscontratacion where idStatusContratacion = 5');
		return $query->result_array();

	}

	public function getContraloriaStatus6() {

		$query = $this->db-> query('SELECT idStatusContratacion,nombreStatus FROM statuscontratacion where idStatusContratacion = 6');
		return $query->result_array();

	}

	public function getJuridicoStatus7() {
		$query = $this->db-> query('SELECT idStatusContratacion,nombreStatus FROM statuscontratacion where idStatusContratacion = 7');
		return $query->result_array();

	}

	public function getAsistentesStatus8() {

		$query = $this->db-> query('SELECT idStatusContratacion,nombreStatus FROM statuscontratacion where idStatusContratacion = 8');
		return $query->result_array();

	}

	public function getContraloriaStatus9() {

		$query = $this->db-> query('SELECT idStatusContratacion,nombreStatus FROM statuscontratacion where idStatusContratacion = 9');
		return $query->result_array();

	}

	public function getContraloriaStatus10() {

		$query = $this->db-> query('SELECT idStatusContratacion,nombreStatus FROM statuscontratacion where idStatusContratacion = 10');
		return $query->result_array();

	}

	public function getAdministracionStatus11() {

		$query = $this->db-> query('SELECT idStatusContratacion,nombreStatus FROM statuscontratacion where idStatusContratacion = 11');
		return $query->result_array();

	}

	public function getRepresentanteStatus12() {

		$query = $this->db-> query('SELECT idStatusContratacion,nombreStatus FROM statuscontratacion where idStatusContratacion = 12');
		return $query->result_array();

	}

	public function getContraloriaStatus13() {

		$query = $this->db-> query('SELECT idStatusContratacion,nombreStatus FROM statuscontratacion where idStatusContratacion = 13');
		return $query->result_array();

	}

	public function getAsistentesStatus14() {

		$query = $this->db-> query('SELECT idStatusContratacion,nombreStatus FROM statuscontratacion where idStatusContratacion = 14');
		return $query->result_array();

	}

	public function getContraloriaStatus15() {

		$query = $this->db-> query('SELECT idStatusContratacion,nombreStatus FROM statuscontratacion where idStatusContratacion = 15');
		return $query->result_array();

	}

	public function liberacion($id,$dato){

		$this->db->where("idLote",$id);
		$this->db->update('lotes',$dato);
		return true;

	}

	public function registroAcuse(){

		$query = $this->db-> query('SELECT cliente.idCliente, primerNombre, segundoNombre, apellidoPaterno, apellidoMaterno, nombreLote, condominio.nombre,nombreAsesor, nombreGerente, noAcuse, nombreResidencial, observacionesAcuseContraloria
        FROM cliente inner join lotes on cliente.idLote = lotes.idLote inner join condominio on
        lotes.idCondominio = condominio.idCondominio inner join residencial on condominio.idResidencial = residencial.idResidencial
        inner join asesor on cliente.idAsesor = asesor.idAsesor
        inner join gerente on asesor.idGerente = gerente.idGerente WHERE noAcuse  IS NOT NULL');
		return ($query->num_rows >0) ? $query->result(): NULL;

	}

// filtro de condominios por residencial PARA SUR Y SAN LUIS

	public function getResidencialQro()
	{
		$this->db->select('idResidencial, nombreResidencial, descripcion');
		$this->db->from('residenciales');
		$this->db->where('status', '1');
		$this->db->order_by('nombreResidencial', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getCondominioQro($residencial)
	{
		$this->db->select('idCondominio, nombre');
		$this->db->from('condominios');
		$this->db->where('status', '1');
		$this->db->order_by('nombre', 'asc');
		$this->db->where("idResidencial", $residencial);
		$query = $this->db->get();
		return $query->result_array();
	}

///	fin filtro de condominios por residencial PARA SUR Y SAN LUIS
// filtro de lote por condominios y residencial

	public function getLotesQro($condominio,$residencial)
	{

		$this->db->select('idLote,nombreLote, idStatusLote');
		$this->db->where('idCondominio', $condominio);
		$this->db->where('lotes.status', 1);
		$this->db->where_in('idStatusLote', array('1','2','3','4','5','6','7','8'));
		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;
		}

	}

///	fin filtro de lote por condominios y residencial
//////////////////////////////INICIA PANEL PARA REGISTRAR STATUS CONTRATACION DEL LOTE VERIFICANDO STATUS ANTERIOR ///////////////////////

	public function registroStatusContratacion () {
		$query = $this->db-> query('
    	SELECT lotes.idLote, cliente.idCliente, primerNombre, segundoNombre,
            apellidoPaterno, apellidoMaterno, lotes.nombreLote, lotes.status, statuslote.nombre,
            idMovimiento, idStatusContratacion, razonSocial, lotes.comentario, condominio.nombre as nombreCondominio, 
            residencial.nombreResidencial
            FROM lotes inner join cliente on cliente.idLote = lotes.idLote
            inner join statuslote on lotes.idStatusLote = statuslote.idStatusLote
	        INNER JOIN condominio ON lotes.idCondominio = condominio.idCondominio
            INNER JOIN residencial ON condominio.idResidencial = residencial.idResidencial
    		where cliente.status = 1 and lotes.idStatusLote <> 9 and lotes.idStatusLote <> 8
    		 and lotes.idStatusContratacion = "0" 
    		 ');
		return $query->result();

	}

	public function registroStatusContratacion2 () {

		$query = $this->db-> query("SELECT lotes.idLote, cliente.id_cliente, cliente.nombre, apellido_paterno, 
	apellido_materno, lotes.nombreLote, lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado, 
	CAST(lotes.comentario AS varchar(MAX)) as comentario, cliente.rfc, fechaVenc, lotes.perfil, condominio.nombre as nombreCondominio, residencial.nombreResidencial, 
	lotes.ubicacion, condominio.idCondominio
	FROM lotes 
	inner join clientes cliente on cliente.idLote = lotes.idLote
	INNER JOIN condominios condominio ON lotes.idCondominio = condominio.idCondominio
    INNER JOIN residenciales residencial ON condominio.idResidencial = residencial.idResidencial
	where  
	lotes.idStatusContratacion = '2' and lotes.idMovimiento  = '84' and cliente.status = 1
	or lotes.idStatusContratacion = '1' and lotes.idMovimiento  = '18' and cliente.status = 1
    or lotes.idStatusContratacion = '1' and lotes.idMovimiento  = '19' and cliente.status = 1
    or lotes.idStatusContratacion = '1' and lotes.idMovimiento  = '20' and cliente.status = 1
    or lotes.idStatusContratacion = '1' and lotes.idMovimiento  = '63' and cliente.status = 1
    or lotes.idStatusContratacion = '1' and lotes.idMovimiento  = '73' and cliente.status = 1
    group by lotes.idLote, cliente.id_cliente, cliente.nombre, apellido_paterno, 
	apellido_materno, lotes.nombreLote, lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado, 
	CAST(lotes.comentario AS varchar(MAX)), cliente.rfc, fechaVenc, lotes.perfil, condominio.nombre, residencial.nombreResidencial, 
	lotes.ubicacion, condominio.idCondominio");
		return $query->result();

	}

	public function registroStatusContratacion3 () {

		$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.fechaApartado, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.nombreLote, l.idStatusContratacion,
        l.idMovimiento, l.modificado, cl.rfc, CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, cond.nombre as nombreCondominio, res.nombreResidencial, l.ubicacion,
        CONCAT(asesor.nombre,' ', asesor.apellido_paterno,' ', asesor.apellido_materno) as asesor, l.tipo_venta,
        CONCAT(gerente.nombre,' ', gerente.apellido_paterno,' ', gerente.apellido_materno) as gerente
        FROM lotes l
        INNER JOIN clientes cl ON cl.idLote=l.idLote
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial=res.idResidencial
        INNER JOIN usuarios asesor ON cl.id_asesor=asesor.id_usuario 
        LEFT JOIN usuarios gerente ON asesor.id_lider=gerente.id_usuario
        WHERE l.idStatusContratacion=2 AND l.idMovimiento=2 AND cl.status=1
        OR l.idStatusContratacion=2 AND l.idMovimiento=32 AND cl.status=1
        OR l.idStatusContratacion=2 AND l.idMovimiento=78 AND cl.status=1
        group by 
        l.idLote, cl.id_cliente, cl.fechaApartado, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.nombreLote, l.idStatusContratacion,
        l.idMovimiento, l.modificado, cl.rfc, CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
        CONCAT(asesor.nombre,' ', asesor.apellido_paterno,' ', asesor.apellido_materno), l.tipo_venta,
        CONCAT(gerente.nombre,' ', gerente.apellido_paterno,' ', gerente.apellido_materno)
        ORDER BY l.modificado DESC");
		return $query->result();

	}

	public function registroStatusContratacion4 () {

		$query = $this->db-> query('SELECT lotes.idLote, cliente.idCliente, primerNombre, segundoNombre, apellidoPaterno, apellidoMaterno,
        lotes.nombreLote, lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado, razonSocial, lotes.comentario, fechaVenc, lotes.perfil, condominio.nombre as nombreCondominio, 
        residencial.nombreResidencial, lotes.ubicacion
        FROM lotes inner join cliente on cliente.idLote = lotes.idLote
	        INNER JOIN condominio ON lotes.idCondominio = condominio.idCondominio
            INNER JOIN residencial ON condominio.idResidencial = residencial.idResidencial
	where  lotes.idStatusContratacion = "3" and lotes.idMovimiento  = "33" and cliente.status = 1
    or lotes.idStatusContratacion = "2" and lotes.idMovimiento  = "3" and cliente.status = 1
    group by lotes.idLote ');
		return $query->result();

	}



	public function registroStatusContratacion6 () {

		$query = $this->db-> query("SELECT lotes.idLote, cliente.id_cliente, cliente.nombre, apellido_paterno, 
	apellido_materno,lotes.nombreLote, lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado, rfc, 
	CAST(lotes.comentario AS varchar(MAX)) as comentario, fechaVenc, lotes.perfil, condominio.nombre as nombreCondominio, residencial.nombreResidencial, 
	cliente.expediente, lotes.ubicacion, lotes.tipo_venta, condominio.idCondominio
	FROM lotes 
	inner join clientes cliente on cliente.idLote = lotes.idLote
	INNER JOIN condominios condominio ON lotes.idCondominio = condominio.idCondominio
    INNER JOIN residenciales residencial ON condominio.idResidencial = residencial.idResidencial
	where  lotes.idStatusContratacion = '5' and lotes.idMovimiento  = '35' and cliente.status = 1 
    or lotes.idStatusContratacion = '5' and lotes.idMovimiento  = '22' and cliente.status = 1 
    or lotes.idStatusContratacion = '2' and lotes.idMovimiento  = '62' and cliente.status = 1 
    or lotes.idStatusContratacion = '5' and lotes.idMovimiento  = '75' and cliente.status = 1 
    group by lotes.idLote, cliente.id_cliente, cliente.nombre, apellido_paterno, 
	apellido_materno,lotes.nombreLote, lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado, rfc, 
	CAST(lotes.comentario AS varchar(MAX)), fechaVenc, lotes.perfil, condominio.nombre, residencial.nombreResidencial, 
	cliente.expediente, lotes.ubicacion, lotes.tipo_venta, condominio.idCondominio

            ");
		return $query->result();

	}

	public function registroStatusContratacion7 () {

		$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.fechaApartado, cl.nombre, cl.apellido_paterno, 
		cl.apellido_materno, l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc, 
		CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, cond.nombre as nombreCondominio, 
		res.nombreResidencial, l.ubicacion,
        CONCAT(asesor.nombre,' ', asesor.apellido_paterno,' ', asesor.apellido_materno) as asesor, l.tipo_venta,
        CONCAT(gerente.nombre,' ', gerente.apellido_paterno,' ', gerente.apellido_materno) as gerente
        FROM lotes l
        INNER JOIN clientes cl ON cl.idLote=l.idLote
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial=res.idResidencial
        INNER JOIN usuarios asesor ON cl.id_asesor=asesor.id_usuario 
        LEFT JOIN usuarios gerente ON asesor.id_lider=gerente.id_usuario
        WHERE l.idStatusContratacion=6 AND l.idMovimiento=36 AND cl.status=1
        OR l.idStatusContratacion=6 AND l.idMovimiento=6 AND cl.status=1
        OR l.idStatusContratacion=6 AND l.idMovimiento=23 AND cl.status=1
        OR l.idStatusContratacion=6 AND l.idMovimiento=76 AND cl.status=1
        OR l.idStatusContratacion=7 AND l.idMovimiento=83 AND cl.status=1
        group by 
        l.idLote, cl.id_cliente, cl.fechaApartado, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.nombreLote, 
        l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc, CAST(l.comentario AS varchar(MAX)), 
        l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
        CONCAT(asesor.nombre,' ', asesor.apellido_paterno,' ', asesor.apellido_materno), l.tipo_venta,
        CONCAT(gerente.nombre,' ', gerente.apellido_paterno,' ', gerente.apellido_materno)
        ORDER BY l.modificado DESC");
		return $query->result();

	}

	public function registroStatusContratacion8 () {

		$this->db->select(" lotes.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lotes.nombreLote, 
		lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado, CAST(lotes.comentario AS varchar(MAX)) as comentario, 
		fechaVenc, lotes.perfil, residencial.nombreResidencial, cond.nombre as nombreCondominio, lotes.ubicacion, lotes.tipo_venta,
		concat(us.nombre,' ', us.apellido_paterno, ' ', us.apellido_materno) as asesor, cl.id_asesor,
		concat(ge.nombre, ' ',ge.apellido_paterno, ' ',ge.apellido_materno) as gerente");

		$this->db->join('clientes as cl', 'lotes.idLote=cl.idLote', 'INNER');
		$this->db->join('condominios as cond', 'lotes.idCondominio=cond.idCondominio', 'INNER');
		$this->db->join('residenciales as residencial', 'cond.idResidencial=residencial.idResidencial', 'INNER');
		$this->db->join('usuarios as us', 'cl.id_asesor=us.id_usuario', 'INNER');
		$this->db->join('usuarios as ge', 'ge.id_usuario=us.id_lider ', 'LEFT');

		$this->db->where('"lotes"."idStatusContratacion" = 7 and "lotes"."idMovimiento" = 37 and "cl"."status" = 1 
			OR  "lotes"."idStatusContratacion" = 7 and "lotes"."idMovimiento" = 7  and "cl"."status" = 1 
			OR "lotes"."idStatusContratacion" = 7 and "lotes"."idMovimiento" = 64  and "cl"."status" = 1 
			OR "lotes"."idStatusContratacion" = 7 and "lotes"."idMovimiento" = 66  and "cl"."status" = 1 
			OR "lotes"."idStatusContratacion" = 7 and "lotes"."idMovimiento" = 77 and "cl"."status" = 1 
			OR "lotes"."idStatusContratacion" = 8 and "lotes"."idMovimiento" = 38 and "cl"."status" = 1 
			OR "lotes"."idStatusContratacion" = 8 and "lotes"."idMovimiento" = 65  and "cl"."status" = 1');
		$query  = $this->db->group_by("lotes.idLote, cl.id_cliente, cl.nombre, cl.apellido_materno, cl.apellido_paterno,
			lotes.nombreLote, lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado,
			lotes.modificado, CAST(lotes.comentario AS varchar(MAX)), lotes.fechaVenc, lotes.perfil,
			residencial.nombreResidencial, cond.nombre, lotes.ubicacion, lotes.tipo_venta,
 			cl.id_gerente, cl.id_coordinador, concat(us.nombre,' ', us.apellido_paterno,' ', us.apellido_materno),
 			concat(ge.nombre,' ', ge.apellido_paterno,' ', ge.apellido_materno), cl.id_asesor");
		$query = $this->db->get('lotes as lotes');
		return $query->result();

		/*$query = $this->db-> query('SELECT l.idLote, cl.idCliente, nombre, apellido_paterno, apellido_materno, l.nombreLote,
l.idStatusContratacion, l.idMovimiento, l.modificado, razonSocial, l.comentario, fechaVenc, l.perfil, 
residencial.nombreResidencial, condominio.nombre as nombreCondominio, l.ubicacion, gerente1.nombreGerente as gerente1, 
gerente2.nombreGerente as gerente2, gerente3.nombreGerente as gerente3, gerente4.nombreGerente as gerente4, gerente5.nombreGerente as gerente5,
 asesor1.nombreAsesor as asesor, asesor2.nombreAsesor as asesor2, asesor3.nombreAsesor as asesor3, asesor4.nombreAsesor as asesor4,
 asesor5.nombreAsesor as asesor5, lotes.tipo_venta
	    FROM lotes l
	    inner join clientes cl on cl.idLote = lotes.idLote
	    INNER JOIN condominios c ON l.idCondominio = c.idCondominio
        INNER JOIN residencial res ON c.idResidencial = res.idResidencial
        INNER JOIN asesor on cliente.idAsesor = asesor.idAsesor
			left JOIN asesor as asesor1 ON asesor1.idAsesor = cliente.idAsesor
            left JOIN asesor as asesor2 ON asesor2.idAsesor = cliente.idAsesor2
            left JOIN asesor as asesor3 ON asesor3.idAsesor = cliente.idAsesor3
            left JOIN asesor as asesor4 ON asesor4.idAsesor = cliente.idAsesor4
            left JOIN asesor as asesor5 ON asesor5.idAsesor = cliente.idAsesor5
            INNER JOIN gerente on asesor.idGerente = gerente.idGerente
		    left JOIN gerente as gerente1 ON asesor1.idGerente = gerente1.idGerente
			left JOIN gerente as gerente2 ON asesor2.idGerente = gerente2.idGerente
            left JOIN gerente as gerente3 ON asesor3.idGerente = gerente3.idGerente
            LEFT JOIN gerente as gerente4 ON asesor4.idGerente = gerente4.idGerente
            left JOIN gerente as gerente5 ON asesor5.idGerente = gerente5.idGerente
	where lotes.idStatusContratacion = "7" and lotes.idMovimiento  = "37" and cliente.status = 1
    OR lotes.idStatusContratacion = "7" and lotes.idMovimiento  = "7" and cliente.status = 1
    OR lotes.idStatusContratacion = "7" and lotes.idMovimiento  = "64" and cliente.status = 1
    OR lotes.idStatusContratacion = "7" and lotes.idMovimiento  = "66" and cliente.status = 1
    OR lotes.idStatusContratacion = "7" and lotes.idMovimiento  = "77" and cliente.status = 1
    OR lotes.idStatusContratacion = "8" and lotes.idMovimiento  = "38" and cliente.status = 1 
    OR lotes.idStatusContratacion = "8" and lotes.idMovimiento  = "65" and cliente.status = 1
  
    group by lotes.idLote');

		return $query->result();*/

	}

	public function registroStatusContratacion9 () {

		$query = $this->db-> query('SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, res.nombreResidencial, cond.nombre as nombreCondominio,
        l.ubicacion, l.tipo_venta, cond.idCondominio
        FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote
        INNER JOIN condominios cond ON l.idCondominio = cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        WHERE l.idStatusContratacion = 8 AND l.idMovimiento = 38 AND cl.status=1 OR
        l.idStatusContratacion = 8 AND l.idMovimiento=65 AND cl.status = 1
        GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, res.nombreResidencial, cond.nombre,
        l.ubicacion, l.tipo_venta, cond.idCondominio;');
		return $query->result();

	}


	public function registroStatusContratacion10 () {

		$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.validacionEnganche, l.firmaRL, l.nombreLote,
        l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc, CAST(l.comentario AS varchar(MAX)) as comentario, fechaVenc, l.perfil, cond.nombre as nombreCondominio,
        res.nombreResidencial, l.ubicacion, l.tipo_venta, cond.idCondominio
        FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote
        INNER JOIN condominios cond ON l.idCondominio = cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        WHERE l.idStatusContratacion=9 AND l.idMovimiento=39 AND cl.status =1
        OR l.idStatusContratacion=9 AND l.idMovimiento=26 AND cl.status =1
        OR l.idStatusContratacion=7 AND l.idMovimiento=66 AND cl.status =1
        OR l.idStatusContratacion=8 AND l.idMovimiento=67 AND cl.status =1
        OR l.idStatusContratacion=10 AND l.idMovimiento=40 AND cl.status =1
        OR l.idStatusContratacion=12 AND l.idMovimiento=42 AND cl.status =1
        OR l.idStatusContratacion=11 AND l.idMovimiento=41 AND cl.status =1
        GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.validacionEnganche, l.firmaRL, l.nombreLote,
        l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc, CAST(l.comentario AS varchar(MAX)), fechaVenc, l.perfil, cond.nombre,
        res.nombreResidencial, l.ubicacion, l.tipo_venta, cond.idCondominio;");
		return $query->result();

	}

	public function registroStatusContratacion11 () {

		$query = $this->db-> query('SELECT lotes.idLote, cliente.idCliente, primerNombre, segundoNombre, apellidoPaterno, apellidoMaterno,
        lotes.nombreLote, lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado, razonSocial, lotes.comentario, 
        condominio.nombre as nombreCondominio, residencial.nombreResidencial, fechaVenc, lotes.perfil, lotes.ubicacion, lotes.fechaSolicitudValidacion, lotes.totalNeto, lotes.tipo_venta
        FROM lotes inner join cliente on cliente.idLote = lotes.idLote
        INNER JOIN condominio ON lotes.idCondominio = condominio.idCondominio
        INNER JOIN residencial ON condominio.idResidencial = residencial.idResidencial
        where  lotes.idStatusContratacion = "10" and lotes.idMovimiento  = "40" and cliente.status = 1 
        or lotes.idStatusContratacion = "10" and lotes.idMovimiento  = "10" and cliente.status = 1
        or lotes.idStatusContratacion = "8" and lotes.idMovimiento  = "67" and cliente.status = 1
        OR lotes.idStatusContratacion = "12" and lotes.idMovimiento  = "42"  and lotes.validacionEnganche = "NULL" and cliente.status = 1
       OR lotes.idStatusContratacion = "12" and lotes.idMovimiento  = "42"  and lotes.validacionEnganche IS NULL and cliente.status = 1
        group by lotes.idLote ');
		return $query->result();

	}

	public function registroStatusContratacion12 () {

		$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.fechaSolicitudValidacion, l.nombreLote, l.idStatusContratacion,
        l.idMovimiento, l.modificado, cl.rfc, CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, cond.nombre as nombreCondominio, 
        res.nombreResidencial, l.numContrato, l.ubicacion, l.totalValidado, l.totalNeto, l.tipo_venta
        FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote
        INNER JOIN condominios cond ON l.idCondominio = cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        WHERE l.idStatusContratacion = 11 AND l.idMovimiento = 41 AND (l.firmaRL = 'NULL' OR l.firmaRL=' ' OR l.firmaRL IS NULL) AND cl.status = 1
        OR l.idStatusContratacion = 10 AND l.idMovimiento = 40 AND (l.firmaRL = 'NULL' OR l.firmaRL = ' ' OR l.firmaRL IS NULL) AND cl.status = 1
        OR l.idStatusContratacion = 7 AND l.idMovimiento = 66 AND (l.firmaRL = 'NULL' OR l.firmaRL = ' ' OR l.firmaRL IS NULL) AND cl.status = 1
        OR l.idStatusContratacion = 8 AND l.idMovimiento = 67 AND (l.firmaRL = 'NULL' OR l.firmaRL = ' ' OR l.firmaRL IS NULL AND cl.status = 1)
        GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.fechaSolicitudValidacion, l.nombreLote, l.idStatusContratacion,
        l.idMovimiento, l.modificado, cl.rfc, CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, 
        res.nombreResidencial, l.numContrato, l.ubicacion, l.totalValidado, l.totalNeto, l.tipo_venta;");
		return $query->result();

	}

	public function registroStatusContratacion13 () {
		$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.firmaRL, l.validacionEnganche, l.nombreLote,
        l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc, CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil,
        cond.nombre as nombreCondominio, res.nombreResidencial, l.ubicacion, l.tipo_venta, cond.idCondominio
        FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote
        INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        WHERE 
        l.idStatusContratacion=12 AND l.idMovimiento=42 AND cl.status=1
        OR l.idStatusContratacion=11 AND l.idMovimiento=41 AND cl.status=1
        GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.firmaRL, l.validacionEnganche, l.nombreLote,
        l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc, CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil,
        cond.nombre, res.nombreResidencial, l.ubicacion, l.tipo_venta, cond.idCondominio;");
		return $query->result();

	}

	public function registroStatusContratacion14 () {
		/*$query = $this->db-> query('SELECT lotes.idLote, cliente.idCliente, primerNombre, segundoNombre, apellidoPaterno, apellidoMaterno,
    lotes.nombreLote, lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado, razonSocial, lotes.comentario, 
    fechaVenc, lotes.perfil, residencial.nombreResidencial, condominio.nombre as nombreCondominio, lotes.ubicacion,
    gerente1.nombreGerente as gerente1, 
gerente2.nombreGerente as gerente2, gerente3.nombreGerente as gerente3, gerente4.nombreGerente as gerente4, gerente5.nombreGerente as gerente5,
 asesor1.nombreAsesor as asesor, asesor2.nombreAsesor as asesor2, asesor3.nombreAsesor as asesor3, asesor4.nombreAsesor as asesor4,
 asesor5.nombreAsesor as asesor5, lotes.tipo_venta
	FROM lotes inner join cliente on cliente.idLote = lotes.idLote
	        INNER JOIN condominio ON lotes.idCondominio = condominio.idCondominio
            INNER JOIN residencial ON condominio.idResidencial = residencial.idResidencial
                        inner join asesor on cliente.idAsesor = asesor.idAsesor
			left JOIN asesor as asesor1 ON asesor1.idAsesor = cliente.idAsesor
            left JOIN asesor as asesor2 ON asesor2.idAsesor = cliente.idAsesor2
            left JOIN asesor as asesor3 ON asesor3.idAsesor = cliente.idAsesor3
            left JOIN asesor as asesor4 ON asesor4.idAsesor = cliente.idAsesor4
            left JOIN asesor as asesor5 ON asesor5.idAsesor = cliente.idAsesor5
            INNER JOIN gerente on asesor.idGerente = gerente.idGerente
		    left JOIN gerente as gerente1 ON asesor1.idGerente = gerente1.idGerente
			left JOIN gerente as gerente2 ON asesor2.idGerente = gerente2.idGerente
            left JOIN gerente as gerente3 ON asesor3.idGerente = gerente3.idGerente
            LEFT JOIN gerente as gerente4 ON asesor4.idGerente = gerente4.idGerente
            left JOIN gerente as gerente5 ON asesor5.idGerente = gerente5.idGerente
	where lotes.idStatusContratacion = "13" and lotes.idMovimiento  = "43" and cliente.status = 1
    OR lotes.idStatusContratacion = "13" and lotes.idMovimiento  = "68" and cliente.status = 1
    group by lotes.idLote');
		return $query->result();*/
		$this->db->select("lotes.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lotes.nombreLote, 
		lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado, CAST(lotes.comentario AS varchar(MAX)) as comentario, 
		fechaVenc, lotes.perfil, residencial.nombreResidencial, cond.nombre as nombreCondominio, lotes.ubicacion, lotes.tipo_venta,
		concat(us.nombre,' ', us.apellido_paterno,' ', us.apellido_materno) as asesor, cl.id_asesor,
		concat(ge.nombre,' ', ge.apellido_paterno,' ', ge.apellido_materno) as gerente");

		$this->db->join('clientes as cl', 'lotes.idLote=cl.idLote', 'INNER');/*lotes.idLote=cl.idLote*/
		$this->db->join('condominios as cond', 'lotes.idCondominio=cond.idCondominio', 'INNER');
		$this->db->join('residenciales as residencial', 'cond.idResidencial=residencial.idResidencial', 'INNER');
		$this->db->join('usuarios as us', 'cl.id_asesor=us.id_usuario', 'INNER');
		$this->db->join('usuarios as ge', 'ge.id_usuario=us.id_lider ', 'LEFT');

		$this->db->where('"lotes"."idStatusContratacion" = 13 and "lotes"."idMovimiento" = 43 and "cl"."status" = 1 
			OR  "lotes"."idStatusContratacion" = 13 and "lotes"."idMovimiento" = 68  and "cl"."status" = 1 ');

		$query  = $this->db->group_by("lotes.idLote, cl.id_cliente, cl.nombre, cl.apellido_materno, cl.apellido_paterno,
			lotes.nombreLote, lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado,
			lotes.modificado, CAST(lotes.comentario AS varchar(MAX)), lotes.fechaVenc, lotes.perfil,
			residencial.nombreResidencial, cond.nombre, lotes.ubicacion, lotes.tipo_venta,
 			cl.id_gerente, cl.id_coordinador, concat(us.nombre,' ', us.apellido_paterno,' ', us.apellido_materno),
 			concat(ge.nombre,' ', ge.apellido_paterno,' ', ge.apellido_materno), cl.id_asesor");
		$query = $this->db->get('lotes as lotes');
		return $query->result();

	}

	public function registroStatusContratacion15 () {
		$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.nombreLote, l.idStatusContratacion, l.idMovimiento,
        l.modificado, cl.rfc, CAST(l.comentario AS varchar(MAX)) as comentario,  l.fechaVenc, l.perfil, res.nombreResidencial,
        cond.nombre as nombreCondominio, l.ubicacion, l.tipo_venta, cond.idCondominio
        FROM lotes l
        INNER JOIN clientes cl ON l.idLote = cl.idLote
        INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        WHERE 
        l.idStatusContratacion=14 AND l.idMovimiento=44 AND cl.status=1
        OR l.idStatusContratacion=14 AND l.idMovimiento=69 AND cl.status=1
        OR l.idStatusContratacion=14 AND l.idMovimiento=80 AND cl.status=1
        GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.nombreLote, l.idStatusContratacion, l.idMovimiento,
        l.modificado, cl.rfc, CAST(l.comentario AS varchar(MAX)),  l.fechaVenc, l.perfil, res.nombreResidencial,
        cond.nombre, l.ubicacion, l.tipo_venta, cond.idCondominio;");
            return $query->result();

	}
//////////////////////////////FIN PANEL PARA REGISTRAR STATUS CONTRATACION DEL LOTE VERIFICANDO STATUS ANTERIOR ///////////////////////

	public function reporteContratacion(){

		$query = $this->db-> query('SELECT idCliente, primerNombre, segundoNombre, apellidoPaterno, apellidoMaterno, fechaApartado, fechaVencimiento,
        nombreAsesor, nombreGerente, nombreLote, nombre, nombreResidencial, nombreClienteExpediente
        FROM contratacion.cliente inner join asesor on cliente.idAsesor = asesor.idAsesor inner join gerente
        on asesor.idGerente = gerente.idGerente inner join lotes on cliente.idLote = lotes.idLote 
        inner join condominio on lotes.idCondominio = condominio.idCondominio inner join residencial on condominio.idResidencial =
        residencial.idResidencial where cliente.status = 1');
		return ($query->num_rows >0) ? $query->result(): NULL;

	}

	public function reporteApartados(){

		$query = $this->db-> query('SELECT idApartado, cliente.primerNombre, cliente.segundoNombre, cliente.apellidoPaterno,
	       cliente.apellidoMaterno, historial_apartados.idCliente,
	       lotes.nombreLote, sum(historial_apartados.apartadoCliente) + cliente.apartadoCliente as sum_total
            FROM historial_apartados 
            INNER JOIN cliente ON historial_apartados.idCliente = cliente.idCliente
            INNER join lotes ON cliente.idLote = lotes.idLote
            where cliente.status = 1
            group by idCliente;');
		return ($query->num_rows >0) ? $query->result(): NULL;

	}

	public function historialLiberacion($lotes){

		$this->db->where("idLote",$lotes);
		$this->db->where('status','1');
		$query = $this->db->get('historial_liberacion');
		return $query->result();

	}

	public function historialProceso($lotes){

		$this->db->where("idLote",$lotes);
		$this->db->where('status','1');
		$query = $this->db->get('historial_lotes');
		return $query->result();

	}

	public function his_Enganche($dato){

		$this->db->insert('historial_enganche',$dato);
		return true;

	}

	public function historialEnganche($cliente){

		$this->db->select('idEnganche, noRecibo, engancheCliente, fechaEnganche, tipopago.tipo, user');
		$this->db->join('tipopago', 'historial_enganche.idTipoPago = tipopago.idTipoPago');
		$this->db->where("idCliente",$cliente);
		$this->db->where('status','1');
		$query = $this->db->get('historial_enganche');
		$this->db->order_by('idEnganche','asc');
		return $query->result();

	}

	public function historialClienteNombre($cliente){
		$this->db->where("idCliente",$cliente);
		$this->db->where('perfil', 'caja');
		$query = $this->db->get('bitacora');
		return $query->result();

	}

	public function historialDocsAsistentes($cliente){

		$this->db->where("idCliente",$cliente);
		$this->db->where('perfil', 'asistentesGerentes');
		// $this->db->or_where('perfil', 'contraloria');
		$query = $this->db->get('bitacora');
		return $query->result();

	}

	public function findCount(){

		$this->db->select('contador');
		$this->db->from('variables');
		$query = $this->db->get();
		return $query->row();

	}

	public function insertReporte($dato2){

		$this->db->insert('Solicitud',$dato2);
		return true;

	}

	public function updateTblvariables($id,$folioUp){

		$this->db->where("idVariable",$id);
		$this->db->update('variables',$folioUp);
		return true;

	}

	public function registroClienteSolicitud(){

		$this->db->select('idCliente, primerNombre, segundoNombre, apellidoPaterno, apellidoMaterno,nombreLote,rfc, razonSocial,  cliente.status');
		$this->db->join('lotes', 'cliente.idLote = lotes.idLote');
		$this->db->where('cliente.status', 1);
		$this->db->where('lotes.idStatusContratacion', '5');
		$this->db->where('lotes.idMovimiento', '35');
		$this->db->order_by('cliente.idCliente', 'desc');
    	$query = $this->db->get('cliente');
		return $query->result();

	}

	public function registroSolicitudContratos(){

		$this->db->select('solicitud.idCliente, primerNombre, segundoNombre, apellidoPaterno, apellidoMaterno,nombreLote,rfc, razonSocial,  cliente.status, solicitud.modificado, noSolicitud, solicitud.idSolicitud, condominio.nombre as nombreCondominio, residencial.nombreResidencial');
		$this->db->join('cliente', 'cliente.idCliente = solicitud.idCliente');
		$this->db->join('lotes', 'cliente.idLote = lotes.idLote');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where('cliente.status', 1);
		$this->db->order_by('solicitud.noSolicitud', 'desc');
		$query = $this->db->get('Solicitud');
		return $query->result();

	}

	public function finalStatus(){
		/*$query = $this->db-> query('SELECT lotes.idLote, cliente.idCliente, lotes.nombreLote, lotes.idStatusContratacion, lotes.idMovimiento,
			lotes.modificado, lotes.perfil, condominio.nombre as nombreCondominio, residencial.nombreResidencial, fechaVenc, comentario,
			fechaSolicitudValidacion, gerente1.nombreGerente as gerente1, gerente2.nombreGerente as gerente2, gerente3.nombreGerente as gerente3,
			 gerente4.nombreGerente as gerente4, gerente5.nombreGerente as gerente5, asesor1.nombreAsesor as asesor, asesor2.nombreAsesor as asesor2,
			 asesor3.nombreAsesor as asesor3, asesor4.nombreAsesor as asesor4, asesor5.nombreAsesor as asesor5, lotes.firmaRL,
			 lotes.validacionEnganche
	        FROM lotes
	        inner join cliente on getReportPost45.idLote = lotes.idLote
	        INNER JOIN condominio ON lotes.idCondominio = condominio.idCondominio
            INNER JOIN residencial ON condominio.idResidencial = residencial.idResidencial
            inner join asesor on cliente.idAsesor = asesor.idAsesor
			left JOIN asesor as asesor1 ON asesor1.idAsesor = cliente.idAsesor
            left JOIN asesor as asesor2 ON asesor2.idAsesor = cliente.idAsesor2
            left JOIN asesor as asesor3 ON asesor3.idAsesor = cliente.idAsesor3
            left JOIN asesor as asesor4 ON asesor4.idAsesor = cliente.idAsesor4
            left JOIN asesor as asesor5 ON asesor5.idAsesor = cliente.idAsesor5
            INNER JOIN gerente on asesor.idGerente = gerente.idGerente
		    left JOIN gerente as gerente1 ON asesor1.idGerente = gerente1.idGerente
			left JOIN gerente as gerente2 ON asesor2.idGerente = gerente2.idGerente
            left JOIN gerente as gerente3 ON asesor3.idGerente = gerente3.idGerente
            LEFT JOIN gerente as gerente4 ON asesor4.idGerente = gerente4.idGerente
            left JOIN gerente as gerente5 ON asesor5.idGerente = gerente5.idGerente
	        where cliente.status = 1 and idStatusContratacion <> 15 and idMovimiento <> 45 group by lotes.idLote ');
		return $query->result();*/


        /*$this->db->join('clientes as cl', 'lotes.idLote=cl.idLote', 'INNER');
        $this->db->join('condominios as cond', 'lotes.idCondominio=cond.idCondominio', 'INNER');
        $this->db->join('residenciales as residencial', 'cond.idResidencial=residencial.idResidencial', 'INNER');
        $this->db->join('usuarios as us', 'cl.id_asesor=us.id_usuario', 'INNER');
        $this->db->join('usuarios as ge', 'ge.id_usuario=us.id_lider ', 'INNER');*/
		$query = $this->db-> query("SELECT lotes.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lotes.nombreLote, 
                                    lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado, CAST(lotes.comentario AS varchar(MAX)) as comentario, 
                                    fechaVenc, lotes.perfil, residencial.nombreResidencial, cond.nombre as nombreCondominio, lotes.ubicacion, lotes.tipo_venta,
                                    lotes.fechaSolicitudValidacion, lotes.firmaRL, lotes.validacionEnganche, sup, cl.fechaApartado,
                                    concat(us.nombre,' ', us.apellido_paterno, ' ', us.apellido_materno) as asesor, idAsesor,
                                    concat(ge.nombre,' ', ge.apellido_paterno, ' ', ge.apellido_materno) as gerente, lotes.referencia FROM lotes as lotes
                                    INNER JOIN clientes as cl ON lotes.idLote=cl.idLote
                                    INNER JOIN condominios as cond ON lotes.idCondominio=cond.idCondominio
                                    INNER JOIN residenciales as residencial ON cond.idResidencial=residencial.idResidencial
                                    LEFT JOIN usuarios us ON cl.id_asesor=us.id_usuario
                                    LEFT JOIN usuarios coord ON cl.id_coordinador=coord.id_usuario
                                    LEFT JOIN usuarios as ge ON cl.id_gerente=ge.id_usuario 
                                    WHERE cl.status=1 AND lotes.status = 1 AND lotes.idStatusContratacion <> 15 AND lotes.idMovimiento <> 45
                                    GROUP BY lotes.idLote, cl.id_cliente, cl.nombre, cl.apellido_materno, cl.apellido_paterno, sup, cl.fechaApartado,
                                    lotes.nombreLote, lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado,
                                    lotes.modificado, CAST(lotes.comentario AS varchar(MAX)), lotes.fechaVenc, lotes.perfil,
                                    residencial.nombreResidencial, cond.nombre, lotes.ubicacion, lotes.tipo_venta,
                                    cl.id_gerente, cl.id_coordinador, concat(us.nombre,' ', us.apellido_paterno, ' ', us.apellido_materno),
                                    concat(ge.nombre,' ', ge.apellido_paterno,' ', ge.apellido_materno), idAsesor, lotes.fechaSolicitudValidacion, lotes.firmaRL, lotes.validacionEnganche, lotes.referencia");
		return $query->result();
	}

// filtro de lotes por condominios y residencial (PARA EL INVENTARIO)

	public function getInventario($condominio,$residencial)

	{
		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo, modalidad_1, modalidad_2, referencia, statuslote.nombre, comentarioLiberacion, fechaLiberacion, condominio.nombre as nombreCondominio, residencial.nombreResidencial,
	                           gerente1.nombreGerente as gerente1, gerente2.nombreGerente as gerente2, gerente3.nombreGerente as gerente3, asesor1.nombreAsesor as asesor, asesor2.nombreAsesor as asesor2, asesor3.nombreAsesor as asesor3, cliente.fechaApartado,
    lotes.idstatuslote, gerenteLote.nombreGerente as gerenteL, gerenteLote2.nombreGerente as gerenteL2, asesorLote.nombreAsesor as asesorL, asesorLote2.nombreAsesor as asesorL2, lotes.fecha_modst, cliente.user as userApartado, lotes.userstatus as userLote, motivo_change_status');
		$this->db->join('statuslote', 'lotes.idStatusLote = statuslote.idStatusLote');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->join('cliente', 'cliente.idLote = lotes.idLote and cliente.status = 1', 'LEFT');
		$this->db->join('asesor', 'cliente.idAsesor = asesor.idAsesor', 'LEFT');
		$this->db->join('asesor as asesor1', 'asesor1.idAsesor = cliente.idAsesor', 'left');
		$this->db->join('asesor as asesor2', 'asesor2.idAsesor = cliente.idAsesor2', 'left');
		$this->db->join('asesor as asesor3', 'asesor3.idAsesor = cliente.idAsesor3', 'left');
		$this->db->join('gerente', 'asesor.idGerente = gerente.idGerente', 'LEFT');
		$this->db->join('gerente as gerente1', 'asesor1.idGerente = gerente1.idGerente', 'left');
		$this->db->join('gerente as gerente2', 'asesor2.idGerente = gerente2.idGerente', 'left');
		$this->db->join('gerente as gerente3', 'asesor3.idGerente = gerente3.idGerente', 'left');
		$this->db->join('asesor as asesorLote', 'asesorLote.idAsesor = lotes.idAsesor', 'left');
		$this->db->join('asesor as asesorLote2', 'asesorLote2.idAsesor = lotes.idAsesor2', 'left');
		$this->db->join('gerente as gerenteLote', 'asesorLote.idGerente = gerenteLote.idGerente', 'left');
		$this->db->join('gerente as gerenteLote2', 'asesorLote2.idGerente = gerenteLote2.idGerente', 'left');
		$this->db->where('lotes.idCondominio', $condominio);
		$this->db->where('lotes.status', 1);
		$this->db->group_by('lotes.idLote');
		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}

///	fin filtro de lotes por condominios y residencial	(PARA EL INVENTARIO)
// filtro de lotes por condominios y residencial (PARA EL INVENTARIO LIBERACIONES)

	public function getInventarioLiberacion($condominio,$residencial)
	{
		$this->db->select('idLote,nombreLote, sup, precio, total, porcentaje, enganche, saldo, modalidad_1, modalidad_2, referencia, statuslote.nombre, comentarioLiberacion, fechaLiberacion');
		$this->db->join('statuslote', 'lotes.idStatusLote = statuslote.idStatusLote');
		$this->db->where('idCondominio', $condominio);
		$this->db->where('lotes.status', 1);
		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;
		}

	}

	///	fin filtro de lotes por condominios y residencial	(PARA EL INVENTARIO LIBERACIONES)

	public function clienteDocumentosElite(){

		$query = $this->db-> query('SELECT idCliente, primerNombre, segundoNombre, apellidoPaterno, apellidoMaterno, corrida, expediente, nombreLote, rfc, razonSocial, condominio.nombre AS nombreCondominio, residencial.nombreResidencial, lotes.idStatusContratacion, lotes.idMovimiento
         FROM cliente INNER JOIN lotes ON cliente.idLote = lotes.idLote
         INNER JOIN condominio ON lotes.idCondominio = condominio.idCondominio INNER JOIN residencial ON condominio.idResidencial = residencial.idResidencial where cliente.status = 1
            and lotes.idStatusContratacion = "1" and lotes.idMovimiento  = "18"
            or lotes.idStatusContratacion = "1" and lotes.idMovimiento  = "31"
            or lotes.idStatusContratacion = "1" and lotes.idMovimiento  = "19"
            or lotes.idStatusContratacion = "1" and lotes.idMovimiento  = "20" ');
		return $query->result();

	}

	public function getLotesAll(){

		$this->db->select('idLote, nombreLote');
		$this->db->from('lotes');
		$this->db->where('status','1');
		$query = $this->db->get();
		return ($query->num_rows >0) ? $query->result_array(): NULL;

	}
// filtro de lote por condominios y residencial DOCUMENTACION ELITE INICIO

	public function getLotesElite($condominio,$residencial)
	{

		$this->db->select('idLote,nombreLote, idStatusLote');

		//         $this->db->where("(lotes.idStatusContratacion = 1 and lotes.idMovimiento  = 18
		//         or lotes.idStatusContratacion = 1 and lotes.idMovimiento  = 31
		//         or lotes.idStatusContratacion = 1 and lotes.idMovimiento  = 19
		//         or lotes.idStatusContratacion = 1 and lotes.idMovimiento  = 20
		//         or lotes.idStatusContratacion = 1 and lotes.idMovimiento  = 63
		//         or lotes.idStatusContratacion = 7 and lotes.idMovimiento  = 37
		// OR lotes.idStatusContratacion = 7 and lotes.idMovimiento  = 7
		// OR lotes.idStatusContratacion = 7 and lotes.idMovimiento  = 64
		// OR lotes.idStatusContratacion = 7 and lotes.idMovimiento  = 66
		// OR lotes.idStatusContratacion = 1 and lotes.idMovimiento  = 73
		// OR lotes.idStatusContratacion = 6 and lotes.idMovimiento  = 23
		// OR lotes.idStatusContratacion = 6 and lotes.idMovimiento  = 36

		// OR lotes.idStatusContratacion = 6 and lotes.idMovimiento  = 6


		//  OR lotes.idStatusContratacion = 2 and lotes.idMovimiento  = 62
		// )");

		$this->db->where('idCondominio', $condominio);
		$this->db->where('lotes.status', 1);
		$this->db->where_in('idStatusLote', array('3'));
		$query = $this->db->get('lotes');

		if($query){
			$query = $query->result_array();
			return $query;

		}

	}

///	fin filtro de lote por condominios y residencial DOCUMENTACION ELITE FIN
	// public function getDocumentosElite($lotes)
	// {
	// 	$this->db->select('idCliente, primerNombre, segundoNombre, apellidoPaterno, apellidoMaterno, corrida, expediente, rfc, razonSocial, idLote');
	// 		$this->db->where('idLote', $lotes);
	// 		$this->db->where('cliente.status', '1');
	// 	$query = $this->db->get('cliente');
	// 	if($query){
	// 		$query = $query->result_array();
	// 		return $query;
	// 	}
	// }

	public function getDocumentosElite($lotes)
	{

		$query = $this->db-> query("SELECT cliente.id_cliente, cliente.nombre, cliente.apellido_paterno, cliente.apellido_materno,
	 cliente.expediente, cliente.rfc,  cliente.idLote, lotes.nombreLote, condominio.nombre as nombreCondominio, residencial.nombreResidencial,
	CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor, 
	CONCAT(gerente.nombre,' ', gerente.apellido_paterno, '', gerente.apellido_materno) as gerente, condominio.idCondominio
	 	from clientes cliente
	 	 inner join lotes on lotes.idLote = cliente.idLote 
		 inner join condominios condominio on condominio.idCondominio = lotes.idCondominio 
		 inner join residenciales residencial on residencial.idResidencial = condominio.idResidencial 
		 INNER JOIN usuarios asesor ON asesor.id_usuario=cliente.id_asesor
		 INNER JOIN usuarios gerente ON gerente.id_usuario=asesor.id_lider  
	 	 where
	 	 cliente.status = 1 and cliente.idLote = ".$lotes." ");
		return $query->result_array();

	}

// filtro de lote por condominios y residencial DOCUMENTACION ELITE INICIO

	public function getExpedienteCliente($lotes)
	{
		$this->db->select('hd.movimiento, hd.expediente,  hd.idDocumento, hd.modificado, hd.status, 
		hd.idCliente, hd.idLote, l.nombreLote, cl.nombre as nombreCliente, cl.apellido_paterno, cl.apellido_materno, cl.rfc, c.nombre, 
		res.nombreResidencial, u.nombre as nombreAsesor, u.apellido_paterno as apellidoPa, l.idMovimiento, hd.tipo_doc, c.idCondominio,
		u.apellido_materno as apellidoMa, s.nombre as ubic ');

		$this->db->join('lotes l', 'l.idLote = hd.idLote');
		$this->db->join('clientes cl', 'hd.idCliente = cl.id_cliente');
		$this->db->join('condominios c', 'c.idCondominio = l.idCondominio');
		$this->db->join('residenciales res', 'res.idResidencial = c.idResidencial');
		$this->db->join('usuarios u', 'hd.idUser = u.id_usuario');
		$this->db->join('sedes s', 'u.id_sede= s.id_sede');

		$this->db->where('hd.status', 1);
		$this->db->where('hd.idLote', $lotes);
		$query = $this->db->get('historial_documento hd');
		return $query->result();
		/*$query = $this->db-> query('SELECT historial_documento.expediente, historial_documento.idDocumento, historial_documento.modificado, historial_documento.status, historial_documento.idCliente, historial_documento.idLote, lotes.nombreLote, cliente.primerNombre, cliente.segundoNombre, cliente.apellidoPaterno, cliente.apellidoMaterno, cliente.rfc, cliente.razonSocial, condominio.nombre, residencial.nombreResidencial, users.primerNombre as primerNom, users.segundoNombre as segundoNom, users.apellidoPaterno as apellidoPa, users.apellidoMaterno as apellidoMa, users.ubicacion as ubic FROM historial_documento
		 inner join lotes on lotes.idLote = historial_documento.idLote inner join cliente on historial_documento.idCliente = cliente.idCliente inner join condominio on condominio.idCondominio = lotes.idCondominio inner
		 join residencial on residencial.idResidencial = condominio.idResidencial inner join users on historial_documento.idUser = users.id where historial_documento.status = 1 and historial_documento.idLote = "'.$lotes.'"
		 ');
	   return $query->result_array();*/

	}

///	fin filtro de lote por condominios y residencial DOCUMENTACION ELITE FIN
// filtro de lote por condominios y residencial DOCUMENTACION CONTRALORIA INICIO

	public function getLotesDocContraloria($condominio,$residencial) {

		$this->db->select('idLote,nombreLote, idStatusLote');
		//     $this->db->where("(lotes.idStatusContratacion = 4 and lotes.idMovimiento  = 34
		// or lotes.idStatusContratacion = 2 and lotes.idMovimiento  = 4
		// or lotes.idStatusContratacion = 4 and lotes.idMovimiento  = 22
		// or lotes.idStatusContratacion = 5 and lotes.idMovimiento  = 35
		// or lotes.idStatusContratacion = 5 and lotes.idMovimiento  = 22 )");
		$this->db->where('idCondominio', $condominio);
		$this->db->where('lotes.status', 1);
		$this->db->where_in('idStatusLote', array('3'));
		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;
		}

	}

///	fin filtro de lote por condominios y residencial DOCUMENTACION CONTRALORIA FIN

	public function insert_historial_documento($dato){
		$this->db->insert('historial_documento',$dato);
		return true;

	}

	public function deletePago($id, $dato) {

		$dato = array(
			'status' => '0'
		);
		$this->db->where("idEnganche", $id);
		$this->db->update('historial_enganche', $dato);
		return true;

	}

	public function getLotesPagos($condominio,$residencial)
	{

		$this->db->select('idLote,nombreLote, idStatusLote');
		$this->db->where('idCondominio', $condominio);
		$this->db->where('lotes.status', 1);
		$this->db->where_in('idStatusLote', array('3', '2'));
		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;
		}

	}

	// 	public function getPagosCliente($lotes) {
	//  $query = $this->db-> query('SELECT idEnganche, historial_enganche.noRecibo, historial_enganche.engancheCliente, historial_enganche.fechaEnganche, lotes.nombreLote, historial_enganche.user,
	//  	tipopago.tipo, cliente.primerNombre, cliente.segundoNombre, cliente.apellidoPaterno, cliente.apellidoMaterno from historial_enganche, lotes, tipopago, cliente where historial_enganche.idLote = lotes.idLote and historial_enganche.idTipoPago = tipopago.idTipoPago
	//  	     and historial_enganche.idCliente = cliente.idCliente and historial_enganche.status = 1 and historial_enganche.idLote = "'.$lotes.'" ');
	// return $query->result_array();
	// 		}

	public function getPagosCliente($lotes) {

		$query = $this->db-> query('SELECT idEnganche, historial_enganche.noRecibo, historial_enganche.engancheCliente,
 		historial_enganche.fechaEnganche, lotes.nombreLote, historial_enganche.user,

	 	tipopago.tipo, cliente.primerNombre, cliente.segundoNombre, cliente.apellidoPaterno, 
	 	cliente.apellidoMaterno, cliente.razonSocial, historial_enganche.concepto 
	 	from historial_enganche 
	 	inner join lotes on historial_enganche.idLote = lotes.idLote 
	 	inner join tipopago on historial_enganche.idTipoPago = tipopago.idTipoPago 
	 	inner join cliente on historial_enganche.idCliente = cliente.idCliente 
	 	where historial_enganche.status = 1 and cliente.status = 1 and historial_enganche.idLote = "'.$lotes.'" ');
		return $query->result_array();

	}

	public function cancelaPago($id,$dato){

		$this->db->where("idEnganche",$id);
		$this->db->update('historial_enganche',$dato);
		return true;

	}

	public function selectPago($id){

		$this->db->where("idEnganche",$id);
		$query= $this->db->get("historial_enganche");
		return $query->row();

	}

	public function getPagosCanceladosCliente($lotes) {

		$query = $this->db-> query('SELECT idEnganche, historial_enganche.noRecibo, historial_enganche.engancheCliente, historial_enganche.fechaCancelacion, lotes.nombreLote, historial_enganche.user,
                                    tipopago.tipo, cliente.primerNombre, cliente.segundoNombre, cliente.apellidoPaterno, cliente.apellidoMaterno, historial_enganche.comentarioCancelacion, historial_enganche.concepto, cliente.razonSocial 
                                    from historial_enganche inner join lotes on historial_enganche.idLote = lotes.idLote 
                                    inner join tipopago on historial_enganche.idTipoPago = tipopago.idTipoPago 
                                    inner join cliente on historial_enganche.idCliente = cliente.idCliente where historial_enganche.status = 0 AND cliente.status = 1 and historial_enganche.idLote = "'.$lotes.'" ');
		return $query->result_array();

	}

// filtro de lote por condominios y residencial DOCUMENTACION ELITE INICIO

	public function getLotesGral($condominio,$residencial)
	{
		$this->db->select('idLote,nombreLote, idStatusLote');
		
		
		
		if(in_array($this->session->userdata('id_usuario'), array("2765", "2776", "2857", "2820", "2876"))){
		   $this->db->where("(lotes.asig_jur = ".$this->session->userdata('id_usuario').")");
		}
		
		$this->db->where('lotes.status', 1);
		$this->db->where('idCondominio', $condominio);
		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;
		}
	}

//	fin filtro de lote por condominios y residencial DOCUMENTACION ELITE FIN

	public function insertHistorialLotes($dato){

		$this->db->insert('historial_lotes',$dato);
		return true;

	}

	public function registroStatus10($b,$dato2){

		$this->db->where("numContrato",$b);
		$this->db->update('lotes',$dato2);
		return true;
	}


	public function insertControlContrato($dato3){
		$this->db->insert('controlcontrato',$dato3);
		return true;
	}

	public function datosControlContratos () {
		/*
		 SELECT idControl, nombreLote, cliente.primerNombre, cliente.segundoNombre,
			cliente.apellidoPaterno, cliente.apellidoMaterno,
			cliente.razonSocial, controlcontrato.numContrato, fechaRecepcion, fechaFirma, lotes.idLote
			FROM controlcontrato inner join lotes on lotes.numContrato = controlcontrato.numContrato
			inner join cliente on cliente.idCliente = lotes.idCliente where cliente.status = 1 and controlcontrato.status = 1
		 */
		$query = $this->db-> query('SELECT cc.idControl, l.nombreLote, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
			cl.rfc, cc.numContrato, cc.fechaRecepcion, cc.fechaFirma, l.idLote
			FROM controlcontrato cc
			INNER JOIN lotes l ON l.numContrato = cc.numContrato
			INNER JOIN clientes cl ON cl.id_cliente=l.idCliente
			WHERE cl.status=1 AND cc.status=1;');
		return $query->result();
	}


	public function updateContratosFirmados($b,$dato3){

		$this->db->where("numContrato",$b);
		$this->db->update('controlcontrato',$dato3);
		return true;

	}

	public function selectRegistroPorContrato($numContrato){

		$this->db->select("cl.id_cliente, l.nombreLote, l.idLote, l.usuario, l.perfil, l.fechaVenc, l.idCondominio,
		l.modificado, l.fechaSolicitudValidacion, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
		cl.rfc, l.contratoUrgente, CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor, 
		CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente, l.observacionContratoUrgente,
		l.fechaRL, l.idStatusContratacion, l.idMovimiento");
		$this->db->join('clientes cl', 'cl.idLote = l.idLote');
		$this->db->join('usuarios asesor', 'cl.id_asesor=asesor.id_usuario');
		$this->db->join('usuarios gerente', 'asesor.id_lider=gerente.id_usuario');
		$this->db->where("l.numContrato",$numContrato);
		$this->db->where("(cl.status=1 AND l.idStatusContratacion=9 AND l.idMovimiento=39)");
		$this->db->where('l.status', 1);
		$query = $this->db->get('lotes l');
		return $query->row();

	}


	public function editaLoteStatus12PorNumContrato($b,$arreglo){

		$this->db->select('cliente.idCliente, cliente.status, lotes.nombreLote, lotes.idLote, lotes.idStatusContratacion, lotes.idMovimiento, lotes.numContrato');
		$this->db->join('cliente', 'cliente.idLote = lotes.idLote');
		$this->db->where("numContrato",$b);
		// $this->db->where("cliente.status", 1);
		//            $this->db->where("(lotes.idStatusContratacion = '11' and lotes.idMovimiento  = '41'
		//  OR lotes.idStatusContratacion = '10' and lotes.idMovimiento  = '40'
		//  OR lotes.idStatusContratacion = '7' and lotes.idMovimiento  = '66'
		//  OR lotes.idStatusContratacion = '8' and lotes.idMovimiento  = '67'
		// )");
		$this->db->update('lotes',$arreglo);
		return true;

	}

	public function insertHistorialLotesContraloria($dato){

		$this->db->insert('historial_lotes',$dato);
		return true;

	}

	public function lots () {
		$query = $this->db-> query('SELECT lotes.idLote, lotes.nombreLote, condominio.nombre, residencial.nombreResidencial  FROM lotes 
                                    inner join cliente on cliente.idLote = lotes.idLote 
                                    inner join condominio on condominio.idCondominio = lotes.idCondominio 
                                    inner join residencial on condominio.idResidencial = residencial.idResidencial');
		return $query->result();
	}

	public function contratin($id){

		$this->db->select('cliente.idCliente, cliente.primerNombre, cliente.segundoNombre,
			cliente.apellidoPaterno, cliente.apellidoMaterno, cliente.correo, lotes.nombreLote, lotes.idLote, lotes.idCondominio, condominio.nombre, lotes.sup, cliente.calle, cliente.numero, cliente.colonia, cliente.estado, cliente.municipio, lotes.precio, lotes.total, residencial.nombreResidencial');
		$this->db->join('cliente', 'cliente.idLote = lotes.idLote');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where("lotes.idLote",$id);
		$this->db->where('lotes.status', 1);
		$query = $this->db->get('lotes');
		return $query->row();

	}

	public function corridaContraloria(){

		$query = $this->db-> query("SELECT cliente.id_cliente, cliente.nombre, condominio.idCondominio, lotes.idLote,
        apellido_paterno, apellido_materno, expediente, nombreLote, rfc, condominio.nombre as nombreCondominio, residencial.nombreResidencial
         FROM clientes cliente INNER JOIN lotes ON cliente.idLote = lotes.idLote 
        inner join condominios condominio on condominio.idCondominio = lotes.idCondominio 
        inner join residenciales residencial on condominio.idResidencial = residencial.idResidencial
            where  
            lotes.idStatusContratacion = '5' and lotes.idMovimiento  = '35' AND cliente.status = 1
            or lotes.idStatusContratacion = '5' and lotes.idMovimiento  = '22' AND cliente.status = 1 
            or lotes.idStatusContratacion = '2' and lotes.idMovimiento  = '62' AND cliente.status = 1
            or lotes.idStatusContratacion = '5' and lotes.idMovimiento  = '75' AND cliente.status = 1");
		return $query->result();

	}

// filtro de lote por condominios y residencial CONTRATO VENTAS INICIO
	public function getContratoCliente($lotes)

	{

		/*$query = $this->db->query('SELECT lotes.contratoArchivo, lotes.idLote, lotes.status, lotes.idCliente,
		cliente.idLote, lotes.nombreLote, cliente.primerNombre, cliente.segundoNombre, cliente.apellidoPaterno,
		cliente.apellidoMaterno, cliente.rfc, cliente.razonSocial, condominio.nombre, residencial.nombreResidencial,
		cliente.status FROM lotes

	 	 inner join cliente on cliente.idLote = lotes.idLote inner join condominio on condominio.idCondominio = lotes.idCondominio inner join residencial on residencial.idResidencial = condominio.idResidencial where cliente.status = 1 and lotes.idLote = "' . $lotes . '"

	 	 ');
		return $query->result_array();*/
		$this->db->select('l.contratoArchivo, l.idLote, l.status, l.idCliente, cl.idLote, 
		l.nombreLote, cl.nombre as nombre_cliente, cl.apellido_paterno, cl.apellido_materno, 
		cl.rfc, c.nombre, res.nombreResidencial, cl.status');

		//inner join cliente on cliente.idLote = lotes.idLote
		// inner join condominio on condominio.idCondominio = lotes.idCondominio
		// inner join residencial on residencial.idResidencial = condominio.idResidencial
		// where cliente.status = 1 and lotes.idLote = "' . $lotes . '"
		$this->db->join('clientes cl', 'cl.idLote = l.idLote');
		$this->db->join('condominios c', 'c.idCondominio = l.idCondominio');
		$this->db->join('residenciales res', 'res.idResidencial = c.idResidencial');
		$this->db->where("cl.status",1);
		$this->db->where("l.idLote",$lotes);
		$query= $this->db->get("lotes l");

		return $query->result();
	}

///	fin filtro de lote por condominios y residencial CONTRATO VENTAS FIN

	public function selectdocs($id){
		// $this->db->select('lotes.idLote, lotes.nombreLote, cliente.idCliente');
		$this->db->join('lotes', 'cliente.idLote = lotes.idLote');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where("cliente.idCliente",$id);
		$query= $this->db->get("cliente");
		return $query->row();

	}

	// public function report(){

		

	// 	$this->db->select("idHistorialLote, hd.nombreLote, hd.idStatusContratacion,
	//    hd.idMovimiento, hd.modificado, hd.fechaVenc, lotes.idLote,
	//    CAST(lotes.comentario AS varchar(MAX)) as comentario, hd.status, lotes.totalNeto, totalValidado, lotes.totalNeto2,
	//    concat(us.nombre,' ', us.apellido_paterno,' ', us.apellido_paterno) as asesor,  
	//    concat(ge.nombre,' ', ge.apellido_paterno,' ', ge.apellido_paterno) as gerente");
	// 	$this->db->join('clientes cl', 'hd.idCliente = cl.id_cliente', 'INNER');
	// 	$this->db->join('lotes lotes', 'hd.idLote = lotes.idLote', 'INNER');
	// 	$this->db->join('condominios cond', 'cond.idCondominio = lotes.idCondominio', 'INNER');
	// 	$this->db->join('residenciales res', 'cond.idResidencial = res.idResidencial', 'INNER');
	// 	$this->db->join('usuarios us', 'cl.id_asesor = us.id_usuario', 'INNER');
	// 	$this->db->join('usuarios ge', 'ge.id_usuario = cl.id_gerente', 'LEFT');
	// 	$this->db->where("hd.idStatusContratacion",9);
	// 	$this->db->where("hd.idMovimiento",39);
	// 	$this->db->where("hd.status",1);
	// 	if($this->session->userdata('id_rol') == 2){
	// 		$this->db->where("ge.id_lider",$this->session->userdata('id_usuario'));	
	// 	}
	// 	// $this->db->order_by('cliente.idCliente', 'desc');
	// 	$query = $this->db->get('historial_lotes hd');
	// 	return $query->result();

	// }

	public function report($typeTransaction, $beginDate, $endDate, $where){
		if ($typeTransaction == 1 || $typeTransaction == 3) {
            $filter = " AND hd.modificado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
        }

		if($this->session->userdata('id_rol') == 2){	
			$lider = "AND ge.id_lider = ".$this->session->userdata('id_usuario');
		}

		$query = $this->db->query("SELECT idHistorialLote, hd.nombreLote, hd.idStatusContratacion, hd.idMovimiento, hd.modificado, hd.fechaVenc, lotes.idLote, 
		CAST(lotes.comentario AS varchar(MAX)) as comentario, hd.status, lotes.totalNeto, totalValidado, lotes.totalNeto2, 
		concat(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_paterno) as asesor, concat(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_paterno) as gerente 
		FROM historial_lotes hd
		INNER JOIN clientes cl ON hd.idCliente = cl.id_cliente 
		INNER JOIN lotes lotes ON hd.idLote = lotes.idLote
		INNER JOIN condominios cond ON cond.idCondominio = lotes.idCondominio 
		INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial 
		INNER JOIN usuarios us ON cl.id_asesor = us.id_usuario 
		LEFT JOIN usuarios ge ON ge.id_usuario = cl.id_gerente
		WHERE hd.idStatusContratacion = 9 AND hd.idMovimiento = 39 AND hd.status = 1 $lider ".$filter);
		
		return $query;
	}

	public function registroClienteDS(){

		$this->db->select('cliente.idCliente, primerNombre, segundoNombre, apellidoPaterno, apellidoMaterno, nombreLote, fechaApartado, fechaVencimiento, cliente.rfc, razonSocial, 
			noRecibo, noAcuse, nombreResidencial, condominio.nombre as nombreCondominio, cliente.status, cliente.idAsesor, condominio.idCondominio, lotes.idLote, cliente.autorizacion, cliente.fechaApartado');
		$this->db->join('lotes', 'cliente.idLote = lotes.idLote');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->join('deposito_seriedad', 'deposito_seriedad.idCliente = cliente.idcliente');
		$this->db->where('cliente.status', 1);
		// $this->db->where("cliente.fechaApartado>",'2020-04-01');
		$this->db->where("(cliente.idAsesor = '".$this->session->userdata('idAsesor')."' 
			OR cliente.idAsesor2 = '".$this->session->userdata('idAsesor')."' OR cliente.idAsesor3 = '".$this->session->userdata('idAsesor')."')");
		$this->db->where("(idStatusContratacion = 1 AND idMovimiento = 31 
					OR idStatusContratacion = 2 AND idMovimiento = 85 
					OR idStatusContratacion = 1 and idMovimiento = 20
					OR idStatusContratacion = 1 and idMovimiento = 63
					OR idStatusContratacion = 1 and idMovimiento = 73 )");
		$this->db->order_by('cliente.idCliente', 'desc');
		$query = $this->db->get('cliente');
		return $query->result();

	}



	public function selectDS($id){
		$query = $this->db-> query("SELECT cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, cl.rfc, cl.fecha_nacimiento, cl.telefono1, cl.telefono2, cl.domicilio_particular,
		cl.correo, l.nombreLote, l.idLote, res.nombreResidencial, cond.nombre as nombreCondominio, l.sup, l.precio, cl.nombre_conyuge, ds.id, ds.clave, ds.desarrollo,
		ds.tipoLote, ds.idOficial_pf, ds.idDomicilio_pf, ds.actaMatrimonio_pf, ds.actaConstitutiva_pm, ds.poder_pm, ds.idOficialApoderado_pm, ds.idDomicilio_pm,
		cl.rfc as rfcDS, cl.nombre, cl.nacionalidad, cl.originario, cl.estado_civil, cl.regimen_matrimonial, cl.ocupacion, cl.empresa, cl.puesto, cl.antiguedad, 
		cl.edadFirma, cl.domicilio_empresa, cl.telefono_empresa, l.sup, ds.noRefPago, costoM2, proyecto, ds.municipio as municipioDS, importOferta, letraImport, 
		cantidad, letraCantidad, saldoDeposito, aportMensualOfer, fecha1erAport, plazo, fechaLiquidaDepo, fecha2daAport, municipio2, dia, mes, anio, nombreFirmaAsesor, 
		observacion, email2,ds.fechaCrate, ds.id_cliente, ds.clave, l.referencia, costom2f, costoM2_casas
		FROM clientes cl
		INNER JOIN lotes l ON cl.idLote = l.idLote
		INNER JOIN condominios cond ON l.idCondominio = cond.idCondominio
		INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		INNER JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios gerente ON asesor.id_lider = gerente.id_usuario
		INNER JOIN deposito_seriedad ds ON cl.id_cliente = ds.id_cliente
		WHERE cl.id_cliente =".$id);
		return $query->row();
		/*$this->db->select('cliente.idCliente, primerNombre, segundoNombre, apellidoPaterno, apellidoMaterno, cliente.rfc, razonSocial,
        	cliente.fechaNacimiento, telefono1, telefono2, calle, numero, colonia, cliente.municipio, estado, cliente.correo, referencia1, telreferencia1,
			referencia2, telreferencia2, nombreLote, lotes.nombreLote, lotes.idLote, nombreResidencial, condominio.nombre as nombreCondominio, lotes.sup, 
			lotes.precio, deposito_seriedad.nombreConyuge, id, clave, desarrollo,camp_desarrollo, tipoLote, idOficial_pf, idDomicilio_pf, 
			actaMatrimonio_pf, actaConstitutiva_pm, poder_pm, idOficialApoderado_pm, idDomicilio_pm, deposito_seriedad.rfc as rfcDS, nombre, 
			nacionalidad, originario, estadoCivil, nombreConyuge, regimen, ocupacion, empresaLabora, puesto, antigueda, edadFirma, domicilioEmpresa, 
			ladaTelEmpresa, telefonoEmp, casa, noLote, cluster, super, noRefPago, costoM2, proyecto, deposito_seriedad.municipio as municipioDS, 
			importOferta, letraImport, cantidad, letraCantidad, saldoDeposito, aportMensualOfer, fecha1erAport, plazo, fechaLiquidaDepo, fecha2daAport,
			municipio2, dia, mes, año, nombreFirOfertante, observacion, parentescoReferen, parentescoReferen2, nombreFirmaAsesor, email2, nombreFirmaAutoriza, 
			precioFianza, montoFianza, preMenlSegVida, montoSegVida, acepto, acepto2, fechaCrate, deposito_seriedad.idCliente, deposito_seriedad.clave,
			lotes.referencia, deposito_seriedad.domicilio_particular, costom2f,
			deposito_seriedad.espectacular,
			deposito_seriedad.volante,
			deposito_seriedad.radio,
			deposito_seriedad.periodico,
			deposito_seriedad.revista,
			deposito_seriedad.redes,
			deposito_seriedad.punto,
			deposito_seriedad.invitacion,
			deposito_seriedad.emailing,
			deposito_seriedad.pagina,
			deposito_seriedad.recomendacion,
			deposito_seriedad.convenio,
			deposito_seriedad.marketing,
			deposito_seriedad.otro1,
			deposito_seriedad.especificar,
			deposito_seriedad.pase,
			deposito_seriedad.modulo,
			deposito_seriedad.paseevento,
			deposito_seriedad.pasedesarrollo,
			deposito_seriedad.call,
			deposito_seriedad.pasedirecto,
			deposito_seriedad.casaCheck,
			deposito_seriedad.oficina,
			deposito_seriedad.whatsapp,
			deposito_seriedad.email,
			deposito_seriedad.otro2,		
			gerente1.nombreGerente as gerente1, gerente2.nombreGerente as gerente2, gerente3.nombreGerente as gerente3, gerente4.nombreGerente as gerente4, gerente5.nombreGerente as gerente5, asesor1.nombreAsesor as asesor, asesor2.nombreAsesor as asesor2, asesor3.nombreAsesor as asesor3, asesor4.nombreAsesor as asesor4, asesor5.nombreAsesor as asesor5');
		$this->db->join('lotes', 'cliente.idLote = lotes.idLote');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->join('asesor', 'cliente.idAsesor = asesor.idAsesor');
		$this->db->join('asesor as asesor1', 'asesor1.idAsesor = cliente.idAsesor', 'left');
		$this->db->join('asesor as asesor2', 'asesor2.idAsesor = cliente.idAsesor2', 'left');
		$this->db->join('asesor as asesor3', 'asesor3.idAsesor = cliente.idAsesor3', 'left');
		$this->db->join('asesor as asesor4', 'asesor4.idAsesor = cliente.idAsesor4', 'left');
		$this->db->join('asesor as asesor5', 'asesor5.idAsesor = cliente.idAsesor5', 'left');
		$this->db->join('gerente', 'asesor.idGerente = gerente.idGerente');
		$this->db->join('gerente as gerente1', 'asesor1.idGerente = gerente1.idGerente', 'left');
		$this->db->join('gerente as gerente2', 'asesor2.idGerente = gerente2.idGerente', 'left');
		$this->db->join('gerente as gerente3', 'asesor3.idGerente = gerente3.idGerente', 'left');
		$this->db->join('gerente as gerente4', 'asesor4.idGerente = gerente4.idGerente', 'left');
		$this->db->join('gerente as gerente5', 'asesor5.idGerente = gerente5.idGerente', 'left');
		$this->db->join('deposito_seriedad', 'cliente.idCliente = deposito_seriedad.idCliente');
		$this->db->where("cliente.idCliente",$id);
		$query= $this->db->get("cliente");
		return $query->row();*/

	}


	public function selectLoteCorrida($id){

		$this->db->select('lotes.idLote, lotes.id_descuento, lotes.nombreLote, lotes.sup, lotes.precio, lotes.total, lotes.porcentaje, lotes.enganche, lotes.descSup1, lotes.descSup2, condominio.msni');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->join('descuentosfin', 'lotes.id_descuento = descuentosfin.id_descuento');
		$this->db->where("lotes.idLote",$id);
		$query = $this->db->get('lotes');
		return $query->row();

	}

	public function getDesc(){

		$this->db->select('id_descuento, motivo, porcentaje, status');
		$this->db->from('descuentos');
		$this->db->where('status','1');
		$query = $this->db->get();
		return $query->result_array();

	}

	public function registroDesc($idLote){

		$query = $this->db-> query('SELECT GROUP_CONCAT(id_descuento) as descArray FROM lotes where idlote = "'.$idLote.'" ');
		foreach ($query->result_array() as $row)
		{
		}
		$row['descArray'];
		$query2 = $this->db-> query('SELECT 
         descuentosfin.id_descuento as idDescFin, 
         descuentosfin.idDescuentoAd as idDescFinAd, 
         descuentosfin.idDescuentopp as idDescFinPp,
         descuentosfin.idDescuentoAd2 as idDescFinAd2,
          descuentosadicionales.idDescuentoAd as idDescuentoAd,
          descuentosadicionales.porcentaje as descuentoAd,
          descuentosadicionales.motivo as motivoDescuentoAd,  
          descuentosadicionales.aplica as aplicaDescuentoAd,
          descuentospp.idDescuentopp as idDescuentopp, 
          descuentospp.descuento as descuentopp, 
          descuentospp.motivo as motivoDescuentoPp, 
          descuentospp.aplica as aplicaDescuentoPp, 
          da2.idDescuentoAd as idDescuentoAd2, 
          da2.porcentaje as descuentoAd2, 
          da2.motivo as motivoDescuentoAd2, 
          da2.aplica as aplicaDescuentoAd2, 
          descuentosfin.nombreDescuento
          from descuentosfin 
          LEFT join descuentosadicionales on descuentosfin.idDescuentoAd = descuentosadicionales.idDescuentoAd
          LEFT join descuentospp on descuentosfin.idDescuentoPP = descuentospp.idDescuentoPP
          LEFT join descuentosadicionales da2 on descuentosfin.idDescuentoAd2 = da2.idDescuentoAd
          where id_descuento IN ('.$row['descArray'].')
          AND descuentosfin.status = 1');
		return $query2->result();

	}




	public function arrayDescad(){

		$this->db->select('idDescuentoAd, motivo, porcentaje');
		$this->db->from('descuentosadicionales');
		$this->db->where('descuentosadicionales.status', 1);
		$query = $this->db->get();
		return $query->result_array();

	}

	public function arrayDescpp(){
		$this->db->select('idDescuentopp, motivo, descuento');
		$this->db->from('descuentospp');
		$this->db->where('descuentospp.status', 1);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function arrayPackDesc(){

	    $this->db->select('id_descuento, descuentosadicionales.motivo as mAdicional, descuentospp.motivo as mProntop, descuentosadicionales.porcentaje as descad, descuentospp.descuento as descpp, descuentosfin.nombreDescuento, descAd2.motivo as mAdicional2, descAd2.porcentaje as descad2');
		$this->db->from('descuentosfin');
		$this->db->join('descuentosadicionales', 'descuentosadicionales.idDescuentoAd = descuentosfin.idDescuentoAd', 'left');
		$this->db->join('descuentosadicionales as descAd2', 'descAd2.idDescuentoAd = descuentosfin.idDescuentoAd2', 'left');
		$this->db->join('descuentospp', 'descuentospp.idDescuentoPP = descuentosfin.idDescuentoPP', 'left');
		$this->db->where('descuentosfin.status', 1);
		$query = $this->db->get();
		return $query->result();

	}

	public function tblDescpp(){

	    $this->db->select('idDescuentopp, motivo, descuento');
		$this->db->from('descuentospp');
		$this->db->where('status', 1);
		$query = $this->db->get();
		return $query->result();

	}

	public function tblDescps(){
		$this->db->select('idDescuentoSup, motivo, desc1_1, desc1_2, desc2_1, desc2_2, supIni, supFin, bonoOpcion1, bonoOpcion2, bonoOpcion3, preciomc, options');
		$this->db->from('descuentosup');
		$this->db->where('status', 1);
		$query = $this->db->get();
		return $query->result();
	}

	public function arrayDesc(){
		$this->db->select('id_descuento, residencial, cluster, motivo, motivo_otro, porcentaje, sup1, sup2, fecha_inicio, fecha_fin, residencial');
		$this->db->from('descuentosmensuales');
		$this->db->where('descuentosmensuales.status', 1);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function editaDesc($id,$dato){
		$this->db->where("id_descuento",$id);
		$this->db->update('descuentosmensuales',$dato);
		return true;
	}

	public function tblDescAd(){
		$this->db->select('idDescuentoAd, motivo, porcentaje');
		$this->db->from('descuentosadicionales');
		$this->db->where('status', 1);
		$query = $this->db->get();
		return $query->result();

	}

	public function getCondominioDesc($residencial){

		$this->db->select('idCondominio, nombre, residencial.nombreResidencial');
		$this->db->from('condominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where('condominio.status','1');
		$this->db->order_by('nombre','asc');
		$this->db->where_in('condominio.idResidencial', $residencial, FALSE);
		$query = $this->db->get();
		return $query->result_array();

	}

	public function selectDesc($id){
		$this->db->where("id_descuento",$id);
		$query = $this->db->get('descuentosmensuales');
		return $query->row();
	}


	public function eliminaDesc($id_descuento){
		$dato = array(
			'status' => '0'
		);
		$this->db->where("id_descuento",$id_descuento);
		$this->db->update('descuentosmensuales', $dato);
		return true;
	}

	public function getLotesVentasAut($condominio,$residencial)
	{
		$this->db->select('idLote,nombreLote, idStatusLote');
		// $this->db->where("(lotes.idStatusContratacion = 8 and lotes.idMovimiento  = 38)");
		$this->db->where('idCondominio', $condominio);
		$this->db->where('lotes.status', 1);
		$this->db->where_in('idStatusLote', array('3'));
		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;
		}
	}

	public function reportContratados($typeTransaction, $beginDate, $endDate, $where){
        if ($typeTransaction == 1 || $typeTransaction == 3) {  // FIRST LOAD || SEARCH BY DATE RANGE
            $filter = " AND hl.fechaVenc BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
            $filterTwo = "";
        }

		/*$this->db->select('idHistorialLote, historial_lotes.nombreLote, historial_lotes.idStatusContratacion,
	        	historial_lotes.idMovimiento, historial_lotes.modificado, historial_lotes.fechaVenc, historial_lotes.comentario, historial_lotes.status, gerente1.nombreGerente as gerente1, gerente2.nombreGerente as gerente2, gerente3.nombreGerente as gerente3, gerente4.nombreGerente as gerente4, gerente5.nombreGerente as gerente5, asesor1.nombreAsesor as asesor, asesor2.nombreAsesor as asesor2, asesor3.nombreAsesor as asesor3, asesor4.nombreAsesor as asesor4, asesor5.nombreAsesor as asesor5, lotes.totalNeto, totalValidado');
		$this->db->join('cliente', 'historial_lotes.idCliente = cliente.idCliente');
		$this->db->join('lotes', 'historial_lotes.idLote = lotes.idLote');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->join('asesor', 'cliente.idAsesor = asesor.idAsesor');
		$this->db->join('asesor as asesor1', 'asesor1.idAsesor = cliente.idAsesor', 'left');
		$this->db->join('asesor as asesor2', 'asesor2.idAsesor = cliente.idAsesor2', 'left');
		$this->db->join('asesor as asesor3', 'asesor3.idAsesor = cliente.idAsesor3', 'left');
		$this->db->join('asesor as asesor4', 'asesor4.idAsesor = cliente.idAsesor4', 'left');
		$this->db->join('asesor as asesor5', 'asesor5.idAsesor = cliente.idAsesor5', 'left');
		$this->db->join('gerente', 'asesor.idGerente = gerente.idGerente');
		$this->db->join('gerente as gerente1', 'asesor1.idGerente = gerente1.idGerente', 'left');
		$this->db->join('gerente as gerente2', 'asesor2.idGerente = gerente2.idGerente', 'left');
		$this->db->join('gerente as gerente3', 'asesor3.idGerente = gerente3.idGerente', 'left');
		$this->db->join('gerente as gerente4', 'asesor4.idGerente = gerente4.idGerente', 'left');
		$this->db->join('gerente as gerente5', 'asesor5.idGerente = gerente5.idGerente', 'left');
		$this->db->where("historial_lotes.idStatusContratacion",15);
		$this->db->where("historial_lotes.idMovimiento",45);
		$this->db->where("historial_lotes.status",1);
		$query = $this->db->get('historial_lotes');*/
		return $this->db-> query("SELECT hl.idHistorialLote, hl.nombreLote, hl.idStatusContratacion, hl.idMovimiento, hl.modificado,
        hl.fechaVenc, hl.comentario, hl.status, l.totalNeto, l.totalValidado,
        CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
        CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente
        FROM
        historial_lotes hl 
        JOIN clientes cl ON hl.idCliente=cl.id_cliente
        JOIN lotes l ON hl.idLote=l.idLote
        JOIN condominios cond ON cond.idCondominio=l.idCondominio
        JOIN residenciales res ON cond.idResidencial=res.idResidencial
        JOIN usuarios asesor ON cl.id_asesor=asesor.id_usuario
        JOIN usuarios gerente ON gerente.id_usuario=asesor.id_lider
        WHERE hl.idStatusContratacion=15 AND hl.idMovimiento=45 AND hl.status=1 ".$filter);
		//return $query->result();

	}

// filtro de lote por condominios y residencial DOCUMENTACION ELITE INICIO

	public function getExp($lotes)
	{
/*SELECT historial_documento.expediente, historial_documento.idDocumento,
		historial_documento.modificado, historial_documento.status, historial_documento.idCliente,
		historial_documento.idLote, lotes.nombreLote, cliente.primerNombre, cliente.segundoNombre,
		cliente.apellidoPaterno, cliente.apellidoMaterno, cliente.rfc, cliente.razonSocial,
		 condominio.nombre, residencial.nombreResidencial, users.primerNombre as primerNom,
		 users.segundoNombre as segundoNom, users.apellidoPaterno as apellidoPa, users.apellidoMaterno as apellidoMa,
		 users.ubicacion as ubic FROM historial_documento

	 	 inner join lotes on lotes.idLote = historial_documento.idLote inner join cliente on historial_documento.idCliente = cliente.idCliente inner join condominio on condominio.idCondominio = lotes.idCondominio inner

	 	 join residencial on residencial.idResidencial = condominio.idResidencial inner join users on historial_documento.idUser = users.id where historial_documento.status = 1 and historial_documento.idLote = "'.$lotes.'"

	 	 */
		$query = $this->db-> query("SELECT historial_documento.expediente, historial_documento.idDocumento, 
	   historial_documento.modificado, historial_documento.status, historial_documento.idCliente, 
	   historial_documento.idLote, lotes.nombreLote, cliente.nombre, 
	   cliente.apellido_paterno, cliente.apellido_materno, cliente.rfc,
	   condominio.nombre, residencial.nombreResidencial, users.nombre as primerNom, 
	   users.apellido_paterno as apellidoPa, users.apellido_materno as apellidoMa, 
	   users.id_sede as ubic 
	   FROM historial_documento
		inner join lotes on lotes.idLote = historial_documento.idLote 
		inner join clientes cliente on historial_documento.idCliente = cliente.id_cliente 
		inner join condominios condominio on condominio.idCondominio = lotes.idCondominio 
		inner join residenciales residencial on residencial.idResidencial = condominio.idResidencial 
		inner join usuarios users on historial_documento.idUser = users.id_usuario 
		where historial_documento.status = 1 and historial_documento.idLote = '".$lotes."'");
		return $query->result();

	}

///	fin filtro de lote por condominios y residencial DOCUMENTACION ELITE FIN

	public function sendMailApartadosOld15(){

		$this->db->join('lotes', 'cliente.idLote = lotes.idLote');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where('fechaApartado BETWEEN concat(DATE_SUB(CURDATE(),INTERVAL 14 DAY), " 00:00:00") AND concat(DATE_SUB(CURDATE(),INTERVAL 14 DAY), " 23:59:59")');
		$this->db->where("lotes.idStatusContratacion",1);
		$this->db->where("lotes.idMovimiento",31);
		$query = $this->db->get('cliente');
		return $query->result();

	}

	public function sendMailApartadosOld7(){

		$this->db->join('lotes', 'cliente.idLote = lotes.idLote');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where('fechaApartado BETWEEN concat(DATE_SUB(CURDATE(),INTERVAL 6 DAY), " 00:00:00") AND concat(DATE_SUB(CURDATE(),INTERVAL 6 DAY), " 23:59:59")');
		$this->db->where("lotes.idStatusContratacion",1);
		$this->db->where("lotes.idMovimiento",31);
		$query = $this->db->get('cliente');
		return $query->result();

	}

	public function queryLotes(){
		$this->db->select('idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo, modalidad_1, modalidad_2, referencia, lotes.status, statuslote.nombre, condominio.nombre as nombreCondominio, residencial.nombreResidencial');
		$this->db->join('statuslote', 'lotes.idStatusLote = statuslote.idStatusLote');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where("lotes.idStatusLote", 1);
		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result();
			return $query;
		}
	}

	public function getDescuentosAdicionales($idDescuentoAd){
		$this->db->select('idDescuentoAd, motivo, porcentaje, aplica');
		$this->db->from('descuentosadicionales');
		// $this->db->where('condominio.status','1');
		$this->db->where("idDescuentoAd",$idDescuentoAd);
		$query = $this->db->get();
		return $query->row();
	}

	public function getDescuentosPP($idDescuentopp){
		$this->db->select('idDescuentopp, motivo, descuento, aplica');
		$this->db->from('descuentospp');
		// $this->db->where('condominio.status','1');
		$this->db->where("idDescuentopp",$idDescuentopp);
		$query = $this->db->get();
		return $query->row();
	}

	public function sendMailVentasRetrasos(){
		$this->db->select('residencial.nombreResidencial, condominio.nombre as nombreCondominio, lotes.nombreLote, cliente.fechaApartado, cliente.primerNombre, cliente.segundoNombre, cliente.apellidoPaterno, cliente.apellidoMaterno, cliente.razonSocial, gerente.nombreGerente, asesor.nombreAsesor');
		$this->db->join('lotes', 'cliente.idLote = lotes.idLote');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->join('asesor', 'cliente.idAsesor = asesor.idAsesor');
		$this->db->join('gerente', 'asesor.idGerente = gerente.idGerente');
		$this->db->where("lotes.idStatusContratacion",1);
		$this->db->where("lotes.idMovimiento",31);
		$this->db->where("cliente.status",1);
		$this->db->order_by('cliente.fechaApartado', 'asc');
		$query = $this->db->get('cliente');
		return $query->result();
	}



	public function lotesContratados(){

		$query = $this->db->query("SELECT lotes.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lotes.nombreLote, 
		lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado, CAST(lotes.comentario AS varchar(MAX)) as comentario, 
		lotes.fechaVenc, lotes.perfil, residencial.nombreResidencial, cond.nombre as nombreCondominio, lotes.ubicacion, lotes.tipo_venta,
		lotes.fechaSolicitudValidacion, lotes.firmaRL, lotes.validacionEnganche, cl.fechaApartado,
		concat(us.nombre,' ', us.apellido_paterno, ' ', us.apellido_materno) as asesor, idAsesor,
		concat(ge.nombre,' ', ge.apellido_paterno, ' ', ge.apellido_materno) as gerente, lotes.totalNeto2, lotes.referencia,
		UPPER(CASE CONCAT(u.nombre,' ', u.apellido_paterno, ' ', u.apellido_materno) WHEN '' THEN hd.usuario ELSE 
		CONCAT(u.nombre,' ', u.apellido_paterno, ' ', u.apellido_materno) END) nombreUsuario
		FROM lotes as lotes
		INNER JOIN clientes as cl ON lotes.idLote=cl.idLote AND cl.status=1
		INNER JOIN condominios as cond ON lotes.idCondominio=cond.idCondominio
		INNER JOIN residenciales as residencial ON cond.idResidencial=residencial.idResidencial
		LEFT JOIN usuarios us ON cl.id_asesor=us.id_usuario
		LEFT JOIN usuarios coord ON cl.id_coordinador=coord.id_usuario
		LEFT JOIN usuarios as ge ON cl.id_gerente=ge.id_usuario 
		INNER JOIN (SELECT MAX(modificado) modificado, idStatusContratacion, idMovimiento, idLote, status, usuario FROM historial_lotes
		WHERE idStatusContratacion = 15 AND idMovimiento = 45 
		GROUP BY idStatusContratacion, idMovimiento, idLote, status, usuario) hd ON hd.idLote = lotes.idLote AND hd.idStatusContratacion = 15 AND hd.idMovimiento = 45 AND hd.status = 1
		LEFT JOIN usuarios u ON CAST(u.id_usuario AS VARCHAR(45)) = CAST(hd.usuario AS VARCHAR(45))
		WHERE lotes.status = 1 AND lotes.idStatusContratacion = 15 AND lotes.idMovimiento = 45
		GROUP BY lotes.idLote, cl.id_cliente, cl.nombre, cl.apellido_materno, cl.apellido_paterno,
		lotes.nombreLote, lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado,
		lotes.modificado, CAST(lotes.comentario AS varchar(MAX)), lotes.fechaVenc, lotes.perfil,
		residencial.nombreResidencial, cond.nombre, lotes.ubicacion, lotes.tipo_venta,
		cl.id_gerente, cl.id_coordinador, concat(us.nombre,' ', us.apellido_paterno, ' ', us.apellido_materno),
		concat(ge.nombre,' ', ge.apellido_paterno,' ', ge.apellido_materno), idAsesor, lotes.fechaSolicitudValidacion, lotes.firmaRL,
		lotes.validacionEnganche, cl.fechaApartado, lotes.totalNeto2, lotes.referencia, CONCAT(u.nombre,' ', u.apellido_paterno, ' ', u.apellido_materno), hd.usuario");
		return $query->result();
	}

	public function reportLotesPost45(){
		/*$query = $this->db-> query('SELECT lotes.idLote, cliente.idCliente, cliente.fechaApartado, lotes.nombreLote,
		lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado, lotes.perfil, condominio.nombre as nombreCondominio,
		residencial.nombreResidencial, fechaVenc, comentario, fechaSolicitudValidacion, gerente1.nombreGerente as gerente1,
		gerente2.nombreGerente as gerente2, gerente3.nombreGerente as gerente3, gerente4.nombreGerente as gerente4,
		gerente5.nombreGerente as gerente5, asesor1.nombreAsesor as asesor, asesor2.nombreAsesor as asesor2,
		asesor3.nombreAsesor as asesor3, asesor4.nombreAsesor as asesor4, asesor5.nombreAsesor as asesor5
	        FROM lotes
	        inner join cliente on cliente.idLote = lotes.idLote
	        INNER JOIN condominio ON lotes.idCondominio = condominio.idCondominio
            INNER JOIN residencial ON condominio.idResidencial = residencial.idResidencial
            inner join asesor on cliente.idAsesor = asesor.idAsesor
			left JOIN asesor as asesor1 ON asesor1.idAsesor = cliente.idAsesor
            left JOIN asesor as asesor2 ON asesor2.idAsesor = cliente.idAsesor2
            left JOIN asesor as asesor3 ON asesor3.idAsesor = cliente.idAsesor3
            left JOIN asesor as asesor4 ON asesor4.idAsesor = cliente.idAsesor4
            left JOIN asesor as asesor5 ON asesor5.idAsesor = cliente.idAsesor5
            INNER JOIN gerente on asesor.idGerente = gerente.idGerente
		    left JOIN gerente as gerente1 ON asesor1.idGerente = gerente1.idGerente
			left JOIN gerente as gerente2 ON asesor2.idGerente = gerente2.idGerente
            left JOIN gerente as gerente3 ON asesor3.idGerente = gerente3.idGerente
            LEFT JOIN gerente as gerente4 ON asesor4.idGerente = gerente4.idGerente
            left JOIN gerente as gerente5 ON asesor5.idGerente = gerente5.idGerente
    where lotes.idStatusContratacion <> "15" and lotes.idMovimiento <> "45" and cliente.status = 1
            group by lotes.idLote ');
		return $query->result();*/
        /*
        $this->db->join('usuarios as us', 'cl.id_asesor=us.id_usuario', 'INNER');
        $this->db->join('usuarios as ge', 'ge.id_usuario=us.id_lider ', 'INNER');*/
		$this->db->select(" lotes.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lotes.nombreLote, 
		lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado, CAST(lotes.comentario AS varchar(MAX)) as comentario, 
		fechaVenc, lotes.perfil, residencial.nombreResidencial, cond.nombre as nombreCondominio, lotes.ubicacion, lotes.tipo_venta,
		lotes.fechaSolicitudValidacion, lotes.firmaRL, lotes.validacionEnganche, cl.fechaApartado,
		concat(us.nombre,' ', us.apellido_paterno, ' ', us.apellido_materno) as asesor, idAsesor,
		concat(ge.nombre,' ', ge.apellido_paterno, ' ', ge.apellido_materno) as gerente, lotes.referencia");


		$this->db->join('clientes as cl', 'lotes.idLote=cl.idLote', 'INNER');
		$this->db->join('condominios as cond', 'lotes.idCondominio=cond.idCondominio', 'INNER');
		$this->db->join('residenciales as residencial', 'cond.idResidencial=residencial.idResidencial', 'INNER');
		

        $this->db->join('usuarios us', 'cl.id_asesor=us.id_usuario', 'LEFT');
        $this->db->join('usuarios coord', 'cl.id_coordinador=coord.id_usuario', 'LEFT');
        $this->db->join('usuarios as ge', 'cl.id_gerente=ge.id_usuario ', 'LEFT');

		$this->db->where('cl.status=1 AND lotes.idStatusContratacion <> 15 AND lotes.idMovimiento <> 45 AND cl.status=1');

		$query  = $this->db->group_by("lotes.idLote, cl.id_cliente, cl.nombre, cl.apellido_materno, cl.apellido_paterno,
			lotes.nombreLote, lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado,
			lotes.modificado, CAST(lotes.comentario AS varchar(MAX)), lotes.fechaVenc, lotes.perfil,
			residencial.nombreResidencial, cond.nombre, lotes.ubicacion, lotes.tipo_venta,
 			cl.id_gerente, cl.id_coordinador, concat(us.nombre,' ', us.apellido_paterno, ' ', us.apellido_materno),
 			concat(ge.nombre,' ', ge.apellido_paterno,' ', ge.apellido_materno), idAsesor, lotes.fechaSolicitudValidacion, lotes.firmaRL,
 			lotes.validacionEnganche, cl.fechaApartado, lotes.referencia");
		$query = $this->db->get('lotes as lotes');
		return $query->result();
	}

	public function getInventarioAllAd()
	{
		$this->db->select('idLote,nombreLote, condominios.msni, sup, precio, total, porcentaje, enganche, saldo, modalidad_1, modalidad_2, referencia, statuslote.nombre, comentarioLiberacion, fechaLiberacion, condominios.nombre as nombreCondominio, residenciales.nombreResidencial');
		$this->db->join('statuslote', 'lotes.idStatusLote = statuslote.idStatusLote');
		$this->db->join('condominios', 'lotes.idCondominio = condominios.idCondominio');
		$this->db->join('residenciales', 'condominios.idResidencial = residenciales.idResidencial');
		$this->db->where_in('lotes.idStatusLote', array('1', '102'));
		$this->db->where("lotes.status",1);
		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;
		}
	}

	public function getInventarioAd($condominio,$residencial)
	{
		$this->db->select('idLote,nombreLote, c.msni, sup, precio, total, porcentaje, enganche, saldo, modalidad_1,
		 modalidad_2, referencia, s.nombre, comentarioLiberacion, fechaLiberacion, c.nombre as nombreCondominio, 
		 res.nombreResidencial');
		$this->db->join('statuslote s', 'l.idStatusLote = s.idStatusLote');
		$this->db->join('condominios c', 'l.idCondominio = c.idCondominio');
		$this->db->join('residenciales res', 'c.idResidencial = res.idResidencial');
		$this->db->where('l.idCondominio', $condominio);
		$this->db->where_in('l.idStatusLote', array('1', '102'));
		$this->db->where("l.status",1);
		$query = $this->db->get('lotes l');
		if($query){
			$query = $query->result_array();
			return $query;
		}
	}

	public function descSup($dato){
		$this->db->trans_begin();
		$this->db->insert('descuentosup',$dato);
		if ($this->db->trans_status() === FALSE) {
		$this->db->trans_rollback();
		}
		else {
			$this->db->trans_commit();
		}
		return true;
	}

	public function getInventarioDis($condominio,$residencial)

	{
		$this->db->select('idLote,nombreLote, sup, precio, total, porcentaje, enganche, saldo, modalidad_1, modalidad_2, referencia, statuslote.nombre, comentarioLiberacion, fechaLiberacion, condominio.nombre as nombreCondominio, residencial.nombreResidencial');

		$this->db->join('statuslote', 'lotes.idStatusLote = statuslote.idStatusLote');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where('lotes.idCondominio', $condominio);

		$this->db->where('lotes.status', 1);
		$this->db->where('lotes.idStatusLote', 1);


		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}






	public function getStatusLotecaja() {

		$query = $this->db-> query('SELECT idStatusLote,nombre FROM statuslote  WHERE idStatusLote IN (9, 8, 7, 3, 10) ');
		return $query->result();

	}



	public function table_condominio(){
		$this->db->select('condominio.idCondominio, residencial.nombreResidencial, condominio.nombre as nombreCluster, etapa.descripcion, datosbancarios.empresa, tipo_lote');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');

		$this->db->join('etapa', 'condominio.idEtapa = etapa.idEtapa', 'LEFT');
		$this->db->join('datosbancarios', 'condominio.idDBanco = datosbancarios.idDBanco', 'LEFT');

		$this->db->where('condominio.status', 1);
		$query= $this->db->get("condominio");
		return $query->result();

	}





	public function uploadData($idCondominio)
	{
		$count=0;
		$fp = fopen($_FILES['userfile']['tmp_name'],'r') or die("can't open file");
		while($csv_line = fgetcsv($fp,1024))
		{
			$count++;
			if($count == 1)
			{
				continue;
			}
			for($i = 0, $j = count($csv_line); $i < $j; $i++)
			{
				$insert_csv = array();
				$insert_csv['nombreLote'] = $csv_line[0];
				$insert_csv['sup'] = $csv_line[1];
				$insert_csv['precio'] = $csv_line[2];
				$insert_csv['porcentaje'] = $csv_line[3];
				$insert_csv['idStatusLote'] = $csv_line[4];

			}
			$i++;
			$data = array(
				'nombreLote' => $insert_csv['nombreLote'] ,
				'sup' => $insert_csv['sup'],
				'precio' => $insert_csv['precio'],
				'total' => ($insert_csv['sup'] *  $insert_csv['precio']),
				'porcentaje' => $insert_csv['porcentaje'],
				'enganche' => (($insert_csv['sup'] *  $insert_csv['precio'])* 0.1),
				'saldo' => (($insert_csv['sup'] *  $insert_csv['precio']) - (($insert_csv['sup'] *  $insert_csv['precio'])* 0.1)),
				'idCondominio' => $idCondominio,
				'idStatusContratacion' => 0,


				// 'idStatusLote' => ($insert_csv['idStatusLote'] === 'DISPONIBLE') ? 1 : 12,

			);

			if ($insert_csv['idStatusLote'] == 'DISPONIBLE') {
				$data['idStatusLote'] = 1;
			} else if ($insert_csv['idStatusLote'] == 'APARTADO') {
				$data['idStatusLote'] = 3;
			} else if ($insert_csv['idStatusLote'] == 'ENGANCHE') {
				$data['idStatusLote'] = 4;
			} else if ($insert_csv['idStatusLote'] == 'INTERCAMBIO') {
				$data['idStatusLote'] = 6;
			} else if ($insert_csv['idStatusLote'] == 'DIRECCION') {
				$data['idStatusLote'] = 7;
			} else if ($insert_csv['idStatusLote'] == 'BLOQUEO' || $insert_csv['idStatusLote'] == 'BLOQUEADO') {
				$data['idStatusLote'] = 8;
			} else {
				$data['idStatusLote'] = 8;
			}


// var_dump($data);
			$data['crane_features']=$this->db->insert('lotes', $data);

		}
		fclose($fp) or die("can't close file");
		$data['success']="success";
		// return $data;
		$countData = $count-1;
		?>

		<title>Ciudad Maderas | Sistema de Contrataci???</title>
		<link rel="shortcut icon" href="<?=base_url()?>static/images/arbol_cm.png" />
		<script src="<?=base_url()?>dist/bower_components/jquery/dist/jquery.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>

		<script type="text/javascript">
			$.confirm({
				title: '???nformacion!',
				content: 'Lotes insertados:' + ' ' + <?php echo $countData;?>,
				type: 'green',
				typeAnimated: true,
				buttons: {
					tryAgain: {
						text: 'Ok',
						btnClass: 'btn-green',
						action: function(){
							document.location.href = '<?=base_url()?>index.php/registroLote/uploadCluster/'
						}
					},
					close: function () {
					}
				}
			});

		</script>
		<?php


	}




	public function table_asesor(){

		return $this->db->query("SELECT u.estatus, u.id_sede, u.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, u.correo, u.rfc, u.telefono, u.usuario,
								CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) lider FROM usuarios u INNER JOIN usuarios uu ON uu.id_usuario = u.id_lider WHERE u.id_rol IN (7, 9)");

		/*$query = $this->db->query("SELECT u.estatus, u.id_sede, u.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor, u.correo, u.rfc, u.telefono, u.usuario,
								CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) lider FROM usuarios u INNER JOIN usuarios uu ON uu.id_usuario = u.id_lider WHERE u.id_rol IN (7, 9)");
		return $query->result();*/
	}


	public function insert_asesor($dato){
		$this->db->insert('usuarios',$dato);
		return true;
	}

	public function changeStatusUser($id, $data) {
		$this->db->where('id_usuario', $id);
		return $this->db->update('usuarios', $data);
	}



	public function changeStatusUserAsesor($id, $data) {
		$this->db->where('id_usuario', $id);
		return $this->db->update('usuarios', $data);
	}




	public function corridaContraloria2(){

		$query = $this->db-> query('SELECT cliente.idCliente, primerNombre, segundoNombre,
apellidoPaterno, apellidoMaterno, razonSocial, expediente, nombreLote, rfc, condominio.nombre, residencial.nombreResidencial
 FROM cliente INNER JOIN lotes ON cliente.idLote = lotes.idLote 
inner join condominio on condominio.idCondominio = lotes.idCondominio inner join residencial on condominio.idResidencial = residencial.idResidencial
	where cliente.status = 1
     ');
		return $query->result();
	}







	public function getStatusLoteDis() {

		$query = $this->db-> query('SELECT idStatusLote,nombre FROM statuslote  WHERE idStatusLote IN (1, 9, 8, 7, 3, 10) ');

		return $query->result();
	}



	public function getStatusLoteDisEditaLote() {

		$query = $this->db-> query('SELECT idStatusLote,nombre FROM statuslote  WHERE idStatusLote IN (1, 9, 8, 7, 10) ');
		return $query->result();

	}




	public function getDataAsesor($idAsesor) {

		$this->db->select('us.id_usuario, us.nombre, us.apellido_paterno, 
		us.apellido_materno, us.contrasena, us.estatus, us.correo, us.telefono, us.rfc, us.tiene_hijos');
		$this->db->where('us.id_usuario', $idAsesor);
		$query= $this->db->get("usuarios us");
		return $query->row();
	}


	public function updateAsesor($idAsesor, $data){

		$this->db->where("id_usuario",$idAsesor);
		$this->db->update('usuarios', $data);
		return true;
	}



	public function updateAsesorUser($idAsesor, $arregloUser){

		$this->db->where("id_usuario",$idAsesor);
		$this->db->update('usuarios', $arregloUser);
		return true;
	}


	public function getDescSup($lote) {


		$query2 = $this->db-> query('SELECT descSup1 FROM lotes where idlote = "'.$lote.'" ');

		foreach ($query2->result_array() as $row)
		{
		}
		$row['descSup1'];

		$this->db->select('desc1_1, desc1_2, desc2_1, desc2_2, bonoOpcion1, bonoOpcion2, bonoOpcion3');
		$this->db->where('idDescuentoSup', $row['descSup1']);
		$this->db->where_in('status', array('1'));
		$query = $this->db->get('descuentosup');
		if($query){
			$query = $query->result_array();
			return $query;
		}
	}




	public function updateDescPackSup($cluster, $pack){

		$queryLotes = $this->db->query('SELECT idLote, sup, descSup1, idCondominio FROM lotes where idCondominio IN ('.$cluster.') ');

		foreach ($queryLotes->result_array() as $lote)
		{
			$query = $this->db-> query('SELECT idDescuentoSup, supIni as descArraySup1, supFin as descArraySup2 from descuentosup where idDescuentoSup IN ('.$pack.')' );

			foreach ($query->result_array() as $row)
			{
				$this->db->query('UPDATE lotes SET descSup1 = '.$row['idDescuentoSup'].' where sup BETWEEN '.$row['descArraySup1'].' and '.$row['descArraySup2'].' and idCondominio IN ('.$lote['idCondominio'].') ');

			}
		}

		return true;

	}




	public function insertProntoPago($dato){
		$this->db->insert('descuentospp',$dato);
		return true;
	}



	public function insertDescFin($dato){
		$this->db->insert('descuentosfin',$dato);
		return true;
	}



	public function descuentosActuales($cluster){


		$queryLotes = $this->db->query('SELECT idLote, idCondominio, id_descuento FROM lotes where idCondominio IN ('.$cluster.') ');
		foreach ($queryLotes->result_array() as $lote)
		{
		}
		$query = $this->db-> query('SELECT id_descuento from descuentosfin where id_descuento IN ('.$lote['id_descuento'].') and status = 1');

		if($query){
			$query = $query->result_array();
			return $query;
		}
	}


	public function updateDescPack($cluster, $res){

		$this->db->where_in("idCondominio", $cluster, FALSE);
		$this->db->update('lotes', array( "id_descuento" => $res));
		return true;

	}


	public function getEtapa($residencial){

		$this->db->select('etapa.idEtapa, etapa.descripcion');
		$this->db->from('etapas');
		$this->db->join('condominio', 'condominio.idEtapa = etapa.idEtapa');
		$this->db->where('condominio.status','1');
		$this->db->order_by('etapa.descripcion','asc');
		$this->db->where_in('condominio.idResidencial', $residencial, FALSE);
		$this->db->group_by('etapa.idEtapa');

		$query = $this->db->get();
		return $query->result_array();
	}



	public function getCondominioEtapa($etapa){

		$this->db->select('condominio.idCondominio, condominio.nombre');
		$this->db->from('condominio');
		$this->db->where('condominio.status','1');
		$this->db->where_in('condominio.idEtapa', $etapa, FALSE);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function editaRegistroClienteDS($idCliente,$arreglo, $arreglo2){
		$this->db->where("id_cliente",$idCliente);
		$this->db->update('clientes',$arreglo);
		$this->db->where("id_cliente",$idCliente);
		$this->db->update('deposito_seriedad',$arreglo2);
		return true;
	}






	public function infoBloqueos($idLote){

		$this->db->select('lotes.idLote as idLoteL, condominio.idCondominio, residencial.idResidencial, lotes.nombreLote, residencial.nombreResidencial, condominio.nombre as nombreCondominio');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where("lotes.idLote",$idLote);
		$query = $this->db->get('lotes');
		return $query->row();
	}




	public function insert_bloqueos($data){
		$this->db->insert('historial_bloqueo',$data);
		return true;
	}



	public function getBloqueos(){
		$query = array();
		$queryBloqueados = $this->db->query('SELECT idLote as idLotes from historial_bloqueo where historial_bloqueo.status = 1 ');
		foreach ($queryBloqueados->result_array() as $bloqueosAll)
		{
			$query[] = $this->db-> query('SELECT idLote, idStatusLote FROM lotes where idLote IN ('.$bloqueosAll['idLotes'].')')->result_array();

		}

		return $query;

	}



	public function updateStatusBloqueo($data){

		$this->db->where_in("idLote", $data, FALSE);
		$this->db->update('historial_bloqueo', array( "status" => 0));
		return true;

	}


	public function sendMailBloqueosDireccion(){

		$this->db->select('lotes.idLote, condominios.idCondominio, residenciales.idResidencial, lotes.nombreLote, residenciales.nombreResidencial, condominios.nombre as nombreCondominio, historial_bloqueo.create_at');
		$this->db->join('lotes', 'lotes.idLote = historial_bloqueo.idLote');
		$this->db->join('condominios', 'lotes.idCondominio = condominios.idCondominio');
		$this->db->join('residenciales', 'condominios.idResidencial = residenciales.idResidencial');
		$this->db->where("historial_bloqueo.status", '1');
		$query = $this->db->get('historial_bloqueo');
		return $query->result();


	}




	public function getClienteChangeAsesor($condominio) {

		$this->db->select('lotes.idLote,nombreLote, condominio.nombre as nombreCondominio, residencial.nombreResidencial,cliente.primerNombre, cliente.segundoNombre, cliente.apellidoPaterno, cliente.apellidoMaterno, cliente.razonSocial,
	gerente1.nombreGerente as gerente1, gerente2.nombreGerente as gerente2, gerente3.nombreGerente as gerente3, gerente4.nombreGerente as gerente4, gerente5.nombreGerente as gerente5, asesor1.nombreAsesor as asesor, asesor2.nombreAsesor as asesor2, asesor3.nombreAsesor as asesor3, asesor4.nombreAsesor as asesor4, asesor5.nombreAsesor as asesor5,
	asesor.idAsesor as idAsesor1, asesor2.idAsesor as idAsesor2,
	gerente1.idGerente as idGerente1');

		$this->db->join('cliente', 'cliente.idLote = lotes.idLote');

		$this->db->join('asesor', 'cliente.idAsesor = asesor.idAsesor');

		$this->db->join('asesor as asesor1', 'asesor1.idAsesor = cliente.idAsesor', 'left');
		$this->db->join('asesor as asesor2', 'asesor2.idAsesor = cliente.idAsesor2', 'left');
		$this->db->join('asesor as asesor3', 'asesor3.idAsesor = cliente.idAsesor3', 'left');
		$this->db->join('asesor as asesor4', 'asesor4.idAsesor = cliente.idAsesor4', 'left');
		$this->db->join('asesor as asesor5', 'asesor5.idAsesor = cliente.idAsesor5', 'left');

		$this->db->join('gerente', 'asesor.idGerente = gerente.idGerente');

		$this->db->join('gerente as gerente1', 'asesor1.idGerente = gerente1.idGerente', 'left');
		$this->db->join('gerente as gerente2', 'asesor2.idGerente = gerente2.idGerente', 'left');
		$this->db->join('gerente as gerente3', 'asesor3.idGerente = gerente3.idGerente', 'left');
		$this->db->join('gerente as gerente4', 'asesor4.idGerente = gerente4.idGerente', 'left');
		$this->db->join('gerente as gerente5', 'asesor5.idGerente = gerente5.idGerente', 'left');

		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where('lotes.idCondominio', $condominio);

		$query = $this->db->get('lotes');
		return $query->result_array();

	}




	public function updateChangeAsesor($idLote, $idAsesor, $asesor){

		$dato = array(
			$asesor => $idAsesor
		);

		$this->db->where("idLote",$idLote);
		$this->db->update('cliente', $dato);
		return true;
	}






	public function getStatus15($condominio) {

		$this->db->select('idLote,nombreLote, idStatusContratacion, idMovimiento, condominio.nombre as nombreCondominio, residencial.nombreResidencial');

		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where('lotes.idCondominio', $condominio);
		$this->db->where("lotes.idStatusContratacion", '15');
		$this->db->where("lotes.idMovimiento", '45');

		$query = $this->db->get('lotes');
		return $query->result_array();

	}


	public function selectRegistroPorContratoStatus12($numContrato){


		$this->db->select("cl.id_cliente, l.nombreLote, l.idLote, l.usuario, l.perfil, l.fechaVenc, l.idCondominio, l.modificado, l.fechaSolicitudValidacion, l.fechaRecepcionContrato,
cl.nombre, cl.apellido_paterno, cl.apellido_materno, cl.rfc, l.contratoUrgente, CONCAT(asesor.nombre,' ', asesor.apellido_paterno,' ', asesor.apellido_materno) as nombreAsesor,
concat(gerente.nombre,' ', gerente.apellido_paterno,' ', gerente.apellido_materno) as nombreGerente, l.observacionContratoUrgente,
l.fechaRL, l.idStatusContratacion, l.idMovimiento, l.firmaRL, cl.status, l.validacionEnganche");
		$this->db->join('clientes cl', 'cl.idLote = l.idLote ');
		$this->db->join('usuarios asesor', 'cl.id_asesor = asesor.id_usuario');
		$this->db->join('usuarios gerente', 'asesor.id_lider = gerente.id_usuario');

		$this->db->where("l.numContrato",$numContrato);


		$this->db->where("(l.idStatusContratacion=11 AND l.idMovimiento=41 AND l.firmaRL='NULL' OR l.firmaRL IS NULL
			OR l.idStatusContratacion=10 AND l.idMovimiento=40 AND l.firmaRL='NULL' OR l.firmaRL IS NULL)");



		$query = $this->db->get('lotes l');
		return $query->row();

	}




	public function insertUserAsesor($dato){
		$this->db->insert('usuarios',$dato);
		return true;
	}



	public function getUserAsesor($user) {
		$query = $this->db-> query("SELECT * FROM usuarios where usuario = '".$user."'");
		return $query->num_rows();

	}













	public function descmc($dato){

		$this->db->trans_begin();

		$this->db->insert('descuentosup',$dato);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		}
		else {
			$this->db->trans_commit();
		}
		return true;

	}



	public function updateDescPackMC($cluster, $pack){

		$queryLotes = $this->db->query('SELECT idLote, precio, sup, descSup1, idCondominio FROM lotes where idCondominio IN ('.$cluster.') ');

		foreach ($queryLotes->result_array() as $lote)
		{
			$query = $this->db-> query('SELECT idDescuentoSup, options, preciomc as tpreciomc from descuentosup where idDescuentoSup IN ('.$pack.')' );

			foreach ($query->result_array() as $row)
			{
				if($row['options'] == 1){

					$this->db->query('UPDATE lotes SET descSup1 = '.$row['idDescuentoSup'].' where precio <= '.$row['tpreciomc'].' and idCondominio IN ('.$lote['idCondominio'].') ');
				} else if($row['options'] == 0){

					$this->db->query('UPDATE lotes SET descSup1 = '.$row['idDescuentoSup'].' where precio >= '.$row['tpreciomc'].' and idCondominio IN ('.$lote['idCondominio'].') ');

				}

			}
		}

		return true;

	}




	public function insertDescAd($dato){
		$this->db->insert('descuentosadicionales',$dato);
		return true;
	}



// filtro de lotes por proyecto
	public function getInventarioXproyecto($residencial){

		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo, modalidad_1, modalidad_2, referencia, statuslote.nombre, comentarioLiberacion, fechaLiberacion, condominio.nombre as nombreCondominio, residencial.nombreResidencial,
gerente1.nombreGerente as gerente1, gerente2.nombreGerente as gerente2, gerente3.nombreGerente as gerente3, asesor1.nombreAsesor as asesor, asesor2.nombreAsesor as asesor2, asesor3.nombreAsesor as asesor3, cliente.fechaApartado,

lotes.idstatuslote, gerenteLote.nombreGerente as gerenteL, gerenteLote2.nombreGerente as gerenteL2, asesorLote.nombreAsesor as asesorL, asesorLote2.nombreAsesor as asesorL2, lotes.fecha_modst, cliente.user as userApartado, lotes.userstatus as userLote, motivo_change_status


');

		$this->db->join('statuslote', 'lotes.idStatusLote = statuslote.idStatusLote');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');

		$this->db->join('cliente', 'cliente.idLote = lotes.idLote and cliente.status = 1', 'LEFT');
		$this->db->join('asesor', 'cliente.idAsesor = asesor.idAsesor', 'LEFT');
		$this->db->join('asesor as asesor1', 'asesor1.idAsesor = cliente.idAsesor', 'left');
		$this->db->join('asesor as asesor2', 'asesor2.idAsesor = cliente.idAsesor2', 'left');
		$this->db->join('asesor as asesor3', 'asesor3.idAsesor = cliente.idAsesor3', 'left');
		$this->db->join('gerente', 'asesor.idGerente = gerente.idGerente', 'LEFT');
		$this->db->join('gerente as gerente1', 'asesor1.idGerente = gerente1.idGerente', 'left');
		$this->db->join('gerente as gerente2', 'asesor2.idGerente = gerente2.idGerente', 'left');
		$this->db->join('gerente as gerente3', 'asesor3.idGerente = gerente3.idGerente', 'left');


		$this->db->join('asesor as asesorLote', 'asesorLote.idAsesor = lotes.idAsesor', 'left');
		$this->db->join('asesor as asesorLote2', 'asesorLote2.idAsesor = lotes.idAsesor2', 'left');
		$this->db->join('gerente as gerenteLote', 'asesorLote.idGerente = gerenteLote.idGerente', 'left');
		$this->db->join('gerente as gerenteLote2', 'asesorLote2.idGerente = gerenteLote2.idGerente', 'left');

		$this->db->where('residencial.idResidencial', $residencial);
		$this->db->where('lotes.status', 1);
		$this->db->group_by('lotes.idLote');

		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}
// Fin de filtro de lotes por proyecto

// filtro de lotes por proyecto todos
	public function getInventarioXproyectoTodosStatus($status){

		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo, modalidad_1, modalidad_2, referencia, statuslote.nombre, comentarioLiberacion, fechaLiberacion, condominio.nombre as nombreCondominio, residencial.nombreResidencial,
	gerente1.nombreGerente as gerente1, gerente2.nombreGerente as gerente2, gerente3.nombreGerente as gerente3, asesor1.nombreAsesor as asesor, asesor2.nombreAsesor as asesor2, asesor3.nombreAsesor as asesor3, cliente.fechaApartado,
	
    lotes.idstatuslote, gerenteLote.nombreGerente as gerenteL, gerenteLote2.nombreGerente as gerenteL2, asesorLote.nombreAsesor as asesorL, asesorLote2.nombreAsesor as asesorL2, lotes.fecha_modst, cliente.user as userApartado, lotes.userstatus as userLote, motivo_change_status

	');

		$this->db->join('statuslote', 'lotes.idStatusLote = statuslote.idStatusLote');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');

		$this->db->join('cliente', 'cliente.idLote = lotes.idLote and cliente.status = 1', 'LEFT');
		$this->db->join('asesor', 'cliente.idAsesor = asesor.idAsesor', 'LEFT');
		$this->db->join('asesor as asesor1', 'asesor1.idAsesor = cliente.idAsesor', 'left');
		$this->db->join('asesor as asesor2', 'asesor2.idAsesor = cliente.idAsesor2', 'left');
		$this->db->join('asesor as asesor3', 'asesor3.idAsesor = cliente.idAsesor3', 'left');
		$this->db->join('gerente', 'asesor.idGerente = gerente.idGerente', 'LEFT');
		$this->db->join('gerente as gerente1', 'asesor1.idGerente = gerente1.idGerente', 'left');
		$this->db->join('gerente as gerente2', 'asesor2.idGerente = gerente2.idGerente', 'left');
		$this->db->join('gerente as gerente3', 'asesor3.idGerente = gerente3.idGerente', 'left');

		$this->db->join('asesor as asesorLote', 'asesorLote.idAsesor = lotes.idAsesor', 'left');
		$this->db->join('asesor as asesorLote2', 'asesorLote2.idAsesor = lotes.idAsesor2', 'left');
		$this->db->join('gerente as gerenteLote', 'asesorLote.idGerente = gerenteLote.idGerente', 'left');
		$this->db->join('gerente as gerenteLote2', 'asesorLote2.idGerente = gerenteLote2.idGerente', 'left');


		$this->db->where('lotes.status', 1);
		$this->db->where('lotes.idStatusLote', $status);
		$this->db->group_by('lotes.idLote');

		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}
// Fin de filtro de lotes por proyecto

// filtro de lotes por proyecto todos
	public function getInventarioXproyectoCondominioStatus($residencial,$condominio,$status){

		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo, modalidad_1, modalidad_2, referencia, statuslote.nombre, comentarioLiberacion, fechaLiberacion, condominio.nombre as nombreCondominio, residencial.nombreResidencial,
	gerente1.nombreGerente as gerente1, gerente2.nombreGerente as gerente2, gerente3.nombreGerente as gerente3, asesor1.nombreAsesor as asesor, asesor2.nombreAsesor as asesor2, asesor3.nombreAsesor as asesor3, cliente.fechaApartado,
	
    lotes.idstatuslote, gerenteLote.nombreGerente as gerenteL, gerenteLote2.nombreGerente as gerenteL2, asesorLote.nombreAsesor as asesorL, asesorLote2.nombreAsesor as asesorL2, lotes.fecha_modst, cliente.user as userApartado, lotes.userstatus as userLote, motivo_change_status

	');

		$this->db->join('statuslote', 'lotes.idStatusLote = statuslote.idStatusLote');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');

		$this->db->join('cliente', 'cliente.idLote = lotes.idLote and cliente.status = 1', 'LEFT');
		$this->db->join('asesor', 'cliente.idAsesor = asesor.idAsesor', 'LEFT');
		$this->db->join('asesor as asesor1', 'asesor1.idAsesor = cliente.idAsesor', 'left');
		$this->db->join('asesor as asesor2', 'asesor2.idAsesor = cliente.idAsesor2', 'left');
		$this->db->join('asesor as asesor3', 'asesor3.idAsesor = cliente.idAsesor3', 'left');
		$this->db->join('gerente', 'asesor.idGerente = gerente.idGerente', 'LEFT');
		$this->db->join('gerente as gerente1', 'asesor1.idGerente = gerente1.idGerente', 'left');
		$this->db->join('gerente as gerente2', 'asesor2.idGerente = gerente2.idGerente', 'left');
		$this->db->join('gerente as gerente3', 'asesor3.idGerente = gerente3.idGerente', 'left');



		$this->db->join('asesor as asesorLote', 'asesorLote.idAsesor = lotes.idAsesor', 'left');
		$this->db->join('asesor as asesorLote2', 'asesorLote2.idAsesor = lotes.idAsesor2', 'left');
		$this->db->join('gerente as gerenteLote', 'asesorLote.idGerente = gerenteLote.idGerente', 'left');
		$this->db->join('gerente as gerenteLote2', 'asesorLote2.idGerente = gerenteLote2.idGerente', 'left');




		$this->db->where('residencial.idResidencial', $residencial);
		$this->db->where('lotes.idCondominio', $condominio);
		$this->db->where('lotes.idStatusLote', $status);
		$this->db->where('lotes.status', 1);
		$this->db->group_by('lotes.idLote');

		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}
// Fin de filtro de lotes por proyecto

// filtro de lotes por proyecto
	public function getInventarioXproyectoStatus($residencial,$status){

		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo, modalidad_1, modalidad_2, referencia, statuslote.nombre, comentarioLiberacion, fechaLiberacion, condominio.nombre as nombreCondominio, residencial.nombreResidencial,
	gerente1.nombreGerente as gerente1, gerente2.nombreGerente as gerente2, gerente3.nombreGerente as gerente3, asesor1.nombreAsesor as asesor, asesor2.nombreAsesor as asesor2, asesor3.nombreAsesor as asesor3, cliente.fechaApartado,
	
    lotes.idstatuslote, gerenteLote.nombreGerente as gerenteL, gerenteLote2.nombreGerente as gerenteL2, asesorLote.nombreAsesor as asesorL, asesorLote2.nombreAsesor as asesorL2, lotes.fecha_modst, cliente.user as userApartado, lotes.userstatus as userLote, motivo_change_status

	');

		$this->db->join('statuslote', 'lotes.idStatusLote = statuslote.idStatusLote');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');

		$this->db->join('cliente', 'cliente.idLote = lotes.idLote and cliente.status = 1', 'LEFT');
		$this->db->join('asesor', 'cliente.idAsesor = asesor.idAsesor', 'LEFT');
		$this->db->join('asesor as asesor1', 'asesor1.idAsesor = cliente.idAsesor', 'left');
		$this->db->join('asesor as asesor2', 'asesor2.idAsesor = cliente.idAsesor2', 'left');
		$this->db->join('asesor as asesor3', 'asesor3.idAsesor = cliente.idAsesor3', 'left');
		$this->db->join('gerente', 'asesor.idGerente = gerente.idGerente', 'LEFT');
		$this->db->join('gerente as gerente1', 'asesor1.idGerente = gerente1.idGerente', 'left');
		$this->db->join('gerente as gerente2', 'asesor2.idGerente = gerente2.idGerente', 'left');
		$this->db->join('gerente as gerente3', 'asesor3.idGerente = gerente3.idGerente', 'left');

		$this->db->join('asesor as asesorLote', 'asesorLote.idAsesor = lotes.idAsesor', 'left');
		$this->db->join('asesor as asesorLote2', 'asesorLote2.idAsesor = lotes.idAsesor2', 'left');
		$this->db->join('gerente as gerenteLote', 'asesorLote.idGerente = gerenteLote.idGerente', 'left');
		$this->db->join('gerente as gerenteLote2', 'asesorLote2.idGerente = gerenteLote2.idGerente', 'left');


		$this->db->where('residencial.idResidencial', $residencial);
		$this->db->where('lotes.status', 1);
		$this->db->where('lotes.idStatusLote', $status);
		$this->db->group_by('lotes.idLote');

		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}
// Fin de filtro de lotes por proyecto



/// Filtro todos lotes

	public function getInventarioTodos()

	{

		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo, modalidad_1, 
		modalidad_2, referencia, statuslote.nombre, comentarioLiberacion, fechaLiberacion, 
		condominio.nombre as nombreCondominio, residencial.nombreResidencial,
	
	gerente1.nombreGerente as gerente1, 
	gerente2.nombreGerente as gerente2, 
	gerente3.nombreGerente as gerente3, 
	asesor1.nombreAsesor as asesor,
	asesor2.nombreAsesor as asesor2, 
	asesor3.nombreAsesor as asesor3, 
	
	cliente.fechaApartado,
	
    lotes.idstatuslote, 
	gerenteLote.nombreGerente as gerenteL, 
	gerenteLote2.nombreGerente as gerenteL2, 
	asesorLote.nombreAsesor as asesorL, 
	asesorLote2.nombreAsesor as asesorL2, 
	lotes.fecha_modst, 
	cliente.user as userApartado, 
	lotes.userstatus as userLote, 
	motivo_change_status
	
	
	');

		$this->db->join('statuslote', 'lotes.idStatusLote = statuslote.idStatusLote');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');

		$this->db->join('cliente', 'cliente.idLote = lotes.idLote and cliente.status = 1', 'LEFT');
		$this->db->join('asesor', 'cliente.idAsesor = asesor.idAsesor', 'LEFT');
		$this->db->join('asesor as asesor1', 'asesor1.idAsesor = cliente.idAsesor', 'left');
		$this->db->join('asesor as asesor2', 'asesor2.idAsesor = cliente.idAsesor2', 'left');
		$this->db->join('asesor as asesor3', 'asesor3.idAsesor = cliente.idAsesor3', 'left');
		$this->db->join('gerente', 'asesor.idGerente = gerente.idGerente', 'LEFT');
		$this->db->join('gerente as gerente1', 'asesor1.idGerente = gerente1.idGerente', 'left');
		$this->db->join('gerente as gerente2', 'asesor2.idGerente = gerente2.idGerente', 'left');
		$this->db->join('gerente as gerente3', 'asesor3.idGerente = gerente3.idGerente', 'left');


		$this->db->join('asesor as asesorLote', 'asesorLote.idAsesor = lotes.idAsesor', 'left');
		$this->db->join('asesor as asesorLote2', 'asesorLote2.idAsesor = lotes.idAsesor2', 'left');
		$this->db->join('gerente as gerenteLote', 'asesorLote.idGerente = gerenteLote.idGerente', 'left');
		$this->db->join('gerente as gerenteLote2', 'asesorLote2.idGerente = gerenteLote2.idGerente', 'left');


		$this->db->where('lotes.status', 1);
		$this->db->group_by('lotes.idLote');

		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}

/// Fin fitro lotes





// Inicio filtro status opcion todos en la vista inventario terrenos en VEntas asistentes

	public function getStatus(){
		$this->db->select('idStatusLote, nombre');
		$this->db->from('statuslote');
		$this->db->order_by('nombre','asc');
		$query = $this->db->get();
		return $query->result_array();
	}

///	fin filtro de status




		public function historialProcesoFin($lotes){

		/*$this->db->select('historial_lotes.nombreLote, historial_lotes.modificado, historial_lotes.comentario,
		movimientos.descripcion, historial_lotes.usuario, statuscontratacion.nombreStatus, historial_lotes.idLote');

		$this->db->join('movimientos', 'historial_lotes.idMovimiento = movimientos.idMovimiento');
		$this->db->join('statuscontratacion', 'historial_lotes.idStatusContratacion = statuscontratacion.idStatusContratacion');

		$this->db->where("idLote",$lotes);
		$this->db->where('historial_lotes.status','1');

		$query = $this->db->get('historial_lotes');
		return $query->result();*/
		$query = $this->db-> query("SELECT historial_lotes.nombreLote, historial_lotes.modificado, historial_lotes.comentario, movimientos.descripcion,
(CASE WHEN (CONCAT(usuarios.nombre, ' ', usuarios.apellido_paterno, ' ', usuarios.apellido_materno)) = '' THEN historial_lotes.usuario 
ELSE (CONCAT(usuarios.nombre, ' ', usuarios.apellido_paterno, ' ', usuarios.apellido_materno)) END) usuario,
(CASE WHEN historial_lotes.perfil = '11' THEN 'administracion' WHEN historial_lotes.perfil = '13' THEN 'contraloria'
 WHEN historial_lotes.perfil = '15' THEN 'juridico' WHEN historial_lotes.perfil = '32' THEN 'contraloriaCorporativa'
 WHEN historial_lotes.perfil = '6' THEN 'asistentesGerentes' WHEN historial_lotes.perfil = '7' THEN 'asesor'
 WHEN historial_lotes.perfil = '9' THEN 'coordinador' ELSE historial_lotes.perfil END) perfil,

			CASE 
				WHEN historial_lotes.idStatusContratacion = 2 AND historial_lotes.idMovimiento = 84 THEN '2.0 Integración de Expediente (Asesor)' 
				ELSE
				statuscontratacion.nombreStatus
			END AS nombreStatus,
		  historial_lotes.idLote
FROM historial_lotes 
INNER JOIN movimientos ON historial_lotes.idMovimiento = movimientos.idMovimiento
INNER JOIN statuscontratacion ON historial_lotes.idStatusContratacion = statuscontratacion.idStatusContratacion 
LEFT JOIN usuarios ON usuarios.id_usuario = (CASE WHEN ISNUMERIC(historial_lotes.usuario) = 1 THEN historial_lotes.usuario ELSE 0 END)
WHERE idLote = ".$lotes." and historial_lotes.status = 1
order by historial_lotes.idHistorialLote");
		return $query->result_array();


	}














	public function get_tventa() {

		$query = $this->db-> query('SELECT id_tventa, tipo_venta FROM tipo_venta where status = 1');
		return $query->result_array();

	}




	public function historialBloqueo($lotes){

		$this->db->select('lotes.idLote, lotes.fecha_modst, lotes.userstatus, lotes.nombreLote, gerente1.nombreGerente as gerente1, gerente2.nombreGerente as gerente2, asesor1.nombreAsesor as asesor, asesor2.nombreAsesor as asesor2');


		$this->db->join('asesor', 'lotes.idAsesor = asesor.idAsesor');
		$this->db->join('asesor as asesor1', 'asesor1.idAsesor = lotes.idAsesor', 'left');
		$this->db->join('asesor as asesor2', 'asesor2.idAsesor = lotes.idAsesor2', 'left');

		$this->db->join('gerente', 'asesor.idGerente = gerente.idGerente');
		$this->db->join('gerente as gerente1', 'asesor1.idGerente = gerente1.idGerente', 'left');
		$this->db->join('gerente as gerente2', 'asesor2.idGerente = gerente2.idGerente', 'left');

		$this->db->where("lotes.idLote",$lotes);
		$this->db->where('lotes.status','1');

		$query = $this->db->get('lotes');
		return $query->result();


	}











	public function registroStatusContratacion10v2 () {
	/*SELECT lotes.idLote, cliente.idCliente, lotes.validacionEnganche, lotes.firmaRL,
    lotes.nombreLote, lotes.idStatusContratacion, lotes.idMovimiento, lotes.perfil, condominio.nombre as nombreCondominio, residencial.nombreResidencial, lotes.ubicacion, lotes.tipo_venta,
    lotes.numContrato

	FROM lotes inner join cliente on cliente.idLote = lotes.idLote
	        INNER JOIN condominio ON lotes.idCondominio = condominio.idCondominio
            INNER JOIN residencial ON condominio.idResidencial = residencial.idResidencial

	where lotes.idStatusContratacion = "9" and lotes.idMovimiento  = "39" and cliente.status = 1
    or lotes.idStatusContratacion = "9" and lotes.idMovimiento  = "26" and cliente.status = 1

    group by lotes.idLote */
		$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, l.validacionEnganche, l.firmaRL,
	l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.perfil, cond.nombre as nombreCondominio,
	res.nombreResidencial, l.ubicacion, l.tipo_venta, l.numContrato
	FROM lotes l
	INNER JOIN clientes cl ON cl.idLote = l.idLote
	INNER JOIN condominios cond ON l.idCondominio = cond.idCondominio
	INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
	WHERE
	l.idStatusContratacion=9 AND l.idMovimiento=39 AND cl.status=1
	OR l.idStatusContratacion=9 AND l.idMovimiento=26 AND cl.status=1
	GROUP BY l.idLote, cl.id_cliente, l.validacionEnganche, l.firmaRL,
	l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.perfil, cond.nombre,
	res.nombreResidencial, l.ubicacion, l.tipo_venta, l.numContrato;
");

		return $query->result();
	}






	public function getDescuentoscf($idLote){

		$this->db->select('id_corrida, id_lote, saldo, precio_m2_final, precio_final, pago_enganche, paquete, opcion_paquete, msi_1p, msi_2p, msi_3p');
		$this->db->where("id_lote",$idLote);

		$query = $this->db->get('corridas_financieras');
		return $query->row();

	}



	public function getDescuentosCorrida($paquete, $opcion_paquete){

		$arrayQuery = array();
		$query = $this->db-> query('SELECT id_descuento from relaciones where id_paquete = "'.$paquete.'" AND id_descuento IN ('.$opcion_paquete.')');

		foreach ($query->result_array() as $desc)
		{
			$arrayQuery[] = $this->db-> query('SELECT id_descuento, porcentaje, apply from descuentos WHERE id_descuento IN ('.$desc['id_descuento'].') ')->result_array();

		}

		return $arrayQuery;
	}


	public function getPaqueteApply($paquete){

		$this->db->select('id_paquete, descripcion');
		$this->db->where("id_paquete",$paquete);
		$query = $this->db->get('paquetes');
		return $query->row();

	}




	public function getInventarioTodosc() {

		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo,
	condominio.nombre as nombreCondominio, residencial.nombreResidencial,
	lotes.idstatuslote, condominio.msni as mesesn');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where('lotes.idStatusLote', 1);
		$this->db->where('lotes.status', 1);
		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}





	public function getSupOne($residencial) {

		$this->db->distinct()->select('sup');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where('residencial.idResidencial', $residencial);

		$this->db->where('lotes.idStatusLote', 1);
		$this->db->where('lotes.status', 1);
		$this->db->order_by('sup', 'asc');

		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}


	public function getPrecio($residencial) {

		$this->db->distinct()->select('precio');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where('residencial.idResidencial', $residencial);

		$this->db->where('lotes.idStatusLote', 1);
		$this->db->where('lotes.status', 1);
		$this->db->order_by('precio', 'asc');

		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}



	public function getTotal($residencial) {

		$this->db->distinct()->select('total');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where('residencial.idResidencial', $residencial);

		$this->db->where('lotes.idStatusLote', 1);
		$this->db->where('lotes.status', 1);
		$this->db->order_by('total', 'asc');

		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}




	public function getMeses($residencial) {

		$this->db->distinct()->select('condominio.msni');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where('residencial.idResidencial', $residencial);

		$this->db->where('lotes.idStatusLote', 1);
		$this->db->where('lotes.status', 1);
		$this->db->order_by('condominio.msni', 'asc');

		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}



	public function getInventarioXproyectoc($residencial) {

		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo,
	condominio.nombre as nombreCondominio, residencial.nombreResidencial,
	lotes.idstatuslote, condominio.msni as mesesn');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where('residencial.idResidencial', $residencial);
		$this->db->where('lotes.idStatusLote', 1);
		$this->db->where('lotes.status', 1);
		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}


	public function getInventarioc($residencial ,$condominio) {

		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo,
	condominios.nombre as nombreCondominio, residenciales.nombreResidencial,
	lotes.idstatuslote, condominios.msni as mesesn');
		$this->db->join('condominios', 'lotes.idCondominio = condominios.idCondominio');
		$this->db->join('residenciales', 'condominios.idResidencial = residenciales.idResidencial');
		$this->db->where('residenciales.idResidencial', $residencial);
		$this->db->where_in('lotes.idCondominio', $condominio, false);
		$this->db->where('lotes.idStatusLote', 1);
		$this->db->where('lotes.status', 1);
		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}


	public function getClusterGrupo($residencial, $condominio, $grupo) {

		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo,
	   condominios.nombre as nombreCondominio, residenciales.nombreResidencial,
	   lotes.idstatuslote, condominios.msni as mesesn');
		$this->db->join('condominios', 'lotes.idCondominio = condominios.idCondominio');
		$this->db->join('residenciales', 'condominios.idResidencial = residenciales.idResidencial');

		$this->db->where('residenciales.idResidencial', $residencial);
		$this->db->where_in('condominios.idCondominio', $condominio, FALSE);


		if($grupo == 1){
			$this->db->where('sup <', '200');
		} else if ($grupo == 2){

			$this->db->where('sup >=', '200');
			$this->db->where('sup <', '300');

		} else if($grupo == 3) {
			$this->db->where('sup >=', '300');
		}

		$this->db->where('lotes.idStatusLote', 1);
		$this->db->where('lotes.status', 1);
		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}



	public function getClusterPreciom($residencial, $condominio, $preciom) {

		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo,
	condominio.nombre as nombreCondominio, residencial.nombreResidencial,
	lotes.idstatuslote, condominio.msni as mesesn');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where('residencial.idResidencial', $residencial);
		$this->db->where_in('condominio.idCondominio', $condominio, FALSE);
		$this->db->where_in('lotes.precio', $preciom, FALSE);

		$this->db->where('lotes.idStatusLote', 1);
		$this->db->where('lotes.status', 1);
		$this->db->order_by('sup', 'asc');

		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}




	public function getClusterTotal($residencial, $condominio, $total) {

		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo,
	condominio.nombre as nombreCondominio, residencial.nombreResidencial,
	lotes.idstatuslote, condominio.msni as mesesn');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where('residencial.idResidencial', $residencial);
		$this->db->where_in('condominio.idCondominio', $condominio, FALSE);
		$this->db->where_in('lotes.total', $total, FALSE);

		$this->db->where('lotes.idStatusLote', 1);
		$this->db->where('lotes.status', 1);
		$this->db->order_by('sup', 'asc');

		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}




	public function getClusterMeses($residencial, $condominio, $meses) {

		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo,
	condominio.nombre as nombreCondominio, residencial.nombreResidencial,
	lotes.idstatuslote, condominio.msni as mesesn');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where('residencial.idResidencial', $residencial);
		$this->db->where_in('condominio.idCondominio', $condominio, FALSE);
		$this->db->where_in('condominio.msni', $meses, FALSE);

		$this->db->where('lotes.idStatusLote', 1);
		$this->db->where('lotes.status', 1);
		$this->db->order_by('sup', 'asc');

		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}


	public function getTwoGroup($residencial, $grupo) {

		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo,
	condominios.nombre as nombreCondominio, residenciales.nombreResidencial,
	lotes.idstatuslote, condominios.msni as mesesn');
		$this->db->join('condominios', 'lotes.idCondominio = condominios.idCondominio');
		$this->db->join('residenciales', 'condominios.idResidencial = residenciales.idResidencial');

		$this->db->where('residenciales.idResidencial', $residencial);


		if($grupo == 1){
			$this->db->where('sup <', '200');
		} else if ($grupo == 2){

			$this->db->where('sup >=', '200');
			$this->db->where('sup <', '300');

		} else if($grupo == 3) {
			$this->db->where('sup >=', '300');
		}

		$this->db->where('lotes.idStatusLote', 1);
		$this->db->where('lotes.status', 1);
		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}

    public function getThreeGroup($grupo) {
        $this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo,
       condominios.nombre as nombreCondominio, residenciales.nombreResidencial,
       lotes.idstatuslote, condominios.msni as mesesn');
        $this->db->join('condominios', 'lotes.idCondominio = condominios.idCondominio');
        $this->db->join('residenciales', 'condominios.idResidencial = residenciales.idResidencial');
        if($grupo == 1){
            $this->db->where('sup <', '200');
        } else if ($grupo == 2){
            $this->db->where('sup >=', '200');
            $this->db->where('sup <', '300');

        } else if($grupo == 3) {
            $this->db->where('sup >=', '300');
        }
        $this->db->where('lotes.idStatusLote', 1);
        $this->db->where('lotes.status', 1);
        $query = $this->db->get('lotes');
        if($query){
            $query = $query->result_array();
            return $query;
        }
    }



	public function getOneGroup($condominio, $grupo) {

		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo,
	   condominios.nombre as nombreCondominio, residenciales.nombreResidencial,
	   lotes.idstatuslote, condominios.msni as mesesn');
		$this->db->join('condominios', 'lotes.idCondominio = condominios.idCondominio');
		$this->db->join('residenciales', 'condominios.idResidencial = residenciales.idResidencial');

		$this->db->where_in('condominios.idCondominio', $condominio, FALSE);


		if($grupo == 1){
			$this->db->where('sup <', '200');
		} else if ($grupo == 2){

			$this->db->where('sup >=', '200');
			$this->db->where('sup <', '300');

		} else if($grupo == 3) {
			$this->db->where('sup >=', '300');
		}

		$this->db->where('lotes.idStatusLote', 1);
		$this->db->where('lotes.status', 1);
		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}

	public function getSup($residencial, $sup) {

		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo,
	condominios.nombre as nombreCondominio, residenciales.nombreResidencial,
	lotes.idstatuslote, condominios.msni as mesesn');
		$this->db->join('condominios', 'lotes.idCondominio = condominios.idCondominio');
		$this->db->join('residenciales', 'condominios.idResidencial = residenciales.idResidencial');

		$this->db->where('residenciales.idResidencial', $residencial);
		$this->db->where_in('sup', $sup, FALSE);


		$this->db->where('lotes.idStatusLote', 1);
		$this->db->where('lotes.status', 1);
		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}



	public function getSupTwo($residencial, $condominio, $sup) {

		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo,
	condominios.nombre as nombreCondominio, residenciales.nombreResidencial,
	lotes.idstatuslote, condominios.msni as mesesn');
		$this->db->join('condominios', 'lotes.idCondominio = condominios.idCondominio');
		$this->db->join('residenciales', 'condominios.idResidencial = residenciales.idResidencial');

		$this->db->where_in('condominios.idCondominio', $condominio, FALSE);
		$this->db->where('residenciales.idResidencial', $residencial);
		$this->db->where_in('sup', $sup, FALSE);


		$this->db->where('lotes.idStatusLote', 1);
		$this->db->where('lotes.status', 1);
		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}


	public function getPreciomResidencial($residencial, $preciom) {

		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo,
	condominios.nombre as nombreCondominio, residenciales.nombreResidencial,
	lotes.idstatuslote, condominios.msni as mesesn');
		$this->db->join('condominios', 'lotes.idCondominio = condominios.idCondominio');
		$this->db->join('residenciales', 'condominios.idResidencial = residenciales.idResidencial');
		$this->db->where('residenciales.idResidencial', $residencial);
		$this->db->where_in('lotes.precio', $preciom, FALSE);

		$this->db->where('lotes.idStatusLote', 1);
		$this->db->where('lotes.status', 1);
		$this->db->order_by('sup', 'asc');

		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}


	public function getPreciomCluster($residencial, $condominio, $preciom) {

		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo,
	condominio.nombre as nombreCondominio, residencial.nombreResidencial,
	lotes.idstatuslote, condominio.msni as mesesn');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where('residencial.idResidencial', $residencial);
		$this->db->where_in('condominio.idCondominio', $condominio, FALSE);
		$this->db->where_in('lotes.precio', $preciom, FALSE);

		$this->db->where('lotes.idStatusLote', 1);
		$this->db->where('lotes.status', 1);
		$this->db->order_by('sup', 'asc');

		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}


	public function getPreciotResidencial($residencial, $preciot) {

		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo,
	condominios.nombre as nombreCondominio, residenciales.nombreResidencial,
	lotes.idstatuslote, condominios.msni as mesesn');
		$this->db->join('condominios', 'lotes.idCondominio = condominios.idCondominio');
		$this->db->join('residenciales', 'condominios.idResidencial = residenciales.idResidencial');
		$this->db->where('residenciales.idResidencial', $residencial);
		$this->db->where_in('lotes.total', $preciot, FALSE);

		$this->db->where('lotes.idStatusLote', 1);
		$this->db->where('lotes.status', 1);
		$this->db->order_by('sup', 'asc');

		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}


	public function getPreciotCluster($residencial, $condominio, $preciot) {

		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo,
	condominios.nombre as nombreCondominio, residenciales.nombreResidencial,
	lotes.idstatuslote, condominios.msni as mesesn');
		$this->db->join('condominios', 'lotes.idCondominio = condominios.idCondominio');
		$this->db->join('residenciales', 'condominios.idResidencial = residenciales.idResidencial');
		$this->db->where('residenciales.idResidencial', $residencial);
		$this->db->where_in('condominios.idCondominio', $condominio, FALSE);
		$this->db->where_in('lotes.total', $preciot, FALSE);

		$this->db->where('lotes.idStatusLote', 1);
		$this->db->where('lotes.status', 1);
		$this->db->order_by('sup', 'asc');

		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}



	public function getMesesResidencial($residencial, $meses) {

		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo,
	condominios.nombre as nombreCondominio, residenciales.nombreResidencial,
	lotes.idstatuslote, condominios.msni as mesesn');
		$this->db->join('condominios', 'lotes.idCondominio = condominios.idCondominio');
		$this->db->join('residenciales', 'condominios.idResidencial = residenciales.idResidencial');
		$this->db->where('residenciales.idResidencial', $residencial);
		$this->db->where_in('condominios.msni', $meses, FALSE);

		$this->db->where('lotes.idStatusLote', 1);
		$this->db->where('lotes.status', 1);
		$this->db->order_by('sup', 'asc');

		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}




	public function getMesesCluster($residencial, $condominio, $meses) {

		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo,
	condominios.nombre as nombreCondominio, residenciales.nombreResidencial,
	lotes.idstatuslote, condominios.msni as mesesn');
		$this->db->join('condominios', 'lotes.idCondominio = condominios.idCondominio');
		$this->db->join('residenciales', 'condominios.idResidencial = residenciales.idResidencial');
		$this->db->where('residenciales.idResidencial', $residencial);
		$this->db->where_in('condominios.idCondominio', $condominio, FALSE);
		$this->db->where_in('condominios.msni', $meses, FALSE);

		$this->db->where('lotes.idStatusLote', 1);
		$this->db->where('lotes.status', 1);
		$this->db->order_by('sup', 'asc');

		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}



	public function finalStatus12(){


		$query = $this->db-> query('SELECT lotes.idLote, cliente.idCliente, lotes.nombreLote, lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado, lotes.perfil, condominio.nombre as nombreCondominio, residencial.nombreResidencial, fechaVenc, comentario, fechaSolicitudValidacion, gerente1.nombreGerente as gerente1, gerente2.nombreGerente as gerente2, gerente3.nombreGerente as gerente3, gerente4.nombreGerente as gerente4, gerente5.nombreGerente as gerente5, asesor1.nombreAsesor as asesor, asesor2.nombreAsesor as asesor2, asesor3.nombreAsesor as asesor3, asesor4.nombreAsesor as asesor4, asesor5.nombreAsesor as asesor5, lotes.firmaRL, lotes.validacionEnganche, lotes.fechaRL
				FROM lotes 
				inner join cliente on cliente.idLote = lotes.idLote
				INNER JOIN condominio ON lotes.idCondominio = condominio.idCondominio
				INNER JOIN residencial ON condominio.idResidencial = residencial.idResidencial
				inner join asesor on cliente.idAsesor = asesor.idAsesor 
				left JOIN asesor as asesor1 ON asesor1.idAsesor = cliente.idAsesor
				left JOIN asesor as asesor2 ON asesor2.idAsesor = cliente.idAsesor2
				left JOIN asesor as asesor3 ON asesor3.idAsesor = cliente.idAsesor3
				left JOIN asesor as asesor4 ON asesor4.idAsesor = cliente.idAsesor4
				left JOIN asesor as asesor5 ON asesor5.idAsesor = cliente.idAsesor5
				INNER JOIN gerente on asesor.idGerente = gerente.idGerente
				left JOIN gerente as gerente1 ON asesor1.idGerente = gerente1.idGerente
				left JOIN gerente as gerente2 ON asesor2.idGerente = gerente2.idGerente
				left JOIN gerente as gerente3 ON asesor3.idGerente = gerente3.idGerente
				LEFT JOIN gerente as gerente4 ON asesor4.idGerente = gerente4.idGerente
				left JOIN gerente as gerente5 ON asesor5.idGerente = gerente5.idGerente
				
				
				where 
				   lotes.idStatusContratacion = "11" and lotes.idMovimiento  = "41" and cliente.status = 1 and lotes.firmaRL = "NULL" OR lotes.firmaRL = " "
				OR lotes.idStatusContratacion = "10" and lotes.idMovimiento  = "40" and cliente.status = 1 and lotes.firmaRL = "NULL" OR lotes.firmaRL = " "
				OR lotes.idStatusContratacion = "7" and lotes.idMovimiento  = "66" and cliente.status = 1 and lotes.firmaRL = "NULL" OR lotes.firmaRL = " "
				OR lotes.idStatusContratacion = "8" and lotes.idMovimiento  = "67" and cliente.status = 1 and lotes.firmaRL = "NULL" OR lotes.firmaRL = " "

				');
		return $query->result();
	}





	public function getSupThree($residencial, $condominio, $sup, $grupo) {

		$this->db->select('lotes.idLote, nombreLote, sup, precio, total, porcentaje, enganche, saldo,
	condominio.nombre as nombreCondominio, residencial.nombreResidencial,
	lotes.idstatuslote, condominio.msni as mesesn');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');

		$this->db->where_in('condominio.idCondominio', $condominio, FALSE);
		$this->db->where('residencial.idResidencial', $residencial);
		$this->db->where_in('sup', $sup, FALSE);


		if($grupo == 1){
			$this->db->where('sup <', '200');
		} else if ($grupo == 2){

			$this->db->where('sup >=', '200');
			$this->db->where('sup <', '300');

		} else if($grupo == 3) {
			$this->db->where('sup >=', '300');
		}


		$this->db->where('lotes.idStatusLote', 1);
		$this->db->where('lotes.status', 1);
		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;

		}
	}




	public function getInfoResepcionExp($idLote){

		$this->db->select('lotes.idLote, nombreLote, condominio.nombre as nombreCondominio, residencial.nombreResidencial,
	gerente1.nombreGerente as gerente1, 
	gerente2.nombreGerente as gerente2, 
	gerente3.nombreGerente as gerente3, 
	asesor1.nombreAsesor as asesor, asesor1.idAsesor as idAs1,
	asesor2.nombreAsesor as asesor2, asesor2.idAsesor as idAs2,
	asesor3.nombreAsesor as asesor3, asesor3.idAsesor as idAs3,
	lotes.idstatuslote, lotes.idCliente, condominio.idCondominio, residencial.idResidencial
	');

		$this->db->join('statuslote', 'lotes.idStatusLote = statuslote.idStatusLote');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');

		$this->db->join('cliente', 'cliente.idLote = lotes.idLote and cliente.status = 1', 'LEFT');
		$this->db->join('asesor', 'cliente.idAsesor = asesor.idAsesor', 'LEFT');
		$this->db->join('asesor as asesor1', 'asesor1.idAsesor = cliente.idAsesor', 'left');
		$this->db->join('asesor as asesor2', 'asesor2.idAsesor = cliente.idAsesor2', 'left');
		$this->db->join('asesor as asesor3', 'asesor3.idAsesor = cliente.idAsesor3', 'left');
		$this->db->join('gerente', 'asesor.idGerente = gerente.idGerente', 'LEFT');
		$this->db->join('gerente as gerente1', 'asesor1.idGerente = gerente1.idGerente', 'left');
		$this->db->join('gerente as gerente2', 'asesor2.idGerente = gerente2.idGerente', 'left');
		$this->db->join('gerente as gerente3', 'asesor3.idGerente = gerente3.idGerente', 'left');


		$this->db->where('lotes.idLote', $idLote);
		$this->db->where('lotes.status', 1);

		$query = $this->db->get('lotes');

		return $query->row_array();

	}






	public function getListAs($dato){

		$this->db->select('correo');
		$this->db->where('status', 1);
		$this->db->where_in('idAsesor', $dato, FALSE);
		$query = $this->db->get('asesor');
		if($query){
			$query = $query->result_array();
			return $query;
		}

	}

	public function getTemporalEstatus() {

		$query = $this->db-> query('SELECT idStatusLote,nombre FROM statuslote  WHERE idStatusLote IN (1, 2, 3, 9, 8, 7, 10) ');
		return $query->result();

	}



	public function getUserSoporte(){
		$this->db->where('status', 1);
		$query= $this->db->get("users");
		return $query->result();

	}






	public function getInfoAsRechazoEst3($idLote){

		$this->db->select('lotes.idLote, nombreLote, condominios.nombre as nombreCondominio, residenciales.nombreResidencial,
		lotes.idstatuslote, lotes.idCliente, condominios.idCondominio, residenciales.idResidencial, lotes.fechaVenc,
		us.correo
		');

		$this->db->join('statuslote statuslote', 'lotes.idStatusLote = statuslote.idStatusLote');
		$this->db->join('condominios condominios', 'lotes.idCondominio = condominios.idCondominio');
		$this->db->join('residenciales residenciales', 'condominios.idResidencial = residenciales.idResidencial');

		$this->db->join('clientes', 'clientes.idLote = lotes.idLote and clientes.status = 1', 'LEFT');
		$this->db->join('usuarios us', 'us.id_usuario = clientes.id_asesor', 'LEFT');



		$this->db->where('lotes.idLote', $idLote);
		$this->db->where('lotes.status', 1);

		$query = $this->db->get('lotes');

		return $query->row_array();

	}



	public function registroRechazosStatus3Contratacion () {

		/*$query = $this->db-> query('SELECT lotes.idLote, cliente.idCliente, primerNombre, segundoNombre, apellidoPaterno, apellidoMaterno,
			lotes.nombreLote, lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado, razonSocial, lotes.comentario, fechaVenc, lotes.perfil, condominio.nombre as nombreCondominio, 
			residencial.nombreResidencial, lotes.ubicacion, lotes.tipo_venta, condominio.idCondominio,
			
			gerente1.nombreGerente as gerente1,
			gerente2.nombreGerente as gerente2,
			gerente3.nombreGerente as gerente3, 
			
			
			asesor1.nombreAsesor as asesor, 
			asesor2.nombreAsesor as asesor2, 
			asesor3.nombreAsesor as asesor3
			
			FROM lotes inner join cliente on cliente.idLote = lotes.idLote
			INNER JOIN condominio ON lotes.idCondominio = condominio.idCondominio
			INNER JOIN residencial ON condominio.idResidencial = residencial.idResidencial

			inner join asesor on cliente.idAsesor = asesor.idAsesor
			left JOIN asesor as asesor1 ON asesor1.idAsesor = cliente.idAsesor
			left JOIN asesor as asesor2 ON asesor2.idAsesor = cliente.idAsesor2
			left JOIN asesor as asesor3 ON asesor3.idAsesor = cliente.idAsesor3

			INNER JOIN gerente on asesor.idGerente = gerente.idGerente
			left JOIN gerente as gerente1 ON asesor1.idGerente = gerente1.idGerente
			left JOIN gerente as gerente2 ON asesor2.idGerente = gerente2.idGerente
			left JOIN gerente as gerente3 ON asesor3.idGerente = gerente3.idGerente
			where  lotes.idStatusContratacion = "3" and lotes.idMovimiento  = "82" and cliente.status = 1
				group by lotes.idLote
			');*/

		$query =  $this->db-> query("
SELECT lotes.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
		lotes.nombreLote, lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado,
		lotes.fechaVenc, residencial.nombreResidencial, lotes.ubicacion, lotes.perfil, cond.nombre as nombreCondominio,
		lotes.tipo_venta, cond.idCondominio, CAST(lotes.comentario AS varchar(MAX)) as comentario,
		concat(us.nombre,' ', us.apellido_paterno,' ', us.apellido_materno) as asesor,  
		concat(ge.nombre,' ', ge.apellido_paterno,' ', ge.apellido_materno) as gerente, cond.idCondominio
FROM lotes as lotes 
INNER JOIN clientes as cl ON lotes.idLote=cl.idLote
INNER JOIN condominios as cond ON lotes.idCondominio=cond.idCondominio 
INNER JOIN residenciales as residencial ON cond.idResidencial=residencial.idResidencial 
INNER JOIN usuarios as us ON cl.id_asesor=us.id_usuario 
LEFT JOIN usuarios as ge ON ge.id_usuario=us.id_lider
WHERE lotes.idStatusContratacion = 3 and lotes.idMovimiento = 82 and cl.status = 1 
group by lotes.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
		lotes.nombreLote, lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado, 
		 lotes.fechaVenc, residencial.nombreResidencial, lotes.ubicacion, lotes.perfil, cond.nombre,
		lotes.tipo_venta, cond.idCondominio, CAST(lotes.comentario AS varchar(MAX)),
		concat(us.nombre,' ', us.apellido_paterno,' ', us.apellido_materno),  
		concat(ge.nombre,' ', ge.apellido_paterno,' ', ge.apellido_materno), cond.idCondominio;");
		return $query->result();

	}






	public function getGerenteBloqueo($idGerentes){
		$this->db->select('nombreGerente');
		$this->db->where_in('idGerente', $idGerentes, FALSE);
		$this->db->where('status','1');
		$query = $this->db->get('gerente');
		return $query->result_array();
	}




	public function getAsesorBloqueo($idAsesores){
		$this->db->select('nombreAsesor');
		$this->db->where_in('idAsesor', $idAsesores, FALSE);
		$this->db->where('status','1');
		$query = $this->db->get('asesor');
		return $query->result_array();
	}







	public function registroStatusContratacion2_0 () {

		$query = $this->db-> query("SELECT lotes.idLote, cliente.id_cliente, cliente.nombre, apellido_paterno, 
				apellido_materno, lotes.nombreLote, lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado, 
				CAST(lotes.comentario AS varchar(MAX)) as comentario, rfc, fechaVenc, lotes.perfil, condominio.nombre as nombreCondominio, 
				residencial.nombreResidencial, lotes.ubicacion
				FROM lotes 
				inner join clientes cliente on cliente.idLote = lotes.idLote
				INNER JOIN condominios condominio ON lotes.idCondominio = condominio.idCondominio
				INNER JOIN residenciales residencial ON condominio.idResidencial = residencial.idResidencial
				where  
				lotes.idStatusContratacion = '1' and lotes.idMovimiento  = '31' and cliente.status = 1
				or lotes.idStatusContratacion = '2' and lotes.idMovimiento  = '85' and cliente.status = 1
				group by lotes.idLote, cliente.id_cliente, cliente.nombre, apellido_paterno, 
				apellido_materno, lotes.nombreLote, lotes.idStatusContratacion, lotes.idMovimiento, lotes.modificado, 
				CAST(lotes.comentario AS varchar(MAX)), rfc, fechaVenc, lotes.perfil, condominio.nombre, 
				residencial.nombreResidencial, lotes.ubicacion ");

		return $query->result();

	}



	public function editaAut($idLote,$arr,$idCliente){
		$this->db->where("idLote",$idLote);
		$this->db->where("idCliente",$idCliente);
		$this->db->update('cliente',$arr);
		return true;
	}




	public function registroClienteAut(){

		/*$this->db->select('cliente.id_cliente, cliente.nombre,  apellido_paterno, apellido_materno, nombreLote, fechaApartado, fechaVencimiento, rfc,
				noRecibo, noAcuse, nombreResidencial, condominio.nombre as nombreCondominio, cliente.status, cliente.idAsesor, condominio.idCondominio, lotes.idLote, cliente.autorizacion,
				cliente.idAut, cliente.motivoAut');

		$this->db->join('lotes', 'cliente.idLote = lotes.idLote');
		$this->db->join('condominios condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residenciales residencial', 'condominio.idResidencial = residencial.idResidencial');

		$this->db->where('cliente.status', 1);
		$this->db->where("(cliente.idAut = '".$this->session->userdata('id')."')");

		$this->db->where("(cliente.autorizacion = 1 AND (idStatusContratacion = 1 AND idMovimiento = 31 OR idStatusContratacion = 2 AND idMovimiento = 85)  )");

		$query = $this->db->get('clientes cliente');
		return $query->result();*/
		$query = $this->db-> query("SELECT  residencial.nombreResidencial, condominio.nombre as nombreCondominio, 
		lotes.nombreLote, MAX(autorizaciones.estatus) as estatus,  MAX(id_autorizacion) as id_autorizacion, MAX(autorizaciones.fecha_creacion) as fecha_creacion,
		MAX(autorizaciones.autorizacion) as autorizacion, id_aut, cl.id_cliente, condominio.idCondominio,
		users.usuario as sol,   autorizaciones.idLote,
		CONCAT(cl.nombre,' ', cl.apellido_paterno,' ', cl.apellido_materno) as cliente,
		CONCAT(asesor.nombre,' ', asesor.apellido_paterno,' ', asesor.apellido_materno) as asesor,
        CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente
		FROM autorizaciones 
		inner join lotes on lotes.idLote = autorizaciones.idLote 
		inner join condominios as condominio on condominio.idCondominio = lotes.idCondominio 
		inner join residenciales as residencial on residencial.idResidencial = condominio.idResidencial
		inner join usuarios as users on autorizaciones.id_sol = users.id_usuario
		INNER JOIN clientes as cl ON autorizaciones.idCliente=cl.id_cliente
		INNER JOIN usuarios as asesor ON cl.id_asesor=asesor.id_usuario
        INNER JOIN usuarios gerente ON gerente.id_usuario = cl.id_gerente
 		where autorizaciones.id_aut = ".$this->session->userdata('id_usuario')."  AND autorizaciones.estatus=1
		GROUP BY residencial.nombreResidencial, condominio.nombre, 
		lotes.nombreLote, id_aut, cl.id_cliente, condominio.idCondominio,
		users.usuario,  autorizaciones.idLote, CONCAT(cl.nombre,' ', cl.apellido_paterno,' ', cl.apellido_materno),
        CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
		CONCAT(asesor.nombre,' ', asesor.apellido_paterno,' ', asesor.apellido_materno)");

		return $query->result();


	}








	public function registroClienteDS_query(){

		$this->db->select('cliente.idCliente, primerNombre, segundoNombre, apellidoPaterno, apellidoMaterno, nombreLote, fechaApartado, fechaVencimiento, cliente.rfc, razonSocial, 
		noRecibo, noAcuse, nombreResidencial, condominio.nombre as nombreCondominio, cliente.status, cliente.idAsesor, condominio.idCondominio, lotes.idLote, cliente.autorizacion, cliente.fechaApartado');

		$this->db->join('lotes', 'cliente.idLote = lotes.idLote');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->join('deposito_seriedad', 'deposito_seriedad.idCliente = cliente.idcliente');


		$this->db->where('cliente.status', 1);

		$this->db->where("(cliente.idAsesor = '".$this->session->userdata('idAsesor')."' 
		OR cliente.idAsesor2 = '".$this->session->userdata('idAsesor')."' OR cliente.idAsesor3 = '".$this->session->userdata('idAsesor')."')");


		// $this->db->where("cliente.fechaApartado>",'2019-03-22');

		$this->db->order_by('cliente.fechaApartado', 'desc');
		$query = $this->db->get('cliente');
		return $query->result();

	}
	public function getLocation($id_sede)
	{
		$query = $this->db-> query('SELECT *  FROM sedes WHERE id_sede='.$id_sede.' AND estatus=1');
		return $query->result();
	}


/////////////////////// NEW MAJO /////////////////////



	public function table_datosBancarios(){
		$this->db->select('idDBanco, empresa, banco, cuenta, clabe');
		$query= $this->db->get("datosbancarios");
		return $query->result_array();
	}



	public function table_etapa(){
		$this->db->select('idEtapa, descripcion');
		$query= $this->db->get("etapa");
		return $query->result_array();
	}

	public function insert_cluster($dato){
		$this->db->insert('condominio',$dato);
		return true;
	}



	public function uploadLotes($idCondominio) {
		$count=0;
		$fp = fopen($_FILES['userfile']['tmp_name'],'r') or die("can't open file");
		while($csv_line = fgetcsv($fp,1024)) {
			$count++;
			if($count == 1) {
				continue;
			}
			for($i = 0, $j = count($csv_line); $i < $j; $i++) {
				$insert_csv = array();
				$insert_csv['nombreLote'] = $csv_line[0];
				$insert_csv['sup'] = $csv_line[1];
				$insert_csv['precio'] = $csv_line[2];
				$insert_csv['porcentaje'] = $csv_line[3];
				$insert_csv['idStatusLote'] = $csv_line[4];

			}
			$i++;
			$data = array(
				'nombreLote' => $insert_csv['nombreLote'] ,
				'sup' => $insert_csv['sup'],
				'precio' => $insert_csv['precio'],
				'total' => ($insert_csv['sup'] *  $insert_csv['precio']),
				'porcentaje' => $insert_csv['porcentaje'],
				'enganche' => (($insert_csv['sup'] *  $insert_csv['precio'])* 0.1),
				'saldo' => (($insert_csv['sup'] *  $insert_csv['precio']) - (($insert_csv['sup'] *  $insert_csv['precio'])* 0.1)),
				'idCondominio' => $idCondominio,
				'idStatusContratacion' => 0,

			);

			if ($insert_csv['idStatusLote'] == 'DISPONIBLE') {
				$data['idStatusLote'] = 1;
			} else if ($insert_csv['idStatusLote'] == 'APARTADO') {
				$data['idStatusLote'] = 3;
			} else if ($insert_csv['idStatusLote'] == 'ENGANCHE') {
				$data['idStatusLote'] = 4;
			} else if ($insert_csv['idStatusLote'] == 'INTERCAMBIO') {
				$data['idStatusLote'] = 6;
			} else if ($insert_csv['idStatusLote'] == 'DIRECCION') {
				$data['idStatusLote'] = 7;
			} else if ($insert_csv['idStatusLote'] == 'BLOQUEO' || $insert_csv['idStatusLote'] == 'BLOQUEADO') {
				$data['idStatusLote'] = 8;
			} else {
				$data['idStatusLote'] = 8;
			}

			$data['arreglo']=$this->db->insert('lotes', $data);

		}
		fclose($fp) or die("can't close file");
		return true;

	}



	public function uploadPrecio($idCondominio) {
		$count=0;
		$fp = fopen($_FILES['precio']['tmp_name'],'r') or die("can't open file");
		while($csv_line = fgetcsv($fp,1024)) {
			$count++;
			if($count == 1) {
				continue;
			}
			for($i = 0, $j = count($csv_line); $i < $j; $i++) {
				$insert_csv = array();
				$insert_csv['idCondominio'] = $idCondominio;
				$insert_csv['nombreLote'] = $csv_line[0];
				$insert_csv['precio'] = $csv_line[1];

			}
			$i++;

			$query = $this->db-> query('SELECT idLote, nombreLote, sup FROM lotes where status = 1 and idCondominio = "'.$insert_csv['idCondominio'].'" and nombreLote = "'.$insert_csv['nombreLote'].'" ');

			foreach ($query->result_array() as $row)
			{
			}

			$this->db->trans_begin();


			$this->db->query("UPDATE lotes SET precio = '".$insert_csv['precio']."', total = (('".$row['sup']."') * '".$insert_csv['precio']."'),
enganche = ((('".$row['sup']."') * '".$insert_csv['precio']."') * 0.1), 
saldo = ((('".$row['sup']."') * '".$insert_csv['precio']."') - ((('".$row['sup']."') * '".$insert_csv['precio']."') * 0.1))
WHERE idLote IN ('".$row['idLote']."') and nombreLote = '".$insert_csv['nombreLote']."' and status = 1");


			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			}
			else {
				$this->db->trans_commit();
			}

		}

		fclose($fp) or die("can't close file");
		return true;

	}



	public function uploadReferencias($idCondominio){
		$count=0;
		$fp = fopen($_FILES['referencias']['tmp_name'],'r') or die("can't open file");
		while($csv_line = fgetcsv($fp,1024)){
			$count++;
			if($count == 1){
				continue;
			}
			for($i = 0, $j = count($csv_line); $i < $j; $i++){
				$insert_csv = array();
				$insert_csv['idCondominio'] = $idCondominio;
				$insert_csv['nombreLote'] = $csv_line[0];
				$insert_csv['referencia'] = $csv_line[1];

			}
			$i++;

			$query = $this->db-> query('SELECT idLote, nombreLote, status FROM lotes where idCondominio = "'.$insert_csv['idCondominio'].'" and nombreLote = "'.$insert_csv['nombreLote'].'" and status = 1');

			foreach ($query->result_array() as $row)
			{
			}

			$this->db->trans_begin();


		$this->db->query("UPDATE lotes SET referencia = '".$insert_csv['referencia']."'
         WHERE idLote IN ('".$row['idLote']."') and nombreLote = '".$insert_csv['nombreLote']."' ");



			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			}
			else {
				$this->db->trans_commit();
			}

		}
		fclose($fp) or die("can't close file");
		return true;
	}





	public function aplicaLiberaciones($idCondominio, $valida){
		$count=0;
		$fp = fopen($_FILES['liberacion']['tmp_name'],'r') or die("can't open file");
		while($csv_line = fgetcsv($fp,1024)) {
			$count++;
			if($count == 1) {
				continue;
			}
			for($i = 0, $j = count($csv_line); $i < $j; $i++) {
				$insert_csv = array();
				$insert_csv['idCondominio'] = $idCondominio;
				$insert_csv['nombreLote'] = $csv_line[0];
				$insert_csv['precio'] = $csv_line[1];
	
			}
			$i++;
		  
			  $query = $this->db-> query('SELECT idLote, nombreLote, sup FROM lotes where idCondominio = "'.$insert_csv['idCondominio'].'" and nombreLote = "'.$insert_csv['nombreLote'].'" and status = 1');
	
	 foreach ($query->result_array() as $row)
				  {
					   }
	
				 $this->db->trans_begin();
				 
	$this->db->query("UPDATE historial_documento SET status = 0 WHERE status = 1 and idLote IN ('".$row['idLote']."') ");
	$this->db->query("UPDATE cliente SET status = 0 WHERE status = 1 and idLote IN ('".$row['idLote']."') ");
	$this->db->query("UPDATE historial_enganche SET status = 0, comentarioCancelacion = 'LOTE LIBERADO' WHERE status = 1 and idLote IN ('".$row['idLote']."') ");
	$this->db->query("UPDATE historial_lotes SET status = 0 WHERE status = 1 and idLote IN ('".$row['idLote']."') ");
	
	if ($valida == 0){
	
	$this->db->query("UPDATE lotes SET idStatusContratacion = 0, idMovimiento = 0, comentario = 'NULL', idCliente = 0, user = 'NULL', perfil = 'NULL ', fechaVenc = '0000-00-00 00:00:00', modificado = '0000-00-00 00:00:00', ubicacion = 'NULL', totalNeto = 0.00, totalNeto2 = 0.00,
		 totalValidado = 0.00, validacionEnganche = 'NULL', fechaSolicitudValidacion = '0000-00-00 00:00:00', fechaRL = '0000-00-00 00:00:00', 
		 firmaRL = 'NULL', comentarioLiberacion = 'LIBERADO', observacionLiberacion = 'Liberado por Yola', idStatusLote = 1, fechaLiberacion = '".date("Y-m-d H:i:s")."', userLiberacion = '".$this->session->userdata('username')."',
		 precio = '".$insert_csv['precio']."', total = (('".$row['sup']."') * '".$insert_csv['precio']."'),
		 enganche = ((('".$row['sup']."') * '".$insert_csv['precio']."') * 0.1), 
		 saldo = ((('".$row['sup']."') * '".$insert_csv['precio']."') - ((('".$row['sup']."') * '".$insert_csv['precio']."') * 0.1))
		 WHERE idLote IN ('".$row['idLote']."') and status = 1 ");
		
	} else if ($valida == 1){
	
		 $this->db->query("UPDATE lotes SET idStatusContratacion = 0, idMovimiento = 0, comentario = 'NULL', idCliente = 0, user = 'NULL', perfil = 'NULL ', fechaVenc = '0000-00-00 00:00:00', modificado = '0000-00-00 00:00:00', ubicacion = 'NULL', totalNeto = 0.00, totalNeto2 = 0.00,
		 totalValidado = 0.00, validacionEnganche = 'NULL', fechaSolicitudValidacion = '0000-00-00 00:00:00', fechaRL = '0000-00-00 00:00:00', 
		 firmaRL = 'NULL', comentarioLiberacion = 'LIBERADO', observacionLiberacion = 'Liberado por Yola', idStatusLote = 101, fechaLiberacion = '".date("Y-m-d H:i:s")."', userLiberacion = '".$this->session->userdata('username')."',
		 precio = '".$insert_csv['precio']."', total = (('".$row['sup']."') * '".$insert_csv['precio']."'),
		 enganche = ((('".$row['sup']."') * '".$insert_csv['precio']."') * 0.1), 
		 saldo = ((('".$row['sup']."') * '".$insert_csv['precio']."') - ((('".$row['sup']."') * '".$insert_csv['precio']."') * 0.1))
		 WHERE idLote IN ('".$row['idLote']."') and status = 1 ");
	
	}
	
				 if ($this->db->trans_status() === FALSE) {
						 $this->db->trans_rollback();
				   }
				 else {
						 $this->db->trans_commit();
				 }
		}
		fclose($fp) or die("can't close file");
		return true;

	}    
	

	function getRevision2() {

		$this->db->select("hd.idHistorialLote, hd.nombreLote, hd.idStatusContratacion, hd.idMovimiento, hd.modificado, hd.fechaVenc, l.idLote, cl.fechaApartado,
							cond.nombre as nombreCondominio, l.comentario, res.nombreResidencial, hd.status, 
							
                            CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
                            CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
                            CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador
							
							
							");

		$this->db->join('clientes cl', 'hd.idCliente = cl.id_cliente');
		$this->db->join('lotes l', 'hd.idLote = l.idLote');
		$this->db->join('condominios cond', 'cond.idCondominio = l.idCondominio');
		$this->db->join('residenciales res', 'cond.idResidencial = res.idResidencial');

		
		$this->db->join('usuarios asesor', 'cl.id_asesor = asesor.id_usuario', 'LEFT');
		$this->db->join('usuarios coordinador', 'cl.id_coordinador = coordinador.id_usuario', 'LEFT');
		$this->db->join('usuarios gerente', 'cl.id_gerente = gerente.id_usuario', 'LEFT');
		


		$this->db->where('(hd.idStatusContratacion=2 AND hd.idMovimiento=4 AND cl.status=1
							OR hd.idStatusContratacion=2 AND hd.idMovimiento=74 AND cl.status=1
							OR hd.idStatusContratacion=2 AND hd.idMovimiento=84 AND cl.status=1
							OR hd.idStatusContratacion=2 AND hd.idMovimiento=93 AND cl.status=1)');

		$this->db->where("hd.status",1);
		$this->db->where("l.status",1);

		$this->db->order_by('hd.modificado','ASC');

		$query = $this->db->get('historial_lotes hd');
		return $query->result();
	}


	/*function getRevision5($datos) {
		$query = $this->db->query("SELECT idHistorialLote, hd.nombreLote, hd.idStatusContratacion, hd.idMovimiento, hd.modificado, 
		hd.fechaVenc, l.idLote, cl.fechaApartado, cond.nombre as nombreCondominio,
		l.comentario, res.nombreResidencial,
		hd.status, l.totalNeto, totalValidado, l.totalNeto2, 
		CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
		CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
		CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador, l.referencia,
		UPPER(CASE CONCAT(u.nombre,' ', u.apellido_paterno, ' ', u.apellido_materno) WHEN '' THEN hd.usuario ELSE 
		CONCAT(u.nombre,' ', u.apellido_paterno, ' ', u.apellido_materno) END) nombreUsuario
		FROM historial_lotes hd
		INNER JOIN clientes cl ON hd.idCliente = cl.id_cliente AND cl.status = 1
		INNER JOIN lotes l ON hd.idLote = l.idLote
		INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio
		INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
		LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
		LEFT JOIN usuarios u ON CAST(u.id_usuario AS VARCHAR(45)) = CAST(hd.usuario AS VARCHAR(45))
		WHERE (hd.idStatusContratacion = '".$datos['one']["idStatusContratacion"]."' and hd.idMovimiento  = '".$datos['one']["idMovimiento"]."'
		OR hd.idStatusContratacion = '".$datos['two']["idStatusContratacion"]."' and hd.idMovimiento  = '".$datos['two']["idMovimiento"]."')  AND hd.status = 1 ORDER BY hd.modificado ASC");
		return $query->result();
	}*/
	function getRevision5($datos,$typeTransaction, $beginDate, $endDate, $where) {
        if ($typeTransaction == 1 || $typeTransaction == 3) {  // FIRST LOAD || SEARCH BY DATE RANGE
            $filter = " AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
            $filterTwo = "";
        } else if($typeTransaction == 2) { // SEARCH BY LOTE
            $filter = "";
            $filterTwo = " AND hl.modificado = $where";
        }



        $query = $this->db->query("SELECT idHistorialLote, hd.nombreLote, hd.idStatusContratacion, hd.idMovimiento, hd.modificado, 
		hd.fechaVenc, l.idLote, cl.fechaApartado, cond.nombre as nombreCondominio,
		l.comentario, res.nombreResidencial,
		hd.status, l.totalNeto, totalValidado, l.totalNeto2, 
		CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
		CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
		CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador, l.referencia,
		UPPER(CASE CONCAT(u.nombre,' ', u.apellido_paterno, ' ', u.apellido_materno) WHEN '' THEN hd.usuario ELSE 
		CONCAT(u.nombre,' ', u.apellido_paterno, ' ', u.apellido_materno) END) nombreUsuario
		FROM historial_lotes hd
		INNER JOIN clientes cl ON hd.idCliente = cl.id_cliente AND cl.status = 1
		INNER JOIN lotes l ON hd.idLote = l.idLote
		INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio
		INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
		LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
		LEFT JOIN usuarios u ON CAST(u.id_usuario AS VARCHAR(45)) = CAST(hd.usuario AS VARCHAR(45))
		WHERE (hd.idStatusContratacion = '".$datos['one']["idStatusContratacion"]."' and hd.idMovimiento  = '".$datos['one']["idMovimiento"]."'
		OR hd.idStatusContratacion = '".$datos['two']["idStatusContratacion"]."' and hd.idMovimiento  = '".$datos['two']["idMovimiento"]."')  
		AND hd.status = 1 ".$filter." ORDER BY hd.modificado ASC");
        return $query->result();
        /*$query = $this->db->query("SELECT idHistorialLote, hd.nombreLote, hd.idStatusContratacion, hd.idMovimiento, hd.modificado,
		hd.fechaVenc, l.idLote, cl.fechaApartado, cond.nombre as nombreCondominio,
		l.comentario, res.nombreResidencial,
		hd.status, l.totalNeto, totalValidado, l.totalNeto2, 
		CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
		CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
		CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador, l.referencia,
		UPPER(CASE CONCAT(u.nombre,' ', u.apellido_paterno, ' ', u.apellido_materno) WHEN '' THEN hd.usuario ELSE 
		CONCAT(u.nombre,' ', u.apellido_paterno, ' ', u.apellido_materno) END) nombreUsuario
		FROM historial_lotes hd
		INNER JOIN clientes cl ON hd.idCliente = cl.id_cliente AND cl.status = 1
		INNER JOIN lotes l ON hd.idLote = l.idLote
		INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio
		INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
		LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
		LEFT JOIN usuarios u ON CAST(u.id_usuario AS VARCHAR(45)) = CAST(hd.usuario AS VARCHAR(45))
		WHERE (hd.idStatusContratacion = '".$datos['one']["idStatusContratacion"]."' and hd.idMovimiento  = '".$datos['one']["idMovimiento"]."'
		OR hd.idStatusContratacion = '".$datos['two']["idStatusContratacion"]."' and hd.idMovimiento  = '".$datos['two']["idMovimiento"]."')  AND hd.status = 1 ORDER BY hd.modificado ASC");
        return $query->result();*/
	}
	

	function getRevision10($typeTransaction, $beginDate, $endDate, $where) {

        if ($typeTransaction == 1 || $typeTransaction == 3) {  // FIRST LOAD || SEARCH BY DATE RANGE
            $filter = " AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
            $filterTwo = "";
        } else if($typeTransaction == 2) { // SEARCH BY LOTE
            $filter = "";
            $filterTwo = " AND hl.modificado = $where";
        }
        $query = $this->db->query("SELECT idHistorialLote, hd.nombreLote, hd.idStatusContratacion, hd.idMovimiento, hd.modificado, 
		hd.fechaVenc, l.idLote, cl.fechaApartado, cond.nombre as nombreCondominio,
		l.comentario, res.nombreResidencial, l.referencia,
		hd.status, hd.comentario,
		CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombreCliente,
		CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
		CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
		CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
		UPPER(CASE CONCAT(u.nombre,' ', u.apellido_paterno, ' ', u.apellido_materno) WHEN '' THEN hd.usuario ELSE 
		CONCAT(u.nombre,' ', u.apellido_paterno, ' ', u.apellido_materno) END) nombreUsuario
		FROM historial_lotes hd
		INNER JOIN clientes cl ON hd.idCliente = cl.id_cliente
		INNER JOIN lotes l ON hd.idLote = l.idLote AND l.status = 1
		INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio
		INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
		LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
		LEFT JOIN usuarios u ON CAST(u.id_usuario AS VARCHAR(45)) = CAST(hd.usuario AS VARCHAR(45))
		WHERE (hd.idStatusContratacion = 10 and hd.idMovimiento  = 40 and cl.status = 1)
		AND hd.status = 1 ".$filter." ORDER BY hd.modificado asc");
        return $query->result();



		/*$query = $this->db->query("SELECT idHistorialLote, hd.nombreLote, hd.idStatusContratacion, hd.idMovimiento, hd.modificado,
		hd.fechaVenc, l.idLote, cl.fechaApartado, cond.nombre as nombreCondominio,
		l.comentario, res.nombreResidencial,
		hd.status, hd.comentario,
		CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombreCliente,
		CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
		CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
		CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
		UPPER(CASE CONCAT(u.nombre,' ', u.apellido_paterno, ' ', u.apellido_materno) WHEN '' THEN hd.usuario ELSE
		CONCAT(u.nombre,' ', u.apellido_paterno, ' ', u.apellido_materno) END) nombreUsuario
		FROM historial_lotes hd
		INNER JOIN clientes cl ON hd.idCliente = cl.id_cliente
		INNER JOIN lotes l ON hd.idLote = l.idLote AND l.status = 1
		INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio
		INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
		LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
		LEFT JOIN usuarios u ON CAST(u.id_usuario AS VARCHAR(45)) = CAST(hd.usuario AS VARCHAR(45))
		WHERE (hd.idStatusContratacion = 10 and hd.idMovimiento  = 40 and cl.status = 1)
		AND hd.status = 1 ORDER BY hd.modificado asc");
        return $query->result();*/
	}
	function getRevision7() {
		$query = $this->db->query("SELECT idHistorialLote, hd.nombreLote, hd.idStatusContratacion, hd.idMovimiento, hd.modificado, 
		hd.fechaVenc, lotes.idLote, cl.fechaApartado, cond.nombre as nombreCondominio,
		lotes.comentario, res.nombreResidencial,
		hd.status, hd.comentario,
		CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
		CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
		CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
		UPPER(CASE CONCAT(u.nombre,' ', u.apellido_paterno, ' ', u.apellido_materno) WHEN '' THEN hd.usuario ELSE 
		CONCAT(u.nombre,' ', u.apellido_paterno, ' ', u.apellido_materno) END) nombreUsuario
		FROM historial_lotes hd
		INNER JOIN clientes cl ON hd.idCliente = cl.id_cliente
		INNER JOIN lotes lotes ON hd.idLote = lotes.idLote AND lotes.status = 1
		INNER JOIN condominios cond ON cond.idCondominio = lotes.idCondominio
		INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
		LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
		--LEFT JOIN usuarios u ON CAST(u.id_usuario AS VARCHAR(45)) = CAST(hd.usuario AS VARCHAR(45))
		LEFT JOIN usuarios u ON CAST(u.id_usuario AS VARCHAR(45)) = (SELECT TOP 1 usuario FROM historial_lotes WHERE idLote = lotes.idLote AND status = 1 AND idStatusContratacion = 6 ORDER BY modificado DESC)
		WHERE (hd.idStatusContratacion =5 and hd.idMovimiento=22 and cl.status = 1
		or hd.idStatusContratacion = 3 and hd.idMovimiento = 82 and cl.status = 1)
		AND hd.status = 1 ORDER BY hd.modificado ASC");
		return $query->result();
	}

	function getDirectores()
	{
		$this->db->select("*");
		$this->db->where('id_rol', 2); /*le indicamos que sean subdirectores*/
		$this->db->where('estatus', 1); /*le indicamos que sean subdirectores*/
		$query = $this->db->get('usuarios');
		return $query->result();
	}




	public function get_auts_by_lote_directivos($idLote)
	{
		$condicion;
		if($this->session->userdata('id_rol') == 1)
		{
			$condicion ='';
			/*SELECT residencial.nombreResidencial, condominio.nombre as nombreCondominio,
		lotes.nombreLote, autorizaciones.estatus, autorizaciones.autorizacion, autorizaciones.fecha_creacion,
		users.username as sol, users1.username as aut, id_autorizacion, autorizaciones.idLote
		FROM autorizaciones
		inner join lotes on lotes.idLote = autorizaciones.idLote
		inner join condominio on condominio.idCondominio = lotes.idCondominio
		inner join residencial on residencial.idResidencial = condominio.idResidencial
		inner join users on autorizaciones.id_sol = users.idAsesor
		inner join users as users1 on autorizaciones.id_aut = users1.id*/
			$query = $this->db-> query('SELECT res.nombreResidencial, cond.nombre as nombreCondominio, lotes.nombreLote, aut.estatus,
		aut.autorizacion, aut.fecha_creacion, users.usuario as sol, users1.usuario as aut, id_autorizacion, aut.idLote
		FROM autorizaciones aut
		inner join lotes on lotes.idLote = aut.idLote 
		inner join condominios cond on cond.idCondominio = lotes.idCondominio 
		inner join residenciales res on res.idResidencial = cond.idResidencial 
		inner join usuarios as users on aut.id_sol = users.id_usuario 
		inner join usuarios as users1 on aut.id_aut = users1.id_usuario 
		where aut.estatus = 3 and '.$condicion.' lotes.idLote='.$idLote);

		}
		else
		{
			$condicion = ' autorizaciones.id_aut ='.$this->session->userdata('id_usuario').' AND';
			/*$query = $this->db-> query('SELECT residencial.nombreResidencial, condominio.nombre as nombreCondominio,
		lotes.nombreLote, autorizaciones.estatus, autorizaciones.autorizacion, autorizaciones.fecha_creacion,
		users.username as sol, users1.username as aut, id_autorizacion, autorizaciones.idLote
		FROM autorizaciones
		inner join lotes on lotes.idLote = autorizaciones.idLote
		inner join condominio on condominio.idCondominio = lotes.idCondominio
		inner join residencial on residencial.idResidencial = condominio.idResidencial
		inner join users on autorizaciones.id_sol = users.idAsesor
		inner join users as users1 on autorizaciones.id_aut = users1.id
		where autorizaciones.estatus = 1 and '.$condicion.' lotes.idLote='.$idLote);*/
			$query = $this->db-> query("SELECT residencial.nombreResidencial, condominio.nombre as nombreCondominio, 
			lotes.nombreLote, autorizaciones.estatus, lotes.idLote, condominio.idCondominio,
		autorizaciones.autorizacion, autorizaciones.fecha_creacion, id_autorizacion, autorizaciones.idLote,
		CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as sol, 
		CONCAT(autorizador.nombre,' ', autorizador.apellido_paterno, ' ', autorizador.apellido_materno) as aut
		FROM autorizaciones 
		inner join lotes on lotes.idLote = autorizaciones.idLote 
		inner join condominios condominio on condominio.idCondominio = lotes.idCondominio 
		inner join residenciales residencial on residencial.idResidencial = condominio.idResidencial 
		inner join usuarios as asesor on autorizaciones.id_sol = asesor.id_usuario 
		inner join usuarios as autorizador on autorizaciones.id_aut = autorizador.id_usuario
		where autorizaciones.estatus = 1 and ".$condicion." lotes.idLote=".$idLote);


			/*
			 		SELECT residencial.nombreResidencial, condominio.nombre as nombreCondominio, lotes.nombreLote, autorizaciones.estatus,
		autorizaciones.autorizacion, autorizaciones.fecha_creacion, id_autorizacion, autorizaciones.idLote,
		CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as sol,
		CONCAT(autorizador.nombre,' ', autorizador.apellido_paterno, ' ', autorizador.apellido_materno) as aut

		FROM autorizaciones
		inner join lotes on lotes.idLote = autorizaciones.idLote
		inner join condominios condominio on condominio.idCondominio = lotes.idCondominio
		inner join residenciales residencial on residencial.idResidencial = condominio.idResidencial
		inner join usuarios as asesor on autorizaciones.id_sol = asesor.id_usuario
		inner join usuarios as autorizador on autorizaciones.id_aut = autorizador.id_usuario
		where autorizaciones.estatus = 1 and autorizaciones.id_aut =1630 AND lotes.idLote=39636
			 * */
		}

		return $query->result_array();
	}




	/*autorizaciones nuevo sistema*/
	public function insertAutorizacion($data)
	{
		$this->db->insert('autorizaciones',$data);
		return $this->db->affected_rows();
	}

	public function updAutFromDC($idAut, $data)
	{
		$this->db->where("id_autorizacion",$idAut);
		$this->db->update('autorizaciones',$data);
		return $this->db->affected_rows();
	}
	public function insertAutFromDC($data)
	{
		$this->db->insert('historial_autorizaciones',$data);
		return $this->db->affected_rows();
	}

	/*mostrar autorizaciones para Rigel - DC ROL 1*/
	public function autsByDC(){/*SELECT cliente.idCliente, nombreLote, razonSocial, nombreResidencial,
				condominio.nombre as nombreCondominio, cliente.status, cliente.idAsesor, condominio.idCondominio,
				lotes.idLote, cliente.autorizacion, cliente.fechaApartado, asesor.nombreAsesor, cliente.primerNombre,
				cliente.segundoNombre, cliente.apellidoPaterno, cliente.apellidoMaterno, GROUP_CONCAT(DISTINCT autorizaciones.autorizacion) motivoAut
				FROM cliente
				INNER JOIN lotes ON cliente.idLote = lotes.idLote
				INNER JOIN condominio ON lotes.idCondominio = condominio.idCondominio
				INNER JOIN residencial ON condominio.idResidencial = residencial.idResidencial
				INNER JOIN deposito_seriedad ON deposito_seriedad.idCliente = cliente.idcliente
				INNER JOIN autorizaciones ON autorizaciones.idLote = lotes.idLote
				INNER JOIN asesor ON asesor.idAsesor = autorizaciones.id_sol
				WHERE cliente.status = 1  AND autorizaciones.estatus = 3
				GROUP BY autorizaciones.idLote ORDER BY cliente.fechaApartado DESC*/
		$query = $this->db-> query("SELECT cl.id_cliente, nombreLote, cl.rfc, res.nombreResidencial,
				cond.nombre as nombreCondominio, cl.status, cl.id_asesor, cond.idCondominio,
				lotes.idLote, cl.fechaApartado, 
				CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
                CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
				CONCAT(cl.nombre,' ', cl.apellido_paterno,' ', cl.apellido_materno) as cliente, motivoAut
				FROM clientes cl
				INNER JOIN lotes lotes ON cl.idLote = lotes.idLote
				INNER JOIN condominios cond ON lotes.idCondominio = cond.idCondominio
				INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
				INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
				INNER JOIN autorizaciones aut ON aut.idLote = lotes.idLote
				INNER JOIN usuarios asesor ON asesor.id_usuario = aut.id_sol
                INNER JOIN usuarios gerente ON gerente.id_usuario = cl.id_gerente
				WHERE cl.status = 1 AND aut.estatus=3
				GROUP BY cl.id_cliente, nombreLote, cl.rfc, res.nombreResidencial,
				cond.nombre, cl.status, cl.id_asesor, cond.idCondominio,
				lotes.idLote, cl.fechaApartado, 
				CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
                CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
				CONCAT(cl.nombre,' ', cl.apellido_paterno,' ', cl.apellido_materno), motivoAut
				ORDER BY cl.fechaApartado DESC;");
		return $query->result();
	}


	// filtro de lote por condominios y residencial DOCUMENTACION ASESOR INICIO

    public function getLotesAsesor($condominio,$residencial){
        switch ($this->session->userdata('id_rol')) {
			case '2':
				$sede =  $this->session->userdata('id_sede');

                $query = $this->db->query("SELECT lotes.idLote, nombreLote, idStatusLote, clientes.id_asesor, '1' venta_compartida  FROM lotes
                                        INNER JOIN clientes ON clientes.idLote = lotes.idLote WHERE clientes.id_gerente IN (SELECT id_usuario FROM usuarios WHERE id_rol = 3 AND id_sede IN (".$sede.") and id_lider = ".$this->session->userdata('id_usuario').") 
                                        AND lotes.status = 1 AND clientes.status = 1 AND lotes.idCondominio = $condominio
                                        UNION ALL
                                        SELECT lotes.idLote, nombreLote, idStatusLote, vc.id_asesor, '2' venta_compartida FROM lotes
                                        INNER JOIN clientes ON clientes.idLote = lotes.idLote 
                                        INNER JOIN ventas_compartidas vc ON vc.id_cliente = clientes.id_cliente
                                        WHERE vc.id_gerente IN (SELECT id_usuario FROM usuarios WHERE id_rol = 3 AND id_sede IN (".$sede.") and id_lider = ".$this->session->userdata('id_usuario').")  AND vc.estatus = 1 AND 
                                        clientes.status = 1 AND lotes.status = 1 AND lotes.idCondominio = $condominio ORDER BY lotes.idLote");
				break;
            case '3': // GERENTE
										$query = $this->db->query("SELECT lotes.idLote, nombreLote, idStatusLote, clientes.id_asesor, '1' venta_compartida FROM lotes
				INNER JOIN clientes ON clientes.idLote = lotes.idLote WHERE (clientes.id_asesor = ".$this->session->userdata('id_usuario')." OR 
				clientes.id_coordinador = ".$this->session->userdata('id_usuario')." OR clientes.id_gerente = ".$this->session->userdata('id_usuario').") AND lotes.status = 1
				AND clientes.status = 1 AND lotes.idCondominio = $condominio
				UNION ALL
				SELECT lotes.idLote, nombreLote, idStatusLote, vc.id_asesor, '2' venta_compartida FROM lotes
				INNER JOIN clientes ON clientes.idLote = lotes.idLote 
				INNER JOIN ventas_compartidas vc ON vc.id_cliente = clientes.id_cliente
				WHERE (vc.id_asesor = ".$this->session->userdata('id_usuario')." OR vc.id_coordinador = ".$this->session->userdata('id_usuario')." 
				OR vc.id_gerente = ".$this->session->userdata('id_usuario').") AND vc.estatus = 1 AND 
				clientes.status = 1 AND lotes.status = 1 AND lotes.idCondominio = $condominio ORDER BY lotes.idLote");
                break;
            case '4': // ASISTENTE DIRECTOR
                $query = $this->db->query("SELECT lotes.idLote, nombreLote, idStatusLote, clientes.id_asesor FROM lotes
                                        INNER JOIN clientes ON clientes.idLote = lotes.idLote WHERE lotes.status = 1
                                        AND clientes.status = 1 AND lotes.idCondominio = $condominio
                                        UNION ALL
                                        SELECT lotes.idLote, nombreLote, idStatusLote, vc.id_asesor FROM lotes
                                        INNER JOIN clientes ON clientes.idLote = lotes.idLote 
                                        INNER JOIN ventas_compartidas vc ON vc.id_cliente = clientes.id_cliente
                                        WHERE vc.estatus = 1 AND clientes.status = 1 AND lotes.status = 1 AND lotes.idCondominio = $condominio ORDER BY lotes.idLote");
                break;
            case '5': // ASISTENTE SUBDIRECTOR
			
			    if ($this->session->userdata('id_usuario') == 30) // MJ: VALERIA PALACIOS VERÁ LO DE SLP + TIJUANA
					$sede = "'".$this->session->userdata('id_sede')."', '8'";
				else if ($this->session->userdata('id_usuario') == 7096 || $this->session->userdata('id_usuario') == 7097) // MJ: EDGAR Y GRISELL VERÁN LO DE CDMX + SMA
					$sede = "'".$this->session->userdata('id_sede')."', '9'";
				else
					$sede = ($this->session->userdata('id_sede') == 3 || $this->session->userdata('id_sede') == 6) ? "'3', '6'" : "'".$this->session->userdata('id_sede')."'";

                $query = $this->db->query("SELECT lotes.idLote, nombreLote, idStatusLote, clientes.id_asesor, '1' venta_compartida  FROM lotes
                                        INNER JOIN clientes ON clientes.idLote = lotes.idLote WHERE clientes.id_gerente IN (SELECT id_usuario FROM usuarios WHERE id_rol = 3 AND id_sede IN ($sede)) 
                                        AND lotes.status = 1 AND clientes.status = 1 AND lotes.idCondominio = $condominio
                                        UNION ALL
                                        SELECT lotes.idLote, nombreLote, idStatusLote, vc.id_asesor, '2' venta_compartida FROM lotes
                                        INNER JOIN clientes ON clientes.idLote = lotes.idLote 
                                        INNER JOIN ventas_compartidas vc ON vc.id_cliente = clientes.id_cliente
                                        WHERE vc.id_gerente IN (SELECT id_usuario FROM usuarios WHERE id_rol = 3 AND id_sede IN ($sede))  AND vc.estatus = 1 AND 
                                        clientes.status = 1 AND lotes.status = 1 AND lotes.idCondominio = $condominio ORDER BY lotes.idLote");
                break;
            case '6': // ASISTENTE GERENTE
                $query = $this->db->query("SELECT lotes.idLote, nombreLote, idStatusLote, clientes.id_asesor, '1' venta_compartida  FROM lotes
                                        INNER JOIN clientes ON clientes.idLote = lotes.idLote WHERE (clientes.id_asesor = ".$this->session->userdata('id_lider')." OR 
                                        clientes.id_coordinador = ".$this->session->userdata('id_lider')." OR clientes.id_gerente = ".$this->session->userdata('id_lider').") AND lotes.status = 1
                                        AND clientes.status = 1 AND lotes.idCondominio = $condominio
                                        UNION ALL
                                        SELECT lotes.idLote, nombreLote, idStatusLote, vc.id_asesor, '2' venta_compartida  FROM lotes
                                        INNER JOIN clientes ON clientes.idLote = lotes.idLote 
                                        INNER JOIN ventas_compartidas vc ON vc.id_cliente = clientes.id_cliente
                                        WHERE (vc.id_asesor = ".$this->session->userdata('id_lider')." OR vc.id_coordinador = ".$this->session->userdata('id_lider')." 
                                        OR vc.id_gerente = ".$this->session->userdata('id_lider').") AND vc.estatus = 1 AND 
                                        clientes.status = 1 AND lotes.status = 1 AND lotes.idCondominio = $condominio ORDER BY lotes.idLote");
                break;
            case '7': // ASESOR
										$query = $this->db->query("SELECT lotes.idLote, nombreLote, idStatusLote, clientes.id_asesor, '1' venta_compartida FROM lotes
										INNER JOIN clientes ON clientes.idLote = lotes.idLote WHERE (clientes.id_asesor = ".$this->session->userdata('id_usuario')." OR 
										clientes.id_coordinador = ".$this->session->userdata('id_usuario')." OR clientes.id_gerente = ".$this->session->userdata('id_usuario').") AND lotes.status = 1
										AND clientes.status = 1 AND lotes.idCondominio = $condominio
										UNION ALL
										SELECT lotes.idLote, nombreLote, idStatusLote, vc.id_asesor, '2' venta_compartida FROM lotes
										INNER JOIN clientes ON clientes.idLote = lotes.idLote 
										INNER JOIN ventas_compartidas vc ON vc.id_cliente = clientes.id_cliente
										WHERE (vc.id_asesor = ".$this->session->userdata('id_usuario')." OR vc.id_coordinador = ".$this->session->userdata('id_usuario')." 
										OR vc.id_gerente = ".$this->session->userdata('id_usuario').") AND vc.estatus = 1 AND 
										clientes.status = 1 AND lotes.status = 1 AND lotes.idCondominio = $condominio ORDER BY lotes.idLote");
                break;
            case '9': // COORDINADOR
              /*  $query = $this->db->query("SELECT lotes.idLote, nombreLote, idStatusLote, clientes.id_asesor FROM lotes
                                        INNER JOIN clientes ON clientes.idLote = lotes.idLote WHERE (clientes.id_asesor = ".$this->session->userdata('id_usuario')." 
                                        OR clientes.id_coordinador = ".$this->session->userdata('id_usuario').") AND lotes.status = 1
                                        AND clientes.status = 1 AND lotes.idCondominio = $condominio ORDER BY lotes.idLote");*/
										$query = $this->db->query("SELECT lotes.idLote, nombreLote, idStatusLote, clientes.id_asesor, '1' venta_compartida FROM lotes
										INNER JOIN clientes ON clientes.idLote = lotes.idLote WHERE (clientes.id_asesor = ".$this->session->userdata('id_usuario')." OR 
										clientes.id_coordinador = ".$this->session->userdata('id_usuario')." OR clientes.id_gerente = ".$this->session->userdata('id_usuario').") AND lotes.status = 1
										AND clientes.status = 1 AND lotes.idCondominio = $condominio
										UNION ALL
										SELECT lotes.idLote, nombreLote, idStatusLote, vc.id_asesor, '2' venta_compartida FROM lotes
										INNER JOIN clientes ON clientes.idLote = lotes.idLote 
										INNER JOIN ventas_compartidas vc ON vc.id_cliente = clientes.id_cliente
										WHERE (vc.id_asesor = ".$this->session->userdata('id_usuario')." OR vc.id_coordinador = ".$this->session->userdata('id_usuario')." 
										OR vc.id_gerente = ".$this->session->userdata('id_usuario').") AND vc.estatus = 1 AND 
										clientes.status = 1 AND lotes.status = 1 AND lotes.idCondominio = $condominio ORDER BY lotes.idLote");
                break;
            default: // SEE EVERYTHING
                $query = $this->db->query("SELECT lotes.idLote, nombreLote, idStatusLote, clientes.id_asesor FROM lotes
                                        INNER JOIN clientes ON clientes.idLote = lotes.idLote WHERE lotes.status = 1
                                        AND clientes.status = 1 AND lotes.idCondominio = $condominio ORDER BY lotes.idLote");
                break;
        }
        if($query){
            $query = $query->result_array();
            return $query;
        }
    }
    public function getLotesAsesorTest($condominio,$residencial){
        switch ($this->session->userdata('id_rol')) {
            case '3': // GERENTE
                $query = $this->db->query("SELECT lotes.idLote, nombreLote, idStatusLote, clientes.id_asesor FROM lotes
                                        INNER JOIN clientes ON clientes.idLote = lotes.idLote WHERE (clientes.id_asesor = ".$this->session->userdata('id_usuario')." OR 
                                        clientes.id_coordinador = ".$this->session->userdata('id_usuario')." OR 
                                        clientes.id_gerente = ".$this->session->userdata('id_usuario').") AND lotes.status = 1
                                        AND clientes.status = 1 AND lotes.idCondominio = $condominio ORDER BY lotes.idLote");
                break;
            case '4': // ASISTENTE DIRECTOR
                $query = $this->db->query("SELECT lotes.idLote, nombreLote, idStatusLote, clientes.id_asesor FROM lotes
                                        INNER JOIN clientes ON clientes.idLote = lotes.idLote WHERE lotes.status = 1
                                        AND clientes.status = 1 AND lotes.idCondominio = $condominio
                                        UNION ALL
                                        SELECT lotes.idLote, nombreLote, idStatusLote, vc.id_asesor FROM lotes
                                        INNER JOIN clientes ON clientes.idLote = lotes.idLote 
                                        INNER JOIN ventas_compartidas vc ON vc.id_cliente = clientes.id_cliente
                                        WHERE vc.estatus = 1 AND clientes.status = 1 AND lotes.status = 1 AND lotes.idCondominio = $condominio ORDER BY lotes.idLote");
                break;
            case '5': // ASISTENTE SUBDIRECTOR
            
                $sede = ($this->session->userdata('id_sede') == 3 || $this->session->userdata('id_sede') == 6) ? '3,6' : $this->session->userdata('id_sede');

                $query = $this->db->query("SELECT lotes.idLote, nombreLote, idStatusLote, clientes.id_asesor, '1' venta_compartida  FROM lotes
                                        INNER JOIN clientes ON clientes.idLote = lotes.idLote WHERE clientes.id_gerente IN (SELECT id_usuario FROM usuarios WHERE id_rol = 3 AND id_sede IN (".$sede.")) 
                                        AND lotes.status = 1 AND clientes.status = 1 AND lotes.idCondominio = $condominio
                                       UNION ALL
                                       SELECT lotes.idLote, nombreLote, idStatusLote, vc.id_asesor, '2' venta_compartida FROM lotes
                                        INNER JOIN clientes ON clientes.idLote = lotes.idLote 
                                        INNER JOIN ventas_compartidas vc ON vc.id_cliente = clientes.id_cliente
                                        WHERE vc.id_gerente IN (SELECT id_usuario FROM usuarios WHERE id_rol = 3 AND id_sede IN (".$sede."))  AND vc.estatus = 1 AND 
                                        clientes.status = 1 AND lotes.status = 1 AND lotes.idCondominio = $condominio ORDER BY lotes.idLote");
                break;
            case '6': // ASISTENTE GERENTE
                $query = $this->db->query("SELECT lotes.idLote, nombreLote, idStatusLote, clientes.id_asesor, '1' venta_compartida  FROM lotes
                                        INNER JOIN clientes ON clientes.idLote = lotes.idLote WHERE (clientes.id_asesor = ".$this->session->userdata('id_lider')." OR 
                                        clientes.id_coordinador = ".$this->session->userdata('id_lider')." OR clientes.id_gerente = ".$this->session->userdata('id_lider').") AND lotes.status = 1
                                        AND clientes.status = 1 AND lotes.idCondominio = $condominio
                                        UNION ALL
                                        SELECT lotes.idLote, nombreLote, idStatusLote, vc.id_asesor, '2' venta_compartida  FROM lotes
                                        INNER JOIN clientes ON clientes.idLote = lotes.idLote 
                                        INNER JOIN ventas_compartidas vc ON vc.id_cliente = clientes.id_cliente
                                        WHERE (vc.id_asesor = ".$this->session->userdata('id_lider')." OR vc.id_coordinador = ".$this->session->userdata('id_lider')." 
                                        OR vc.id_gerente = ".$this->session->userdata('id_lider').") AND vc.estatus = 1 AND 
                                        clientes.status = 1 AND lotes.status = 1 AND lotes.idCondominio = $condominio ORDER BY lotes.idLote");
                break;
            case '7': // ASESOR
                $query = $this->db->query("SELECT lotes.idLote, nombreLote, idStatusLote, clientes.id_asesor FROM lotes
                                        INNER JOIN clientes ON clientes.idLote = lotes.idLote WHERE clientes.id_asesor = ".$this->session->userdata('id_usuario')." AND lotes.status = 1
                                        AND clientes.status = 1 AND lotes.idCondominio = $condominio ORDER BY lotes.idLote");
                break;
            case '9': // COORDINADOR
                $query = $this->db->query("SELECT lotes.idLote, nombreLote, idStatusLote, clientes.id_asesor FROM lotes
                                        INNER JOIN clientes ON clientes.idLote = lotes.idLote WHERE (clientes.id_asesor = ".$this->session->userdata('id_usuario')." 
                                        OR clientes.id_coordinador = ".$this->session->userdata('id_usuario').") AND lotes.status = 1
                                        AND clientes.status = 1 AND lotes.idCondominio = $condominio ORDER BY lotes.idLote");
                break;
            default: // SEE EVERYTHING
                $query = $this->db->query("SELECT lotes.idLote, nombreLote, idStatusLote, clientes.id_asesor FROM lotes
                                        INNER JOIN clientes ON clientes.idLote = lotes.idLote WHERE lotes.status = 1
                                        AND clientes.status = 1 AND lotes.idCondominio = $condominio ORDER BY lotes.idLote");
                break;
        }
        if($query){
            $query = $query->result_array();
            return $query;
        }
    }


	public function updateDoc($data,$tipo,$idCliente,$idDocumento){
		$this->db->where("tipo_doc", $tipo);
		$this->db->where("idCliente", $idCliente);
		$this->db->where("idDocumento", $idDocumento);
		$this->db->update('historial_documento',$data);
		return true;
	}


	public function getNomExp($idDocumento) {
		$query = $this->db-> query('SELECT idDocumento, expediente, idLote FROM historial_documento where idDocumento = '.$idDocumento);
		return $query->row();
	}
	
	
	public function sendMailAdmin($idLote) {

		$this->db->select_max("idHistorialLote");
		$this->db->where("idLote = ".$idLote." AND (perfil = '11' or perfil = 'administracion') and status = 1 ");
		$query = $this->db->get('historial_lotes');

		return $query->row();
	
	}
	
	
	
	
	public function deleteDoc($id, $data) {
		$this->db->where("idDocumento", $id);
		$this->db->update('historial_documento', $data);
		return true;
	}



	// filtro de lote por condominios y residencial DOCUMENTACION INICIO

	public function getExpedienteAll($lotes, $cliente = '') {
		$where = '';
		if($cliente != ''){
			$where= "hd.idLote = $lotes AND cl.id_cliente = $cliente";
		} else {
			$where = "hd.status = 1 AND hd.idLote = $lotes";
		}
		$query = $this->db-> query("SELECT 
		hd.expediente, hd.idDocumento, hd.modificado, hd.status, hd.idCliente, hd.idLote, lotes.nombreLote, 
		cl.nombre as nomCliente, cl.apellido_paterno, cl.apellido_materno, cl.rfc, cond.nombre, res.nombreResidencial, 
		u.nombre as primerNom, u.apellido_paterno as apellidoPa, u.apellido_materno as apellidoMa, sedes.abreviacion as ubic, 
		hd.movimiento, hd.movimiento, cond.idCondominio, hd.tipo_doc, lotes.idMovimiento, cl.id_asesor, cl.flag_compartida
		FROM historial_documento hd
		INNER JOIN lotes ON lotes.idLote = hd.idLote
		INNER JOIN clientes cl ON  hd.idCliente = cl.id_cliente
		INNER JOIN condominios cond ON cond.idCondominio = lotes.idCondominio
		INNER JOIN residenciales res ON res.idResidencial = cond.idResidencial
		LEFT JOIN usuarios u ON hd.idUser = u.id_usuario
		LEFT JOIN sedes ON lotes.ubicacion = sedes.id_sede
		WHERE $where");
		return $query->result_array();
	}
	//public function getExpedienteAll($lotes) {
		/*SELECT historial_documento.expediente, historial_documento.idDocumento, historial_documento.modificado,
		historial_documento.status, historial_documento.idCliente, historial_documento.idLote, lotes.nombreLote, cliente.primerNombre,
		cliente.segundoNombre, cliente.apellidoPaterno, cliente.apellidoMaterno, cliente.rfc, cliente.razonSocial, condominio.nombre,
		residencial.nombreResidencial, users.primerNombre as primerNom, users.segundoNombre as segundoNom, users.apellidoPaterno as apellidoPa,
		users.apellidoMaterno as apellidoMa, users.ubicacion as ubic, historial_documento.movimiento, tipo_documento.descripcion, condominio.idCondominio,
		tipo_documento.id_tipo, lotes.idMovimiento, historial_documento.tipo_doc
		from historial_documento
		inner join lotes on lotes.idLote = historial_documento.idLote
		inner join cliente on historial_documento.idCliente = cliente.idCliente
		inner join condominio on condominio.idCondominio = lotes.idCondominio
		inner join residencial on residencial.idResidencial = condominio.idResidencial
		left join tipo_documento on historial_documento.tipo_doc = tipo_documento.id_tipo
		left join users on historial_documento.idUser = users.id
		where historial_documento.status = 1*/
	/*	$query = $this->db-> query('SELECT 
		hd.expediente, hd.idDocumento, hd.modificado, hd.status, hd.idCliente, hd.idLote, lotes.nombreLote, 
		cl.nombre as nomCliente, cl.apellido_paterno, cl.apellido_materno, cl.rfc, cond.nombre, res.nombreResidencial, 
		u.nombre as primerNom, u.apellido_paterno as apellidoPa, u.apellido_materno as apellidoMa, sedes.abreviacion as ubic, 
		hd.movimiento, hd.movimiento, cond.idCondominio, hd.tipo_doc, lotes.idMovimiento, cl.id_asesor
		FROM historial_documento hd
		INNER JOIN lotes ON lotes.idLote = hd.idLote
		INNER JOIN clientes cl ON  hd.idCliente = cl.id_cliente
		INNER JOIN condominios cond ON cond.idCondominio = lotes.idCondominio
		INNER JOIN residenciales res ON res.idResidencial = cond.idResidencial
		LEFT JOIN usuarios u ON hd.idUser = u.id_usuario
		LEFT JOIN sedes ON lotes.ubicacion = sedes.id_sede
		WHERE hd.status = 1 and hd.idLote = '.$lotes);

		return $query->result_array();

	}*/


	public function getdp($lotes,$cliente = ''){
		$where = '';
		if($cliente != ''){
			$where = "l.status = 1 AND ds.desarrollo IS NOT NULL AND cl.idLote = $lotes AND cl.id_cliente = $cliente";
		} else {
			$where = "cl.status = 1 AND l.status = 1 AND ds.desarrollo IS NOT NULL AND cl.idLote = $lotes";
		}
		$query = $this->db-> query("SELECT TOP(1)  'Depósito de seriedad' as expediente, 'DEPÓSITO DE SERIEDAD' as movimiento,
		'VENTAS-ASESOR' AS primerNom, 'VENTAS' AS ubic, l.nombreLote, cl.nombre as nomCliente, cl.apellido_paterno, cl.apellido_materno, cl.rfc,
		cond.nombre, res.nombreResidencial, cl.fechaApartado, cl.id_cliente, cl.id_cliente as idDocumento, ds.fechaCrate as modificado, l.idLote, cl.flag_compartida
		FROM clientes cl
		INNER JOIN lotes l ON l.idLote = cl.idLote
		INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
		INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio
		INNER JOIN residenciales res ON res.idResidencial = cond.idResidencial
		WHERE $where");
		return $query->result_array();

	}


	public function get_auts_by_loteAll($idLote, $cliente= ''){
		$where = '';
		if($cliente != ''){
			$where = "l.idLote = $idLote AND cl.id_cliente = $cliente";
		} else {
			$where = "cl.status = 1 AND l.idLote = $idLote";
		}

		$query = $this->db-> query("SELECT  TOP(1) 'Autorizaciones' as expediente, 'AUTORIZACIONES' as movimiento, 'VENTAS-ASESOR' as primerNom, 'VENTAS' as ubic, l.nombreLote,
		cl.nombre as nomCliente, cl.apellido_paterno, cl.apellido_materno, cl.rfc, cl.fechaApartado, cl.id_cliente, cl.id_cliente as idDocumento, cl.fechaApartado as modificado,
		res.nombreResidencial, cond.nombre, l.nombreLote, aut.estatus, aut.autorizacion, aut.fecha_creacion, 
		CONCAT(asesor.nombre,' ', asesor.apellido_paterno,' ', asesor.apellido_materno) as sol,
		CONCAT(users1.nombre,' ', users1.apellido_paterno,' ', users1.apellido_materno) as aut, id_autorizacion, aut.idLote, cl.id_asesor, cl.flag_compartida
		FROM autorizaciones aut
		INNER JOIN lotes l ON l.idLote = aut.idLote
		INNER JOIN clientes cl ON aut.idCliente = cl.id_cliente
		INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio
		INNER JOIN residenciales res ON res.idResidencial = cond.idResidencial
		LEFT JOIN usuarios as asesor ON aut.id_sol = asesor.id_usuario
		LEFT JOIN usuarios as users1 ON aut.id_aut = users1.id_usuario
		WHERE $where");
		return $query->result_array();
	}

	public function getsProspeccionData($idLote,$cliente='')
	{
		$where = '';
		if($cliente != ''){
			$where = "l.status = 1 AND cl.idLote = $idLote AND cl.id_cliente = $cliente";
		} else {
			$where = "cl.status = 1 AND l.status = 1 AND cl.idLote = $idLote";
		}
		$query = $this->db->query("SELECT  'Prospecto' as expediente, 'PROSPECTO' as movimiento,
		'VENTAS-ASESOR' AS primerNom, 'VENTAS' AS ubic, l.nombreLote, cl.nombre as nomCliente, cl.apellido_paterno, cl.apellido_materno, cl.rfc,
		cond.nombre, res.nombreResidencial, cl.fechaApartado, cl.id_cliente, cl.id_cliente as idDocumento, ps.fecha_creacion as modificado,
		ps.id_prospecto, cl.id_asesor, l.idLote, cl.lugar_prospeccion, cl.flag_compartida
		FROM clientes cl
		INNER JOIN lotes l ON l.idLote = cl.idLote
		INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
		INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio
		INNER JOIN residenciales res ON res.idResidencial = cond.idResidencial
		INNER JOIN prospectos ps ON cl.id_prospecto = ps.id_prospecto
		WHERE $where");
		return $query->result_array();

	}

    public function getEVMTKTD($idLote,$cliente = '')
    {

		$complemento = '';
		if($cliente != ''){
			$complemento= " AND  cl.id_cliente=$cliente";
		}

        $query = $this->db->query(" SELECT ec.evidencia as expediente, 'EVIDENCIA MKTD' as movimiento,
        CONCAT(asesor.nombre, ' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) AS primerNom, 
        sedes.abreviacion as ubic, l.nombreLote, cl.nombre as nomCliente, cl.apellido_paterno, cl.apellido_materno, cl.rfc,
        cond.nombre, res.nombreResidencial, cl.fechaApartado, cl.id_cliente, cl.id_cliente as idDocumento, ec.fecha_creacion as modificado,
        cl.id_prospecto, cl.id_asesor, l.idLote, cl.lugar_prospeccion, 66 as tipo_doc, cl.flag_compartida
        FROM clientes cl
        INNER JOIN lotes l ON l.idLote = cl.idLote
        INNER JOIN deposito_seriedad ds ON ds.id_cliente=cl.id_cliente
        INNER JOIN usuarios asesor ON asesor.id_usuario=cl.id_asesor
        INNER JOIN condominios cond ON cond.idCondominio=l.idCondominio
        INNER JOIN residenciales res ON res.idResidencial= cond.idResidencial
        INNER JOIN evidencia_cliente ec ON cl.id_cliente=ec.idCliente
        LEFT JOIN sedes ON l.ubicacion = sedes.id_sede
        WHERE cl.status=1 AND l.status=1 AND ec.estatus=3 AND cl.idLote=".$idLote. $complemento);
        return $query->result_array();
    }


		public function get_auts_by_lote($idLote)
	{
		$condicionToAsesor = '';
		if($this->session->userdata('id_rol') == 7)
		{
			$condicionToAsesor = 'autorizaciones.id_sol='.$this->session->userdata('id_usuario').' AND';
		}
		$query = $this->db-> query("SELECT res.nombreResidencial, cond.nombre as nombreCondominio, lotes.nombreLote, autorizaciones.estatus, autorizaciones.autorizacion,
		autorizaciones.fecha_creacion, solicitante.usuario as sol, autorizador.usuario as aut, id_autorizacion, autorizaciones.idLote,
		CONCAT(autorizador.nombre,' ',autorizador.apellido_paterno,' ',autorizador.apellido_materno) AS nombreAUT
		FROM autorizaciones
        INNER JOIN lotes ON lotes.idLote = autorizaciones.idLote
        INNER JOIN clientes ON clientes.id_cliente = autorizaciones.idCliente
		INNER JOIN condominios cond ON cond.idCondominio = lotes.idCondominio
		INNER JOIN residenciales res ON res.idResidencial = cond.idResidencial
		INNER JOIN usuarios solicitante ON autorizaciones.id_sol = solicitante.id_usuario
		INNER JOIN usuarios autorizador ON autorizaciones.id_aut = autorizador.id_usuario
		WHERE clientes.status = 1 AND ".$condicionToAsesor." lotes.idLote=".$idLote);

		return $query->result_array();
	}
	
	
	
	public function getcop($id_cliente){

			$query = $this->db-> query("SELECT CONCAT(asesor.nombre,' ',asesor.apellido_paterno) AS nombreAsesor,
            CONCAT(coordinador.nombre,' ',coordinador.apellido_paterno) AS  nombreCoordinador,
            CONCAT(gerente.nombre,' ',gerente.apellido_paterno) AS  nombreGerente
            FROM ventas_compartidas vc 
            LEFT JOIN clientes cl ON vc.id_cliente = cl.id_cliente  
            LEFT JOIN usuarios asesor ON asesor.id_usuario = vc.id_asesor 
			LEFT JOIN usuarios coordinador ON coordinador.id_usuario = vc.id_coordinador 
            LEFT JOIN usuarios gerente ON gerente.id_usuario = vc.id_gerente 
            WHERE vc.id_cliente = ".$id_cliente." AND vc.estatus=1");
			return $query->result();  

	}

	   /*busquedas*/
    function getClientsByName($name_client)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where CONCAT (cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) LIKE '%".$name_client."%' AND cl.status = 1 order by cl.id_cliente desc");

        return $query->result();
    }

    function getClientsByMail($correo_client)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.correo ='%".$correo_client."%' AND cl.correo LIKE '%".$correo_client."%' AND cl.status = 1  order by cl.id_cliente desc");

        return $query->result();
    }

    function getClientByTel($telefono_client)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.telefono1 ='".$telefono_client."' 
                                 AND cl.status = 1 order by cl.id_cliente desc");

        return $query->result();
    }

    function getClientsByMailName($name_client, $correo_client)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where CONCAT (cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) LIKE '%".$name_client."%' AND
                                cl.correo LIKE '%".$correo_client."%' AND cl.status = 1 order by cl.id_cliente desc");

        return $query->result();
    }

    function getClientsByNameTel($name_client, $telefono_client)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where CONCAT (cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) LIKE '%".$name_client."%' AND
                                cl.telefono1 LIKE '%".$telefono_client."%'
                                 AND cl.status = 1 order by cl.id_cliente desc");

        return $query->result();
    }


    function getClientsByMailTel($correo_client, $telefono_client)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.correo LIKE '%".$correo_client."%' OR cl.telefono1= '".$telefono_client."'
                                 AND cl.status = 1 order by cl.id_cliente desc");

        return $query->result();
    }

    function getClientsByAllFiels($name_client, $correo_client, $telefono_client, $apellido_paterno, $apellido_materno)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where  CONCAT (cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) LIKE '%".$name_client."%' AND
                                cl.correo LIKE '%".$correo_client."%' AND cl.telefono1= '".$telefono_client."' AND cl.apellido_paterno LIKE '%".$apellido_paterno."%' AND
                                 cl.apellido_materno LIKE '%".$apellido_materno."%' AND cl.status = 1 order by cl.id_cliente desc");

        return $query->result();
    }
	
    /*nuevo alv*/
    function getClientByApPaterno($apellido_paterno)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.apellido_paterno LIKE '%".$apellido_paterno."%' 
                                 AND cl.status = 1 order by cl.id_cliente desc");

        return $query->result();
    }
    function getClientByApMaterno($apellido_materno)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.apellido_materno LIKE '%".$apellido_materno."%' 
                                 AND cl.status = 1 order by cl.id_cliente desc");

        return $query->result();
    }
    function getClientsByNameApPaterno($name_client, $apellido_paterno)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.nombre LIKE '%".$name_client."%' AND cl.apellido_paterno LIKE '%".$apellido_paterno."%'
                                 AND cl.status = 1 order by cl.id_cliente desc");

        return $query->result();
    }
    function getClientsByNameApMaterno($name_client, $apellido_materno)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.nombre LIKE '%".$name_client."%' AND cl.apellido_materno LIKE '%".$apellido_materno."%'
                                 AND cl.status = 1 order by cl.id_cliente desc");

        return $query->result();
    }
    function getClientsByMailApPaterno($correo_client, $apellido_paterno)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.correo LIKE '%".$correo_client."%' AND cl.apellido_paterno LIKE '%".$apellido_paterno."%'
                                 AND cl.status = 1 order by cl.id_cliente desc");
        return $query->result();
    }
    function getClientsByMailApMaterno($correo_client, $apellido_materno)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.correo LIKE '%".$correo_client."%' AND cl.apellido_materno LIKE '%".$apellido_materno."%'
                                 AND cl.status = 1 order by cl.id_cliente desc");
        return $query->result();
    }
    function getClientsByApPaternoTel($apellido_paterno, $telefono_client)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.apellido_paterno LIKE '%".$apellido_paterno."%' AND
                                cl.telefono1 LIKE '%".$telefono_client."%'
                                 AND cl.status = 1 order by cl.id_cliente desc");

        return $query->result();
    }
    function getClientsByApMaternoTel($apellido_materno, $telefono_client)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.apellido_materno LIKE '%".$apellido_materno."%' AND
                                cl.telefono1 LIKE '%".$telefono_client."%'
                                 AND cl.status = 1 order by cl.id_cliente desc");

        return $query->result();
    }
    function getClientsByNameApPaternoApMaterno($name_client, $apellido_paterno, $apellido_materno)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.nombre LIKE '%".$name_client."%' AND cl.apellido_paterno LIKE '%".$apellido_paterno."%' AND
                                cl.apellido_materno LIKE '%".$apellido_materno."%'
                                 AND cl.status = 1 order by cl.id_cliente desc");
        return $query->result();
    }
    function getClientsByNameApPaternoMail($name_client, $apellido_paterno, $correo_client)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.nombre LIKE '%".$name_client."%' AND cl.apellido_paterno LIKE '%".$apellido_paterno."%' AND
                                cl.correo LIKE '%".$correo_client."%'
                                 AND cl.status = 1 order by cl.id_cliente desc");

        return $query->result();
    }
    function getClientsByNameApPaternoTel($name_client, $apellido_paterno, $telefono_client)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.nombre LIKE '%".$name_client."%' AND cl.apellido_paterno LIKE '%".$apellido_paterno."%' AND
                                cl.telefono1 LIKE '%".$telefono_client."%'
                                 AND cl.status = 1 order by cl.id_cliente desc");

        return $query->result();
    }
    function getClientsByNameApPaternoApMaternoMail($name_client, $apellido_paterno, $apellido_materno, $correo_client)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.nombre LIKE '%".$name_client."%' AND cl.apellido_paterno LIKE '%".$apellido_paterno."%' AND
                                cl.apellido_materno LIKE '%".$apellido_materno."%' AND cl.correo LIKE '%".$correo_client."%'
                                 AND cl.status = 1 order by cl.id_cliente desc");
        return $query->result();
    }
    function getClientsByNameApPaternoApMaternoTel($name_client, $apellido_paterno, $apellido_materno, $telefono_client)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.nombre LIKE '%".$name_client."%' AND cl.apellido_paterno LIKE '%".$apellido_paterno."%' AND
                                cl.apellido_materno LIKE '%".$apellido_materno."%' AND cl.telefono1 LIKE '%".$telefono_client."%'
                                 AND cl.status = 1 order by cl.id_cliente desc");
        return $query->result();
    }
    function getClientsByApPaternoApMaterno($apellido_paterno, $apellido_materno)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.apellido_paterno LIKE '%".$apellido_paterno."%' AND
                                cl.apellido_materno LIKE '%".$apellido_materno."%'
                                 AND cl.status = 1 order by cl.id_cliente desc");
        return $query->result();
    }
    function getClientsByApPaternoApMaternoMail($apellido_paterno, $apellido_materno, $correo_client)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.apellido_paterno LIKE '%".$apellido_paterno."%' AND
                                cl.apellido_materno LIKE '%".$apellido_materno."%' AND cl.correo LIKE '%".$correo_client."%'
                                 AND cl.status = 1 order by cl.id_cliente desc");
        return $query->result();
    }
    function getClientsByApPaternoApMaternoTel($apellido_paterno, $apellido_materno, $telefono_client)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.apellido_paterno LIKE '%".$apellido_paterno."%' AND
                                cl.apellido_materno LIKE '%".$apellido_materno."%' AND cl.telefono1 LIKE '%".$telefono_client."%'
                                 AND cl.status = 1 order by cl.id_cliente desc");
        return $query->result();
    }
    function getClientsByNombreApMaternoTel($name_client, $apellido_materno, $telefono_client)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.nombre LIKE '%".$name_client."%' AND
                                cl.apellido_materno LIKE '%".$apellido_materno."%' AND cl.telefono1 LIKE '%".$telefono_client."%'
                                 AND cl.status = 1 order by cl.id_cliente desc");
        return $query->result();
    }
    function getClientsByNombreApMaternoMail($name_client, $apellido_materno, $correo_client)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.nombre LIKE '%".$name_client."%' AND
                                cl.apellido_materno LIKE '%".$apellido_materno."%' AND cl.correo LIKE '%".$correo_client."%'
                                 AND cl.status = 1 order by cl.id_cliente desc");
        return $query->result();
    }
    function getClientsByNombreTelMail($name_client, $telefono_client, $correo_client)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.nombre LIKE '%".$name_client."%' AND
                                cl.telefono1 LIKE '%".$telefono_client."%' AND cl.correo LIKE '%".$correo_client."%'
                                 AND cl.status = 1 order by cl.id_cliente desc");
        return $query->result();
    }
    function getClientsByNombreTelMailApMaterno($name_client, $telefono_client, $correo_client, $apellido_materno)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.nombre LIKE '%".$name_client."%' AND
                                cl.telefono1 LIKE '%".$telefono_client."%' AND cl.correo LIKE '%".$correo_client."%' AND cl.apellido_materno LIKE '%".$apellido_materno."%'
                                 AND cl.status = 1 order by cl.id_cliente desc");
        return $query->result();
    }
    function getClientsByNombreTelMailApPaterno($name_client, $telefono_client, $correo_client, $apellido_paterno)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.nombre LIKE '%".$name_client."%' AND
                                cl.telefono1 LIKE '%".$telefono_client."%' AND cl.correo LIKE '%".$correo_client."%' AND
                                 cl.apellido_paterno LIKE '%".$apellido_paterno."%'
                                 AND cl.status = 1 order by cl.id_cliente desc");
        return $query->result();
    }
    function getClientsByTelMailApPaterno($telefono_client, $correo_client, $apellido_paterno)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.telefono1 LIKE '%".$telefono_client."%' AND cl.correo LIKE '%".$correo_client."%' AND
                                 cl.apellido_paterno LIKE '%".$apellido_paterno."%'
                                 AND cl.status = 1 order by cl.id_cliente desc");
        return $query->result();
    }
    function getClientsByTelMailApMaterno($telefono_client, $correo_client, $apellido_materno)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.telefono1 LIKE '%".$telefono_client."%' AND cl.correo LIKE '%".$correo_client."%' AND
                                 cl.apellido_materno LIKE '%".$apellido_materno."%'
                                 AND cl.status = 1 order by cl.id_cliente desc");
        return $query->result();
    }
    function getClientsByTelMailApPaternoApMaterno($telefono_client, $correo_client, $apellido_paterno, $apellido_materno)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.telefono1 LIKE '%".$telefono_client."%' AND cl.correo LIKE '%".$correo_client."%' AND
                                 cl.apellido_materno LIKE '%".$apellido_materno."%' AND cl.apellido_paterno LIKE '%".$apellido_paterno."%'
                                 AND cl.status = 1 order by cl.id_cliente desc");
        return $query->result();
    }
    function getClientsByNameMailTel($telefono_client, $correo_client, $name_client)
    {
        $query = $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
                                cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
                                ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
                                ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
                                ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, oc.nombre as primerContacto,
                                cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
                                (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
                                (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
                                FROM clientes as cl
                                LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
                                LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
                                LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
                                LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
                                LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
                                LEFT JOIN opcs_x_cats as oc ON cl.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9
                                where cl.telefono1 LIKE '%".$telefono_client."%' AND cl.correo LIKE '%".$correo_client."%' AND
                                 cl.nombre LIKE '%".$name_client."%' 
                                 AND cl.status = 1 order by cl.id_cliente desc");
        return $query->result();
    }
    /***************/












	public function getNameLote($idLote){
		$query = $this->db-> query("SELECT l.idLote, l.nombreLote, cond.nombre,
		res.nombreResidencial
        FROM lotes l
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		where l.idLote = ".$idLote." "); 
		return $query->row();
	}

    public function getLotesAllAssistant($condominio, $residencial)
    {
        $query = $this->db-> query("SELECT l.* FROM lotes l 
            INNER JOIN clientes c ON c.id_cliente = l.idCliente
            INNER JOIN usuarios u ON u.id_usuario = c.id_asesor AND u.estatus IN (0,3)
            WHERE l.status = 1 AND (l.idStatusContratacion = 1 OR l.idMovimiento = 82) AND c.status = 1 AND c.id_gerente = ". $this->session->userdata('id_lider') ." AND l.idCondominio = $condominio");
        if($query){
            $query = $query->result_array();
            return $query;
        }
    }

    public function registroClienteTwo($id_proyecto, $id_condominio)
    {
        if ($id_condominio == 0) { // SE FILTRA POR RESIDENCIAL
            return $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
            cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
            ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
            ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
            ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por,
            cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
            (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
            (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
            (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
            FROM clientes as cl
            LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
            LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
            LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
            LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
            LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
            where cl.status = 1 AND residencial.idResidencial = $id_proyecto order by cl.id_cliente desc")->result();
        } else { // SE FILTRA POR CONDOMINIO
            return $this->db->query("select cl.id_cliente ,id_asesor ,id_coordinador ,id_gerente ,cl.id_sede ,cl.nombre ,cl.apellido_paterno ,
            cl.apellido_materno ,personalidad_juridica ,nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1, us.rfc
            ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge  
            ,domicilio_particular ,tipo_vivienda ,ocupacion ,cl.empresa ,puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa  ,noRecibo
            ,engancheCliente ,concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por,
            cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote,
            (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor,
            (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
            (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador
            FROM clientes as cl
            LEFT JOIN usuarios as us on cl.id_asesor=us.id_usuario
            LEFT JOIN lotes as lotes on lotes.idLote=cl.idLote
            LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
            LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
            LEFT JOIN tipopago as tp on cl.idTipoPago=tp.idTipoPago
            where cl.status = 1 AND cond.idCondominio = $id_condominio order by cl.id_cliente desc")->result();
        }
    }

    public function getLotesGralTwo($condominio,$residencial)
	{
		$query = $this->db->query("SELECT idLote,nombreLote, idStatusLote FROM lotes WHERE status = 1 AND idCondominio = $condominio AND idStatusContratacion IN (1, 2, 3)");
		if($query){
			$query = $query->result_array();
			return $query;
		}
	}

	public function getClientByLote($lote){

		$result = $this->db->query('select id_cliente,nombre, apellido_paterno, apellido_materno from clientes where idLote='.$lote.'')->result_array();

		//print_r($result->result_array());
		return count($result) > 0 ? $result: NULL;

	}

	public function getLotesJuridico($condominio,$residencial)
	{
		
		
		$query = $this->db->query("SELECT * FROM lotes WHERE status = 1 AND idCondominio = $condominio AND idStatusContratacion >= 7
		AND idStatusLote IN (2,3)");

		// if($this->session->userdata('id_usuario') == 2776 || $this->session->userdata('id_usuario') == 2857 || 
		//    $this->session->userdata('id_usuario') == 2765){
		//    $this->db->where("(lotes.asig_jur = ".$this->session->userdata('id_usuario').")");
		// }
		
		// $this->db->where('lotes.status', 1);
		// $this->db->where('idCondominio', $condominio);
		// $this->db->where('idStatusContratacion', 15);
		// $this->db->where('idStatusLote', 2);
		// $this->db->where('idMovimiento', 45);

		// $query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;
		}
	}

		//filtro reemplazo de contrato
		public function getExpedienteReplace($lotes,$cliente = '') {
			$complemento = '';
			if($cliente != ''){
				$complemento= " AND  cl.id_cliente=$cliente";
			}
		
			$query = $this->db-> query("SELECT 
			hd.expediente, hd.idDocumento, hd.modificado, hd.status, hd.idCliente, hd.idLote, lotes.nombreLote, 
			cl.nombre as nomCliente, cl.apellido_paterno, cl.apellido_materno, cl.rfc, cond.nombre, res.nombreResidencial, 
			u.nombre as primerNom, u.apellido_paterno as apellidoPa, u.apellido_materno as apellidoMa, sedes.abreviacion as ubic, 
			hd.movimiento, hd.movimiento, cond.idCondominio, hd.tipo_doc, lotes.idMovimiento, cl.id_asesor
			FROM historial_documento hd
			INNER JOIN lotes ON lotes.idLote = hd.idLote
			INNER JOIN clientes cl ON  hd.idCliente = cl.id_cliente
			INNER JOIN condominios cond ON cond.idCondominio = lotes.idCondominio
			INNER JOIN residenciales res ON res.idResidencial = cond.idResidencial
			LEFT JOIN usuarios u ON hd.idUser = u.id_usuario
			LEFT JOIN sedes ON lotes.ubicacion = sedes.id_sede
			WHERE hd.status = 1 and hd.idLote = $lotes AND hd.tipo_doc=8");
	
			return $query->result_array();
	
		}

	
}
