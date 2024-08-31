import React, { useState } from 'react';
import { Tabs, Tab, Box } from '@mui/material';

const DashboardTipoDoc = ({ tipoDocumentos, onDocTypeChange }) => {
  const [selectedTab, setSelectedTab] = useState('');

  const handleTabChange = (event, newValue) => {
    setSelectedTab(newValue);
    onDocTypeChange(newValue); // Llama a la función para filtrar documentos por tipo
  };

  return (
    <Box sx={{ width: '100%', overflowX: 'auto' }}>
    <Tabs
      value={selectedTab}
      onChange={handleTabChange}
      variant="scrollable"
      scrollButtons="auto"
      aria-label="Tipo de Documento"
      sx={{ whiteSpace: 'nowrap' }}
    >
      <Tab label="Todos" value="" />
      {tipoDocumentos.map((tipo) => (
        <Tab
          key={tipo.id}
          label={tipo.nombre}
          value={tipo.id}
          sx={{ marginX: 2.5, width: '150px'}} // Adds 20px horizontal margin to each Tab
        />
      ))}
    </Tabs>
    <br/>
  </Box>
);
};

export default DashboardTipoDoc;
