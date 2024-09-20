import React, { useEffect } from 'react';
import { Routes, Route, Navigate } from 'react-router-dom';

import Empresas from '../admin/Empresas';
import ManageEmpresa from '../admin/ManageEmpresa';
import ComunicacionesCard from '../admin/ComunicacionesCard';
import SolicitudesCard from '../admin/SolicitudesCard';
import LeyKarin from '../mantenedores/LeyKarin';

import Documentos from '../mantenedores/Dashboard';
import Usuarios from '../mantenedores/Users';
import Trabajadores from '../mantenedores/Trabajadores';
import Roles from '../mantenedores/Roles';
import Comunas from '../mantenedores/Comunas';
import Cargos from '../mantenedores/Cargos';
import Sexo from '../mantenedores/Sexo';
import TipoDocs from '../mantenedores/Tipo_Docs';
import TipoSol from '../mantenedores/TipoSol';
import EstadoSol from '../mantenedores/EstadoSol';
import LiquidacionesToPdf from '../mantenedores/LiquidacionesToPdf';
import DocumentosToPdf from '../mantenedores/DocumentosToPdf';
import DocumentosGenToPdf from '../mantenedores/DocumentosGenToPdf';

import UserDashboard from '../users/manageUser';
import ContratosUser from '../mantenedores/DashTrabDocLabContrCopia';
import LiquidacionesUser from '../mantenedores/LiqAnioActual';
import ReglamentosUser from '../mantenedores/DashTrabDocLabReglaRIOHS';
import OtrosUser from '../mantenedores/DashTrabDocLabReglaCarga';
import SolicitarAnticipo from '../users/SolicitudesAnti';
import SolicitarPrestamo from '../users/SolicitudesPrest';
import SolicitarPermiso from '../users/SolicitudesPerm';
import SolicitarVacaciones from '../users/SolicitudesVac';
import ComunicacionesUsers from '../users/Comunicaciones';

import { useDispatch } from 'react-redux';
import { setCurrentOption } from '../../actions';

const Panel = ({ currentOption, empresaId }) => {
  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(setCurrentOption(currentOption));
  }, [currentOption, dispatch]);

  return (
    <div className="panel">
      <Routes>
        <Route path="/" element={<Navigate replace to={`/${currentOption}`} />} />
        <Route path="/Empresas" element={<Empresas empresaId={empresaId}/>} />
        <Route path="/ComunicacionesCard" element={<ComunicacionesCard />} />
        <Route path="/SolicitudesCard" element={<SolicitudesCard />} />
        <Route path="/Empresas/:id" element={<ManageEmpresa />} />
        <Route path="/LeyKarin"  element={<LeyKarin />} />
        
        <Route path="/Documentos" element={<Documentos />} />
        <Route path="/Usuarios" element={<Usuarios />} />
        <Route path="/Trabajadores" element={<Trabajadores />} />
        <Route path="/Roles" element={<Roles />} />
        <Route path="/Comunas" element={<Comunas />} />
        <Route path="/Cargos" element={<Cargos />} />
        <Route path="/Sexo" element={<Sexo />} />
        <Route path="/TipoDocs" element={<TipoDocs />} />
        <Route path="/TipoSol" element={<TipoSol />} />
        <Route path="/EstadoSol" element={<EstadoSol />} />
        <Route path="/LiquidacionesToPdf" element={<LiquidacionesToPdf />} />
        <Route path="/DocumentosToPdf" element={<DocumentosToPdf />} />
        <Route path="/DocumentosGenToPdf" element={<DocumentosGenToPdf />} />

        <Route path="/UserDashboard" element={<UserDashboard />} />
        <Route path="/ContratosUser" element={<ContratosUser />} />
        <Route path="/LiquidacionesUser" element={<LiquidacionesUser />} />
        <Route path="/ReglamentosUser" element={<ReglamentosUser />} />
        <Route path="/OtrosUser" element={<OtrosUser />} />
        <Route path="/SolicitarAnticipo" element={<SolicitarAnticipo />} />
        <Route path="/SolicitarPrestamo" element={<SolicitarPrestamo />} />
        <Route path="/SolicitarPermiso" element={<SolicitarPermiso />} />
        <Route path="/SolicitarVacaciones" element={<SolicitarVacaciones />} />
        <Route path="/ComunicacionesUsers" element={<ComunicacionesUsers />} />


      </Routes>
    </div>
  );
};

export default Panel;
