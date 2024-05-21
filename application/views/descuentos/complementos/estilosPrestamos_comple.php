<style>
    .modal-backdrop{
        z-index:9;
    }


	buttons_adelanto {
		padding: 35px 50px;
		border: unset;
		border-radius: 27px;
		width: 98%;
		color: #212121;
		z-index: 1;
		background: #FFFFFF;
		position: relative;
		-webkit-box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
		box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
		transition: all 250ms;
		overflow: hidden;
		}

		buttons_adelanto::before {
		content: "";
		position: absolute;
		top: 0;
		left: 0;
		height: 100%;
		width: 0;
		border-radius: 27px;
		background-color: #4794EC;
		z-index: -1;
		-webkit-box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
		box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
		transition: all 250ms
		}
		/* COLO DE LETRA 
		#103f75
		#FFFFFF
		*/
		buttons_adelanto:hover {
		color: #FFFFFF;
		}

		buttons_adelanto:hover::before {
		width: 100%;
	}




		buttons {
		padding: 10px 25px;
		border: unset;
		border-radius: 27px;
		width: 98%;
		color: #212121;
		z-index: 1;
		background: #e8e8e8;
		position: relative;
		-webkit-box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
		box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
		transition: all 250ms;
		overflow: hidden;
		}

		buttons::before {
		content: "";
		position: absolute;
		top: 0;
		left: 0;
		height: 100%;
		width: 0;
		border-radius: 27px;
		background-color: #103f75;
		z-index: -1;
		-webkit-box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
		box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
		transition: all 250ms
		}
		/* COLO DE LETRA 
		#103f75
		#e8e8e8
		*/
		buttons:hover {
		color: #e8e8e8;
		}

		buttons:hover::before {
		width: 100%;
	}



	.switch {
    --button-width: 2.5em;
    --button-height: 1.5em;
    --toggle-diameter: 1.5em;
    --button-toggle-offset: calc((var(--button-height) - var(--toggle-diameter)) / 2);
    --toggle-shadow-offset: 3px;
    --toggle-wider: 1em;
    --color-grey: #b8babf;
    --top: 1;
    --color-green: #003d82;
    margin: auto; /* Agregamos esta línea para centrar horizontalmente */
}

.slider {
    display: inline-block;
    width: var(--button-width);
    height: var(--button-height);
    background-color: var(--color-grey);
    border-radius: calc(var(--button-height) / 2);
    position: relative;
    transition: 0.3s all ease-in-out;
}

.slider::after {
    content: "";
    display: inline-block;
    width: var(--toggle-diameter);
    height: var(--toggle-diameter);
    background-color: #fff;
    border-radius: calc(var(--toggle-diameter) / 2);
    position: absolute;
    top: var(--button-toggle-offset);
    transform: translateX(var(--button-toggle-offset));
    box-shadow: var(--toggle-shadow-offset) 0 calc(var(--toggle-shadow-offset) * 4) rgba(0, 0, 0, 0.1);
    transition: 0.3s all ease-in-out;
}

	.switch input[type="checkbox"]:checked + .slider {
	background-color: var(--color-green);
	}

	.switch input[type="checkbox"]:checked + .slider::after {
	transform: translateX(calc(var(--button-width) - var(--toggle-diameter) - var(--button-toggle-offset)));
	box-shadow: calc(var(--toggle-shadow-offset) * -1) 0 calc(var(--toggle-shadow-offset) * 4) rgba(0, 0, 0, 0.1);
	}

	.switch input[type="checkbox"] {
	display: none;
	}

	.switch input[type="checkbox"]:active + .slider::after {
	width: var(--toggle-wider);
	}

	.switch input[type="checkbox"]:checked:active + .slider::after {
	transform: translateX(calc(var(--button-width) - var(--toggle-wider) - var(--button-toggle-offset)));
	}
	/* .boxOnOff{
		width: 100%;
		display: flex;
		background-color: $white;
		padding: 5px 7px;
		border-radius: 27px;
		justify-content: space-between;
		.switch-label{
		cursor: pointer;
		}
	} */

	/* .switch-label:before, .switch-label:after {
        content: "";
        position: absolute;
        margin: 0;
        outline: 0;
        top: 50%;
        transform: translate(0, -50%);
        transition: all 0.3s ease;
      }
      .switch-label:before {
        width: 25%;
        height: 14px;
        background-color: $platinumScroll;
        border-radius: 8px;
      }
      .switch-label:after {
        width: 15px;
        height: 15px;
        background-color: $white;
        border-radius: 50%;
        box-shadow: 0 3px 1px -2px rgba(0, 0, 0, 0.14), 0 2px 2px 0 rgba(0, 0, 0, 0.098), 0 1px 5px 0 rgba(0, 0, 0, 0.084);
      }
      .switch-label .toggle--on {
        display: none;
      }
      .switch-label .toggle--off {
        display: inline-block;
      }
      .switch-input:checked + .switch-label:before {
        background-color: #A5D6A7;
      }
      .switch-input:checked + .switch-label:after {
        background-color: $green;
        transform: translate(80%, -50%);
      } */
	  #modal_config_motivo{
                z-index: 99!important;
            }
            
</style>