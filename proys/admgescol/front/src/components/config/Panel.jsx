import React from 'react';
import { Routes, Route, Navigate } from 'react-router-dom';
import Empresas from '../admin/Empresas';
import Documentos from '../mantenedores/Dashboard';
import Usuarios from '../mantenedores/Users';
import Trabajadores from '../mantenedores/Trabajadores';
import Roles from '../mantenedores/Roles';
import Comunas from '../mantenedores/Comunas';
import Cargos from '../mantenedores/Cargos';
import Sexo from '../mantenedores/Sexo';
import TipoDocs from '../mantenedores/Tipo_Docs';

const Panel = ({ currentOption }) => {
  return (
    <div className="panel">
      <Routes>
        <Route path="/" element={<Navigate replace to={`/${currentOption}`} />} />
        <Route path="/Empresas" element={<Empresas />} />
        <Route path="/Documentos" element={<Documentos />} />
        <Route path="/Usuarios" element={<Usuarios />} />
        <Route path="/Trabajadores" element={<Trabajadores />} />
        <Route path="/Roles" element={<Roles />} />
        <Route path="/Comunas" element={<Comunas />} />
        <Route path="/Cargos" element={<Cargos />} />
        <Route path="/Sexo" element={<Sexo />} />
        <Route path="/TipoDocs" element={<TipoDocs />} />
      </Routes>
    </div>
  );
};

export default Panel;

