<link href="<?= base_url() ?>dist/css/home.css" rel="stylesheet"/>
<body class="">
	<div class="wrapper ">
		<?php
		/*-------------------------------------------------------*/
		$this->load->view('template/sidebar');
		/*--------------------------------------------------------*/
		?>


		<div class="content" id="boxHome">
		<?=$this->session->flashdata('error_usuario')?>
			<div class="container-fluid h-100">				
				<div class="row h-100" style="" id="banner">
					<div id="clock">
						<div class="w-100" id="info">
							<h5 id="saludoTxt"></h5>
							<div class="">
								<p class="m-0 w-100" id="time"></p>
								<p class="m-0 w-100" id="date"></p>
							</div>
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

		const shortDate = `${date.getDate()} ${months[date.getMonth()]}`
		
		document.getElementById("time").textContent = time
		document.getElementById("date").textContent = shortDate
		document.getElementById("saludoTxt").textContent = saludo
	}

	displayClock();
</script>