import React, { useEffect } from 'react';
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
import LiquidacionesToPdf from '../mantenedores/LiquidacionesToPdf';
import DocumentosToPdf from '../mantenedores/DocumentosToPdf';
import DocumentosGenToPdf from '../mantenedores/DocumentosGenToPdf';
import ManageEmpresa from '../admin/ManageEmpresa';
import Breadcrumbs from '../config/Breadcrumbs'; // Adjust the path as necessary
import { useDispatch } from 'react-redux';
import { setCurrentOption } from '../../actions';

const Panel = ({ currentOption }) => {
  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(setCurrentOption(currentOption));
  }, [currentOption, dispatch]);

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
        <Route path="/LiquidacionesToPdf" element={<LiquidacionesToPdf />} />
        <Route path="/DocumentosToPdf" element={<DocumentosToPdf />} />
        <Route path="/DocumentosGenToPdf" element={<DocumentosGenToPdf />} />
        <Route path="/Empresas/:id" element={<ManageEmpresa />} />
      </Routes>
    </div>
  );
};

export default Panel;
