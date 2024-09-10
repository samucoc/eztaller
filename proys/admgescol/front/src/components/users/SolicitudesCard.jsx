import React from 'react';
import { Grid, Typography, List, ListItem, ListItemIcon, ListItemText } from '@mui/material';
import MoneyIcon from '@mui/icons-material/Money';
import CreditCardIcon from '@mui/icons-material/CreditCard';
import AccessTimeIcon from '@mui/icons-material/AccessTime';
import BeachAccess from '@mui/icons-material/BeachAccess';
import { useNavigate } from 'react-router-dom';

const DocumentosCard = ({ usuario }) => {
    const navigate = useNavigate();

    const handleSolicitarAnticipo = () => {
        navigate('/SolicitarAnticipo');
    };

    const handleSolicitarPrestamo = () => {
        navigate('/SolicitarPrestamo');
    };

    const handleSolicitarPermiso = () => {
        navigate('/SolicitarPermiso');
    };

    const handleSolicitarVacaciones = () => {
        navigate('/SolicitarVacaciones');
    };

    return (
    <List>
      <Grid container spacing={2}>
        {/* Contratos y Anexos */}
        <Grid item xs={12} sm={6} md={3}>
            <ListItem
                button
                sx={{
                    border: '1px solid rgba(63, 81, 181, 0.5)', // Borde azul con 50% de transparencia
                    borderRadius: '4px',          // Añade esquinas redondeadas
                padding: '10px 15px',         // Agrega padding para darle apariencia de botón
                marginBottom: '10px',         // Agrega margen inferior para separación
                '&:hover': {
                    backgroundColor: '#f0f0f0', // Cambia el color de fondo al pasar el mouse
                },
                }}
                onClick={handleSolicitarAnticipo}

            >   
                        <ListItemIcon>
                        <MoneyIcon sx={{ color: '#3f51b5' }} />
                        </ListItemIcon>
                        <ListItemText primary="Solicitud de Anticipo" />
          </ListItem>
        </Grid>

        {/* Liquidaciones */}
        <Grid item xs={12} sm={6} md={3}>
            <ListItem
                button
                sx={{
                    border: '1px solid rgba(63, 81, 181, 0.5)', // Borde azul con 50% de transparencia
                    borderRadius: '4px',          // Añade esquinas redondeadas
                padding: '10px 15px',         // Agrega padding para darle apariencia de botón
                marginBottom: '10px',         // Agrega margen inferior para separación
                '&:hover': {
                    backgroundColor: '#f0f0f0', // Cambia el color de fondo al pasar el mouse
                },
                }}
                onClick={handleSolicitarPrestamo}
            >   
                        <ListItemIcon>
                        <CreditCardIcon sx={{ color: '#3f51b5' }} />
                        </ListItemIcon>
                        <ListItemText primary="Solicitud de Préstamo" />
          </ListItem>
        </Grid>

        {/* Reglamentos */}
        <Grid item xs={12} sm={6} md={3}>
            <ListItem
                button
                sx={{
                    border: '1px solid rgba(63, 81, 181, 0.5)', // Borde azul con 50% de transparencia
                    borderRadius: '4px',          // Añade esquinas redondeadas
                padding: '10px 15px',         // Agrega padding para darle apariencia de botón
                marginBottom: '10px',         // Agrega margen inferior para separación
                '&:hover': {
                    backgroundColor: '#f0f0f0', // Cambia el color de fondo al pasar el mouse
                },
                }}
                onClick={handleSolicitarPermiso}
            >   
                        <ListItemIcon>
                        <AccessTimeIcon sx={{ color: '#3f51b5' }} />
                        </ListItemIcon>
                        <ListItemText primary="Solicitud de Permiso" />
          </ListItem>
        </Grid>

        {/* Otros */}
        <Grid item xs={12} sm={6} md={3}>
            <ListItem
                button
                sx={{
                border: '1px solid rgba(63, 81, 181, 0.5)', // Borde azul con 50% de transparencia
                borderRadius: '4px',          // Añade esquinas redondeadas
                padding: '10px 15px',         // Agrega padding para darle apariencia de botón
                marginBottom: '10px',         // Agrega margen inferior para separación
                '&:hover': {
                    backgroundColor: '#f0f0f0', // Cambia el color de fondo al pasar el mouse
                },
                }}
                onClick={handleSolicitarVacaciones}
            >   
                        <ListItemIcon>
                        <BeachAccess sx={{ color: '#3f51b5' }} />
                        </ListItemIcon>
                        <ListItemText primary="Solicitud de Beneficios" />
          </ListItem>
        </Grid>
      </Grid>
    </List>
  );
};

export default DocumentosCard;
