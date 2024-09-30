import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here
import { Box, Typography, Card, CardActionArea , CardContent, Button, Grid } from '@mui/material';
import { useParams, useNavigate } from 'react-router-dom';

import SolicitudesCard from './SolicitudesCard';
import ComunicacionesCard from './ComunicacionesCard';
import DocumentosCard from './DocumentosCard';
import ConsultarGestionCard from './ConsultarGestionCard';
import { useDispatch, useSelector } from 'react-redux';

const ManageEmpresa = () => {
  const [value, setValue] = useState(0);
  const [empresa, setEmpresa] = useState([]);
  const { id } = useParams();
  const navigate = useNavigate();
  const [pendingCount, setPendingCount] = useState(0);
  const token = useSelector((state) => state.token);

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
        const response = await axios.get(`${API_BASE_URL}/solicitudes/all/${token}`); // Replace with your API endpoint
        const resultSol = response.data.filter((s) => s.empresa_id === id && s.status === "1");
        setPendingCount(resultSol.length);
      } catch (error) {
        console.error('Error fetching pending solicitudes count:', error);
      }
    };

    fetchPendingCount();

  }, [id]);

  return (
    <div className="container empresas">
        {/* Display the company title */}
        <Box>
          <Typography variant="h4" component="h1">
            {empresa?.NombreFantasia}
          </Typography>
          <Typography variant="h6" component="h2">
            {empresa?.RazonSocial}
          </Typography>
          <br />
         
        </Box>

        {/* Cards as Buttons using Grid */}
        <Grid container >
          {/* Documentos Card */}
          <Grid item xs={12} md={12}>
            <DocumentosCard empresaId={empresa?.id} />
          </Grid>

          {/* Consultar Documentos y Gestión de Trabajos Card */}
          <Grid item xs={12} md={12}>
            <Typography variant="h6" sx={{ color: 'black' }}>
              Consultar Datos
            </Typography>
            <ConsultarGestionCard empresaId={empresa?.id} />
          </Grid>

          {/* Solicitudes Card */}
          <Grid item xs={12} md={4} sx={{ backgroundColor: '#f5f5f5'}}>
            <Card sx={{ backgroundColor: '#f5f5f5', flexGrow: 1, mx: 1 }}>
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
          <Grid item xs={12} md={4}>
            <Card sx={{ flexGrow: 1, mx: 1 }}>
              <>
                <CardContent>
                  <Typography variant="h6" sx={{ color: 'black' }}>Comunicaciones</Typography>
                  <Typography variant="body2" color="textSecondary" sx={{ mt: 1 }}>Publica las últimas noticias sobre tu establecimiento</Typography>
                  <br/>
                  <Button
                    variant="outlined"
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
          {/* Ley Karin Card */}
          <Grid item xs={12} md={4}>
            <Card sx={{ flexGrow: 1, mx: 1 }}>
              <>
                <CardContent>
                  <Typography variant="h6" sx={{ color: 'black' }}>Denuncias Ley Karin</Typography>
                  <Typography variant="body2" color="textSecondary" sx={{ mt: 1 }}>Revisa las ultimas denuncias con respecto a esta ley</Typography>
                  <br/>
                  <Button
                    variant="outlined"
                    color="primary"
                    sx={{ mt: 2 }}
                    onClick={() => handleItemClick(`/LeyKarin`)} // Adjust path as per routing
                  >
                    Gestionar
                  </Button>
                </CardContent>
              </>
            </Card>
          </Grid>
        </Grid>
    </div>
  );
};

export default ManageEmpresa;
