<style >

  .epecial {
  min-width: 80px;
  min-height: 90px;
  text-transform: uppercase;
  letter-spacing: 1.3px;
  font-weight: 80;
  /* color: #27515e; */
  background: #00bcd4;
  background: linear-gradient(90deg, rgba(255, 255, 255, 0.1) 4%, rgba(255, 255, 255, 0.1) 100%);
  border: none;
  border-radius: 60px;

  transition: all 0.3s ease-in-out 0s;
  cursor: pointer;
  outline: none;
  position: relative;
  padding: 10px;
  }


.epecial:hover, .epecial:focus {
  color: #313133;
  transform: translateY(-6px);
}

.epecial:hover::before, button:focus::before {
  opacity: 1;
}

.epecial::after {
  content: '';
  width: 30px; height: 30px;
  border-radius: 60%;
  border: 6px solid #00bcd4;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  animation: ring 1.5s infinite;
}

.epecial:hover::after, button:focus::after {
  animation: none;
  display: none;
}

@keyframes ring {
  0% {
    width: 30px;
    height: 30px;
    opacity: 1;
  }
  100% {
    width: 70px;
    height: 70px;
    opacity: 0;
  }
}




.timeline-steps {
    display: flex;
    justify-content: center;
    flex-wrap: wrap
}

.timeline-steps .timeline-step {
    align-items: center;
    display: flex;
    flex-direction: column;
    position: relative;
    margin: 1rem
}

@media (min-width:768px) {
    .timeline-steps .timeline-step:not(:last-child):after {
        content: "";
        display: block;
        border-top: .25rem dotted #3b82f6;
        width: 3.46rem;
        position: absolute;
        left: 7.5rem;
        top: .3125rem
    }
    .timeline-steps .timeline-step:not(:first-child):before {
        content: "";
        display: block;
        border-top: .25rem dotted #3b82f6;
        width: 3.8125rem;
        position: absolute;
        right: 7.5rem;
        top: .3125rem
    }
}

.timeline-steps .timeline-content {
    width: 10rem;
    text-align: center
}

.timeline-steps .timeline-content .inner-circle {
    border-radius: 1.5rem;
    height: 1rem;
    width: 1rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #3b82f6
}

.timeline-steps .timeline-content .inner-circle:before {
    content: "";
    background-color: #3b82f6;
    display: inline-block;
    height: 3rem;
    width: 3rem;
    min-width: 3rem;
    border-radius: 6.25rem;
    opacity: .5
}
/* color gris */
.timeline-steps .timeline-content .inner-circle_n:before {
    content: "";
    background-color: #AEB2B9;
    display: inline-block;
    height: 3rem;
    width: 3rem;
    min-width: 3rem;
    border-radius: 6.25rem;
    opacity: .5
}
.timeline-steps .timeline-content .inner-circle_n {
    border-radius: 1.5rem;
    height: 1rem;
    width: 1rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #AEB2B9
}
/* color NEGATIV */
.timeline-steps .timeline-content .inner-circle_negativp:before {
    content: "";
    background-color: #DA0101;
    display: inline-block;
    height: 3rem;
    width: 3rem;
    min-width: 3rem;
    border-radius: 6.25rem;
    opacity: .5
}
.timeline-steps .timeline-content .inner-circle_negativp {
    border-radius: 1.5rem;
    height: 1rem;
    width: 1rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #FF0101
}

/* liquidado */

.timeline-steps .timeline-content .inner-circle_succes:before {
    content: "";
    background-color: #16F200;
    display: inline-block;
    height: 3rem;
    width: 3rem;
    min-width: 3rem;
    border-radius: 6.25rem;
    opacity: .5
}
.timeline-steps .timeline-content .inner-circle_succes {
    border-radius: 1.5rem;
    height: 1rem;
    width: 1rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #16F200
}


/* 
@media (min-device-width: 320px) and (max-device-width: 700px)
  .timeline
    list-style-type: none
    display: block
  .li
    transition: all 200ms ease-in
    display: flex
    width: inherit
  .timestamp
    width: 100px
  .status
    &:before
      left: -8%
      top: 30%
      transition: all 200ms ease-in 

/// Layout stuff
html,body
  width: 100%
  height: 100%
  display: flex
  justify-content: center
  font-family: 'Titillium Web', sans serif
  color: #758D96

button
  position: absolute
  width: 100px
  min-width: 100px
  padding: 20px
  margin: 20px
  font-family: 'Titillium Web', sans serif
  border: none
  color: white
  font-size: 16px
  text-align: center
#toggleButton
  position: absolute
  left: 50px
  top: 20px
  background-color: #75C7F6
 */
.btn {		
	 /* position: relative;	
	padding: 1.4rem 4.2rem;
	padding-right: 3.1rem;
	font-size: 1.4rem;  */
	color: var(--inv);
	/* letter-spacing: 1.1rem; */
	 /* text-transform: uppercase;  */
	-webkit-transition: all 500ms cubic-bezier(0.77, 0, 0.175, 1);
	transition: all 500ms cubic-bezier(0.77, 0, 0.175, 1);	
	cursor: pointer;
	-webkit-user-select: none;
	   -moz-user-select: none;
	    -ms-user-select: none;
	        user-select: none;
    background-color: #0a548b; /* Cambio del color de fondo a azul marino */
}

.btn:before, .btn:after {
	content: '';
	position: absolute;	
	-webkit-transition: inherit;	
	transition: inherit;
	z-index: -1;
}

.btn:hover {
	color: #400000;
	-webkit-transition-delay: .5s;
	        transition-delay: .5s;
}

.btn:hover:before {
	-webkit-transition-delay: 0s;
	        transition-delay: 0s;
}

.btn:hover:after {
	background: var(--inv);
	-webkit-transition-delay: .35s;
	        transition-delay: .35s;
}

/* From Top */

.from-top:before, 
.from-top:after {
	left: 0;
	height: 0;
	width: 100%;
}

.from-top:before {
	bottom: 0;	
	border: 1px solid var(--inv);
	border-top: 0;
	border-bottom: 0;
}

.from-top:after {
	top: 0;
	height: 0;
}

.from-top:hover:before,
.from-top:hover:after {
	height: 100%;
}

/* From Left */

.from-left:before, 
.from-left:after {
	top: 0;
	width: 0;
	height: 100%;
}

.from-left:before {
	right: 0;
	border: 1px solid var(--inv);
	border-left: 0;
	border-right: 0;	
}

.from-left:after {
	left: 0;
}

.from-left:hover:before,
.from-left:hover:after {
	width: 100%;
}

/* From Right */

.from-right:before, 
.from-right:after {
	top: 0;
	width: 0;
	height: 100%;
}

.from-right:before {
	left: 0;
	border: 1px solid var(--inv);
	border-left: 0;
	border-right: 0;	
}

.from-right:after {
	right: 0;
}

.from-right:hover:before,
.from-right:hover:after {
	width: 100%;
}

/* From center */

.from-center:before {
	top: 0;
	left: 50%;
	height: 100%;
	width: 0;
	border: 1px solid var(--inv);
	border-left: 0;
	border-right: 0;
}

.from-center:after {
	bottom: 0;
	left: 0;
	height: 0;
	width: 100%;
	background: var(--inv);
}

.from-center:hover:before {
	left: 0;
	width: 100%;
}

.from-center:hover:after {
	top: 0;
	height: 100%;
}

/* From Bottom */

.from-bottom:before, 
.from-bottom:after {
	left: 0;
	height: 0;
	width: 100%;
}

.from-bottom:before {
	top: 0;	
	border: 1px solid var(--inv);
	border-top: 0;
	border-bottom: 0;
}

.from-bottom:after {
	bottom: 0;
	height: 0;
}

.from-bottom:hover:before,
.from-bottom:hover:after {
	height: 100%;
}


/* ~~~~~~~~~~~~ GLOBAL SETTINGS ~~~~~~~~~~~~ */

*, *:before, *:after {
	box-sizing: border-box;
}

body {
	--def: #96B7C4; 	
	--inv: #ffff;

	/* -webkit-box-pack: center;
	        justify-content: center;
	-webkit-box-align: center;
	        align-items: center;
	-webkit-box-orient: vertical;
	-webkit-box-direction: normal;
	        flex-direction: column; */
/* background-image: linear-gradient(-25deg, #616161 0%, #96B7C4 100%); */
}
.buttons_adelanto.clicked::before {
  width: 100%;
}





.ag-courses-item_title {
  min-height: 87px;
  margin: 0 0 25px;

  overflow: hidden;

  font-weight: bold;
  font-size: 30px;
  color: #000000;

  z-index: 2;
  position: relative;
}


@media only screen and (max-width: 979px) {
  .ag-courses_item {
    -ms-flex-preferred-size: calc(33.33333% - 30px);
    flex-basis: calc(33.33333% - 30px);
  }
  .ag-courses-item_title {
    font-size: 24px;
  }
}

.ag-courses-item_title {
  min-height: 87px;
  margin: 0 0 25px;

  overflow: hidden;

  font-weight: bold;
  font-size: 30px;
  color: #000000;

  z-index: 2;
  position: relative;
}

/* nuevvo prueba de un boton mamonb  */



/* 
  You want a simple and fancy tooltip?
  Just copy all [data-tooltip] blocks:
*/
[data-tooltip] {
  --arrow-size: 5px;
  position: relative;
  z-index: 10;
}

/* Positioning and visibility settings of the tooltip */
[data-tooltip]:before,
[data-tooltip]:after {
  position: absolute;
  visibility: hidden;
  opacity: 0;
  left: 50%;
  bottom: calc(100% + var(--arrow-size));
  pointer-events: none;
  transition: 0.2s;
  will-change: transform;
}

/* The actual tooltip with a dynamic width */
[data-tooltip]:before {
  content: attr(data-tooltip);
  padding: 10px 18px;
  min-width: 50px;
  max-width: 300px;
  width: max-content;
  width: -moz-max-content;
  border-radius: 6px;
  font-size: 14px;
  background-color: rgba(59, 72, 80, 0.9);
  background-image: linear-gradient(30deg,
    rgba(59, 72, 80, 0.44),
    rgba(59, 68, 75, 0.44),
    rgba(60, 82, 88, 0.44));
  box-shadow: 0px 0px 24px rgba(0, 0, 0, 0.2);
  color: #fff;
  text-align: center;
  white-space: pre-wrap;
  transform: translate(-50%,  calc(0px - var(--arrow-size))) scale(0.5);
}

/* Tooltip arrow */
[data-tooltip]:after {
  content: '';
  border-style: solid;
  border-width: var(--arrow-size) var(--arrow-size) 0px var(--arrow-size); /* CSS triangle */
  border-color: rgba(55, 64, 70, 0.9) transparent transparent transparent;
  transition-duration: 0s; /* If the mouse leaves the element, 
                              the transition effects for the 
                              tooltip arrow are "turned off" */
  transform-origin: top;   /* Orientation setting for the
                              slide-down effect */
  transform: translateX(-50%) scaleY(0);
}

/* Tooltip becomes visible at hover */
[data-tooltip]:hover:before,
[data-tooltip]:hover:after {
  visibility: visible;
  opacity: 1;
}
/* Scales from 0.5 to 1 -> grow effect */
[data-tooltip]:hover:before {
  transition-delay: 0.3s;
  transform: translate(-50%, calc(0px - var(--arrow-size))) scale(1);
}
/* 
  Arrow slide down effect only on mouseenter (NOT on mouseleave)
*/
[data-tooltip]:hover:after {
  transition-delay: 0.5s; /* Starting after the grow effect */
  transition-duration: 0.2s;
  transform: translateX(-50%) scaleY(1);
}
/*
  That's it for the basic tooltip.

  If you want some adjustability
  here are some orientation settings you can use:
*/

/* LEFT */
/* Tooltip + arrow */
[data-tooltip-location="left"]:before,
[data-tooltip-location="left"]:after {
  left: auto;
  right: calc(100% + var(--arrow-size));
  bottom: 50%;
}

/* Tooltip */
[data-tooltip-location="left"]:before {
  transform: translate(calc(0px - var(--arrow-size)), 50%) scale(0.5);
}
[data-tooltip-location="left"]:hover:before {
  transform: translate(calc(0px - var(--arrow-size)), 50%) scale(1);
}

/* Arrow */
[data-tooltip-location="left"]:after {
  border-width: var(--arrow-size) 0px var(--arrow-size) var(--arrow-size);
  border-color: transparent transparent transparent rgba(55, 64, 70, 0.9);
  transform-origin: left;
  transform: translateY(50%) scaleX(0);
}
[data-tooltip-location="left"]:hover:after {
  transform: translateY(50%) scaleX(1);
}



/* RIGHT */
[data-tooltip-location="right"]:before,
[data-tooltip-location="right"]:after {
  left: calc(100% + var(--arrow-size));
  bottom: 50%;
}

[data-tooltip-location="right"]:before {
  transform: translate(var(--arrow-size), 50%) scale(0.5);
}
[data-tooltip-location="right"]:hover:before {
  transform: translate(var(--arrow-size), 50%) scale(1);
}

[data-tooltip-location="right"]:after {
  border-width: var(--arrow-size) var(--arrow-size) var(--arrow-size) 0px;
  border-color: transparent rgba(55, 64, 70, 0.9) transparent transparent;
  transform-origin: right;
  transform: translateY(50%) scaleX(0);
}
[data-tooltip-location="right"]:hover:after {
  transform: translateY(50%) scaleX(1);
}



/* BOTTOM */
[data-tooltip-location="bottom"]:before,
[data-tooltip-location="bottom"]:after {
  top: calc(100% + var(--arrow-size));
  bottom: auto;
}

[data-tooltip-location="bottom"]:before {
  transform: translate(-50%, var(--arrow-size)) scale(0.5);
}
[data-tooltip-location="bottom"]:hover:before {
  transform: translate(-50%, var(--arrow-size)) scale(1);
}

[data-tooltip-location="bottom"]:after {
  border-width: 0px var(--arrow-size) var(--arrow-size) var(--arrow-size);
  border-color: transparent transparent rgba(55, 64, 70, 0.9) transparent;
  transform-origin: bottom;
}














/* Settings that make the pen look nicer */

@keyframes moveFocus { 
  0%   { background-position: 0% 100% }
  100% { background-position: 100% 0% }
}

body {
  background: none;    display: flex;
    flex-direction: column;
    height: 100%;
    margin: 0;
}

main {
  padding: 0 4%;
  display: flex;
  flex-direction: row;
  margin: auto 0;
}

button {
  margin: 0;
  padding: 0.7rem 1.4rem;

  cursor: pointer;
  text-align: center;
  border: none;
  border-radius: 4px;
  outline: inherit;
  text-decoration: none;
  font-family: Roboto, sans-serif;
  font-size: 0.7em;
  background-color: rgba(174, 184, 192, 0.55);
  color: white;

  -webkit-appearance: none;
  -moz-appearance: none;
  transition: background 350ms ease-in-out, 
              transform 150ms ease;
}
button:hover {
  background-color: #484f56;
}
button:active {
  transform: scale(0.98);
}
button:focus {
  box-shadow: 0 0 2px 2px #298bcf;
}
button::-moz-focus-inner {
  border: 0;
}

.example-elements {
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  align-content: center;
  justify-content: center;
  text-align: center;
  padding-right: 4%;
}

.example-elements p {
  padding: 6px;
  display: inline-block;
  margin-bottom: 5%;
  color: #000;
}
.example-elements p:hover {
  border-left: 1px solid lightgrey;
  border-right: 1px solid lightgrey;
  padding-left: 5px;
  padding-right: 5px;
  color: red; /* Cambia el color al pasar el puntero */
}

.example-elements a {
  margin-left: 6px;
  margin-bottom: calc(5% + 10px);
  color: #76daff;
  text-decoration: none;
}
.example-elements a:hover {
  margin-bottom: calc(5% + 9px);
  border-bottom: 1px solid #76daff;
}

.example-elements button {
  margin-bottom: 20px;
}
/* 
.info-wrapper {
  flex-grow: 8;
  display: flex;
  flex-direction: column;
  justify-content: center;
  text-align: justify;
  padding-left: 6%;
  border-left: 3px solid #35ea95;
} */

.info-wrapper p {
  color: #000;
}
/* .info-wrapper p {
  max-width: 600px;
  text-align: justify;
} */

.info-wrapper .title-question {
  display: block;
  color: #fff;
  font-size: 1.36em;
  font-weight: 500;
  padding-bottom: 24px;
}


@media (max-height: 450px) {
  main {
    margin: 2rem 0;
  }
}

@media (max-width: 800px) {
  html {
    font-size: 0.9em;
  }
}

/* Thumbnail settings */
@media (max-width: 750px) {
  html {
    animation-duration: 0.6s;
    font-size: 1em;
  }
  body {
    display: flex;
    background: none;
    height: 100%;
    margin: 0px;
  }
  main {
    font-size: 1.1em;
    padding: 6%;
  }
  .info-wrapper p:before,
  .info-wrapper p:after {
    display: none;
  }
  .example-elements {
    max-width: 150px;
    font-size: 22px;
  }
  .example-elements a, button {
    display: none;
  }
  .example-elements p:before, 
  .example-elements p:after {
    visibility: visible;
    opacity: 1;
  }
  .example-elements p:before {
    content: "Tooltip";
    font-size: 20px;
    transform: translate(-50%, calc(0px - var(--arrow-size))) scale(1);
  }
  .example-elements p:after {
    transform: translate(-50%, -1px) scaleY(1);
  }
  
  
  [data-tooltip]:after {
    bottom: calc(100% + 3px);
  }
  [data-tooltip]:after {
    border-width: 7px 7px 0px 7px;
  }
}
/* preuba de un bptpm mamon */
 /* botones */
 /* .ag-format-container {
  width: 1142px;
  margin: 0 auto;
} */


.ag-courses_box {
  display: -webkit-box;
  display: -ms-flexbox;
  /* display: flex; */
  -webkit-box-align: start;
  -ms-flex-align: start;
  align-items: flex-start;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;

  padding: 50px 0;
}
.ag-courses_item {
  /* -ms-flex-preferred-size: calc(50% - 50px); */
  /* flex-basis: calc(33.33333% - 30px); */

  /* margin: 0 50px 50px; */

  overflow: hidden;

  border-radius: 15px;
}
.ag-courses-item_link {
  display: block;
  padding: 30px 20px;
  background-color: #F4F7FF ;

  overflow: hidden;

  position: relative;
}
.ag-courses-item_link:hover,
.ag-courses-item_link:hover .ag-courses-item_date {
  text-decoration: none;
  color: #616060  ;
}
.ag-courses-item_link:hover .ag-courses-item_bg {
  -webkit-transform: scale(10);
  -ms-transform: scale(10);
  transform: scale(10);
}
.ag-courses-item_title {
  min-height: 87px;
  margin: 0 0 25px;

  overflow: hidden;

  font-weight: bold;
  font-size: 30px;
  color: #616060  ;

  z-index: 2;
  position: relative;
}
.ag-courses-item_date-box {
  font-size: 18px;
  color: #616060  ;

  z-index: 2;
  position: relative;
}
.ag-courses-item_date {
  font-weight: bold;
  color: #616060  ;

  -webkit-transition: color .5s ease;
  -o-transition: color .5s ease;
  transition: color .5s ease
}

.ag-courses-item_link.clicked {

  background-color: #B19E55; /* Cambia este color según tu preferencia */
}

.ag-courses-item_bg.clicked::before {
  width: 100%;
  
}


        
.ag-courses-item_bg {
  height: 200px;
  width: 200px;
  background-color: #B19E55; 

  
   position: absolute;
  top: 75px;
  right: 75px;

  border-radius: 100%;

  -webkit-transition: all .5s ease;
  -o-transition: all .5s ease;
  transition: all .5s ease;
  
  /* .ag-courses-item_title {
  min-height: 87px;
    margin: 0 0 25px;

    overflow: hidden;

    font-weight: bold;
    font-size: 30px;
    color: #505050  ;

    z-index: 2;
    position: relative;
    } */
}.


.ag-courses-item_bg:hover ~ .ag-courses-item_title {
            color: #FFFEFE; /* Cambia el color según tu preferencia */
        }

        /* Cambiar el color de la clase .ag-courses-item_title cuando se hace clic en .ag-courses-item_link */
        .ag-courses-item_link.clicked .ag-courses-item_title {
            color: white; /* Cambia el color según tu preferencia */
        }

        /* Cambiar el fondo de .ag-courses-item_link cuando se hace clic */
        .ag-courses-item_link.clicked {
            background-color: #B19E55; /* Cambia este color según tu preferencia */
        }


.ag-courses-item {
            position: relative;
            margin: 50px;
            padding: 20px;
            background-color: #616060;
            border-radius: 15px;
            overflow: hidden;
        }

        .ag-courses-item_bg {
            height: 200px;
            width: 200px;
            background-color: #B19E55;
            position: absolute;
            top: 75px;
            right: 75px;
            border-radius: 100%;
            transition: all .5s ease;
        }

        .ag-courses-item_title {
            min-height: 87px;
            margin: 0 0 25px;
            overflow: hidden;
            font-weight: bold;
            font-size: 30px;
            color: #545454;
            z-index: 2;
            position: relative;
            transition: color .5s ease;
        }

        /* Cambiar el color de la clase .ag-courses-item_title cuando se pasa el puntero sobre .ag-courses-item_bg */
        
            .ag-courses-item_bg:hover ~ .ag-courses-item_title {
                color: #FFFEFE; /* Cambia el color según tu preferencia */
            }

.ag-courses_item:nth-child(2n) .ag-courses-item_bg {
  background-color: #B19E55;
}
.ag-courses_item:nth-child(3n) .ag-courses-item_bg {
  background-color: #e44002;
}
.ag-courses_item:nth-child(4n) .ag-courses-item_bg {
  background-color: #952aff;
}
.ag-courses_item:nth-child(5n) .ag-courses-item_bg {
  background-color: #cd3e94;
}
.ag-courses_item:nth-child(6n) .ag-courses-item_bg {
  background-color: #4c49ea;
}



@media only screen and (max-width: 979px) {
  .ag-courses_item {
    /* -ms-flex-preferred-size: calc(50% - 30px); */
    flex-basis: calc(50% - 30px);
  }
  .ag-courses-item_title {
    font-size: 20px;
  }
}

@media only screen and (max-width: 767px) {
  .ag-format-container {
    width: 96%;
  }

}
@media only screen and (max-width: 639px) {
  .ag-courses_item {
    /* -ms-flex-preferred-size: 100%; */
    flex-basis: 100%;
  }
  .ag-courses-item_title {
    min-height: 72px;
    line-height: 1;

    font-size: 24px;
  }
  .ag-courses-item_link {
    padding: 22px 40px;
  }
  .ag-courses-item_date-box {
    font-size: 16px;
  }
}


.ag-courses-item_link.gold-background {
  background-color: gold; /* Fondo dorado */
  color: black; /* Texto negro para buen contraste */
}
.ag-courses-item_link.gold-background .ag-courses-item_title,
.ag-courses-item_link.gold-background .ag-courses-item_date-box,
.ag-courses-item_link.gold-background .ag-courses-item_date {
  color: black; /* Asegurar que todos los textos sean negros */
}

 /* bptpemes */
 
 
 </style>