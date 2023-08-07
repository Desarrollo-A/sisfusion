// PRUEBAS
const CLIENT_ID = '161969316544-ou10ee3mktbmp2og21po8rj2eke8ej9t.apps.googleusercontent.com';

// PRUEBAS
const API_KEY = 'AIzaSyCCR6Rd3y0E3FgV4iBWTVn_ZtLYMIvZPNw';

// Array of API discovery doc URLs for APIs used by the quickstart
const DISCOVERY_DOC = ['https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest'];

// Authorization scopes required by the API; multiple scopes can be
// included, separated by spaces.
const SCOPES = "https://www.googleapis.com/auth/calendar";

let tokenClient;

function gapiLoaded() {
  gapi.load('client', initGapiLoaded);
}

function initGapiLoaded() {
  gapi.client.init({
    'apiKey': API_KEY,
    'discoveryDocs': DISCOVERY_DOC,
    'clientId': CLIENT_ID,
    'scope': 'profile'
  }).then(function (response) {
    console.log(response);
  });
}

/**
 * Callback after Google Identity Services are loaded.
 */
function gisLoaded() {
  if (localStorage.getItem('auth-google-token') === null) {
    tokenClient = google.accounts.oauth2.initTokenClient({
      client_id: CLIENT_ID,
      scope: SCOPES,
      callback: tokenCallback,
    });
    tokenClient.requestAccessToken();
  }
}

const tokenCallback = (tokenResponse) => {
  localStorage.setItem('auth-google-token', tokenResponse.access_token);
  isSignInGoogle();
}