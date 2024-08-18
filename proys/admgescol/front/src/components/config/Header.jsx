import React from 'react';
import AppBar from '@mui/material/AppBar';
import Toolbar from '@mui/material/Toolbar';
import Typography from '@mui/material/Typography';
import IconButton from '@mui/material/IconButton';
import Button from '@mui/material/Button';
import MenuIcon from '@mui/icons-material/Menu';
import { green } from '@mui/material/colors';
import Box from '@mui/material/Box';

const Header = ({ onLogout }) => {
  const handleLogout = () => {
    onLogout(); // Llama a la función de cierre de sesión
    window.location.href = '/'; // Redirige a la página de inicio de sesión
  };

  return (
    <AppBar
      position="static"
      sx={{
        backgroundColor: 'white', // Tono verde para la barra de aplicación
        color: 'black', // Texto blanco en toda la aplicación
        boxShadow: 'none', // Sin sombra de caja
      }}
    >
      <Toolbar>
        <IconButton
          edge="start"
          color="inherit"
          aria-label="menu"
          sx={{ mr: 2 }}
        >
          <MenuIcon />
        </IconButton>
        <Box
          component="a"
          href="#"
          sx={{
            display: 'flex',
            alignItems: 'center',
            color: 'inherit',
            textDecoration: 'none',
          }}
        >
          <img src="logo.png" alt="Logo" width="60" />
          <Typography variant="h6" sx={{ ml: 1 }}>
            GRHIN
          </Typography>
        </Box>
        <Box sx={{ flexGrow: 1 }} />
        <Button
          variant="outlined"
          sx={{
            borderColor: 'white', // Borde blanco para el botón
            color: 'white', // Texto blanco en el botón
            '&:hover': {
              backgroundColor: green[700], // Cambia ligeramente el tono de verde al hacer hover
              borderColor: 'white',
            },
          }}
          onClick={handleLogout}
        >
          Cerrar sesión
        </Button>
      </Toolbar>
    </AppBar>
  );
};

export default Header;
