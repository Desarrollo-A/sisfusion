<link href="<?= base_url() ?>dist/css/home.css" rel="stylesheet"/>
<body class="">
	<div class="wrapper ">
		<?php
		/*-------------------------------------------------------*/
		$datos = array();
		$datos = $datos4;
		$datos = $datos2;
		$datos = $datos3;  
		$this->load->view('template/sidebar', $datos);
		/*--------------------------------------------------------*/
		?>
		<style>
			#boxHome #banner{
				background-image: linear-gradient(RGB(0 0 0/30%),RGB(0 0 0/32%)),url('<?=base_url()?>dist/img/home.png');
				background-position: center;
				background-size: cover;
				background-repeat: no-repeat;
				display:flex;
				justify-content: center;
				align-items: center;
			}
		</style>
		<div class="content" id="boxHome">
			<div class="container-fluid h-100">				
				<div class="row h-100" style="" id="banner">
					<div id="clock">
						<div class="w-100" id="info">
							<h5 id="saludoTxt" style="text-align: left;font-size: 1.5em;padding:0px 0px 20px 0px;margin:0px"></h5>
							<div id="time"></div>
							<div class="pl-2" id="date"></div>
						</div>
					</div>
				</div>
			</div>		
		</div>
        <?php $this->load->view('template/footer_legend');?>
	</div>
	</div><!--main-panel close-->
</body>

<script>
	let hours24 = true;

	function getTime(date, hourChange, suffix) {
		const hours = date.getHours() - hourChange
		const minutes = ('0' + date.getMinutes()).slice(-2)
		const time = `${hours}:${minutes}${suffix}`
		return time
	}

	function getFormattedTime(date) {
		if (hours24==false) {
			if (date.getHours()<12){
				return getTime(date, 0, "am");
			} else if (date.getHours()==12) {
				return getTime(date, 0, "pm");
			} else {
				return getTime(date, 12, "pm");
			}
		} else {
			return getTime(date, 0, "");
		}
	}

	function displayClock() {
		const months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
		const date = new Date()
		const time = getFormattedTime(date)
		let saludo='';

		if(time>'18:00' && time < '3:00'){
			saludo = 'Buenas noches';
		}else if(time > '12:00' && time < '18:00'){
			saludo = 'Buenas tardes';
		}else if(time > '03:00' && '0'+time < '12:00'){
			saludo = 'Buenos días';
		}
		console.log("Tiempo: " + time);
		console.log("Saludo: " + saludo);
		const shortDate = `${date.getDate()} - ${months[date.getMonth()]}`
		
		document.getElementById("time").textContent = time
		document.getElementById("date").textContent = shortDate
		document.getElementById("saludoTxt").textContent = saludo
		
	}

	function startClock() {
		displayClock();
	}

	startClock()
	
</script>