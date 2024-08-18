import React from 'react';
import AppBar from '@mui/material/AppBar';
import Toolbar from '@mui/material/Toolbar';
import Typography from '@mui/material/Typography';
import IconButton from '@mui/material/IconButton';
import Button from '@mui/material/Button';
import MenuIcon from '@mui/icons-material/Menu';
import { green } from '@mui/material/colors';
import Box from '@mui/material/Box';
import '../../css/Header.css';

const Header = ({ onLogout }) => {
  const handleLogout = () => {
    onLogout(); // Llama a la función de cierre de sesión
    window.location.href = '/'; // Redirige a la página de inicio de sesión
  };

  return (
    <AppBar position="static" className="app-bar">
      <Toolbar>
        <Box
          component="a"
          href="#"
          className="logo-container"
        >
          <img src="logo.png" alt="Logo" width="60" />
          <Typography variant="h6" className="title">
            GRHIN
          </Typography>
        </Box>
        <Box sx={{ flexGrow: 1 }} />
        <Button
          variant="outlined"
          className="logout-button"
          onClick={handleLogout}
        >
          Cerrar sesión
        </Button>
      </Toolbar>
    </AppBar>
  );
};

export default Header;
