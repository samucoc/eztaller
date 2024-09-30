import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here
import TrabajadorForm from './TrabajadorForm';
import {
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TableRow,
  Paper,
  Button,
  TextField,
  TablePagination,
  FormControl,
  InputLabel,
  Select,
  MenuItem,
  Grid
} from '@material-ui/core';
import { Delete as DeleteIcon, Edit as EditIcon, Add as AddIcon } from '@material-ui/icons';
import swal from 'sweetalert2';
import * as XLSX from 'xlsx';
import { useSelector } from 'react-redux';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';
import { makeStyles } from '@material-ui/core/styles';
import '../../css/Empresas.css';
import { Autocomplete } from '@mui/material';
import { Chip } from '@mui/material';
import DeleteOutlinedIcon from '@mui/icons-material/DeleteOutlined';
import Swal from 'sweetalert2'; // Asegúrate de importar Swal si no lo has hecho
import { useNavigate } from 'react-router-dom';

const Trabajadores = ({ empresaId }) => {
  const useStyles = makeStyles({
    root: {
      width: '100%',
    },
    container: {
      maxHeight: 550,
    },
  });

  const [showForm, setShowForm] = useState(false);
  const [selectedTrabajador, setSelectedTrabajador] = useState(null);
  const [trabajadores, setTrabajadores] = useState([]);
  const [searchTerm, setSearchTerm] = useState('');
  const [page, setPage] = useState(0);
  const [rowsPerPage, setRowsPerPage] = useState(5);
  const [selectedEmpresa, setSelectedEmpresa] = useState('');
  const [empresas, setEmpresas] = useState([]);
  const roleSession = useSelector((state) => state.roleSession);
  const empresaIdS = useSelector((state) => state.empresaId);
  const classes = useStyles();
  const token = useSelector((state) => state.token);
  const navigate = useNavigate();

  const fetchTrabajadores = async () => {
    try {
        const response = await axios.get(`${API_BASE_URL}/trabajadores/all/${token}`); // Replace with your API endpoint
        setTrabajadores(response.data);
    } catch (error) {
      console.error('Error fetching Trabajadores:', error);
    }
  };

  useEffect(() => {
    if (selectedTrabajador !== null) {
      setShowForm(true);
    }
    const fetchEmpresas = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/empresas/all/${token}`); // Replace with your API endpoint
        setEmpresas(response.data);
      } catch (error) {
        console.error('Error fetching empresas:', error);
      }
    };

    // Si hay solo un valor para empresaIdS, actualizar el estado de selectedEmpresa
    if (empresaIdS && empresas.filter((empresa) => empresa.id === empresaIdS).length === 1) {
      setSelectedEmpresa(empresaIdS);
    }

    
    fetchEmpresas();
    fetchTrabajadores();
  }, []);

  const deleteTrabajador = async (id) => {
    try {
      // Mostrar confirmación con SweetAlert2
      const result = await swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarlo',
        cancelButtonText: 'Cancelar',
      });
  
      // Si el usuario confirma la eliminación
      if (result.isConfirmed) {
        const response = await axios.delete(`${API_BASE_URL}/trabajadores/${id}`);
  
        if (response.status === 200) {
          setTrabajadores(trabajadores.filter(comunicacion => comunicacion.id !== id));
  
          // Mostrar éxito con SweetAlert2
          swal.fire(
            '¡Eliminado!',
            'El trabajador ha sido eliminado exitosamente.',
            'success'
          );
        } else {
          // Mostrar error si la eliminación no fue exitosa
          swal.fire(
            'Error',
            'Hubo un problema al eliminar el trabajador.',
            'error'
          );
          console.error('Error al eliminar el trabajador:', response.data);
        }
      }
    } catch (error) {
      // Mostrar error si ocurrió durante la solicitud
      swal.fire(
        'Error',
        'Ocurrió un error durante la eliminación.',
        'error'
      );
      console.error('Error durante la eliminación:', error);
    }
  };

  const validateRUT = (rut) => {
    if (!/^[0-9]+-[0-9kK]{1}$/.test(rut)) return false;
    const [rutBody, dv] = rut.split('-');
    let sum = 0;
    let multiplier = 2;
    for (let i = rutBody.length - 1; i >= 0; i--) {
      sum += parseInt(rutBody[i], 10) * multiplier;
      multiplier = (multiplier === 7) ? 2 : multiplier + 1;
    }
    const calculatedDV = 11 - (sum % 11);
    const validDV = calculatedDV === 11 ? '0' : calculatedDV === 10 ? 'k' : calculatedDV.toString();
    return validDV.toLowerCase() === dv.toLowerCase();
  };


  const addTrabajador = async (trabajadorData) => {
    try {
      // Validar RUT
      if (!validateRUT(`${trabajadorData.rut}-${trabajadorData.dv}`)) {
        Swal.fire("Error", "El dígito verificador no corresponde al RUT ingresado.", "error");
        return;
      }
      
      // Configurar URL y método HTTP
      const url = selectedTrabajador ? `${API_BASE_URL}/trabajadores/${selectedTrabajador.id}` : `${API_BASE_URL}/trabajadores`;
      const method = selectedTrabajador ? 'PUT' : 'POST';
  
      // Realizar la solicitud para agregar/actualizar
      const response = await axios({ method, url, data: trabajadorData });
  
      // Verificar si la respuesta fue exitosa
      if (response.status === 200 || response.status === 201) {
        const updatedTrabajador = response.data;
  
        // // Manejar carga de foto si se proporciona
        // if (trabajadorData.foto && updatedTrabajador.id) {
        //   const formData1 = new FormData();
        //   formData1.append('foto', trabajadorData.foto);
        //   await axios.post(`${API_BASE_URL}/trabajadores/uploadFoto/${updatedTrabajador.id}`, formData1, { headers: { 'Content-Type': 'multipart/form-data' } });
        // }
  
        // Actualizar la lista de trabajadores
        setTrabajadores(trabajadores.map(trabajador => trabajador.id === updatedTrabajador.id ? updatedTrabajador : trabajador));
        setShowForm(false);
  
        navigate('/Empresas')

        // Mostrar mensaje de éxito
        Swal.fire({
          icon: 'success',
          title: selectedTrabajador ? 'Actualización exitosa' : 'Inserción exitosa',
          text: selectedTrabajador ? 'El trabajador ha sido actualizado exitosamente.' : 'El trabajador ha sido agregado exitosamente.',
          confirmButtonText: 'OK',
        });
      } else {
        console.error('Error al agregar/actualizar el trabajador:', response.data);
        // Mostrar mensaje de error
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No se pudo completar la operación. Intente nuevamente.',
          confirmButtonText: 'OK',
        });
      }
    } catch (error) {
      console.error('Error durante la creación/actualización:', error);
      // Mostrar mensaje de error
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Ocurrió un problema durante la operación. Intente nuevamente.',
        confirmButtonText: 'OK',
      });
    }
  };

  const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        const data = new Uint8Array(e.target.result);
        const workbook = XLSX.read(data, { type: 'array' });
        const json = XLSX.utils.sheet_to_json(workbook.Sheets[workbook.SheetNames[0]]);
        handleBulkUpload(json);
      };
      reader.readAsArrayBuffer(file);
    }
  };

  const handleBulkUpload = async (data) => {
    try {
      const response = await axios.post(`${API_BASE_URL}/trabajadores/bulk-upload`, data);
      if (response.status === 200 || response.status === 201) {
        fetchTrabajadores();
        swal.fire("Correcto", "Carga masiva exitosa.", "success");
        console.log('Carga masiva exitosa');
      } else {
        swal.fire("Error", `Error durante la carga masiva: ${response.data}`, "error");
        console.error('Error en la carga masiva:', response.data);
      }
    } catch (error) {
      swal.fire("Error", "Error durante la carga masiva.", "error");
      console.error('Error durante la carga masiva:', error);
    }
  };

  const handleSearch = (event) => setSearchTerm(event.target.value);
  const handleChangePage = (event, newPage) => setPage(newPage);
  const handleChangeRowsPerPage = (event) => {
    setRowsPerPage(parseInt(event.target.value, 10));
    setPage(0);
  };
  const handleEmpresaChange = (event) => {
    setSelectedEmpresa(event.target.value);
    setPage(0);
  };

  let filteredTrabajadores = trabajadores
    .filter((trabajadores) => empresaIdS ? trabajadores.empresa_id === empresaIdS : true);

  filteredTrabajadores = selectedEmpresa
    ? filteredTrabajadores.filter(trabajador => trabajador.empresa_id === selectedEmpresa)
    : filteredTrabajadores;

  filteredTrabajadores = filteredTrabajadores.filter((trabajador) => trabajador.usuario?.role_id === "3" )

  // Ordenar trabajadores por apellido_paterno, apellido_materno, y luego nombre
  filteredTrabajadores = filteredTrabajadores.sort((a, b) => {
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
  
  const uniqueRuts = [...new Set(
    trabajadores
      .filter((trabajador) => trabajador.usuario?.role_id === "3")
      .filter((trabajador) => trabajador.empresa_id === empresaIdS)
      .sort((a, b) => {
        // Comparar primero por apellido paterno
        if (a.apellido_paterno < b.apellido_paterno) return -1;
        if (a.apellido_paterno > b.apellido_paterno) return 1;
        
        // Si los apellidos paternos son iguales, comparar por apellido materno
        if (a.apellido_materno < b.apellido_materno) return -1;
        if (a.apellido_materno > b.apellido_materno) return 1;
  
        // Si ambos apellidos son iguales, comparar por nombre
        if (a.nombre < b.nombre) return -1;
        if (a.nombre > b.nombre) return 1;
  
        return 0; // Si todos son iguales
      })
      .map((trabajador) => trabajador.rut)
  )];
  

  const getTrabajadorNombre = (trab) => {
    for (let i = 0; i < filteredTrabajadores.length; i++) {
      if (filteredTrabajadores[i].rut === trab) {
        return `${filteredTrabajadores[i].apellido_paterno} ${filteredTrabajadores[i].apellido_materno}, ${filteredTrabajadores[i].nombres}`;
      }
    }
    console.warn(`Trabajador con RUT ${trab} no encontrado.`);
    return 'Desconocido';
  };

  const getEmpresaRazonSocial = (empresa_id) => {
    const empresa = empresas.find((e) => e.id === empresa_id);
    return empresa ? empresa.RazonSocial : "Desconocida";
  };

  const handleTrabajadorChange = (value) => {
    if (value === null) {
      // Si no hay selección, restaurar todos los trabajadores filtrados
      fetchTrabajadores(); // O restaurar la lista original si ya tienes los trabajadores cargados
    } else {
      // Filtrar trabajadores por el RUT seleccionado
      setTrabajadores(trabajadores.filter(trabajador => trabajador.rut === value));
    }
  };
  const defaultPhoto = 'https://www.gravatar.com/avatar/?d=mp';
  
  const editTrabajador = (Traba) => {
    setSelectedTrabajador(Traba);
    setShowForm(true);
  };

  return (
    <div className="container Trabajadores">
      <h3>Trabajadores</h3>

      {showForm ? (
        <TrabajadorForm
          onSubmit={addTrabajador}
          initialTrabajador={selectedTrabajador}
          onCancel={() => setShowForm(false)}
          empresaId={empresaId}
        />
      ) : (
        <div>
          <div className="form-control-container">
            <div className="form-control-left">
              {!showForm && (
                  <Autocomplete
                  id="trabajador-autocomplete"
                  options={uniqueRuts}
                  getOptionLabel={(option) => getTrabajadorNombre(option)}
                  onChange={(event, value) => handleTrabajadorChange(value)}
                  renderInput={(params) => (
                    <TextField {...params} label="Trabajador" variant="outlined" style={{ minWidth: '500px' }} />
                  )}
                  sx={{ color: 'black' }}
                  InputLabelProps={{ 
                    style: { color: 'black' }  // Set label color
                  }}
                  InputProps={{ 
                    style: { color: 'black' }  // Set input text color
                  }}
                />
              )}
            </div>
            <div className="form-control-right">
              {empresaIdS && empresas.filter((empresa) => empresa.id === empresaIdS).length === 1 ? (
                // Mostrar un campo oculto y no el Select
                <input type="hidden" value={selectedEmpresa} />
              ) : (
                <FormControl variant="outlined" style={{ marginRight: '1rem', minWidth: '120px' }}>
                  <InputLabel id="empresa-select-label">Empresa</InputLabel>
                  <Select
                    labelId="empresa-select-label"
                    id="empresa-select"
                    value={selectedEmpresa}
                    onChange={handleEmpresaChange}
                    label="Empresa"
                  >
                    <MenuItem value="">
                      <em>Elija Empresa</em>
                    </MenuItem>
                    {empresas.map((empresa) => (
                      <MenuItem key={empresa.id} value={empresa.id}>
                        {empresa.RazonSocial}
                      </MenuItem>
                    ))}
                  </Select>
                </FormControl>
              )}

              <Button
                onClick={() => {
                  setSelectedTrabajador(null);
                  setShowForm(true);
                }}
                variant="contained"
                className="crear-empresa-btn"
                startIcon={<AddIcon />}
              >
                Crear Trabajador
              </Button>

              <label htmlFor="bulk-upload-file">
                <Button
                  variant="contained"
                  component="span"
                  color="secondary"
                  style={{ marginLeft: '1rem' }}
                >
                  Carga Masiva
                </Button>
                <input
                  type="file"
                  accept=".xlsx, .xls"
                  id="bulk-upload-file"
                  onChange={handleFileUpload}
                  style={{ display: 'none' }}
                />
              </label>
            </div>
            
          </div>
          <Paper className={classes.root}>
            <TableContainer 
              className={classes.container}
              >
              <Table stickyHeader>
                <TableHead>
                  <TableRow>
                    {/* <TableCell>Foto</TableCell> */}
                    <TableCell>Nombre</TableCell>
                    <TableCell>Empresa</TableCell>
                    <TableCell>Email</TableCell>
                    <TableCell>Status</TableCell>
                    <TableCell>Acciones</TableCell>
                  </TableRow>
                </TableHead>
                <TableBody>
                {!empresaIdS
                      ? 
                        filteredTrabajadores
                        .slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage)
                        .map((trabajador) => (
                        <TableRow key={trabajador.id} hover >
                          {/* <TableCell>
                            <img
                              src={trabajador.foto ? `${trabajador.foto}` : defaultPhoto}
                              alt="Foto Trabajador"
                              className="img-thumbnail"
                              width="50"
                              height="50"
                            /> 
                          </TableCell>*/}
                          <TableCell>{trabajador.apellido_paterno} {trabajador.apellido_materno}, {trabajador.nombres}</TableCell>
                          <TableCell>{getEmpresaRazonSocial(trabajador.empresa_id)}</TableCell>
                          <TableCell>{trabajador.email}</TableCell>
                          <TableCell>
                            {trabajador.estado_id === "1" ? (
                              <Chip label="Activo" color="primary" />
                            ) : (
                              <Chip label="Desactivado" sx={{ backgroundColor: '#dc3545', color: 'white' }} />
                            )}
                          </TableCell>
                          <TableCell>
                            <Button
                              onClick={() => editTrabajador(trabajador)}
                              variant="text"
                              color="primary"
                              startIcon={<EditIcon  style={{width:'48px', height: '48px'}}/>}
                            >
                            </Button>
                            <Button
                              onClick={() => {
                                if (window.confirm('¿Estás seguro de eliminar este trabajador?')) {
                                  deleteTrabajador(trabajador.id);
                                }
                              }}
                              variant="text"
                              color="secondary"
                              startIcon={<DeleteOutlinedIcon  style={{width:'48px', height: '48px'}}/>}
                              style={{ marginLeft: '0.5rem' }}
                            >
                            </Button>
                          </TableCell>
                        </TableRow>
                      ))
                      : 
                        filteredTrabajadores
                        .filter( (trabajador) => trabajador.empresa_id === empresaIdS)
                        .slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage)
                        .map((trabajador) => (
                        <TableRow key={trabajador.id}>
                          {/* <TableCell>
                            <img
                              src={trabajador.foto ? `${trabajador.foto}` : defaultPhoto}
                              alt="Foto Trabajador"
                              className="img-thumbnail"
                              width="50"
                              height="50"
                            />
                          </TableCell> */}
                          <TableCell>{trabajador.apellido_paterno} {trabajador.apellido_materno}, {trabajador.nombres}</TableCell>
                          <TableCell>{getEmpresaRazonSocial(trabajador.empresa_id)}</TableCell>
                          <TableCell>{trabajador.email}</TableCell>
                          <TableCell>
                            {trabajador.estado_id === "1" ? (
                              <Chip label="Activo" color="primary" />
                            ) : (
                              <Chip label="Desactivado" sx={{ backgroundColor: '#dc3545', color: 'white' }} />
                            )}
                          </TableCell>
                          <TableCell>
                            <Button
                              onClick={() => editTrabajador(trabajador)}
                              variant="text"
                              color="primary"
                              startIcon={<EditIcon  style={{width:'48px', height: '48px'}}/>}
                            >
                            </Button>
                            <Button
                              onClick={() => {
                                if (window.confirm('¿Estás seguro de eliminar este trabajador?')) {
                                  deleteTrabajador(trabajador.id);
                                }
                              }}
                              variant="text"
                              color="secondary"
                              startIcon={<DeleteOutlinedIcon  style={{width:'48px', height: '48px'}}/>}
                              style={{ marginLeft: '0.5rem' }}
                            >
                            </Button>
                          </TableCell>
                        </TableRow>
                      ))}
                </TableBody>
              </Table>
            </TableContainer>
            <TablePagination
              component="div"
              count={filteredTrabajadores.length}
              page={page}
              onPageChange={handleChangePage}
              rowsPerPage={rowsPerPage}
              onRowsPerPageChange={handleChangeRowsPerPage}
            />
          </Paper>
        </div>
      )}
    </div>
  );
};

export default Trabajadores;
