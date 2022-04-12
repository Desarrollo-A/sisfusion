document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('side-calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {   
      headerToolbar: {
        start: 'title',
      },
      timeZone: 'none',
      locale: 'es',
      initialView: 'timeGridDay',
      allDaySlot: false,
      height: 'auto',
      eventSources: [{
        url: base_url+'index.php/calendar/Events',
        method: 'POST',
        color: '#12558C',   // a non-ajax option
        textColor: 'white', // a non-ajax option
        backgroundColor:'#12558C',
        display:'block' 
      }],
    });
    calendar.render();
  });
