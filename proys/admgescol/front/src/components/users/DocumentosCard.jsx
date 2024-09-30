import React from 'react';
import { Grid, Typography, List, ListItem, ListItemIcon, ListItemText } from '@mui/material';
import DescriptionIcon from '@mui/icons-material/Description';
import ReceiptIcon from '@mui/icons-material/Receipt';
import GavelIcon from '@mui/icons-material/Gavel';
import FolderOpenIcon from '@mui/icons-material/FolderOpen';
import { useNavigate } from 'react-router-dom';

const DocumentosCard = ({ usuario }) => {
    const navigate = useNavigate();

    const handleContratos = () => {
        navigate('/ContratosUser');
    };

    const handleLiquidaciones = () => {
        navigate('/LiquidacionesUser');
    };

    const handleReglamentos = () => {
        navigate('/ReglamentosUser');
    };

    const handleOtros = () => {
        navigate('/OtrosUser');
    };

      
  return (
    <List>
      <Grid container spacing={2}>
        
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
                onClick={handleLiquidaciones}

            >   
           <ListItemIcon>
              <ReceiptIcon sx={{ color: '#3f51b5' }} />
            </ListItemIcon>
            <ListItemText primary="Liquidaciones" />
          </ListItem>
        </Grid>

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
                onClick={handleContratos}

            >   
           <ListItemIcon>
              <DescriptionIcon sx={{ color: '#3f51b5' }} />
            </ListItemIcon>
            <ListItemText primary="Contratos y Anexos" />
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
                onClick={handleReglamentos}
            >   
           <ListItemIcon>
              <GavelIcon sx={{ color: '#3f51b5' }} />
            </ListItemIcon>
            <ListItemText primary="Reglamentos" />
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
                onClick={handleOtros}
            >   
           <ListItemIcon>
              <FolderOpenIcon sx={{ color: '#3f51b5' }} />
            </ListItemIcon>
            <ListItemText primary="Otros" />
          </ListItem>
        </Grid>
      </Grid>
    </List>
  );
};

export default DocumentosCard;
