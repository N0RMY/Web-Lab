import { initializeApp } from "firebase/app";
import { getFirestore, connectFirestoreEmulator } from "firebase/firestore";
import { getAnalytics } from "firebase/analytics";

const firebaseConfig = {
  apiKey: "AIzaSyALyC2-1a7Lk5VWnIf0JUPL26mRuC2icHs",
  authDomain: "electro-shop-5885d.firebaseapp.com",
  projectId: "electro-shop-5885d",
  storageBucket: "electro-shop-5885d.appspot.com",
  messagingSenderId: "765133533617",
  appId: "1:765133533617:web:efc37ebc3ba8a417000d90",
  measurementId: "G-6DWXQ49YBT",
};

const app = initializeApp(firebaseConfig);

export const db = getFirestore(app);

if (import.meta.env.DEV) {
  connectFirestoreEmulator(db, "127.0.0.1", 8080);
}

export const analytics = typeof window !== "undefined" ? getAnalytics(app) : null;
