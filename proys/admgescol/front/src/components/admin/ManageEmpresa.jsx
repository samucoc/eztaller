import React, { useState, useEffect } from 'react';
import axios from 'axios';
import API_BASE_URL from '../config/apiConstants';
import Box from '@mui/material/Box';
import Typography from '@mui/material/Typography';
import Card from '@mui/material/Card';
import CardActionArea from '@mui/material/CardActionArea';
import CardContent from '@mui/material/CardContent';
import Button from '@mui/material/Button'; // Import Button
import { useParams } from 'react-router-dom';

import SolicitudesCard from './SolicitudesCard';
import ComunicacionesCard from './ComunicacionesCard';
import DocumentosCard from './DocumentosCard';
import ConsultarGestionCard from './ConsultarGestionCard';

const ManageEmpresa = () => {
  const [value, setValue] = useState(0);
  const [empresa, setEmpresa] = useState([])
  const { id } = useParams();

  const handleChangeSolicitudes = (newValue) => {
    setValue(newValue);
  };

  const handleChangeComunicaciones = (newValue) => {
    setValue(newValue);
  };

  useEffect(() => {
    if (id) {
      axios
        .get(`${API_BASE_URL}/empresas/show/${id}`)
        .then((response) => {
          setEmpresa(response.data);
        })
        .catch((error) => {
          console.error('Error fetching razonSocial:', error);
          setEmpresa('');
        });
    }
  }, [id]);

  return (
    <Box sx={{ width: '100%' }}>
      {/* Display the company title */}
      <Box sx={{ mb: 2 }}>
        <Typography variant="h4" component="h1" gutterBottom>
          {empresa?.RazonSocial}
        </Typography>
        <Typography variant="h6" component="h2">
          {empresa?.NombreFantasia}
        </Typography>
        <br></br>
        <Typography variant="h8" component="h3">
          ¿Qué deseas realizar?
        </Typography>
      </Box>

      {/* Cards as Buttons */}
      <Box sx={{ display: 'flex', flexDirection: 'column', gap: 2, mb: 3 }}>
        <Card
          sx={{
            minWidth: 200,
            border: value === 0 ? '2px solid #3f51b5' : '1px solid #ccc',
            backgroundColor: value === 0 ? '#e8eaf6' : '#fff',
          }}
        >
          <CardActionArea >
            <CardContent>
              <Typography variant="h6">Solicitudes</Typography>
              <Button 
                variant="contained" 
                color="primary" 
                sx={{ mt: 2 }} 
                onClick={() => handleChangeSolicitudes(empresa?.id)}
              >
                Gestionar
              </Button>
            </CardContent>
          </CardActionArea>
        </Card>

        <Card
          sx={{
            minWidth: 200,
            border: value === 1 ? '2px solid #3f51b5' : '1px solid #ccc',
            backgroundColor: value === 1 ? '#e8eaf6' : '#fff',
          }}
        >
          <CardActionArea >
            <CardContent>
              <Typography variant="h6">Comunicaciones</Typography>
              <Button 
                variant="contained" 
                color="primary" 
                sx={{ mt: 2 }} 
                onClick={() => handleChangeComunicaciones(empresa?.id)}
              >
                Gestionar
              </Button>
            </CardContent>
          </CardActionArea>
        </Card>

        <Card
          sx={{
            minWidth: 200,
            border: value === 2 ? '2px solid #3f51b5' : '1px solid #ccc',
            backgroundColor: value === 2 ? '#e8eaf6' : '#fff',
          }}
        >
          <CardActionArea>
            <CardContent>
              <Typography variant="h6">Documentos</Typography>
              <DocumentosCard empresaId={empresa?.id}/>
            </CardContent>
          </CardActionArea>
        </Card>

        <Card
          sx={{
            minWidth: 200,
            border: value === 3 ? '2px solid #3f51b5' : '1px solid #ccc',
            backgroundColor: value === 3 ? '#e8eaf6' : '#fff',
          }}
        >
          <CardActionArea>
            <CardContent>
              <Typography variant="h6">
                Consultar Documentos y Gestión de Trabajos
              </Typography>
              <ConsultarGestionCard empresaId={empresa?.id}/>
            </CardContent>
          </CardActionArea>
        </Card>
      </Box>

    </Box>
  );
};

export default ManageEmpresa;