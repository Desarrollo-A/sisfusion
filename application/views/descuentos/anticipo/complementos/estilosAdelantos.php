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
  </style>