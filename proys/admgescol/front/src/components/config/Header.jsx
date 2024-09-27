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
import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here
import '../../css/Header.css';
import { useParams, useNavigate, Link  } from 'react-router-dom';

const Header = ({ onLogout }) => {
  const dispatch = useDispatch();
  const [anchorEl, setAnchorEl] = useState(null);
  const userDNI = useSelector((state) => state.userDNI); // Assuming userDNI is stored in Redux
  const notificacionesNoVistas = useSelector((state) => state.notificacionesNoVistas);
  const notificaciones = useSelector((state) => state.notificaciones); // Todas las notificaciones
  const roleSession = useSelector((state) => state.roleSession); // Obteniendo roleSession desde Redux
  const href = roleSession === "3" ? '/UserDashboard' : '/Empresas'; // Verificando si es 3 o no
  const navigate = useNavigate();
  const token = useSelector((state) => state.token);

  // Fetch notificaciones in Header
  useEffect(() => {
    const fetchNotificaciones = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/notificaciones/all/${token}`); // Replace with your API endpoint
        const sortedNotificaciones = response.data
          .filter((noti) => noti.trabajador === userDNI && (noti.vista === 'false' || noti.vista === null))
          .sort((a, b) => new Date(b.fecha) - new Date(a.fecha));
        
        // Dispatch action to store notifications in Redux
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
      // Enviar una solicitud para marcar las notificaciones como vistas en el backend
      await axios.get(`${API_BASE_URL}/notificaciones/notificaciones-marcadas/${userDNI}`);
  
      // Después de marcar las notificaciones como vistas, actualiza el estado en el frontend
      // Aquí se asume que el backend responde con la lista actualizada de notificaciones
      const response = await axios.get(`${API_BASE_URL}/notificaciones`);
      const sortedNotificaciones = response.data
        .filter((noti) => noti.trabajador === userDNI && (noti.vista === 'false' || noti.vista === null))
        .sort((a, b) => new Date(b.fecha) - new Date(a.fecha));
  
      // Dispatch action to update notifications in Redux
      dispatch(setNotificaciones(sortedNotificaciones));
      handleClose();
    } catch (error) {
      console.error('Error marking notifications as viewed:', error);
    }
  };
  
  // Function to handle button clicks for navigation
  const handleItemClick = (path) => {
    navigate(path); // Use navigate to change route
  };

  const open = Boolean(anchorEl);
  const id = open ? 'notifications-popover' : undefined;

  return (
    <AppBar position="static" className="app-bar">
      <Toolbar>
      <Box
          component={Link}
          to={href} // Navegación dinámica basada en roleSession
          className="logo-container"
          sx={{ display: 'flex', alignItems: 'center', textDecoration: 'none' }} // Estilos adicionales opcionales
        >
          <img src="logo.png" alt="Logo" width="60" />
        </Box>
        <Box sx={{ flexGrow: 1 }} />
        {/* Campanita de notificaciones */}
        <IconButton color="inherit" onClick={handleBellClick}>
          <Badge badgeContent={notificacionesNoVistas} color="secondary">
            <NotificationsIcon />
          </Badge>
        </IconButton>

        <Button
          variant="outlined"
          className="logout-button"
          onClick={onLogout}
        >
          Cerrar sesión
        </Button>
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
        <Box sx={{ p: 2, width: '300px' , height: '300px' }}>
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
