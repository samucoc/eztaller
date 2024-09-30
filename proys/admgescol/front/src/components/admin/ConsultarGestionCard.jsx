// ConsultarGestionCard.jsx
import React from 'react';
import { Button, Card, CardContent, Typography, Box } from '@mui/material';
import { useNavigate } from 'react-router-dom';
import DescriptionIcon from '@mui/icons-material/Description';
import GroupIcon from '@mui/icons-material/Group';

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
        <Box sx={{ display: 'flex', justifyContent: 'space-between', mt: 2 }}>
          <Card sx={{ flexGrow: 1, mx: 1 }}>
            <CardContent>
              <Typography variant="h6" sx={{ color: 'black' }}>Documentos de la Empresa</Typography>
              <Typography variant="body2" color="textSecondary" sx={{ mt: 1 }}>              
                Aquí puedes revisar todos los documentos subidos al sistema
              </Typography>
              <Button
                variant="outlined"
                color="primary"
                sx={{ width: '100%' }}
                startIcon={<DescriptionIcon />}
                onClick={handleConsultarDocumentos}
              >
                Consultar Documentos
              </Button>
            </CardContent>
          </Card>
          <Card sx={{ flexGrow: 1, mx: 1 }}>
            <CardContent>
              <Typography variant="h6" sx={{ color: 'black' }}>Listado de Trabajadores</Typography>
              <Typography variant="body2" color="textSecondary" sx={{ mt: 1 }}>              
                Aquí puedes revisar y actualizar los datos de tus trabajadores       
              </Typography>
              <Button
                variant="outlined"
                color="primary"
                sx={{ width: '100%' }}
                startIcon={<GroupIcon />}
                onClick={handleConsultarTrabajadores}
              >
                Gestionar Trabajadores
              </Button>
            </CardContent>
          </Card>
        </Box>
      </CardContent>
    </Card>
  );
};

export default ConsultarGestionCard;

