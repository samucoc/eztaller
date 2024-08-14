import React from 'react';
import { Button, Card, CardContent, Typography } from '@mui/material';

const ComunicacionesCard = ({ empresaId }) => {
  return (
    <Card sx={{ mb: 3 }}>
      <CardContent>
        <Typography variant="h5" component="div" gutterBottom>
          Comunicaciones
        </Typography>
        <Button variant="contained" color="primary">
          Gestionar Comunicaciones
        </Button>
      </CardContent>
    </Card>
  );
};

export default ComunicacionesCard;

