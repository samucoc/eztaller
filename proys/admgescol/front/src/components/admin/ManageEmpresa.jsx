import React, { useState } from 'react';
import Tabs from '@mui/material/Tabs';
import Tab from '@mui/material/Tab';
import Box from '@mui/material/Box';
import Typography from '@mui/material/Typography'; // Import Typography for titles

import SolicitudesCard from './SolicitudesCard';
import ComunicacionesCard from './ComunicacionesCard';
import DocumentosCard from './DocumentosCard';
import ConsultarGestionCard from './ConsultarGestionCard';

function TabPanel(props) {
  const { children, value, index, ...other } = props;

  return (
    <div
      role="tabpanel"
      hidden={value !== index}
      id={`tabpanel-${index}`}
      aria-labelledby={`tab-${index}`}
      {...other}
    >
      {value === index && (
        <Box p={3}>
          {children}
        </Box>
      )}
    </div>
  );
}

const ManageEmpresa = ({ empresa }) => {
  const [value, setValue] = useState(0);

  const handleChange = (event, newValue) => {
    setValue(newValue);
  };

  return (
    <Box sx={{ width: '100%' }}>
      {/* Display the company title */}
      <Box sx={{ mb: 2 }}>
        <Typography variant="h4" component="h1" gutterBottom>
          {empresa.RazonSocial}
        </Typography>
        <Typography variant="h6" component="h2">
          {empresa.NombreFantasia}
        </Typography>
      </Box>

      <Tabs value={value} onChange={handleChange} aria-label="Manage Empresa Tabs">
        <Tab label="Solicitudes" id="tab-0" />
        <Tab label="Comunicaciones" id="tab-1" />
        <Tab label="Documentos" id="tab-2" />
        <Tab label="Consultar y Gestión" id="tab-3" />
      </Tabs>

      <TabPanel value={value} index={0}>
        <SolicitudesCard empresaId={empresa.id} />
      </TabPanel>
      <TabPanel value={value} index={1}>
        <ComunicacionesCard empresaId={empresa.id} />
      </TabPanel>
      <TabPanel value={value} index={2}>
        <DocumentosCard empresaId={empresa.id} />
      </TabPanel>
      <TabPanel value={value} index={3}>
        <ConsultarGestionCard empresaId={empresa.id} />
      </TabPanel>
    </Box>
  );
};

export default ManageEmpresa;
