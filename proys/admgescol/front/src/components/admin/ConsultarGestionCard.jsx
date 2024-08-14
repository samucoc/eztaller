// ConsultarGestionCard.jsx
import React from 'react';
import { Button, Card, CardContent, Typography, Box } from '@mui/material';
import { useNavigate } from 'react-router-dom';

const ConsultarGestionCard = ({ empresaId }) => {
  const navigate = useNavigate();

  const handleConsultarDocumentos = () => {
    navigate('/Documentos');
  };

  const handleConsultarTrabajadores = () => {
    navigate('/Trabajadores');
  };

  return (
    <Card sx={{ mb: 2, flexGrow: 1 }}>
      <CardContent>
        <Typography variant="h6" component="div">
          Consultar Documentos y Gestión de Trabajos
        </Typography>
        <Box sx={{ display: 'flex', justifyContent: 'space-between', mt: 2 }}>
          <Card sx={{ flexGrow: 1, mx: 1 }}>
            <CardContent>
              <Button variant="contained" color="primary" sx={{ width: '100%' }} onClick={handleConsultarDocumentos}>
                Consultar Documentos
              </Button>
            </CardContent>
          </Card>
          <Card sx={{ flexGrow: 1, mx: 1 }}>
            <CardContent>
              <Button variant="contained" color="secondary" sx={{ width: '100%' }} onClick={handleConsultarTrabajadores}>
                Gestionar Trabajos
              </Button>
            </CardContent>
          </Card>
        </Box>
      </CardContent>
    </Card>
  );
};

export default ConsultarGestionCard;
