import React, { useState, useEffect } from 'react';
import axios from 'axios';
import {  TextField, Tabs, Tab, Button, Box, Typography, Paper, Table, TableHead, TableBody, TableRow, TableCell, TablePagination } from '@mui/material';
import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here
import Swal from 'sweetalert2';
import { useNavigate } from 'react-router-dom';
import { useSelector } from 'react-redux';
import { ExportToXlsx } from './ExportToXlsx'; // Import your new component
import { Chip } from '@mui/material'; // Importar Chip de Material-UI
import { Autocomplete } from '@mui/material';
import '../../css/Dashboard.css';
import '../../css/Empresas.css';

const SolicitudesCard = ({ empresaId }) => {
  const [solicitudes, setSolicitudes] = useState({
    anticipos: [],
    beneficios: [],
    permisos: [],
    prestamos: [],
  });

  const [value, setValue] = useState('anticipos');
  const [trabajadores, setTrabajadores] = useState([]);
  const [statuses, setStatuses] = useState([]);
  const navigate = useNavigate();
  const [exportType, setExportType] = useState('');
  const [startDate, setStartDate] = useState('');
  const [endDate, setEndDate] = useState('');
  const [status, setStatus] = useState('');
  const token = useSelector((state) => state.token);
  const [trabajador, setTrabajador] = useState('');

  // Pagination state
  const [page, setPage] = useState(0);
  const [rowsPerPage, setRowsPerPage] = useState(5);
  const empresaIdS = useSelector((state) => state.empresaId);
  const handleTrabajadorChange = (value) => setTrabajador(value);

  useEffect(() => {
    const fetchSolicitudes = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/solicitudes/all/${token}`); // Replace with your API endpoint
        const solicitudesData = response.data
        .filter((soli) => soli.empresa_id == empresaIdS)
        .sort((a, b) => new Date(b.fecha) - new Date(a.fecha)); 
        // Filter and categorize the data
        const categorizedSolicitudes = {
          anticipos: [],
          beneficios: [],
          permisos: [],
          prestamos: [],          
        };

        solicitudesData.forEach(solicitud => {
          const tipo = getTipoSolicitud(solicitud.tipo_sol_id);
          if (categorizedSolicitudes[tipo]) {
            categorizedSolicitudes[tipo].push(solicitud);
          }
        });

        // Fetch trabajadores data
        try {
        // Fetch trabajadores data
        const trabajadoresResponse = await axios.get(`${API_BASE_URL}/trabajadores/all/${token}`);
        
        // Ordenar trabajadores por apellido_paterno, apellido_materno y nombre
        const sortedTrabajadores = trabajadoresResponse.data.sort((a, b) => {
          const fullNameA = `${a.apellido_paterno} ${a.apellido_materno} ${a.nombres}`.toLowerCase();
          const fullNameB = `${b.apellido_paterno} ${b.apellido_materno} ${b.nombres}`.toLowerCase();
          return fullNameA.localeCompare(fullNameB); // Compara nombres completos
        });

        setTrabajadores(sortedTrabajadores);
          const statusResponse = await axios.get(`${API_BASE_URL}/estadoSol/all/${token}`); // Replace with your API endpoint
          setStatuses(statusResponse.data);
        } catch (error) {
          console.error('Error fetching trabajadores:', error);
        }

        setSolicitudes(categorizedSolicitudes);
      } catch (error) {
        console.error('Error fetching solicitudes:', error);
      }
    };

    fetchSolicitudes();
  }, []);

  const getTipoSolicitud = (tipo_sol_id) => {
    switch (tipo_sol_id) {
      case '1':
        return 'anticipos';
      case '4':
        return 'beneficios';
      case '3':
        return 'permisos';
      case '2':
        return 'prestamos';
      default:
        return 'desconocido';
    }
  };

  const handleChangePage = (event, newPage) => {
    setPage(newPage);
  };

  const handleChangeRowsPerPage = (event) => {
    setRowsPerPage(parseInt(event.target.value, 10));
    setPage(0);
  };

  const getTrabajadorNombre = (rut) => {
    const trabajador = trabajadores.find(t => t.rut === rut);
    return trabajador ? `${trabajador.apellido_paterno} ${trabajador.apellido_materno}, ${trabajador.nombres} ` : 'Desconocido';
  };

  const getStatusNombre = (id) => {
    const status = statuses.find(t => t.id === id);
    return status ? `${status.nombre}` : 'Desconocido';
  };

  const uniqueRuts = [...new Set(trabajadores.map((doc) => doc.rut))];


  const renderTable = (type) => {
    const fields = {
      anticipos: ['trabajador', 'fecha', 'monto', 'cuotas', 'comentario', 'status'],
      beneficios: ['trabajador', 'fecha_inicio', 'fecha_fin', 'dias', 'comentario', 'status'],
      permisos: ['trabajador', 'fecha', 'dias_1', 'horas', 'goce', 'comentario', 'status'],
      prestamos: ['trabajador', 'fecha', 'monto', 'cuotas', 'comentario', 'status'],
    };
    
    const headers = {
      anticipos: {
        trabajador: 'Trabajador',
        fecha: 'Fecha',
        monto: 'Monto',
        cuotas: 'Cuotas',
        comentario: 'Comentario',
        status: 'Estado',
      },
      beneficios: {
        trabajador: 'Trabajador',
        fecha_inicio: 'Inicio',
        fecha_fin: 'Regreso',
        dias: 'Días', // Cabecera para días
        comentario: 'Comentario',
        status: 'Estado',
      },
      permisos: {
        trabajador: 'Trabajador',
        fecha: 'Fecha',
        dias_1: 'Días',
        horas: 'Horas',
        goce: 'Goce',
        comentario: 'Comentario',
        status: 'Estado',
      },
      prestamos: {
        trabajador: 'Trabajador',
        fecha: 'Fecha',
        monto: 'Monto',
        cuotas: 'Cuotas',
        comentario: 'Comentario',
        status: 'Estado',
      },
    };
    

    let solicitudesData = solicitudes[type];
    solicitudesData = solicitudesData.filter((doc) => trabajador ? doc.trabajador === trabajador : true);

    const paginatedData = solicitudesData.slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage);

    return (
      <>
        <Table sx={{ color: 'black' }}>
          <TableHead>
            <TableRow>
              {fields[type].map(field => (
                <TableCell key={field} sx={{ color: 'black' }}>
                  {headers[type][field]} {/* Usar el objeto de mapeo para obtener la cabecera */}
                </TableCell>
              ))}
              <TableCell sx={{ color: 'black' }}>Acciones</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {paginatedData.map(solicitud => (
              <TableRow key={solicitud.id}>
                {fields[type].map(field => {
                  if (field === 'trabajador') {
                    return (
                      <TableCell key={field} sx={{ color: 'black' }}>
                        {getTrabajadorNombre(solicitud[field])}
                      </TableCell>
                    );
                  }

                  if (field === 'dias_1') {
                    return (
                      <TableCell key={field} sx={{ color: 'black' }}>
                        1                     
                      </TableCell>
                    );
                  }

                  if (field === 'status') {
                    const status = solicitud[field];
                    let chipColor = 'default'; // Color por defecto

                    // Determinar el color y el texto del chip según el estado
                    switch (status) {
                      case '1': // Pendiente
                        chipColor = 'warning'; // Color amarillo
                        break;
                      case '2': // Aceptado
                        chipColor = 'success'; // Color verde
                        break;
                      case '3': // Rechazado
                        chipColor = 'error'; // Color rojo
                        break;
                      default:
                        chipColor = 'default'; // Color por defecto si no coincide
                    }

                    return (
                      <TableCell key={field} sx={{ color: 'black' }}>
                        <Chip label={getStatusNombre(status)} color={chipColor} />
                      </TableCell>
                    );
                  }

                  if (field === 'dias') {
                    const dias = Math.round((new Date(solicitud.fecha_fin) - new Date(solicitud.fecha_inicio)) / (1000 * 60 * 60 * 24) ); // Calcular días
                    return (
                      <TableCell key={field} sx={{ color: 'black' }}>
                        {dias}
                      </TableCell>
                    );
                  }

                  // Formato para las fechas
                  if (field === 'fecha') {
                    return (
                      <TableCell key={field} sx={{ color: 'black' }}>
                        {new Date(solicitud.fecha).toLocaleDateString()} {/* Formato de fecha */}
                      </TableCell>
                    );
                  }

                  // Formato para las fechas
                  if (field === 'goce') {
                    const goce = solicitud[field];
                    let temp 
                    goce == 1 ? temp = "Sí" : temp = "No"
                    return (
                      <TableCell key={field} sx={{ color: 'black' }}>
                        {temp} {/* Formato de fecha */}
                      </TableCell>
                    );
                  }

                  // Formato para las fechas
                  if (field === 'fecha_inicio') {
                    return (
                      <TableCell key={field} sx={{ color: 'black' }}>
                        {new Date(solicitud.fecha_inicio).toLocaleDateString()} {/* Formato de fecha */}
                      </TableCell>
                    );
                  }

                  if (field === 'fecha_fin') {
                    return (
                      <TableCell key={field} sx={{ color: 'black' }}>
                        {new Date(solicitud.fecha_fin).toLocaleDateString()} {/* Formato de fecha_fin */}
                      </TableCell>
                    );
                  }

                  // Para otros campos, simplemente devolver el valor
                  return (
                    <TableCell key={field} sx={{ color: 'black' }}>
                      {solicitud[field]}
                    </TableCell>
                  );
                })}
                <TableCell>
                  {solicitud.status === '1' && (
                    <>
                      <Button 
                        variant="text" 
                        onClick={() => handleReject(3, solicitud.id)} 
                        sx={{ 
                          ml: 1, 
                          mr: 1, 
                          backgroundColor: 'white', 
                          color: 'red', 
                          border: 'none',
                          '&:hover': { backgroundColor: 'gray' } // Maintain same style on hover
                        }}
                      >
                        Rechazar
                      </Button>
                      <Button 
                        variant="contained" 
                        onClick={() => handleAccept(2, solicitud.id)}
                        sx={{ 
                          backgroundColor: 'white', 
                          color: 'green', 
                          border: '1px solid green',
                          '&:hover': { backgroundColor: 'white' } // Maintain same style on hover
                        }}
                      >
                        Aceptar
                      </Button>
                    </>
                  )}
                  {solicitud.status === '2' && (
                    <Button
                      variant="text"
                      sx={{
                        color: 'green', // Color verde para "Aceptado"
                        fontWeight: 'bold' // Para resaltar el texto
                      }}
                    >
                      Aceptado
                    </Button>
                  )}
                  {solicitud.status === '3' && (
                    <Button
                      variant="text"
                      sx={{
                        color: 'red', // Color rojo para "Rechazado"
                        fontWeight: 'bold' // Para resaltar el texto
                      }}
                    >
                      Rechazado
                    </Button>
                  )}
                </TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
        <TablePagination
          rowsPerPageOptions={[5, 10, 25]}
          component="div"
          count={solicitudes[type].length}
          rowsPerPage={rowsPerPage}
          page={page}
          onPageChange={handleChangePage}
          onRowsPerPageChange={handleChangeRowsPerPage}
          sx={{ color: 'black' }}
        />
      </>
    );
  };

  const handleChange = (event, newValue) => {
    setValue(newValue);
    setPage(0); // Reset pagination when changing tabs
  };

  const handleAccept = async (type, id) => {
    try {
      // Mostrar un cuadro de entrada para el comentario
      const { value: comentario } = await Swal.fire({
        title: 'Aprobar Solicitud',
        text: '¿Desea aprobar solicitud?',
        showCancelButton: true,
        confirmButtonText: 'Aprobar',
        cancelButtonText: 'Cancelar'
      });

      // Si el usuario proporciona un comentario y confirma
      if (comentario) {
        const response = await axios.post(`${API_BASE_URL}/solicitudes/change-status/${id}/2`);
        if (response.status === 200) {
          Swal.fire({
            title: 'Éxito',
            text: 'Solicitud aceptada correctamente.',
            icon: 'success'
          }).then(() => {
            navigate(`/Empresas/${empresaId}`); // Redirect to empresa page
          });
        }
      }
    } catch (error) {
      Swal.fire({
        title: 'Error',
        text: 'No se pudo aceptar la solicitud.',
        icon: 'error'
      });
    }  };

  const handleReject = async (type, id) => {
    try {
      // Mostrar un cuadro de entrada para el comentario
      const { value: comentario } = await Swal.fire({
        title: 'Rechazar Solicitud',
        input: 'textarea',
        inputLabel: 'Comentario',
        inputPlaceholder: 'Escribe tu comentario aquí...',
        inputAttributes: {
          'aria-label': 'Escribe tu comentario aquí'
        },
        showCancelButton: true,
        confirmButtonText: 'Rechazar',
        cancelButtonText: 'Cancelar',
        inputValidator: (value) => {
          if (!value) {
            return 'El comentario es obligatorio';
          }
        }
      });

      // Si el usuario proporciona un comentario y confirma
      if (comentario) {
        const response = await axios.post(`${API_BASE_URL}/solicitudes/change-status/${id}/3`, { comentario: comentario });

        if (response.status === 200) {
          Swal.fire({
            title: 'Éxito',
            text: 'Solicitud rechazada correctamente.',
            icon: 'success'
          }).then(() => {
            navigate(`/Empresas/${empresaId}`); // Redirigir a la página de empresa
          });
        }
      }
    } catch (error) {
      Swal.fire({
        title: 'Error',
        text: 'No se pudo rechazar la solicitud.',
        icon: 'error'
      });
    }
  };

  return (
<Paper sx={{ p: 2 }}>
      <Typography variant="h5" component="div" gutterBottom>
        Solicitudes Pendientes
      </Typography>
      <Tabs value={value} onChange={handleChange} aria-label="solicitudes tabs">
        <Tab label={`Anticipos (${solicitudes.anticipos.length})`} value="anticipos" />
        <Tab label={`Beneficios (${solicitudes.beneficios.length})`} value="beneficios" />
        <Tab label={`Permisos (${solicitudes.permisos.length})`} value="permisos" />
        <Tab label={`Préstamos (${solicitudes.prestamos.length})`} value="prestamos" />
        <Tab label="Exportar XLSX" value="export" />
      </Tabs>
      <Box sx={{ p: 2 }}>
          <Autocomplete
            id="trabajador-autocomplete"
            options={uniqueRuts}
            getOptionLabel={(option) => getTrabajadorNombre(option)}
            onChange={(event, value) => handleTrabajadorChange(value)}
            renderInput={(params) => (
              <TextField 
                {...params} 
                label="Trabajador" 
                variant="outlined" 
                sx={{
                  minWidth: '360px',
                  '& .MuiInputLabel-root': { color: 'black' },  // Color de la etiqueta
                  '& .MuiOutlinedInput-root': { 
                    '& input': { color: 'black' }, // Color del texto
                    '& fieldset': { borderColor: 'black' }, // Color del borde
                  },
                }} 
              />
            )}
          />
        {value === 'export' ? (
          <ExportToXlsx
            exportData={solicitudes}
          />
        ) : (
            renderTable(value)
        )}
      </Box>
    </Paper>
  );
};

export default SolicitudesCard;
