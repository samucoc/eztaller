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

const Trabajadores = ({ empresaId }) => {
  const useStyles = makeStyles({
    root: {
      width: '100%',
    },
    container: {
      maxHeight: 440,
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
      if (!validateRUT(`${trabajadorData.rut}-${trabajadorData.dv}`)) {
        swal.fire("Error", "El dígito verificador no corresponde al RUT ingresado.", "error");
        return;
      }
      const url = selectedTrabajador ? `${API_BASE_URL}/trabajadores/${selectedTrabajador.id}` : `${API_BASE_URL}/trabajadores`;
      const method = selectedTrabajador ? 'PUT' : 'POST';
      const formData = new FormData();
      Object.entries(trabajadorData).forEach(([key, value]) => formData.append(key, value));
      const response = await axios({ method, url, data: formData });

      if (response.status === 200 || response.status === 201) {
        const updatedTrabajador = response.data;
        if (trabajadorData.foto && updatedTrabajador.id) {
          const formData1 = new FormData();
          formData1.append('foto', trabajadorData.foto);
          await axios.post(`${API_BASE_URL}/trabajadores/uploadFoto/${updatedTrabajador.id}`, formData1, { headers: { 'Content-Type': 'multipart/form-data' } });
        }
        setTrabajadores(trabajadores.map(trabajador => trabajador.id === updatedTrabajador.id ? updatedTrabajador : trabajador));
        setShowForm(false);
        console.log(selectedTrabajador ? 'Trabajador actualizado exitosamente' : 'Trabajador agregado exitosamente');
      } else {
        console.error('Error al agregar/actualizar el trabajador:', response.data);
      }
    } catch (error) {
      console.error('Error durante la creación/actualización:', error);
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

  let filteredTrabajadores = trabajadores.filter(trabajador =>
    [trabajador.rut, trabajador.nombres, trabajador.apellido_paterno, trabajador.apellido_materno, trabajador.email].some(field =>
      (field || '').toString().toLowerCase().includes(searchTerm.toLowerCase())
    )
  );

  filteredTrabajadores = trabajadores
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
  
  const getEmpresaRazonSocial = (empresa_id) => {
    const empresa = empresas.find((e) => e.id === empresa_id);
    return empresa ? empresa.RazonSocial : "Desconocida";
  };

  const defaultPhoto = 'https://www.gravatar.com/avatar/?d=mp';

  return (
    <div className="container Trabajadores">
      <h3>Trabajadores</h3>
      <div className="d-flex justify-content-between mb-3">
        {!showForm && (
          <TextField
            label="Buscar"
            variant="outlined"
            value={searchTerm}
            onChange={handleSearch}
            style={{ marginBottom: '1rem' }}
          />
        )}
      </div>
      {showForm ? (
        <TrabajadorForm
          onSubmit={addTrabajador}
          initialTrabajador={selectedTrabajador}
          onCancel={() => setShowForm(false)}
          empresaId={empresaId}
        />
      ) : (
        <div>
          <Grid container spacing={3} alignItems="center">
              {empresaIdS && empresas.filter((empresa) => empresa.id === empresaIdS).length === 1 ? (
                // Mostrar un campo oculto y no el Select
                <input type="hidden" value={selectedEmpresa} />
              ) : (
                <Grid item xs={12} sm={4}>
                  <FormControl variant="outlined" style={{ marginRight: '1rem', minWidth: '120px' }}>
                  <>
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
                  </>
                  </FormControl>
                </Grid>
              )}
            <Grid item xs={12} sm={12} className="text-end">
              <Button
                onClick={() => {
                  setSelectedTrabajador(null);
                  setShowForm(true);
                }}
                variant="contained"
                color="primary"
                startIcon={<AddIcon />}
              >
                Agregar Trabajador
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
            </Grid>
          </Grid>
          <Paper className={classes.root}>
            <TableContainer 
              className={classes.container}
              >
              <Table stickyHeader>
                <TableHead>
                  <TableRow>
                    <TableCell>Foto</TableCell>
                    <TableCell>RUT</TableCell>
                    <TableCell>Apellido Paterno</TableCell>
                    <TableCell>Apellido Materno</TableCell>
                    <TableCell>Nombres</TableCell>
                    <TableCell>Email</TableCell>
                    <TableCell>Teléfono</TableCell>
                    <TableCell>Empresa</TableCell>
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
                          <TableCell>
                            <img
                              src={trabajador.foto ? `${API_BASE_URL}/trabajadores/getFoto/${trabajador.foto}` : defaultPhoto}
                              alt="Foto Trabajador"
                              className="img-thumbnail"
                              width="50"
                              height="50"
                            />
                          </TableCell>
                          <TableCell>{trabajador.rut}-{trabajador.dv}</TableCell>
                          <TableCell>{trabajador.apellido_paterno}</TableCell>
                          <TableCell>{trabajador.apellido_materno}</TableCell>
                          <TableCell>{trabajador.nombres}</TableCell>
                          <TableCell>{trabajador.email}</TableCell>
                          <TableCell>{trabajador.telefono}</TableCell>
                          <TableCell>{getEmpresaRazonSocial(trabajador.empresa_id)}</TableCell>
                          <TableCell>
                            <Button
                              onClick={() => setSelectedTrabajador(trabajador)}
                              variant="contained"
                              color="primary"
                              startIcon={<EditIcon />}
                            >
                              Editar
                            </Button>
                            <Button
                              onClick={() => {
                                  deleteTrabajador(trabajador.id);
                              }}
                              variant="contained"
                              color="secondary"
                              startIcon={<DeleteIcon />}
                              style={{ marginLeft: '0.5rem' }}
                            >
                              Eliminar
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
                          <TableCell>
                            <img
                              src={trabajador.foto ? `${API_BASE_URL}/trabajadores/getFoto/${trabajador.foto}` : defaultPhoto}
                              alt="Foto Trabajador"
                              className="img-thumbnail"
                              width="50"
                              height="50"
                            />
                          </TableCell>
                          <TableCell>{trabajador.rut}-{trabajador.dv}</TableCell>
                          <TableCell>{trabajador.apellido_paterno}</TableCell>
                          <TableCell>{trabajador.apellido_materno}</TableCell>
                          <TableCell>{trabajador.nombres}</TableCell>
                          <TableCell>{trabajador.email}</TableCell>
                          <TableCell>{trabajador.telefono}</TableCell>
                          <TableCell>{getEmpresaRazonSocial(trabajador.empresa_id)}</TableCell>
                          <TableCell>
                            <Button
                              onClick={() => setSelectedTrabajador(trabajador)}
                              variant="contained"
                              color="primary"
                              startIcon={<EditIcon />}
                            >
                              Editar
                            </Button>
                            <Button
                              onClick={() => {
                                if (window.confirm('¿Estás seguro de eliminar este trabajador?')) {
                                  deleteTrabajador(trabajador.id);
                                }
                              }}
                              variant="contained"
                              color="secondary"
                              startIcon={<DeleteIcon />}
                              style={{ marginLeft: '0.5rem' }}
                            >
                              Eliminar
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
