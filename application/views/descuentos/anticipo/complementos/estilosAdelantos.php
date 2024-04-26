<style >


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

  </style>