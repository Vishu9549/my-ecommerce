// main.jsx or index.jsx

import React from "react";
import { createRoot } from "react-dom/client";
import App from "./App.jsx";
import "./assets/scss/style.scss"; // custom styles
import "bootstrap/dist/css/bootstrap.min.css"; // Bootstrap


import axios from "axios";
import { CartProvider } from "./components/CartContext"; // ✅ import context
import "@fortawesome/fontawesome-free/css/all.min.css";


axios.defaults.baseURL = "http://127.0.0.1:8000";
axios.defaults.withCredentials = true;

createRoot(document.getElementById("root")).render(
  
    
      <App />
    
  
);
