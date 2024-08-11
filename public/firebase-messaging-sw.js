importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyCOhkfag0YwhgfJewZfQ_YEb0qzeFt0URU",
    authDomain: "bilpay-f48f1.firebaseapp.com",
    projectId: "bilpay-f48f1",
    storageBucket: "bilpay-f48f1.appspot.com",
    messagingSenderId: "912465607868",
    appId: "1:912465607868:web:9c402a7719639d00e864b9",
    measurementId: "G-V9FGB30FYY"
});


const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function ({ data: { title, body, icon } }) {
    return self.registration.showNotification(title, { body, icon });
});
