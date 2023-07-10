import React from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import './App.css';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';

import Salas from './components/Salas';
import Menu from './components/NavigationMenu';
import Home from './components/Home';
import Predicacion from './components/Predicacion';
import Configuracion from './components/Configuracion';
import Perfil from './components/Perfil';

function App() {
  return (
    <Router>
      <div className="App">
        <Menu />
        <Routes>
          <Route path="/" element={<Home />} exact />
          <Route path="/salas" element={<Salas />} />
          <Route path="/predicacion" element={<Predicacion />} />
          <Route path="/configuracion" element={<Configuracion />} />
          <Route path="/perfil" element={<Perfil />} />
        </Routes>
      </div>
    </Router>
  );
}

export default App;
