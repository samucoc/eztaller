import React, { useState, useEffect } from 'react';
import axios from 'axios';
import API_BASE_URL from '../config/apiConstants';
import {
  Box, Typography, Card, CardActionArea, CardContent, Button, Grid, Modal, List, ListItem, ListItemText, Menu, MenuItem
} from '@mui/material';
import MoneyIcon from '@mui/icons-material/Money';
import CreditCardIcon from '@mui/icons-material/CreditCard';
import AccessTimeIcon from '@mui/icons-material/AccessTime';
import FlightTakeoffIcon from '@mui/icons-material/FlightTakeoff';
import AddIcon from '@mui/icons-material/Add';
import { useNavigate } from 'react-router-dom';
import { useDispatch, useSelector } from 'react-redux';
import DocumentosCard from './DocumentosCard';
import SolicitudesCard from './SolicitudesCard';

const ManageUser = () => {
  const [value, setValue] = useState(0);
  const [usuario, setUsuario] = useState(null); // Initialize as null
  const [openModal, setOpenModal] = useState(false);
  const [modalContent, setModalContent] = useState('');
  const [notificaciones, setNotificaciones] = useState([]);
  const [solicitudes, setSolicitudes] = useState([]);
  const [anchorEl, setAnchorEl] = useState(null);
  const [comunicaciones, setComunicaciones] = useState([]);
  const [trabajadores, setTrabajadores] = useState([]);

  const navigate = useNavigate();
  const dispatch = useDispatch();
  const empresaId = useSelector((state) => state.empresaId); // Assuming empresaId is stored in Redux
  const userDNI = useSelector((state) => state.userDNI); // Assuming userDNI is stored in Redux

  useEffect(() => {
    const fetchNotificaciones = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/notificaciones`);
        const sortedNotificaciones = response.data
          .filter((noti) => noti.trabajador === userDNI)
          .sort((a, b) => new Date(b.fecha) - new Date(a.fecha))
          .slice(0, 3);
        setNotificaciones(sortedNotificaciones);
      } catch (error) {
        console.error('Error al obtener las notificaciones:', error);
      }
    };

    const fetchSolicitudes = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/solicitudes`);
        const recentSolicitudes = response.data
          .filter((soli) => soli.status === '1' && soli.trabajador === userDNI)
          .sort((a, b) => new Date(b.fecha) - new Date(a.fecha))
          .slice(0, 3);
        setSolicitudes(recentSolicitudes);
      } catch (error) {
        console.error('Error al obtener solicitudes:', error);
      }
    };

    const fetchComunicaciones = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/comunicaciones`);
        const recentComunicaciones = response.data
          .filter((com) => com.empresa_id === empresaId)
          .sort((a, b) => new Date(b.fecha) - new Date(a.fecha))
          .slice(0, 3);
        setComunicaciones(recentComunicaciones);
      } catch (error) {
        console.error('Error al obtener comunicaciones:', error);
      }
    };

    if (userDNI && usuario === null) { // Correct condition check
      axios
        .get(`${API_BASE_URL}/users/showByRut/${userDNI}`)
        .then((response) => {
          setUsuario(response.data);
        })
        .catch((error) => {
          console.error('Error fetching user data:', error);
          setUsuario(null); // Handle error state
        });
    }

    const fetchTrabajadores = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/trabajadores`);
        setTrabajadores(response.data);
      } catch (error) {
        console.error('Error fetching trabajadores:', error);
      }
    };

    fetchTrabajadores();
    fetchComunicaciones();
    fetchSolicitudes();
    fetchNotificaciones();
  }, [userDNI, empresaId]); // Dependencies: userDNI and empresaId

  const handleOpenModal = (content) => {
    setModalContent(content);
    setOpenModal(true);
  };

  const handleCloseModal = () => {
    setOpenModal(false);
  };

  const handleClick = (event) => {
    setAnchorEl(event.currentTarget);
  };

  const handleClose = () => {
    setAnchorEl(null);
  };

  const handleMenuItemClick = (path) => {
    handleClose();
    navigate(path);
  };

  const getTrabajadorNombre = (trab) => {
    const trabajador = trabajadores.find(t => t.rut === trab);
    return trabajador ? `${trabajador.nombres} ${trabajador.apellido_paterno} ${trabajador.apellido_materno}` : 'Desconocido';
  };

  const getTipoSolicitud = (tipo_sol_id) => {
    switch (tipo_sol_id) {
      case '1':
        return 'Anticipo';
      case '2':
        return 'Préstamo';
      case '3':
        return 'Permiso';
      case '4':
        return 'Vacaciones';
      default:
        return 'Desconocido';
    }
  };
  
  const isPermiso = (tipo_sol_id) => {
    return getTipoSolicitud(tipo_sol_id) === 'Permiso'; // Adjust if necessary
  };

  return (
    <Box sx={{ width: '100%', p: 3 }}>
      {/* Display the user name and role */}
      <Box sx={{ mb: 3 }}>
        <Typography variant="h4" component="h1" gutterBottom>
          Hola, {usuario?.trabajador?.nombres}
        </Typography>
        <Typography variant="h6" component="h2">
          {usuario?.role?.roleName}
        </Typography>
      </Box>

      {/* Cards as Buttons using Grid */}
      <Grid container spacing={2}>
        <Grid item xs={12}>
          <Typography variant="h6" component="h3" sx={{ mb: 2 }}>
            ¿Qué deseas realizar?
          </Typography>
        </Grid>

        {/* Documentos Card */}
        <Grid item xs={12} md={12}>
          <Card
            sx={{
              minWidth: 200,
              border: value === 2 ? '2px solid #3f51b5' : '1px solid #ccc',
              backgroundColor: value === 2 ? '#e8eaf6' : '#fff',
            }}
          >
            <CardActionArea>
              <CardContent>
                <Typography variant="h6" sx={{ color: 'black' }}>
                  Consultar Documentos
                </Typography>
                <DocumentosCard usuario={usuario} />
              </CardContent>
            </CardActionArea>
          </Card>
        </Grid>

        {/* Botones de Solicitudes */}
        <Grid item xs={12} md={12}>
          <Card>
            <CardContent>
              <Typography variant="h6" sx={{ color: 'black' }}>
                Solicitudes
              </Typography>
              <SolicitudesCard usuario={usuario} />
            </CardContent>
          </Card>
        </Grid>

        <Grid item xs={12}>
          <Typography variant="h6" component="h3" sx={{ mb: 2 }}>
            ¿Qué deseas revisar?
          </Typography>
        </Grid>

        {/* Notificaciones del Sistema y Comunicaciones */}
        <Grid item xs={12} md={6}>
          <Card>
            <CardActionArea onClick={() => handleOpenModal('Notificaciones del Sistema')}>
              <CardContent>
                <Typography variant="h6" sx={{ color: 'black' }}>
                  Notificaciones del Sistema
                </Typography>
                <List>
                  {notificaciones.map((notificacion) => {
                    const [, tipoSolicitud] = notificacion.controlador.split('-');
                    return (
                      <ListItem key={notificacion.id}>
                        <Box sx={{ display: 'flex', alignItems: 'center', width: '100%' }}>
                          <Button variant="contained" color="primary" sx={{ marginRight: 2 }}>
                            {tipoSolicitud}
                          </Button>
                          <ListItemText primary={notificacion.mensaje} />
                        </Box>
                      </ListItem>
                    );
                  })}
                </List>
              </CardContent>
            </CardActionArea>
          </Card>
        </Grid>

        <Grid item xs={12} md={6}>
          <Card>
            <CardActionArea onClick={() => handleOpenModal('Comunicaciones')}>
              <CardContent>
                <Typography variant="h6" sx={{ color: 'black' }}>
                  Comunicaciones
                </Typography>
                <List>
                  {comunicaciones.map((comunicacion) => (
                    <ListItem key={comunicacion.id}>
                      <ListItemText
                        primary={comunicacion.titulo}
                        secondary={`Enviado por: ${getTrabajadorNombre(comunicacion.user_id)}`} // Display both title and user_id
                      />
                    </ListItem>
                  ))}
                </List>
              </CardContent>
            </CardActionArea>
          </Card>
        </Grid>
        {/* Estados de Solicitudes */}
        <Grid item xs={12}>
          <Card>
            <CardContent>
              <Typography variant="h6" sx={{ color: 'black' }}>
                Estados de Solicitudes
              </Typography>
              <List>
                {solicitudes.map((soli) => {
                  const tipoSolicitud = getTipoSolicitud(soli.tipo_sol_id); // Obtén el tipo de solicitud

                  return (
                    <ListItem key={soli.id}>
                      <Box sx={{ display: 'flex', alignItems: 'center', width: '100%' }}>
                        <Button 
                          variant="contained" 
                          color="primary" 
                          sx={{ marginRight: 2 }}
                        >
                          {tipoSolicitud}
                        </Button>
                        <ListItemText
                          primary={
                            isPermiso(soli.tipo_sol_id)
                              ? `Comentario: ${soli.comentario}` // Show only comentario for "Permiso"
                              : `Monto: ${soli.monto} | Cuotas: ${soli.cuotas} | Comentario: ${soli.comentario}` // Show all details otherwise
                          }
                        />
                      </Box>
                    </ListItem>
                  );
                })}
              </List>
              <Box sx={{ display: 'flex', justifyContent: 'flex-end', mt: 2 }}>
                <Button
                  variant="contained"
                  color="primary"
                  startIcon={<AddIcon />}
                  onClick={handleClick}
                >
                  Realizar Solicitud
                </Button>
                <Menu
                  anchorEl={anchorEl}
                  open={Boolean(anchorEl)}
                  onClose={handleClose}
                >
                  <MenuItem onClick={() => handleMenuItemClick('/SolicitarAnticipo')}>Anticipo</MenuItem>
                  <MenuItem onClick={() => handleMenuItemClick('/SolicitarPrestamo')}>Préstamo</MenuItem>
                  <MenuItem onClick={() => handleMenuItemClick('/SolicitarPermiso')}>Permiso</MenuItem>
                  <MenuItem onClick={() => handleMenuItemClick('/SolicitarVacaciones')}>Vacaciones</MenuItem>
                </Menu>
              </Box>
            </CardContent>
          </Card>
        </Grid>
      </Grid>
      
      {/* Modal for displaying additional information */}
      <Modal open={openModal} onClose={handleCloseModal}>
        <Box
          sx={{
            position: 'absolute',
            top: '50%',
            left: '50%',
            transform: 'translate(-50%, -50%)',
            width: 400,
            bgcolor: 'background.paper',
            border: '2px solid #000',
            boxShadow: 24,
            p: 4,
          }}
        >
          <Typography variant="h6" component="h2">
            {modalContent}
          </Typography>
        </Box>
      </Modal>
    </Box>
  );
};

export default ManageUser;
