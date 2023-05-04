const functions = require("firebase-functions");

// create an HTTP function to handle incoming requests
exports.callback = functions.https.onRequest((request, response) => {
    // include your existing code from the callback.php file here
});


// // Create and deploy your first functions
// // https://firebase.google.com/docs/functions/get-started
//
// exports.helloWorld = functions.https.onRequest((request, response) => {
//   functions.logger.info("Hello logs!", {structuredData: true});
//   response.send("Hello from Firebase!");
// });