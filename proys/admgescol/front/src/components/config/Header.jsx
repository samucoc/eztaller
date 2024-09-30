import React, { useState, useEffect } from 'react';
import AppBar from '@mui/material/AppBar';
import Toolbar from '@mui/material/Toolbar';
import Typography from '@mui/material/Typography';
import IconButton from '@mui/material/IconButton';
import Button from '@mui/material/Button';
import Badge from '@mui/material/Badge';
import NotificationsIcon from '@mui/icons-material/Notifications';
import Popover from '@mui/material/Popover';
import List from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import ListItemText from '@mui/material/ListItemText';
import Box from '@mui/material/Box';
import { useSelector, useDispatch } from 'react-redux';
import { setNotificaciones } from '../../actions';
import axios from 'axios';
import { Avatar, Menu, MenuItem } from '@mui/material';
import { API_BASE_URL } from '../config/apiConstants';
import { useNavigate, Link } from 'react-router-dom';
import '../../css/Header.css';

const Header = ({ onLogout }) => {
  const dispatch = useDispatch();
  const [anchorEl, setAnchorEl] = useState(null);
  const [profileAnchorEl, setProfileAnchorEl] = useState(null); // Para el perfil
  const userDNI = useSelector((state) => state.userDNI);
  const username = useSelector((state) => state.username); // Asumiendo que el nombre de usuario está en Redux
  const nombre = useSelector((state) => state.nombre);

  const notificacionesNoVistas = useSelector((state) => state.notificacionesNoVistas);
  const notificaciones = useSelector((state) => state.notificaciones);
  const roleSession = useSelector((state) => state.roleSession);
  const token = useSelector((state) => state.token);
  const navigate = useNavigate();

  // Iniciales del nombre de usuario
  const userInitials = username ? username.slice(0, 2).toUpperCase() : '';

  useEffect(() => {
    const fetchNotificaciones = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/notificaciones/all/${token}`);
        const sortedNotificaciones = response.data
          .filter((noti) => noti.trabajador === userDNI && (noti.vista === 'false' || noti.vista === null))
          .sort((a, b) => new Date(b.fecha) - new Date(a.fecha));
        dispatch(setNotificaciones(sortedNotificaciones));
      } catch (error) {
        console.error('Error fetching notifications:', error);
      }
    };

    fetchNotificaciones();
  }, [dispatch, userDNI]);

  const handleBellClick = (event) => {
    setAnchorEl(event.currentTarget);
  };

  const handleClose = () => {
    setAnchorEl(null);
  };

  const handleNotificacionesVistas = async () => {
    try {
      await axios.get(`${API_BASE_URL}/notificaciones/notificaciones-marcadas/${userDNI}`);
      const response = await axios.get(`${API_BASE_URL}/notificaciones`);
      const sortedNotificaciones = response.data
        .filter((noti) => noti.trabajador === userDNI && (noti.vista === 'false' || noti.vista === null))
        .sort((a, b) => new Date(b.fecha) - new Date(a.fecha));
      dispatch(setNotificaciones(sortedNotificaciones));
      handleClose();
    } catch (error) {
      console.error('Error marking notifications as viewed:', error);
    }
  };

  // Funciones para el menú de perfil
  const handleProfileClick = (event) => {
    setProfileAnchorEl(event.currentTarget);
  };

  const handleProfileClose = () => {
    setProfileAnchorEl(null);
  };

  const handleViewProfile = () => {
    navigate('/Perfiles');
    handleProfileClose();
  };

  const open = Boolean(anchorEl);
  const id = open ? 'notifications-popover' : undefined;

  return (
    <AppBar position="static" className="app-bar">
      <Toolbar>
        <Box
          component={Link}
          to={roleSession === "3" ? '/UserDashboard' : '/Empresas'}
          className="logo-container"
          sx={{ display: 'flex', alignItems: 'center', textDecoration: 'none' }}
        >
          <img src="logo.png" alt="Logo" width="120" />
        </Box>
        <Box sx={{ flexGrow: 1 }} />
        
        {/* Campanita de notificaciones */}
        <IconButton color="inherit" onClick={handleBellClick}>
          <Badge badgeContent={notificacionesNoVistas} color="secondary">
            <NotificationsIcon />
          </Badge>
        </IconButton>

        {/* Nombre de usuario en letras verdes */}
        <span style={{ color: 'white', fontWeight: 'bold', marginLeft: '10px' }}>
          {nombre}
        </span>

        {/* Botón de perfil */}
        <IconButton onClick={handleProfileClick} sx={{ ml: 2 }}>
          <Avatar sx={{ bgcolor: 'primary.main' }}>{userInitials}</Avatar>
        </IconButton>
        
        <Menu
          anchorEl={profileAnchorEl}
          open={Boolean(profileAnchorEl)}
          onClose={handleProfileClose}
          anchorOrigin={{
            vertical: 'bottom',
            horizontal: 'right',
          }}
          transformOrigin={{
            vertical: 'top',
            horizontal: 'right',
          }}
        >
          <MenuItem disabled>
            <Typography variant="body1">Bienvenido, {username}</Typography>
          </MenuItem>
          <MenuItem onClick={handleViewProfile}>Ver Perfil</MenuItem>
          <MenuItem onClick={onLogout}>Cerrar Sesión</MenuItem>
        </Menu>
      </Toolbar>

      {/* Popover para mostrar notificaciones */}
      <Popover
        id={id}
        open={open}
        anchorEl={anchorEl}
        onClose={handleClose}
        anchorOrigin={{
          vertical: 'bottom',
          horizontal: 'right',
        }}
        transformOrigin={{
          vertical: 'top',
          horizontal: 'right',
        }}
      >
        <Box sx={{ p: 2, width: '300px', height: '300px' }}>
          <Typography variant="h6">Notificaciones</Typography>
          <List>
            {notificaciones.length === 0 ? (
              <Typography variant="body2">No hay notificaciones</Typography>
            ) : (
              notificaciones.map((notificacion) => (
                <ListItem key={notificacion.id}>
                  <ListItemText primary={notificacion.mensaje} />
                </ListItem>
              ))
            )}
          </List>
          <Button
            variant="contained"
            color="primary"
            onClick={handleNotificacionesVistas}
            fullWidth
          >
            Marcar como vistas
          </Button>
        </Box>
      </Popover>
    </AppBar>
  );
};

export default Header;
