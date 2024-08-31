import React, { useState, useEffect } from 'react';
import axios from 'axios';
import API_BASE_URL from '../config/apiConstants';
import { Box, Typography, Card, CardActionArea , CardContent, Button, Grid } from '@mui/material';
import { useParams, useNavigate } from 'react-router-dom';

import SolicitudesCard from './SolicitudesCard';
import ComunicacionesCard from './ComunicacionesCard';
import DocumentosCard from './DocumentosCard';
import ConsultarGestionCard from './ConsultarGestionCard';

const ManageEmpresa = () => {
  const [value, setValue] = useState(0);
  const [empresa, setEmpresa] = useState([]);
  const { id } = useParams();
  const navigate = useNavigate();
  const [pendingCount, setPendingCount] = useState(0);

  // Function to handle button clicks for navigation
  const handleItemClick = (path) => {
    navigate(path); // Use navigate to change route
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
    const fetchPendingCount = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/solicitudes`);
        const resultSol = response.data.filter((s) => s.empresa_id === id && s.status === "1");
        setPendingCount(resultSol.length);
      } catch (error) {
        console.error('Error fetching pending solicitudes count:', error);
      }
    };

    fetchPendingCount();

  }, [id]);

  return (
    <Box sx={{ width: '100%' }}>
      {/* Display the company title */}
      <Box>
        <Typography variant="h4" component="h1" gutterBottom>
          {empresa?.NombreFantasia}
        </Typography>
        <Typography variant="h6" component="h2">
          {empresa?.RazonSocial}
        </Typography>
        <br />
        <Typography variant="h6" component="h3">
          ¿Qué deseas realizar?
        </Typography>
      </Box>

      {/* Cards as Buttons using Grid */}
      <Grid container spacing={2} sx={{ mt: 2 }}>
        {/* Documentos Card */}
        <Grid item xs={12} md={12}>
          <Typography variant="h6" sx={{ color: 'black' }}>Documentos</Typography>
          <DocumentosCard empresaId={empresa?.id} />
        </Grid>

        {/* Consultar Documentos y Gestión de Trabajos Card */}
        <Grid item xs={12} md={12}>
          <Typography variant="h6" sx={{ color: 'black' }}>
            Consultar Documentos y Gestión de Trabajos
          </Typography>
          <ConsultarGestionCard empresaId={empresa?.id} />
        </Grid>

        {/* Solicitudes Card */}
        <Grid item xs={12} md={6}>
          <Card
          >
            <>
              <CardContent>
                <Typography variant="h6" sx={{ color: 'black' }}>Solicitudes</Typography>
                <Typography variant="body2" color="textSecondary" sx={{ mt: 1 }}>              
                  Tienes {pendingCount} solicitud(es) por revisar
                </Typography>
                <br/>
                <Button
                  variant="contained"
                  color="primary"
                  sx={{ mt: 2 }}
                  onClick={() => handleItemClick(`/SolicitudesCard`)} // Adjust path as per routing
                >
                  Gestionar
                </Button>
              </CardContent>
            </>
          </Card>
        </Grid>

        {/* Comunicaciones Card */}
        <Grid item xs={12} md={6}>
          <Card
          >
            <>
              <CardContent>
                <Typography variant="h6" sx={{ color: 'black' }}>Comunicaciones</Typography>
                <Typography variant="body2" color="textSecondary" sx={{ mt: 1 }}>Publica las últimas noticias sobre tu establecimiento</Typography>
                <br/>
                <Button
                  variant="contained"
                  color="primary"
                  sx={{ mt: 2 }}
                  onClick={() => handleItemClick(`/ComunicacionesCard`)} // Adjust path as per routing
                >
                  Gestionar
                </Button>
              </CardContent>
            </>
          </Card>
        </Grid>
      </Grid>
    </Box>
  );
};

export default ManageEmpresa;
