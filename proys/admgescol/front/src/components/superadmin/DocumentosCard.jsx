import React from 'react';
import { Button, Card, CardContent, Typography, Box } from '@mui/material';
import AttachMoneyIcon from '@mui/icons-material/AttachMoney';
import FolderIcon from '@mui/icons-material/Folder';
import DescriptionIcon from '@mui/icons-material/Description';
import { useNavigate } from 'react-router-dom';

const DocumentosCard = ({ empresaId }) => {
  const navigate = useNavigate();

  const handleLiquidaciones = () => {
    navigate('/LiquidacionesToPdf');
  };

  const handleGestionarIndividuales = () => {
    navigate('/DocumentosToPdf');
  };

  const handleGestionarGenerales = () => {
    navigate('/DocumentosGenToPdf');
  };

  return (
    <Card sx={{ mb: 3 }}>
      <CardContent>
        <Box sx={{ display: 'flex', justifyContent: 'space-between', gap: 2 }}>
          <Card sx={{ flexGrow: 1 }}>
            <CardContent>
              <Typography variant="h6" component="div">
                Liquidaciones
              </Typography>
              <Button 
                variant="contained" 
                color="primary" 
                sx={{ mt: 1 }} 
                startIcon={<AttachMoneyIcon />}
                onClick={handleLiquidaciones}

              >
                Gestionar Liquidaciones
              </Button>
            </CardContent>
          </Card>
          <Card sx={{ flexGrow: 1 }}>
            <CardContent>
              <Typography variant="h6" component="div">
                Documentos Generales
              </Typography>
              <Button 
                variant="contained" 
                color="primary" 
                sx={{ mt: 1 }} 
                startIcon={<FolderIcon />}
                onClick={handleGestionarGenerales}

              >
                Gestionar Documentos Generales
              </Button>
            </CardContent>
          </Card>
          <Card sx={{ flexGrow: 1 }}>
            <CardContent>
              <Typography variant="h6" component="div">
                Documentos Individuales
              </Typography>
              <Button 
                variant="contained" 
                color="primary" 
                sx={{ mt: 1 }} 
                startIcon={<DescriptionIcon />}
                onClick={handleGestionarIndividuales}

              >
                Gestionar Documentos Individuales
              </Button>
            </CardContent>
          </Card>
        </Box>
      </CardContent>
    </Card>
  );
};

export default DocumentosCard;
