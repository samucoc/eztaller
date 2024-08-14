import React from 'react';
import { Button, Card, CardContent, Typography, Box } from '@mui/material';

const DocumentosCard = ({ empresaId }) => {
  return (
    <Card sx={{ mb: 3 }}>
      <CardContent>
        <Typography variant="h5" component="div" gutterBottom>
          Documentos
        </Typography>
        <Box sx={{ display: 'flex', justifyContent: 'space-between', gap: 2 }}>
          <Card sx={{ flexGrow: 1 }}>
            <CardContent>
              <Typography variant="h6" component="div">
                Liquidaciones
              </Typography>
              <Button variant="contained" color="primary" sx={{ mt: 1 }}>
                Gestionar Liquidaciones
              </Button>
            </CardContent>
          </Card>
          <Card sx={{ flexGrow: 1 }}>
            <CardContent>
              <Typography variant="h6" component="div">
                Documentos Generales
              </Typography>
              <Button variant="contained" color="primary" sx={{ mt: 1 }}>
                Gestionar Documentos Generales
              </Button>
            </CardContent>
          </Card>
          <Card sx={{ flexGrow: 1 }}>
            <CardContent>
              <Typography variant="h6" component="div">
                Documentos Individuales
              </Typography>
              <Button variant="contained" color="primary" sx={{ mt: 1 }}>
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

