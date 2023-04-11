  // PRUEBAS
  var CLIENT_ID = '161969316544-ou10ee3mktbmp2og21po8rj2eke8ej9t.apps.googleusercontent.com';

  // PRUEBAS
  var API_KEY = 'AIzaSyCCR6Rd3y0E3FgV4iBWTVn_ZtLYMIvZPNw';

  // Array of API discovery doc URLs for APIs used by the quickstart
  var DISCOVERY_DOCS = ["https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest"];

  // Authorization scopes required by the API; multiple scopes can be
  // included, separated by spaces.
  var SCOPES = "https://www.googleapis.com/auth/calendar";

  var arrayEvents = [];

  /** On load, called to load the auth2 library and API client library.*/
  function handleClientLoad() {
    gapi.load('client:auth2', initClient);
  }

  /* Initializes the API client library and sets up sign-in state listeners. */
  function initClient() {
    gapi.client.init({
      apiKey: API_KEY,
      clientId: CLIENT_ID,
      discoveryDocs: DISCOVERY_DOCS,
      scope: SCOPES,
      plugin_name: 'Google Auth production'
    }).then(function () {
      // Listen for sign-in state changes.
      gapi.auth2.getAuthInstance().isSignedIn.listen(updateSigninStatus);
      // Handle the initial sign-in state.
      updateSigninStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
    }, function(error) {
      console.error(error);
    });
  }

  /*Called when the signed in status changes, to update the UI appropriately. After a sign-in, the API is called. */
  function updateSigninStatus(isSignedIn) {
    if (isSignedIn) {
      $(".fc-googleSignIn-button").attr("style", "display: none !important");
      $(".fc-googleLogout-button").attr("style", "display: block !important");
    } else {
      $(".fc-googleSignIn-button").attr("style", "display: block !important");
      $(".fc-googleLogout-button").attr("style", "display: none !important");
      removeEvents();
    }
  }

  function listUpcomingEvents() {
    gapi.client.lis
    gapi.client.idc
    gapi.client.calendar.events.list({
      'calendarId': 'primary',
      'timeMin': '1090-12-11T23:59:59.000Z',
      'showDeleted': false,
      'singleEvents': true,
      'maxResults': 2500,
      'orderBy': 'startTime'
    }).then(function(response) {
      var googleAppointments = response.result.items;
      for(let i = 0; i < googleAppointments.length; i++){
        if(!(googleAppointments[i].hasOwnProperty('extendedProperties') && googleAppointments[i].extendedProperties.hasOwnProperty('private') && googleAppointments[i].extendedProperties.private.hasOwnProperty('setByFullCalendar'))){
          eventTemplateGoogle(arrayEvents, googleAppointments[i]);
        }
      }
      
      if(typeof(calendar) != 'undefined'){
        calendar.addEventSource({
          title: 'sourceGoogle',
          display:'block',
          events: arrayEvents
        })
        
        calendar.refetchEvents();
      }
    });
  }

  function eventTemplateGoogle(arrayEvents, googleAppointments){
    const { summary, htmlLink } = googleAppointments;
    let start, end;

    start = (googleAppointments.start.hasOwnProperty('date')) ? googleAppointments.start.date : googleAppointments.start.dateTime;
    end = (googleAppointments.end.hasOwnProperty('date')) ? googleAppointments.end.date : googleAppointments.end.dateTime;

    arrayEvents.push({
      className: 'googleEvents',
      title: summary,
      start: start,
      end: end,
      url: htmlLink,
      backgroundColor:'transparent',
      borderColor: '#999',
      textColor: '#999'
    });
  }
  
  function removeEvents(){
    let srcEventos;
    if (typeof(calendar) != 'undefined') srcEventos = calendar.getEventSources();
  
    srcEventos.forEach(event => {
      if(event['internalEventSource']['extendedProps'].hasOwnProperty('title') && event['internalEventSource']['extendedProps']['title'] == "sourceGoogle") event.remove();
    });
  }