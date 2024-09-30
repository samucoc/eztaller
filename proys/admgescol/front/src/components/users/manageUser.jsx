import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here
import {
  Box, Typography, Card, CardActionArea, CardContent, Button, Modal, List, ListItem, ListItemText, Menu, MenuItem,
  Grid, TextField, FormControlLabel, Checkbox

} from '@mui/material';
import {
  Business, Description, Group, AccountCircle, Settings, Home, ExitToApp, EventNote, BeachAccess, Receipt, Gavel,
  Folder, People, Person, AdminPanelSettings, LocationCity, Work, Wc, FolderOpen, Assignment, Verified, Mail, MonetizationOn, AttachMoney, 
} from '@mui/icons-material';

import MoneyIcon from '@mui/icons-material/Money';
import CreditCardIcon from '@mui/icons-material/CreditCard';
import AccessTimeIcon from '@mui/icons-material/AccessTime';
import FlightTakeoffIcon from '@mui/icons-material/FlightTakeoff';
import AddIcon from '@mui/icons-material/Add';
import { useNavigate } from 'react-router-dom';
import { useDispatch, useSelector } from 'react-redux';
import DocumentosCard from './DocumentosCard';
import SolicitudesCard from './SolicitudesCard';
import Swal from 'sweetalert2';
//import '../../css/manageUser.css'; // Si tienes estilos adicionales para DashTrab
import ReactQuill from 'react-quill';
import 'react-quill/dist/quill.snow.css'; // Importa los estilos de Quill
import { Chip } from '@mui/material'; // Importar Chip de Material-UI

const ManageUser = () => {
  const [value, setValue] = useState(0);
  const [usuario, setUsuario] = useState(null); // Initialize as null
  const [openModalCom, setOpenModalCom] = useState(false);
  const [modalContentCom, setModalContentCom] = useState('');
  const [openModalNot, setOpenModalNot] = useState(false);
  const [modalContentNot, setModalContentNot] = useState('');
  const [notificaciones, setNotificaciones] = useState([]);
  const [solicitudes, setSolicitudes] = useState([]);
  const [anchorEl, setAnchorEl] = useState(null);
  const [comunicaciones, setComunicaciones] = useState([]);
  const [trabajadores, setTrabajadores] = useState([]);

  const navigate = useNavigate();
  const dispatch = useDispatch();
  const empresaId = useSelector((state) => state.empresaId); // Assuming empresaId is stored in Redux
  const userDNI = useSelector((state) => state.userDNI); // Assuming userDNI is stored in Redux
  const token = useSelector((state) => state.token);

  const [openKarin, setOpenKarin] = useState(false);
  const handleOpenKarin = () => setOpenKarin(true);
  const handleCloseKarin = () => { setOpenKarin(false); navigate('/UserDashboard')  } 
  const [selectedFilesKarin, setSelectedFilesKarin] = useState([]);

  const [denunciante, setDenunciante] = useState({
    nombre: '',
    apellidos: '',
    rut: '',
    celular: '',
    email: '',
    confirmarEmail: '',
    relacionTrabajo: '',
    lugarDenuncia: '',
    anonimato: false,
  });
  const [implicados, setImplicados] = useState([
    {
      nombre: '',
      apellidos: '',
      lugar: '',
      cargo: '',
      denuncia: '',
      archivo: []
    }
  ]);

  const handleChangeDenuncianteKarin= (e) => {
    const { name, value } = e.target;
    setDenunciante({ ...denunciante, [name]: value });
  };

  const addImplicado = () => {
    setImplicados([
      ...implicados,
      { nombre: '', apellidos: '', lugar: '', cargo: '', denuncia: '', archivo: [] }
    ]);
  };
  
  const removeImplicado = (index) => {
    const updatedImplicados = [...implicados];
    updatedImplicados.splice(index, 1);
    setImplicados(updatedImplicados);
  };

  const handleChangeImplicadoKarin = (index, e) => {
    const { name, value } = e.target;
    const updatedImplicados = [...implicados];
    updatedImplicados[index] = { ...updatedImplicados[index], [name]: value };
    setImplicados(updatedImplicados);
  };

  // Updated handler function
  const handleChangeImplicadoDenunciaKarin = (index, value) => {
    const updatedImplicados = [...implicados];
    updatedImplicados[index] = { ...updatedImplicados[index], denuncia: value }; // Directly update the 'denuncia' field
    setImplicados(updatedImplicados);
  };

  const handleFileChangeKarin = (e) => {
    const selectedFiles = Array.from(e.target.files);
    setSelectedFilesKarin(selectedFiles); // Assume you have a state for files
  };

  const validateRut = (rut) => {
    // Eliminar puntos y guiones
    rut = rut.replace(/[.-]/g, "");
    if (rut.length < 8 || rut.length > 9) return false;
  
    const body = rut.slice(0, -1);
    let dv = rut.slice(-1).toUpperCase();
  
    let suma = 0;
    let multiplicador = 2;
  
    for (let i = body.length - 1; i >= 0; i--) {
      suma += multiplicador * body[i];
      multiplicador = multiplicador === 7 ? 2 : multiplicador + 1;
    }
  
    let expectedDv = 11 - (suma % 11);
    expectedDv = expectedDv === 11 ? "0" : expectedDv === 10 ? "K" : expectedDv.toString();
  
    return dv === expectedDv;
  };
  
  const handleSubmitKarin = async (e) => {
    e.preventDefault();
  
    // Validación de campos obligatorios
    if (
      !denunciante.nombre ||
      !denunciante.apellidos ||
      !denunciante.rut ||
      !denunciante.celular ||
      !denunciante.email ||
      !denunciante.confirmarEmail ||
      !denunciante.lugarDenuncia
    ) {
      Swal.fire({
        icon: 'error',
        title: 'Campos incompletos',
        text: 'Todos los campos del denunciante son obligatorios.',
        confirmButtonText: 'OK',
        customClass: {
          container: 'swal-container',
        },
      });
      return;
    }
  
    // Validación de al menos un implicado
    if (implicados.length === 0) {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Debe ingresar al menos un implicado.',
        confirmButtonText: 'OK',
        customClass: {
          container: 'swal-container',
        },
      });
      return;
    }
  
    // Validación de coincidencia de emails
    if (denunciante.email !== denunciante.confirmarEmail) {
      Swal.fire({
        icon: 'error',
        title: 'Error en el email',
        text: 'Los correos electrónicos no coinciden.',
        confirmButtonText: 'OK',
        customClass: {
          container: 'swal-container',
        },
      });
      return;
    }
  
    // Validación de RUT chileno
    if (!validateRut(denunciante.rut)) {
      Swal.fire({
        icon: 'error',
        title: 'RUT inválido',
        text: 'El RUT ingresado no es válido. Por favor, verifica el formato.',
        confirmButtonText: 'OK',
        customClass: {
          container: 'swal-container',
        },
      });
      return;
    }
  
    const formData = new FormData();
    formData.append('denuncianteNombre', denunciante.nombre);
    formData.append('denuncianteApellidos', denunciante.apellidos);
    formData.append('denuncianteRut', denunciante.rut);
    formData.append('denuncianteCelular', denunciante.celular);
    formData.append('denuncianteEmail', denunciante.email);
    formData.append('denuncianteConfirmarEmail', denunciante.confirmarEmail);
    formData.append('denuncianteRelacionTrabajo', denunciante.relacionTrabajo);
    formData.append('denuncianteLugarDenuncia', denunciante.lugarDenuncia);
    formData.append('denuncianteAnonimato', denunciante.anonimato);
  

    implicados.forEach((implicado, index) => {
      formData.append(`implicados[${index}][nombre]`, implicado.nombre);
      formData.append(`implicados[${index}][apellidos]`, implicado.apellidos);
      formData.append(`implicados[${index}][lugar]`, implicado.lugar);
      formData.append(`implicados[${index}][cargo]`, implicado.cargo);
      formData.append(`implicados[${index}][denuncia]`, implicado.denuncia);
    });
  
    // Añadir archivos como una sola colección
    selectedFilesKarin.forEach((file, index) => {
      formData.append(`archivos[${index}]`, file);
    });
  
    try {
      const response = await axios.post(`${API_BASE_URL}/denuncias-karin`, formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      });
  
      Swal.fire({
        icon: 'success',
        title: 'Denuncia enviada',
        text: 'Tu denuncia ha sido enviada con éxito.',
        confirmButtonText: 'OK',
        customClass: {
          container: 'swal-container',
        },
      });
      setOpenKarin(false);
      navigate('/UserDashboard');
    } catch (error) {
      console.error('Error al enviar la denuncia:', error);
      Swal.fire({
        icon: 'error',
        title: 'Error al enviar denuncia',
        text: 'Hubo un problema al enviar tu denuncia. Por favor, intenta nuevamente.',
        confirmButtonText: 'OK',
        customClass: {
          container: 'swal-container',
        },
      });
      setOpenKarin(false);
      navigate('/UserDashboard');
    }
  };
 
  

  const handleCancelKarin = () => {
    // Lógica para limpiar o cancelar el formulario
    setDenunciante({
      nombre: '',
      apellidos: '',
      rut: '',
      celular: '',
      email: '',
      confirmarEmail: '',
      relacionTrabajo: '',
      lugarDenuncia: '',
      anonimato: false,
    });
    setImplicados({
      nombre: '',
      apellidos: '',
      lugar: '',
      cargo: '',
      denuncia: '',
      archivo: [],
    });
  };

  useEffect(() => {

    const fetchSolicitudes = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/solicitudes/all/${token}`); // Replace with your API endpoint
        const recentSolicitudes = response.data
          .filter((soli) => soli.trabajador === userDNI) // Filtra por el trabajador actual
          .sort((a, b) => {
            // Ordenar por fecha (más reciente primero)
            const dateComparison = new Date(b.fecha) - new Date(a.fecha);
            // Si las fechas son iguales, ordenar por status de menor a mayor
            if (dateComparison === 0) {
              return a.status - b.status;
            }
            return dateComparison;
          });
        setSolicitudes(recentSolicitudes);
        
      } catch (error) {
        console.error('Error al obtener solicitudes:', error);
      }
    };

    const fetchComunicaciones = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/comunicaciones/all/${token}`); // Replace with your API endpoint
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
        .get(`${API_BASE_URL}/users/showByRut/${userDNI}/${token}`) // Replace with your API endpoint
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
        const response = await axios.get(`${API_BASE_URL}/trabajadores/all/${token}`); // Replace with your API endpoint
        
        // Ordenar trabajadores por apellido_paterno, apellido_materno, y luego nombre
        const sortedTrabajadores = response.data.sort((a, b) => {
          if (a.apellido_paterno < b.apellido_paterno) return -1;
          if (a.apellido_paterno > b.apellido_paterno) return 1;
          
          // Si los apellidos paternos son iguales, ordenar por apellido_materno
          if (a.apellido_materno < b.apellido_materno) return -1;
          if (a.apellido_materno > b.apellido_materno) return 1;
          
          // Si ambos apellidos paternos y maternos son iguales, ordenar por nombre
          if (a.nombre < b.nombre) return -1;
          if (a.nombre > b.nombre) return 1;

          return 0;
        });

        setTrabajadores(sortedTrabajadores);
      } catch (error) {
        console.error('Error fetching trabajadores:', error);
      }
    };

    fetchTrabajadores();
    fetchComunicaciones();
    fetchSolicitudes();
  }, []); // Dependencies: userDNI and empresaId

  const handleOpenModalCom = (content) => {
    setModalContentCom(content);
    setOpenModalCom(true);
  };

  const handleCloseModalCom = () => {
    setOpenModalCom(false);
  };

  const handleOpenModalNot = (content) => {
    setModalContentNot(content);
    setOpenModalNot(true);
  };

  const handleCloseModalNot = () => {
    setOpenModalNot(false);
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
    return trabajador ? `${trabajador.apellido_paterno} ${trabajador.apellido_materno},  ${trabajador.nombres}` : 'Desconocido';
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
        return 'Beneficio';
      default:
        return 'Desconocido';
    }
  };
  
  const getStatusSolicitud = (tipo_sol_id) => {
    switch (tipo_sol_id) {
      case '1':
        return 'En proceso';
      case '2':
        return 'Aceptada';
      case '3':
        return 'Rechazada';
      default:
        return 'Desconocido';
    }
  };
  
    const isPermiso = (tipo_sol_id) => {
      return getTipoSolicitud(tipo_sol_id) === 'Permiso'; // Adjust if necessary
    };
  
    const isBeneficio = (tipo_sol_id) => {
      return getTipoSolicitud(tipo_sol_id) === 'Beneficio'; // Adjust if necessary
    };

    const formatFechaSolicitud = (fecha) => {
      const date = new Date(fecha);
      const day = String(date.getDate()).padStart(2, '0'); // Obtiene el día y añade un 0 si es necesario
      const month = String(date.getMonth() + 1).padStart(2, '0'); // Los meses empiezan desde 0, por lo que se suma 1
      const year = date.getFullYear(); // Obtiene el año
    
      return `${day}-${month}-${year}`;
    };

  return (
    <div className="container empresas">
      {/* Display the user name and role */}
      <Box >
        <Typography variant="h4" component="h1" gutterBottom>
          Hola, {usuario?.trabajador?.nombres}
        </Typography>
        <Typography variant="h6" component="h2">
          {usuario?.role?.roleName}
        </Typography>
      </Box>

      {/* Cards as Buttons using Grid */}
      <Grid container>
        <Grid item xs={12} sx={{mb:2, mt:2}}>
          <Typography variant="h6" component="h3" sx={{ mb: 2 }}>
            ¿Qué quieres consultar?
          </Typography>
        </Grid>

        {/* Documentos Card */}
        <Grid item xs={12} md={12} sx={{mb:2, mt:2}}>
          <Card
            sx={{
              minWidth: 200,
              backgroundColor: value === 2 ? '#e8eaf6' : '#fff',
            }}
          >
            <CardContent>
              <DocumentosCard usuario={usuario} />
            </CardContent>
          </Card>
        </Grid>

        <Grid item xs={12}>
          <Typography variant="h6" component="h3" sx={{ mb: 2 }}>
            Realiza una solicitud
          </Typography>
        </Grid>

        {/* Botones de Solicitudes */}
        <Grid item xs={12} md={12}>
          <Card>
            <CardContent>
              <SolicitudesCard usuario={usuario} />
            </CardContent>
          </Card>
        </Grid>

        {/* Estados de Solicitudes */}
        <Grid item xs={12} md={12}>
          <Card>
            <CardContent>
              <Typography variant="h6" sx={{ color: 'black' }}>
                Estados de Solicitudes
              </Typography>
              <List sx={{ height: 200, overflowY: 'auto' }}>
                {solicitudes.map((soli) => {
                  const tipoSolicitud = getTipoSolicitud(soli.tipo_sol_id); // Obtén el tipo de solicitud
                  const estadoSolicitud = soli.status; // Obtén el estado de la solicitud
                  const fechaSolicitud = formatFechaSolicitud(soli.fecha); // Obtén la fecha de la solicitud

                  // Definir la estructura para el estado
                  const chipColor = soli.status === '3' ? 'error' : soli.status === '2' ? 'primary' : 'info';
                  const estadoTexto = getStatusSolicitud(estadoSolicitud) + ` - ${fechaSolicitud}`;

                  // Estructura del comentario
                  let comentario;
                  if (isPermiso(soli.tipo_sol_id) || isBeneficio(soli.tipo_sol_id) ) {
                    comentario = `${estadoTexto} - Solicitud de ${tipoSolicitud}`;
                  } else {
                    comentario = soli.estado === '3'
                      ? `${estadoTexto} - Solicitud de ${tipoSolicitud}. Monto ${soli.monto}. Motivo: ${soli.comentario_status}`
                      : `${estadoTexto} - Solicitud de ${tipoSolicitud}. Monto ${soli.monto}`;
                  }

                  return (
                    <ListItem key={soli.id}>
                      {/* Mostrar Chip con el estado */}
                      <Chip
                        label={getStatusSolicitud(estadoSolicitud)}
                        color={chipColor}
                        sx={{ marginRight: 2 }}
                      />

                      {/* Texto de la solicitud */}
                      <ListItemText
                        primary={comentario}
                      />
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

        {/* Comunicaciones */}
        <Grid item xs={12} md={8}>
          <Card>
            <CardContent >
              <Typography variant="h6" sx={{ color: 'black' }}>
                Comunicaciones
              </Typography>
              <List sx={{ height: 200, overflowY: 'auto' }}>
                {comunicaciones.map((comunicacion) => (
                  <ListItem key={comunicacion.id} onClick={() => handleOpenModalCom(comunicacion)}>
                    <ListItemText
                      primary={comunicacion.titulo}
                      secondary={`Publicado por: ${getTrabajadorNombre(comunicacion.user_id)}`} // Display both title and user_id
                    />
                  </ListItem>
                ))}
              </List>
              <Box sx={{ display: 'flex', justifyContent: 'flex-end', mt: 2 }}>
                <Button
                  variant="outlined"
                  color="primary"
                  startIcon={<Mail />}
                  onClick={() => handleMenuItemClick('/ComunicacionesUsers')}
                >
                  Revisar más noticias
                </Button>
              </Box>
            </CardContent>
          </Card>
        </Grid>

        {/* Ley karin */}
        <Grid item xs={12} md={4}>
          <Card>
            <CardContent >
              <Typography variant="h6" sx={{ color: 'black' }}>
                Ley Karin – N° 21.643
              </Typography>
              <List sx={{ height: 200, overflowY: 'auto' }}>
                  <ListItem >
                    <ListItemText
                      primary="Si has experimentado acoso, llena el formulario"
                    />
                  </ListItem>
              </List>
              <Box sx={{ display: 'flex', justifyContent: 'flex-end', mt: 2 }}>
                <Button
                  variant="outlined"
                  color="primary"
                  onClick={() => handleMenuItemClick('/LeyKarinModel')}
                  >
                  Realizar Denuncia
                </Button>
              </Box>
            </CardContent>
          </Card>
        </Grid>
      </Grid>
      
      <Modal
        open={openKarin}
        onClose={handleCloseKarin}
        aria-labelledby="modal-modal-title"
        aria-describedby="modal-modal-description"
        sx={{ zIndex : 1040}}
      >
        <Card sx={{ maxWidth: 800, maxHeight: 850, overflowY: 'auto', margin: 'auto', padding: 2 }}>
          <CardContent>
            <Typography variant="h5" gutterBottom>
              Formulario de Denuncia
            </Typography>
            <form onSubmit={handleSubmitKarin}>
              <Typography variant="h6" gutterBottom>
                Identificación del Denunciante
              </Typography>
              <Grid container spacing={2}>
                <Grid item xs={12} sm={6}>
                  <TextField
                    variant="outlined"
                    required
                    fullWidth
                    id="nombre"
                    label="Nombre"
                    name="nombre"
                    value={denunciante.nombre}
                    onChange={handleChangeDenuncianteKarin}
                    sx={{ color: 'black' }}
                    InputLabelProps={{ 
                      style: { color: 'black' }  // Set label color
                    }}
                    InputProps={{ 
                      style: { color: 'black' }  // Set input text color
                    }}
                  />
                </Grid>
                <Grid item xs={12} sm={6}>
                  <TextField
                    variant="outlined"
                    required
                    fullWidth
                    id="apellidos"
                    label="Apellidos"
                    name="apellidos"
                    value={denunciante.apellidos}
                    onChange={handleChangeDenuncianteKarin}
                    sx={{ color: 'black' }}
                    InputLabelProps={{ 
                      style: { color: 'black' }  // Set label color
                    }}
                    InputProps={{ 
                      style: { color: 'black' }  // Set input text color
                    }}
                  />
                </Grid>
                <Grid item xs={12} sm={6}>
                  <TextField
                    variant="outlined"
                    required
                    fullWidth
                    id="rut"
                    label="RUT"
                    name="rut"
                    value={denunciante.rut}
                    onChange={handleChangeDenuncianteKarin}
                    helperText="Formato: 12345678-9"
                    sx={{ color: 'black' }}
                    InputLabelProps={{ 
                      style: { color: 'black' }  // Set label color
                    }}
                    InputProps={{ 
                      style: { color: 'black' }  // Set input text color
                    }}
                  />
                </Grid>
                <Grid item xs={12} sm={6}>
                  <TextField
                    variant="outlined"
                    required
                    fullWidth
                    id="celular"
                    label="Celular"
                    name="celular"
                    value={denunciante.celular}
                    onChange={handleChangeDenuncianteKarin}
                    inputProps={{ maxLength: 9 }}
                    sx={{ color: 'black' }}
                    InputLabelProps={{ 
                      style: { color: 'black' }  // Set label color
                    }}
                    InputProps={{ 
                      style: { color: 'black' }  // Set input text color
                    }}
                  />
                </Grid>
                <Grid item xs={12} sm={6}>
                  <TextField
                    variant="outlined"
                    required
                    fullWidth
                    id="email"
                    label="Email"
                    name="email"
                    value={denunciante.email}
                    onChange={handleChangeDenuncianteKarin}
                    sx={{ color: 'black' }}
                    InputLabelProps={{ 
                      style: { color: 'black' }  // Set label color
                    }}
                    InputProps={{ 
                      style: { color: 'black' }  // Set input text color
                    }}
                  />
                </Grid>
                <Grid item xs={12} sm={6}>
                  <TextField
                    variant="outlined"
                    required
                    fullWidth
                    id="confirmarEmail"
                    label="Confirmar Email"
                    name="confirmarEmail"
                    value={denunciante.confirmarEmail}
                    onChange={handleChangeDenuncianteKarin}
                    sx={{ color: 'black' }}
                    InputLabelProps={{ 
                      style: { color: 'black' }  // Set label color
                    }}
                    InputProps={{ 
                      style: { color: 'black' }  // Set input text color
                    }}
                  />
                </Grid>
                <Grid item xs={12}>
                  <TextField
                    variant="outlined"
                    fullWidth
                    id="relacionTrabajo"
                    label="Relación con el trabajo"
                    name="relacionTrabajo"
                    value={denunciante.relacionTrabajo}
                    onChange={handleChangeDenuncianteKarin}
                    sx={{ color: 'black' }}
                    InputLabelProps={{ 
                      style: { color: 'black' }  // Set label color
                    }}
                    InputProps={{ 
                      style: { color: 'black' }  // Set input text color
                    }}
                  />
                </Grid>
                <Grid item xs={12}>
                  <TextField
                    variant="outlined"
                    fullWidth
                    id="lugarDenuncia"
                    label="Lugar de la denuncia"
                    name="lugarDenuncia"
                    value={denunciante.lugarDenuncia}
                    onChange={handleChangeDenuncianteKarin}
                    sx={{ color: 'black' }}
                    InputLabelProps={{ 
                      style: { color: 'black' }  // Set label color
                    }}
                    InputProps={{ 
                      style: { color: 'black' }  // Set input text color
                    }}
                  />
                </Grid>
                <Grid item xs={12}>
                  <FormControlLabel
                    control={
                      <Checkbox
                        checked={denunciante.anonimato}
                        onChange={(e) =>
                          setDenunciante({ ...denunciante, anonimato: e.target.checked })
                        }
                        name="anonimato"
                        color="primary"
                      />
                    }
                    label="¿Desea denunciar manteniendo reserva de su identidad o de forma anónima?"
                  />
                </Grid>
              </Grid>

              <Typography variant="h6" gutterBottom sx={{ mt: 2 }}>
                Datos de las Personas Implicadas en la Denuncia
              </Typography>
              <Grid container spacing={2}>
                {Array.isArray(implicados) && implicados.map((implicado, index) => (
                  <React.Fragment key={index}>
                    <Grid item xs={12} sm={6}>
                      <TextField
                        variant="outlined"
                        fullWidth
                        id={`nombreImplicado-${index}`}
                        label="Nombre del Implicado"
                        name="nombre"
                        value={implicado.nombre}
                        onChange={(e) => handleChangeImplicadoKarin(index, e)}
                        sx={{ color: 'black' }}
                        InputLabelProps={{ 
                          style: { color: 'black' }  // Set label color
                        }}
                        InputProps={{ 
                          style: { color: 'black' }  // Set input text color
                        }}
                      />
                    </Grid>
                    <Grid item xs={12} sm={6}>
                      <TextField
                        variant="outlined"
                        fullWidth
                        id={`apellidosImplicado-${index}`}
                        label="Apellidos del Implicado"
                        name="apellidos"
                        value={implicado.apellidos}
                        onChange={(e) => handleChangeImplicadoKarin(index, e)}
                        sx={{ color: 'black' }}
                        InputLabelProps={{ 
                          style: { color: 'black' }  // Set label color
                        }}
                        InputProps={{ 
                          style: { color: 'black' }  // Set input text color
                        }}
                      />
                    </Grid>
                    <Grid item xs={12} sm={6}>
                      <TextField
                        variant="outlined"
                        fullWidth
                        id={`lugarImplicado-${index}`}
                        label="Lugar de la Denuncia"
                        name="lugar"
                        value={implicado.lugar}
                        onChange={(e) => handleChangeImplicadoKarin(index, e)}
                        sx={{ color: 'black' }}
                        InputLabelProps={{ 
                          style: { color: 'black' }  // Set label color
                        }}
                        InputProps={{ 
                          style: { color: 'black' }  // Set input text color
                        }}
                      />
                    </Grid>
                    <Grid item xs={12} sm={6}>
                      <TextField
                        variant="outlined"
                        fullWidth
                        id={`cargoImplicado-${index}`}
                        label="Cargo del Implicado"
                        name="cargo"
                        value={implicado.cargo}
                        onChange={(e) => handleChangeImplicadoKarin(index, e)}
                        sx={{ color: 'black' }}
                        InputLabelProps={{ 
                          style: { color: 'black' }  // Set label color
                        }}
                        InputProps={{ 
                          style: { color: 'black' }  // Set input text color
                        }}
                      />
                    </Grid>
                    <Grid item xs={12} sm={12}>
                      <ReactQuill 
                        fullWidth
                        id={`denuncia-${index}`}
                        label="Denuncia"
                        name="denuncia"
                        theme="snow" 
                        value={implicado.denuncia}
                        onChange={(value) => handleChangeImplicadoDenunciaKarin(index, value)} // Change to pass value directly
                        placeholder="Escribe la descripción aquí..." 
                        sx={{ color: 'black' }}
                        InputLabelProps={{ 
                          style: { color: 'black' }  // Set label color
                        }}
                        InputProps={{ 
                          style: { color: 'black' }  // Set input text color
                        }}
                      /> 
                    </Grid>

                    <Grid item xs={12}>
                      <Button
                        variant="outlined"
                        color="secondary"
                        onClick={() => removeImplicado(index)}
                        fullWidth
                      >
                        Eliminar Implicado
                      </Button>
                    </Grid>
                  </React.Fragment>
                ))}
                <Grid item xs={12}>
                  <Button variant="contained" component="label" fullWidth>
                    Adjuntar Archivos
                    <input
                      type="file"
                      hidden
                      onChange={(e) => handleFileChangeKarin(e)}
                      multiple
                    />
                  </Button>
                </Grid>
                <Grid item xs={12}>
                  <Button
                    variant="contained"
                    color="primary"
                    onClick={addImplicado}
                    fullWidth
                  >
                    Agregar Implicado
                  </Button>
                </Grid>
              </Grid>

              <Grid container spacing={2} sx={{ mt: 2 }}>
                <Grid item xs={6}>
                  <Button type="submit" fullWidth variant="contained" color="primary">
                    Enviar
                  </Button>
                </Grid>
                <Grid item xs={6}>
                  <Button fullWidth variant="outlined" onClick={handleCloseKarin}>
                    Cancelar
                  </Button>
                </Grid>
              </Grid>
            </form>
          </CardContent>
        </Card>
      </Modal>

      <Modal open={openModalCom} onClose={handleCloseModalCom}>
        <Box
          sx={{
            position: 'absolute',
            top: '50%',
            left: '50%',
            transform: 'translate(-50%, -50%)',
            width: 600,
            maxHeight: '80vh', // Limita la altura máxima al 80% de la ventana para permitir el scroll
            bgcolor: 'background.paper',
            border: '2px solid #000',
            boxShadow: 24,
            p: 4,
            overflowY: 'auto', // Asegura que el contenido sea desplazable verticalmente
          }}
        >
          {modalContentCom ? (
            <>
              <Typography variant="h6" component="h2">
                {modalContentCom.titulo} {/* Ajusta según la estructura real */}
              </Typography>
              <Typography variant="body1" color="textSecondary" dangerouslySetInnerHTML={{ __html: modalContentCom?.descripcion }} />
              <Typography variant="body1" component="p">
                Enviado por: {getTrabajadorNombre(modalContentCom.user_id)} {/* Ajusta según la estructura real */}
              </Typography>
              {/* Añade más campos si es necesario */}
            </>
          ) : (
            <Typography variant="body1">No hay contenido disponible.</Typography>
          )}
        </Box>
      </Modal>

      <Modal open={openModalNot} onClose={handleCloseModalNot}>
        <Box
          sx={{
            position: 'absolute',
            top: '50%',
            left: '50%',
            transform: 'translate(-50%, -50%)',
            width: 600,
            bgcolor: 'background.paper',
            border: '2px solid #000',
            boxShadow: 24,
            p: 4,
            overflowY: 'auto', // Make sure the content is scrollable if needed
          }}
        >
          {modalContentNot ? (
            <>
              <Typography variant="h6" component="h2">
                {modalContentNot.tipoSolicitud} {/* Adjust this based on the actual structure */}
              </Typography>
              <Typography variant="body1" component="p">
                Mensaje: {modalContentNot.mensaje} {/* Adjust this based on the actual structure */}
              </Typography>
              {/* Add more fields as needed */}
            </>
          ) : (
            <Typography variant="body1">No hay contenido disponible.</Typography>
          )}
        </Box>
      </Modal>
    </div>
  );
};

export default ManageUser;
