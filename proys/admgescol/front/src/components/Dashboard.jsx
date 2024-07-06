import React, { useState, useEffect } from 'react';
import axios from 'axios';
import API_BASE_URL from './apiConstants'; // Assuming API_BASE_URL is defined here
import API_DOWNLOAD_URL from './apiConstants1'; // Asegúrate de importar la URL de descarga de tu API
import DocumentForm from './DashboardForm'; // Assuming you have a DocumentForm component
import { Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper, Button, TextField, TablePagination, Dialog, DialogTitle, DialogContent } from '@material-ui/core';
import DeleteIcon from '@material-ui/icons/Delete';
import EditIcon from '@material-ui/icons/Edit';
import VisibilityIcon from '@material-ui/icons/Visibility';
import AddIcon from '@material-ui/icons/Add';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';
import Swal from 'sweetalert2';
import Loader from 'react-loader-spinner';

const Dashboard = ({ userDNI, empresaId }) => {
  const [showForm, setShowForm] = useState(false); // State to control form visibility
  const [selectedDoc, setSelectedDoc] = useState(null); // State for selected document
  const [documents, setDocuments] = useState([]); // Use state to manage documents
  const [searchTerm, setSearchTerm] = useState(''); // State to manage search term
  const [page, setPage] = useState(0); // State to manage pagination page
  const [rowsPerPage, setRowsPerPage] = useState(5); // State to manage rows per page
  const [previewPdf, setPreviewPdf] = useState('');
  const [open, setOpen] = useState(false);
  const [tipoDocumentos, setTipoDocumentos] = useState([]);
  const [trabajadores, setTrabajadores] = useState([]);
  const [loading, setLoading] = useState(false);

  // Fetch documents on component mount
  useEffect( () => {
    const fetchDocuments = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/documentos`); // Replace with your API endpoint
        setDocuments(response.data);
      } catch (error) {
        console.error('Error fetching documents:', error);
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
    const fetchTrabajadores = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/trabajadores`);
        setTrabajadores(response.data);
      } catch (error) {
        console.error('Error fetching trabajadores:', error);
      }
    };
    fetchDocuments();
    fetchTrabajadores();
    fetchTipoDocumentos();

  }, []);

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
      const response = await axios.delete(`${API_BASE_URL}/documentos/${id}`); // Delete request with document ID

      if (response.status === 200) { // Check for successful deletion (replace with your API's success code)
        setDocuments(documents.filter(doc => doc.id !== id)); // Filter out deleted document
        console.log('Document eliminado exitosamente');
      } else {
        console.error('Error al eliminar el documento:', response.data); // Handle deletion errors
      }
    } catch (error) {
      console.error('Error durante la eliminación:', error); // Handle general errors
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
    if (!mes || !agno || !tipo || !trabajador || !nombre) {
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
    formData.append('empresa_id', empresaId);
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
        return `${trabajadores[i].nombres} ${trabajadores[i].apellido_paterno} ${trabajadores[i].apellido_materno}`;
      }
    }
    console.warn(`Trabajador con RUT ${trab} no encontrado.`);
    return 'Desconocido';
  };

  const getTipoDocumentoNombre = (tipoDocId) => {
    const tipoDoc = tipoDocumentos.find((tipo) => tipo.id === tipoDocId);
    return tipoDoc ? tipoDoc.nombre : 'Desconocido';
  };

  const editDocument = (doc) => {
    setSelectedDoc(doc);
    setShowForm(true);
  };

  const handleCancel = () => {
    setShowForm(false);
    setSelectedDoc(null);
  };

  const handleSearch = (event) => {
    setSearchTerm(event.target.value);
  };

  const handleChangePage = (event, newPage) => {
    setPage(newPage);
  };

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

  const filteredDocuments = documents.filter(doc =>
    (doc.mes?.toString() || '').toLowerCase().includes(searchTerm.toLowerCase()) ||
    (doc.agno?.toString() || '').includes(searchTerm) ||
    (getTipoDocumentoNombre(doc.tipo_doc_id)?.toLowerCase() || '').includes(searchTerm.toLowerCase()) ||
    (getTrabajadorNombre(doc.trabajador)?.toLowerCase() || '').includes(searchTerm.toLowerCase()) ||
    (doc.nombre?.toLowerCase() || '').includes(searchTerm.toLowerCase())
  );

  const addDocumentPrev = async ({mes, agno, tipo, trabajador, nombre, file}) => {
    setLoading(true);

    const docData = { mes, agno, tipo, trabajador, nombre, file };
    await addDocument(docData);

    setLoading(false);
  };

  return (
    <div className="container Documentos">
      <h3>Documentos</h3>
      <div className="d-flex justify-content-between mb-3">
        { !showForm && (
            <TextField
            label="Buscar"
            variant="outlined"
            value={searchTerm}
            onChange={handleSearch}
            style={{ marginBottom: '1rem' }}
          />
        )}
      </div>
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
        />
      ) : (
        <>
          <TableContainer component={Paper}>
            <Table>
              <TableHead>
                <TableRow>
                  <TableCell>Mes</TableCell>
                  <TableCell>Año</TableCell>
                  <TableCell>Tipo</TableCell>
                  <TableCell>Trabajador</TableCell>
                  <TableCell>Nombre</TableCell>
                  <TableCell>Acciones</TableCell>
                </TableRow>
              </TableHead>
              <TableBody>
                {filteredDocuments
                  .filter((doc) => doc.empresa_id === empresaId)
                  .slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage)
                  .map((doc) => (
                  <TableRow key={doc.id}>
                    <TableCell>{doc.mes}</TableCell>
                    <TableCell>{doc.agno}</TableCell>
                    <TableCell>{getTipoDocumentoNombre(doc.tipo_doc_id)}</TableCell>
                    <TableCell>{getTrabajadorNombre(doc.trabajador)}</TableCell>
                    <TableCell>{doc.nombre}</TableCell>
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
                        color="primary"
                        onClick={() => editDocument(doc)}
                        startIcon={<EditIcon />}
                        style={{ marginRight: '0.5rem' }}
                      >
                        Editar
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
