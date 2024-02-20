
<style type="text/css">    
















.epecial {
  min-width: 50px;
  min-height: 60px;
  text-transform: uppercase;
  letter-spacing: 1.3px;
  font-weight: 70;
  color: #27515e;
  background: #00bcd4;
  background: linear-gradient(90deg, rgba(255, 255, 255, 0.1) 4%, rgba(255, 255, 255, 0.1) 100%);
  border: none;
  border-radius: 50px;

  transition: all 0.3s ease-in-out 0s;
  cursor: pointer;
  outline: none;
  position: relative;
  padding: 10px;
  }

  /* .epecial::before {
content: '';
  border-radius: 90px;
  min-width: calc(130px + 12px);
  min-height: calc(40px + 12px);
  border: 6px solid #00bcd4;
  box-shadow: 0 0 60px rgb(0,127,101);
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  opacity: 0;
  transition: all .3s ease-in-out 0s;
} */

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

</style>