// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyCMkbfK8SN2TM4WqtnGlEbLwCn96jGfkdQ",
  authDomain: "distance-edu-c5df1.firebaseapp.com",
  projectId: "distance-edu-c5df1",
  storageBucket: "distance-edu-c5df1.firebasestorage.app",
  messagingSenderId: "933357033423",
  appId: "1:933357033423:web:cd464a4dc3d10b2cbfe4ba",
  measurementId: "G-QECB50LW1F"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);