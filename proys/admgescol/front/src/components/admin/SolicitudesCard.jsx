import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Tabs, Tab, Button, Box, Typography, Paper, Table, TableHead, TableBody, TableRow, TableCell, TablePagination } from '@mui/material';
import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here
import Swal from 'sweetalert2';
import { useNavigate } from 'react-router-dom';
import { useSelector } from 'react-redux';
import { ExportToXlsx } from './ExportToXlsx'; // Import your new component

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

  // Pagination state
  const [page, setPage] = useState(0);
  const [rowsPerPage, setRowsPerPage] = useState(5);
  const empresaIdS = useSelector((state) => state.empresaId);

  useEffect(() => {
    const fetchSolicitudes = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/solicitudes/all/${token}`); // Replace with your API endpoint
        const solicitudesData = response.data.filter((soli) => soli.empresa_id == empresaIdS);

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
          const trabajadoresResponse = await axios.get(`${API_BASE_URL}/trabajadores/all/${token}`); // Replace with your API endpoint
          setTrabajadores(trabajadoresResponse.data);
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

  const renderTable = (type) => {
    const fields = {
      anticipos: ['trabajador', 'fecha', 'monto', 'cuotas', 'comentario', 'status'],
      beneficios: ['trabajador', 'fecha', 'fecha_fin', 'comentario', 'status'],
      permisos: ['trabajador', 'fecha', 'goce', 'horas', 'time', 'timeEnd', 'comentario', 'status'],
      prestamos: ['trabajador', 'fecha', 'monto', 'cuotas', 'comentario', 'status'],
    };

    const solicitudesData = solicitudes[type];
    const paginatedData = solicitudesData.slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage);

    return (
      <>
        <Table sx={{ color: 'black' }}>
          <TableHead>
            <TableRow>
              {fields[type].map(field => (
                <TableCell key={field} sx={{ color: 'black' }}>
                  {field.charAt(0).toUpperCase() + field.slice(1)}
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
                  if (field === 'status') {
                    return (
                      <TableCell key={field} sx={{ color: 'black' }}>
                        {getStatusNombre(solicitud[field])}
                      </TableCell>
                    );
                  }
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
                        variant="contained" 
                        onClick={() => handleReject(3, solicitud.id)} 
                        sx={{ 
                          ml: 1, 
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
                      variant="contained" 
                      disabled
                      sx={{ 
                        backgroundColor: 'gray', 
                        color: 'green', 
                        border: '1px solid green' 
                      }}
                    >
                      Aceptado
                    </Button>
                  )}
                  {solicitud.status === '3' && (
                    <Button 
                      variant="contained" 
                      disabled
                      sx={{ 
                        backgroundColor: 'gray', 
                        color: 'red', 
                        border: '1px solid red' 
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
