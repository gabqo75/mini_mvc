// src/index.js
// Point d'entrée de l'application React

import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import App from './App';

// Crée le point de montage de React dans le DOM
const root = ReactDOM.createRoot(document.getElementById('root'));

// Rend l'application
root.render(
  <React.StrictMode>
    <App />
  </React.StrictMode>
);