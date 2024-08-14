import React, { useState } from 'react';
import { Tabs, Tab, Button, Box, Typography, Paper } from '@mui/material';

const SolicitudesCard = ({ empresaId }) => {
  const [solicitudes, setSolicitudes] = useState({
    anticipos: [],
    prestamos: [],
    permisos: [],
    vacaciones: []
  });

  const [value, setValue] = useState('anticipos');

  const handleChange = (event, newValue) => {
    setValue(newValue);
  };

  const handleAccept = (type, id) => {
    // Lógica para aceptar una solicitud
  };

  const handleReject = (type, id) => {
    // Lógica para rechazar una solicitud
  };

  const renderSolicitudes = (type) => {
    return solicitudes[type].map(solicitud => (
      <Box key={solicitud.id} sx={{ display: 'flex', justifyContent: 'space-between', mb: 1 }}>
        <Typography>{solicitud.descripcion}</Typography>
        <Box>
          <Button variant="contained" color="success" onClick={() => handleAccept(type, solicitud.id)}>Aceptar</Button>
          <Button variant="contained" color="error" onClick={() => handleReject(type, solicitud.id)} sx={{ ml: 1 }}>Rechazar</Button>
        </Box>
      </Box>
    ));
  };

  return (
    <Paper sx={{ p: 2 }}>
      <Typography variant="h5" component="div" gutterBottom>
        Solicitudes Pendientes
      </Typography>
      <Tabs value={value} onChange={handleChange} aria-label="solicitudes tabs">
        <Tab label={`Anticipos (${solicitudes.anticipos.length})`} value="anticipos" />
        <Tab label={`Préstamos (${solicitudes.prestamos.length})`} value="prestamos" />
        <Tab label={`Permisos (${solicitudes.permisos.length})`} value="permisos" />
        <Tab label={`Vacaciones (${solicitudes.vacaciones.length})`} value="vacaciones" />
      </Tabs>
      <Box sx={{ p: 2 }}>
        {renderSolicitudes(value)}
      </Box>
      <Button variant="contained" color="info" sx={{ mt: 2 }}>
        Exportar a XLSX
      </Button>
    </Paper>
  );
};

export default SolicitudesCard;
