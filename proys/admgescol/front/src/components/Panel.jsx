import React, { useState } from 'react';
import LiquidacionesToPdf from './LiquidacionesToPdf'; 
import ListadoDocumentos from './ListadoDocumentos'; 
import ListadoContratos from './ListadoContratos'; 
import ListadoReglamento from './ListadoReglamento'; 
import Documentos from './Documentos'; 
import Trabajadores from './Trabajadores'; 
import Comunas from './Comunas'; 
import Cargos from './Cargos'; 
import Sexo from './Sexo'; 
import Tipo_Docs from './Tipo_Docs'; 
import Empresas from './Empresas'; 
import Resumen from './Resumen'; 
import Dashboard from './Dashboard'; 
import DashTrab from './DashTrab'; 
import Users from './Users'; 
import Roles from './Roles'; 
import LiqAnioActual from './LiqAnioActual'; 
import LiqAnioAnterior from './LiqAnioAnterior'; 
import SolAntSue from './SolAntSue'; 
import SolOtros from './SolOtros'; 
import SolBene from './SolBene'; 
import SolPer from './SolPer'; 
import SolAntCuo from './SolAntCuo'; 
import ComAmon from './ComAmon'; 
import ComCumple from './ComCumple'; 
import ComOtras from './ComOtras'; 
import DashTrabDocLabRegla from './DashTrabDocLabRegla'; 
import DashTrabDocLabContr from './DashTrabDocLabContr'; 
import DashTrabDocLabReglaCarga from './DashTrabDocLabReglaCarga'; 
import DashTrabDocLabReglaFunGen from './DashTrabDocLabReglaFunGen'; 
import DashTrabDocLabReglaRIOHS from './DashTrabDocLabReglaRIOHS'; 
import DashTrabDocLabContrCopia from './DashTrabDocLabContrCopia'; 
import DashTrabDocLabContrFirmar from './DashTrabDocLabContrFirmar'; 
import Button from '@mui/material/Button';
import '../css/Panel.css';

const Panel = ({ currentOption, userDNI, empresaId, setCurrentOption }) => {
  const [previousOption, setPreviousOption] = useState(null);

  const handleOptionChange = (option) => {
    setPreviousOption(currentOption); // Almacena la opción actual como la anterior
    setCurrentOption(option);
  };

  const handleBack = () => {
    if (previousOption) {
      setCurrentOption(previousOption);
      setPreviousOption(null);
    }
  };

  const renderContent = () => {
    switch (currentOption) {
      case 'LiquidacionesToPdf':
        return <LiquidacionesToPdf />;
      case 'ListadoDocumentos':
        return <ListadoDocumentos userDNI={userDNI} empresaId={empresaId} />;
      case 'ListadoContratos':
        return <ListadoContratos userDNI={userDNI} empresaId={empresaId} />;
      case 'ListadoReglamento':
        return <ListadoReglamento userDNI={userDNI} empresaId={empresaId} />;
      case 'Documentos':
        return <Documentos empresaId={empresaId} />;
      case 'Trabajadores':
        return <Trabajadores empresaId={empresaId} />;
      case 'Comunas':
        return <Comunas />;
      case 'Cargos':
        return <Cargos />;
      case 'Sexo':
        return <Sexo />;
      case 'Tipo_Docs':
        return <Tipo_Docs />;
      case 'Empresas':
        return <Empresas />;
      case 'Resumen':
        return <Resumen userDNI={userDNI} empresaId={empresaId} />;
      case 'Dashboard':
        return <Dashboard userDNI={userDNI} empresaId={empresaId} />;
      case 'DashTrab':
        return <DashTrab userDNI={userDNI} onOptionChange={handleOptionChange} />;
      case 'Users':
        return <Users />;
      case 'Roles':
        return <Roles />;
      case 'LiqAnioActual':
        return <LiqAnioActual />;
      case 'LiqAnioAnterior':
        return <LiqAnioAnterior />;
      case 'SolAntSue':
        return <SolAntSue />;
      case 'SolAntCuo':
        return <SolAntCuo />;
      case 'SolPer':
        return <SolPer />;
      case 'SolBene':
        return <SolBene />;
      case 'SolOtros':
        return <SolOtros />;
      case 'ComAmon':
        return <ComAmon />;
      case 'ComCumple':
        return <ComCumple />;
      case 'ComOtras':
        return <ComOtras />;
      case 'DashTrabDocLabRegla':
        return <DashTrabDocLabRegla />;
      case 'DashTrabDocLabContr':
        return <DashTrabDocLabContr />;
      case 'DashTrabDocLabReglaCarga':
        return <DashTrabDocLabReglaCarga />;
      case 'DashTrabDocLabReglaFunGen':
        return <DashTrabDocLabReglaFunGen />;
      case 'DashTrabDocLabReglaRIOHS':
        return <DashTrabDocLabReglaRIOHS />;
      case 'DashTrabDocLabContrCopia':
        return <DashTrabDocLabContrCopia />;
      case 'DashTrabDocLabContrFirmar':
        return <DashTrabDocLabContrFirmar />;
      default:
        return <h1>{currentOption}</h1>;
    }
  };

  return (
    <div className="panel">
      {renderContent()}
    </div>
  );
};

export default Panel;
