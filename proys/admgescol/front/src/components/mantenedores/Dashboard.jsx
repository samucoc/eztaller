import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here
import DocumentForm from './DashboardForm'; // Assuming you have a DocumentForm component
import {
  TextField, Button, TableContainer, Paper, Table, TableHead, TableRow, TableCell, TableBody,
  TablePagination, Dialog, DialogTitle, DialogContent, FormControl, InputLabel, Select, MenuItem
} from '@material-ui/core';
import DeleteIcon from '@material-ui/icons/Delete';
import EditIcon from '@material-ui/icons/Edit';
import VisibilityIcon from '@material-ui/icons/Visibility';
import AddIcon from '@material-ui/icons/Add';
import Swal from 'sweetalert2';
import Loader from 'react-loader-spinner';
import { useSelector } from 'react-redux'; // Importar useSelector
import DashboardTipoDoc from '../mantenedores/DashboardTipoDoc';
import { makeStyles } from '@material-ui/core/styles';
import moment from 'moment';

const Dashboard = ({ userDNI, empresaId }) => {
  const useStyles = makeStyles({
    root: {
      width: '100%',
    },
    container: {
      maxHeight: 440,
    },
  });
  const [showForm, setShowForm] = useState(false); // State to control form visibility
  const [selectedDoc, setSelectedDoc] = useState(null); // State for selected document
  const [documents, setDocuments] = useState([]); // Use  state to manage documents
  const [searchTerm, setSearchTerm] = useState(''); // State to manage search term
  const [page, setPage] = useState(0); // State to manage pagination page
  const [rowsPerPage, setRowsPerPage] = useState(5); // State to manage rows per page
  const [previewPdf, setPreviewPdf] = useState('');
  const [open, setOpen] = useState(false);
  const [tipoDocumentos, setTipoDocumentos] = useState([]);
  const [trabajadores, setTrabajadores] = useState([]);
  const [loading, setLoading] = useState(false);
  const [selectedEmpresa, setSelectedEmpresa] = useState('');
  const [trabajador, setTrabajador] = useState('');
  const [year, setYear] = useState('');
  const [month, setMonth] = useState('');
  const [docType, setDocType] = useState('');
  const [empresas, setEmpresas] = useState([]);
  const [cargos, setCargos] = useState([]);
  const classes = useStyles();
  const token = useSelector((state) => state.token);

  const empresaIdS = useSelector((state) => state.empresaId); // Obtener empresaId de Redux

  const fetchDocuments = async (newType) => {
    try {
      const response = await axios.get(`${API_BASE_URL}/documentos/all/${token}`); // Replace with your API endpoint
      !newType ? setDocuments(response.data) : setDocuments(response.data.filter((doc) => doc.tipo_doc_id === newType ));
    } catch (error) {
      console.error('Error fetching documents:', error);
    }
  };
  const fetchTipoDocumentos = async () => {
    try {
      const response = await axios.get(`${API_BASE_URL}/tipo_doc/all/${token}`); // Replace with your API endpoint
      setTipoDocumentos(response.data);
    } catch (error) {
      console.error('Error fetching tipo_doc:', error);
    }
  };
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
  const fetchEmpresas = async () => {
    try {
      const response = await axios.get(`${API_BASE_URL}/empresas/all/${token}`); // Replace with your API endpoint
      setEmpresas(response.data);
    } catch (error) {
      console.error('Error fetching trabajadores:', error);
    }
  };
  const fetchCargos = async () => {
    try {
      const response = await axios.get(`${API_BASE_URL}/cargos/all/${token}`); // Replace with your API endpoint
      setCargos(response.data);
    } catch (error) {
      console.error('Error fetching cargos:', error);
    }
  };

  const handleDocTypeChangeTable = (newType) => {
    setDocType(newType);
    // Filtra y actualiza los documentos según el tipo seleccionado
    fetchDocuments(newType);
  };

  // Fetch documents on component mount
  useEffect( () => {
    // Si hay solo un valor para empresaIdS, actualizar el estado de selectedEmpresa
    if (empresaIdS && empresas.filter((empresa) => empresa.id === empresaIdS).length === 1) {
      setSelectedEmpresa(empresaIdS);
    }

    fetchCargos();
    fetchEmpresas();
    fetchDocuments(null); 
    fetchTrabajadores();
    fetchTipoDocumentos();

  }, []);



  const handleEmpresaChange = (e) => setSelectedEmpresa(e.target.value);
  const handleTrabajadorChange = (e) => setTrabajador(e.target.value);
  const handleYearChange = (e) => setYear(e.target.value);
  const handleMonthChange = (e) => setMonth(e.target.value);
  const handleDocTypeChange = (e) => setDocType(e.target.value);
  const handleCancel = () => {
    setShowForm(false);
    setSelectedDoc(null);
  };
  const handleChangePage = (event, newPage) => setPage(newPage);
  const handleChangeRowsPerPage = (event) => {
    setRowsPerPage(parseInt(event.target.value, 10));
    setPage(0);
  };
  const handleClickOpen = (pdfUrl) => {
    setPreviewPdf(pdfUrl);
    setOpen(true);
  };
  const handleClose = () => {
    setOpen(false);
    setPreviewPdf('');
  };

  const showLoadingAlert = () => {
    Swal.fire({
      title: 'Cargando...',
      allowOutsideClick: false,
      allowEscapeKey: false,
      showConfirmButton: false,
      onBeforeOpen: () => {
        Swal.showLoading();
      }
    });
  };
  const hideLoadingAlert = () => {
    Swal.close();
  };

  const deleteDocument = async (id) => {
    try {
      // Mostrar confirmación con SweetAlert2
      const result = await Swal.fire({
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
        const response = await axios.delete(`${API_BASE_URL}/documentos/${id}`);
  
        if (response.status === 200) {
          setDocuments(documents.filter(comunicacion => comunicacion.id !== id));
  
          // Mostrar éxito con SweetAlert2
          Swal.fire(
            '¡Eliminado!',
            'El registro ha sido eliminado exitosamente.',
            'success'
          );
        } else {
          // Mostrar error si la eliminación no fue exitosa
          Swal.fire(
            'Error',
            'Hubo un problema al eliminar el registro.',
            'error'
          );
          console.error('Error al eliminar el registro:', response.data);
        }
      }
    } catch (error) {
      // Mostrar error si ocurrió durante la solicitud
      Swal.fire(
        'Error',
        'Ocurrió un error durante la eliminación.',
        'error'
      );
      console.error('Error durante la eliminación:', error);
    }
  };

  const addDocument = async (docData) => {

    const initialDoc = selectedDoc;

    try {
      const url = initialDoc ? `${API_BASE_URL}/documentos/${initialDoc.id}` : `${API_BASE_URL}/documentos`;
      const method = initialDoc ? 'PUT' : 'POST'; // Use PUT for update, POST for create

      showLoadingAlert();

      // Validar que todos los campos requeridos están completos
      const { mes, agno, tipo, trabajador, nombre, file  } = docData;
      if (!mes || !agno || !tipo || !trabajador || !nombre || !selectedEmpresa) {
        alert('');
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor, complete todos los campos.'
          });
        hideLoadingAlert();
        return;
      }
    
      const formData = new FormData();
      formData.append('month', docData.mes);
      formData.append('year', docData.agno);
      formData.append('tipo_doc_id', docData.tipo);
      formData.append('trabajador', docData.trabajador);
      formData.append('nombre', docData.nombre);
      formData.append('empresa_id', selectedEmpresa);
      formData.append('file', docData.file);
      
      const response = await axios({
        method,
        url,
        data: formData,
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      });

      if (response.status === 200 || response.status === 201) { // Check for successful creation/update (replace with your API's success codes)
        const updatedDoc = response.data; // Assuming your API returns the updated document

        if (initialDoc) { // Update scenario, update state with modified document
          setDocuments(documents.map(doc => doc.id === updatedDoc.id ? updatedDoc : doc));
        } else { // Create scenario, add new document to state
          setDocuments([...documents, updatedDoc]);
        }

        setShowForm(false); // Hide the form after successful operation
        hideLoadingAlert();
        Swal.fire({
          icon: 'success',
          title: 'Respuesta Exitosa',
          text: initialDoc ? 'Documento actualizado exitosamente' : 'Documento agregado exitosamente'
        });
      } else {
        hideLoadingAlert();
        console.error(initialDoc ? 'Error al actualizar el documento:' : 'Error al agregar el documento:', response.data); // Handle creation/update errors
      }
    } catch (error) {
      console.error(initialDoc ? 'Error durante la actualización:' : 'Error durante la creación:', error); // Handle general errors
      hideLoadingAlert();

      let errorMessage = 'Ocurrió un error al procesar la solicitud.';
      if (error.response && error.response.request && error.response.request.response) {
        try {
          const errorData = JSON.parse(error.response.request.response);
          if (errorData.messages && errorData.messages.error) {
            errorMessage = errorData.messages.error;
          }
        } catch (parseError) {
          console.error('Error al parsear el JSON de la respuesta de error:', parseError);
        }
      }

      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: errorMessage
      });
    }
  };

  const getTrabajadorNombre = (trab) => {
    for (let i = 0; i < trabajadores.length; i++) {
      if (trabajadores[i].rut === trab) {
        return `${trabajadores[i].apellido_paterno} ${trabajadores[i].apellido_materno}, ${trabajadores[i].nombres}`;
      }
    }
    console.warn(`Trabajador con RUT ${trab} no encontrado.`);
    return 'Desconocido';
  };

  const getCargoTrabajadorNombre = (cargo_id) => {
    const cargo = cargos.find((c) => c.id === cargo_id);
    return cargo ? cargo.nombre : 'Desconocido';
  };
  const getTipoDocumentoNombre = (tipoDocId) => {
    const tipoDoc = tipoDocumentos.find((tipo) => tipo.id === tipoDocId);
    return tipoDoc ? tipoDoc.nombre : 'Desconocido';
  };
  
  const getMonthName = (monthNumber) => {
    const monthNames = [
      'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
      'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
    ];
    return monthNames[monthNumber - 1];
  };

  const editDocument = (doc) => {
    setSelectedDoc(doc);
    setShowForm(true);
  };

  const filteredDocuments = documents
  .filter((doc) => selectedEmpresa ? doc.empresa_id === selectedEmpresa : true)
  .filter((doc) => trabajador ? doc.trabajador === trabajador : true)
  .filter((doc) => year ? doc.agno == year : true)
  .filter((doc) => month ? doc.mes == month : true)
  .filter((doc) => docType ? doc.tipo_doc_id === docType : true)
  .filter((doc) => empresaIdS ? doc.empresa_id === empresaIdS : true);

  const addDocumentPrev = async ({mes, agno, tipo, trabajador, nombre, file}) => {
    setLoading(true);
    const docData = { mes, agno, tipo, trabajador, nombre, file };
    await addDocument(docData);
    setLoading(false);
  };

  const getLastTenYears = () => {
    const currentYear = new Date().getFullYear();
    const years = [];
    
    for (let i = 0; i < 10; i++) {
      years.push(currentYear - i);
    }
    
    return years;
  };

  const formatDate = (dateString) => {
    return moment(dateString.date, 'YYYY-MM-DD HH:mm:ss.SSSSSS').format('DD-MM-YYYY HH:mm:ss');
  };

  return (
    <div className="container Documentos">
      <h3>Documentos</h3>
      <div className="d-flex justify-content-between mb-3">
        <div></div> {/* Espacio en blanco */}
        <Button
          variant="contained"
          color="primary"
          startIcon={<AddIcon />}
          onClick={() => setShowForm(true)}
        >
          Agregar Documento
        </Button>
      </div>
      {showForm ? (
        <DocumentForm
          onSubmit={addDocumentPrev}
          initialDoc={selectedDoc}
          onCancel={handleCancel}
          empresaId={empresaId}
        />
      ) : (
        <>
          <DashboardTipoDoc tipoDocumentos={tipoDocumentos} onDocTypeChange={handleDocTypeChangeTable} />
            {empresaIdS && empresas.filter((empresa) => empresa.id === empresaIdS).length === 1 ? (
              // Mostrar un campo oculto y no el Select
              <input type="hidden" value={selectedEmpresa} />
            ) : (
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
            )}
          <FormControl variant="outlined" style={{ marginRight: '1rem', minWidth: '120px' }}>
            <InputLabel id="trabajador-select-label">Trabajador</InputLabel>
            <Select
              labelId="trabajador-select-label"
              id="trabajador-select"
              value={trabajador}
              onChange={handleTrabajadorChange}
              label="Trabajador"
            >
              <MenuItem value="">
                <em>Seleccionar trabajador...</em>
              </MenuItem>
              {trabajadores
                .filter((trab) => trab.empresa_id === selectedEmpresa)
                .map((trab) => (
                  <MenuItem key={trab.rut} value={trab.rut}>
                    {trab.apellido_paterno} {trab.apellido_materno}, {trab.nombres} 
                  </MenuItem>
                ))}
            </Select>
          </FormControl>

          <FormControl variant="outlined" style={{ marginRight: '1rem', minWidth: '120px' }}>
            <InputLabel id="year-select-label">Año</InputLabel>
            <Select
              labelId="year-select-label"
              id="year"
              value={year}
              onChange={handleYearChange}
              label="Año"
            >
              <MenuItem value="">
                <em>Seleccionar año...</em>
              </MenuItem>
              {getLastTenYears().map((year) => (
                <MenuItem key={year} value={year}>
                  {year}
                </MenuItem>
              ))}
            </Select>
          </FormControl>

          <FormControl variant="outlined" style={{ marginRight: '1rem', minWidth: '120px' }}>
            <InputLabel id="month-select-label">Mes</InputLabel>
            <Select
              labelId="month-select-label"
              id="month-select"
              value={month}
              onChange={handleMonthChange}
              label="Mes"
            >
              <MenuItem value="">
                <em>Seleccionar mes...</em>
              </MenuItem>
              <MenuItem value="1">Enero</MenuItem>
              <MenuItem value="2">Febrero</MenuItem>
              <MenuItem value="3">Marzo</MenuItem>
              <MenuItem value="4">Abril</MenuItem>
              <MenuItem value="5">Mayo</MenuItem>
              <MenuItem value="6">Junio</MenuItem>
              <MenuItem value="7">Julio</MenuItem>
              <MenuItem value="8">Agosto</MenuItem>
              <MenuItem value="9">Septiembre</MenuItem>
              <MenuItem value="10">Octubre</MenuItem>
              <MenuItem value="11">Noviembre</MenuItem>
              <MenuItem value="12">Diciembre</MenuItem>
            </Select>
          </FormControl>
          <Paper className={classes.root}>
            <TableContainer 
              className={classes.container}
              >
              <Table stickyHeader>
                <TableHead>
                  <TableRow>
                    <TableCell>Mes - Año</TableCell>
                    <TableCell>Trabajador</TableCell>
                    <TableCell>Fecha</TableCell>
                    <TableCell>Nombre</TableCell>
                    <TableCell>Firmado</TableCell>
                    <TableCell>Acciones</TableCell>
                  </TableRow>
                </TableHead>
                <TableBody>
                  {filteredDocuments
                    .slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage)
                    .map((doc) => (
                    <TableRow key={doc.id} hover >
                      <TableCell>{getTrabajadorNombre(doc.trabajador)}</TableCell>
                      <TableCell>{getMonthName(parseInt(doc.mes))} - {doc.agno}</TableCell>
                      <TableCell>{formatDate(doc.created_at)}</TableCell>
                      <TableCell>{doc.nombre}</TableCell>
                      <TableCell>{doc.firma === "1"? "Firmado" : "Sin Firmar"}</TableCell>
                      <TableCell>
                        <Button
                          variant="contained"
                          color="primary"
                          onClick={() => handleClickOpen(`${API_DOWNLOAD_URL}/${doc.ruta}`)}
                          startIcon={<VisibilityIcon />}
                          style={{ marginRight: '0.5rem' }}
                        >
                          Ver
                        </Button>
                        <Button
                          variant="contained"
                          color="secondary"
                          onClick={() => deleteDocument(doc.id)}
                          startIcon={<DeleteIcon />}
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
              count={filteredDocuments.length}
              page={page}
              onPageChange={handleChangePage}
              rowsPerPage={rowsPerPage}
              onRowsPerPageChange={handleChangeRowsPerPage}
            />
          </Paper>
        </>
      )}

      <Dialog open={open} onClose={handleClose} maxWidth="lg" fullWidth>
        <DialogTitle>Vista previa</DialogTitle>
        <DialogContent>
          {previewPdf && <iframe src={previewPdf} width="100%" height="500px" title="PDF Viewer"></iframe>}
        </DialogContent>
      </Dialog>
    </div>
  );
};

export default Dashboard;
