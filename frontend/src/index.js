import React from "react";
import ReactDOM from "react-dom/client";
import App from "./components/App";
import './App.css';
import axios from 'axios';
import 'react-notifications/lib/notifications.css';

axios.defaults.baseURL = process.env.REACT_APP_API_HOST;

const root = ReactDOM.createRoot(document.getElementById("root"));
root.render(<App />);

