import React from 'react';
import { Routes, Route } from 'react-router-dom';
import Dashboard from '../mantenedores/Dashboard';
import Trabajadores from '../mantenedores/Trabajadores';

const RoutesComponent = () => (
  <Routes>
    <Route path="/mantenedores/Dashboard" element={<Dashboard />} />
    <Route path="/mantenedores/Trabajadores" element={<Trabajadores />} />
    {/* Add more routes here if needed */}
  </Routes>
);

export default RoutesComponent;
