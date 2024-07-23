import React, { useState, useEffect } from 'react';
import axios from 'axios';
import API_BASE_URL from './apiConstants'; // Assuming API_BASE_URL is defined here
import API_DOWNLOAD_URL from './apiConstants1'; // Asegúrate de importar la URL base de tu API desde apiConstants.js
import {
  Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper,
  Button, TablePagination, TextField, Select, MenuItem, FormControl, InputLabel
} from '@material-ui/core'; // Importa componentes de Material-UI
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faEye } from '@fortawesome/free-solid-svg-icons';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';

const ListDocs = () => {
  const [showForm, setShowForm] = useState(false); // State to control form visibility
  const [selectedDocumento, setSelectedDocumento] = useState(null); // State for selected Documento
  const [Documentos, setDocumentos] = useState([]); // Use state to manage Documentos
  const [empresas, setEmpresas] = useState([]);
  const [tipoDocumentos, setTipoDocumentos] = useState([]);
  const [Trabajadores, setTrabajadores] = useState([]); // Use state to manage Trabajadores
  const [previewPdf, setPreviewPdf] = useState(null);

  const [searchTerm, setSearchTerm] = useState("");
  const [selectedTipoDoc, setSelectedTipoDoc] = useState("");
  const [selectedEmpresa, setSelectedEmpresa] = useState("");
  const [selectedMes, setSelectedMes] = useState("");
  const [selectedAgno, setSelectedAgno] = useState("");
  const [currentPage, setCurrentPage] = useState(0);
  const [rowsPerPage, setRowsPerPage] = useState(10);

  // Fetch Documentos on component mount
  const fetchDocumentos = async () => {
    try {
      const response = await axios.get(API_BASE_URL + '/documentos'); // Replace with your API endpoint
      setDocumentos(response.data);
    } catch (error) {
      console.error('Error fetching Documentos:', error);
    }
  };

  const fetchEmpresas = async () => {
    try {
      const response = await axios.get(`${API_BASE_URL}/empresas`);
      setEmpresas(response.data);
    } catch (error) {
      console.error('Error al obtener la lista de empresas:', error);
    }
  };

  const fetchTrabajadores = async () => {
    try {
      const response = await axios.get(API_BASE_URL + '/trabajadores');
      setTrabajadores(response.data);
    } catch (error) {
      console.error('Error fetching Trabajadores:', error);
    }
  };

  const fetchTipoDocumentos = async () => {
    try {
      const response = await axios.get(`${API_BASE_URL}/tipo_doc`);
      setTipoDocumentos(response.data);
    } catch (error) {
      console.error('Error fetching tipo_doc:', error);
    }
  };

  useEffect(() => {
    fetchEmpresas();
    fetchTipoDocumentos();
    fetchDocumentos();
    fetchTrabajadores();
  }, []);

  const getTipoDocumentoNombre = (id) => {
    const tipoDocumento = tipoDocumentos.find(tipo => tipo.id === id);
    return tipoDocumento ? tipoDocumento.nombre : 'Desconocido';
  };

  const getEmpresaNombre = (id) => {
    const empresa = empresas.find(emp => emp.id === id);
    return empresa ? empresa.RazonSocial : 'Desconocido';
  };

  const getTrabajadorNombre = (id) => {
    const trabajador = Trabajadores.find(trab => trab.rut === id);
    return trabajador ? trabajador.apellido_paterno + ' ' + trabajador.apellido_materno + ' ' + trabajador.nombres : 'Desconocido';
  };

  const handleSearchChange = (event) => {
    setSearchTerm(event.target.value);
    setCurrentPage(0); // Reset to first page on search
  };

  const handleTipoDocChange = (event) => {
    setSelectedTipoDoc(event.target.value);
    setCurrentPage(0); // Reset to first page on filter change
  };

  const handleEmpresaChange = (event) => {
    setSelectedEmpresa(event.target.value);
    setCurrentPage(0); // Reset to first page on filter change
  };

  const handleMesChange = (event) => {
    setSelectedMes(event.target.value);
    setCurrentPage(0); // Reset to first page on filter change
  };

  const handleAgnoChange = (event) => {
    setSelectedAgno(event.target.value);
    setCurrentPage(0); // Reset to first page on filter change
  };

  const handleChangePage = (event, newPage) => {
    setCurrentPage(newPage);
  };

  const handleChangeRowsPerPage = (event) => {
    setRowsPerPage(parseInt(event.target.value, 10));
    setCurrentPage(0); // Reset to first page on rows per page change
  };

  const filteredDocumentos = Documentos.filter(doc => {
    return (
      (!searchTerm || doc.nombre.toLowerCase().includes(searchTerm.toLowerCase()) || getTrabajadorNombre(doc.trabajador).toLowerCase().includes(searchTerm.toLowerCase())) &&
      (!selectedTipoDoc || doc.tipo_doc_id === selectedTipoDoc) &&
      (!selectedEmpresa || doc.empresa_id === selectedEmpresa) &&
      (!selectedMes || doc.mes === selectedMes) &&
      (!selectedAgno || doc.agno === selectedAgno)
    );
  });

  const displayedDocumentos = filteredDocumentos.slice(currentPage * rowsPerPage, currentPage * rowsPerPage + rowsPerPage);

  return (
    <div className="container Documentos">
      <h3>Documentos</h3>
      <div className="filters">
        <FormControl variant="outlined" style={{ minWidth: 200, marginRight: 16 }}>
          <InputLabel>Empresa</InputLabel>
          <Select value={selectedEmpresa} onChange={handleEmpresaChange} label="Empresa">
            <MenuItem value="">
              <em>Todos</em>
            </MenuItem>
            {empresas.map((emp) => (
              <MenuItem key={emp.id} value={emp.id}>
                {emp.RazonSocial}
              </MenuItem>
            ))}
          </Select>
        </FormControl>
        <TextField
          label="Buscar por nombre o trabajador"
          value={searchTerm}
          onChange={handleSearchChange}
          variant="outlined"
          style={{ marginRight: 16 }}
        />
        <FormControl variant="outlined" style={{ minWidth: 200, marginRight: 16 }}>
          <InputLabel>Tipo de Documento</InputLabel>
          <Select value={selectedTipoDoc} onChange={handleTipoDocChange} label="Tipo de Documento">
            <MenuItem value="">
              <em>Todos</em>
            </MenuItem>
            {tipoDocumentos.map((tipo) => (
              <MenuItem key={tipo.id} value={tipo.id}>
                {tipo.nombre}
              </MenuItem>
            ))}
          </Select>
        </FormControl>
        <TextField
          label="Mes"
          value={selectedMes}
          onChange={handleMesChange}
          variant="outlined"
          style={{ marginRight: 16 }}
        />
        <TextField
          label="Año"
          value={selectedAgno}
          onChange={handleAgnoChange}
          variant="outlined"
          style={{ marginRight: 16 }}
        />
      </div>
      <TableContainer component={Paper}>
        <Table>
          <TableHead>
            <TableRow>
              <TableCell>Tipo de Documento</TableCell>
              <TableCell>Mes</TableCell>
              <TableCell>Año</TableCell>
              <TableCell>Trabajador</TableCell>
              <TableCell>Empresa</TableCell>
              <TableCell>Nombre</TableCell>
              <TableCell>Acciones</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {displayedDocumentos.map((Documento) => (
              <TableRow key={Documento.id}>
                <TableCell>{getTipoDocumentoNombre(Documento.tipo_doc_id)}</TableCell>
                <TableCell>{Documento.mes}</TableCell>
                <TableCell>{Documento.agno}</TableCell>
                <TableCell>{getTrabajadorNombre(Documento.trabajador)}</TableCell>
                <TableCell>{getEmpresaNombre(Documento.empresa_id)}</TableCell>
                <TableCell>{Documento.nombre}</TableCell>
                <TableCell>
                  <a
                    href="#"
                    className="btn btn-primary"
                    onClick={() => setPreviewPdf(`${API_DOWNLOAD_URL}/${Documento.ruta}`)}
                    data-bs-toggle="modal"
                    data-bs-target="#pdfModal"
                  >
                    <FontAwesomeIcon icon={faEye} /> Ver Archivo
                  </a>
                </TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
        <TablePagination
          rowsPerPageOptions={[10, 25, 50]}
          component="div"
          count={filteredDocumentos.length}
          rowsPerPage={rowsPerPage}
          page={currentPage}
          onPageChange={handleChangePage}
          onRowsPerPageChange={handleChangeRowsPerPage}
        />
      </TableContainer>
      <div className="modal fade" id="pdfModal" tabIndex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div className="modal-dialog modal-lg">
          <div className="modal-content">
            <div className="modal-header">
              <h5 className="modal-title" id="pdfModalLabel">Vista previa</h5>
            </div>
            <div className="modal-body">
              {previewPdf && <iframe src={previewPdf} width="100%" height="500px" title="PDF Viewer"></iframe>}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ListDocs;
