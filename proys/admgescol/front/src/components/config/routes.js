import React from 'react';
import { Routes, Route } from 'react-router-dom';
import Dashboard from '../mantenedores/Dashboard';
import Trabajadores from '../mantenedores/Trabajadores';
import LiquidacionesToPdf from '../mantenedores/LiquidacionesToPdf';
import DocumentosToPdf from '../mantenedores/DocumentosToPdf';
import DocumentosGenToPdf from '../mantenedores/DocumentosGenToPdf';
import ManageEmpresa from '../admin/ManageEmpresa';

const RoutesComponent = () => (
  <Routes>
    <Route path="/mantenedores/Dashboard" element={<Dashboard />} />
    <Route path="/mantenedores/Trabajadores" element={<Trabajadores />} />
    <Route path="/mantenedores/LiquidacionesToPdf" element={<LiquidacionesToPdf />} />
    <Route path="/mantenedores/DocumentosToPdf" element={<DocumentosToPdf />} />
    <Route path="/mantenedores/DocumentosGenToPdf" element={<DocumentosGenToPdf />} />
    <Route path="/Empresas/:id" element={<ManageEmpresa />} />
    {/* Add more routes here if needed */}
  </Routes>
);

export default RoutesComponent;
