import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here

import { useSelector } from 'react-redux';
import { IconButton, Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Button, Dialog, DialogTitle, DialogContent, Paper, Typography, Box } from '@mui/material';
import { Modal, TextField } from '@mui/material';
import Swal from 'sweetalert2';

import { Visibility } from '@mui/icons-material';
import { useNavigate } from 'react-router-dom';

const DashTrabDocLabContrCopia = () => {
  const userDNI = useSelector((state) => state.userDNI);
  const empresaId = useSelector((state) => state.empresaId);
  const roleSession = useSelector((state) => state.roleSession);
  const navigate = useNavigate();

  const [data, setData] = useState([]);
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState(null);
  const [currentPage, setCurrentPage] = useState(1);
  const [previewPdf, setPreviewPdf] = useState(null);
  const [open, setOpen] = useState(false);
  const [trabajadores, setTrabajadores] = useState([]);
  const [openModal, setOpenModal] = useState(false);
  const [selectedDocument, setSelectedDocument] = useState(null);
  const [password, setPassword] = useState('');
  const [signedDocuments, setSignedDocuments] = useState(new Set()); // Keep track of signed documents

  const contractsPerPage = 10;
  const indexOfLastContract = currentPage * contractsPerPage;
  const indexOfFirstContract = indexOfLastContract - contractsPerPage;

  useEffect(() => {
    const fetchData = async () => {
      setIsLoading(true);
      setError(null);
      try {
        const response = roleSession === 2
        ? await axios.get(`${API_BASE_URL}/documentos/showContratosByEmp/${empresaId}`)
        : await axios.get(`${API_BASE_URL}/documentos/showContratosByUserByEmp/${userDNI}/${empresaId}`);
        setData(response.data);
      } catch (error) {
        const errorMessage = error.response?.data?.message || 'An error occurred while fetching data';
        setError(errorMessage);
      } finally {
        setIsLoading(false);
      }
    };

    const fetchTrabajadores = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/trabajadores`);
        
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
    fetchData();
  }, []);

  if (isLoading) {
    return <Typography variant="h6" color="black">Loading data...</Typography>;
  }

  if (error) {
    return <Typography variant="h6" color="black">Error: {error}</Typography>;
  }

  if (!data.length) {
    return <Typography variant="h6" color="black">No documents found for RUT {userDNI}.</Typography>;
  }

  const currentContracts = data.slice(indexOfFirstContract, indexOfLastContract);
  const paginateForward = () => setCurrentPage(currentPage + 1);
  const paginateBackward = () => setCurrentPage(currentPage - 1);

  const handleClickOpen = (pdfUrl) => {
    setPreviewPdf(pdfUrl);
    setOpen(true);
  };

  const handleClose = () => {
    setPreviewPdf(null);
    setOpen(false);
  };

  const handleOpenSignModal = (document) => {
    setSelectedDocument(document);
    setOpenModal(true);
  };

  const handleCloseModal = () => {
    setOpenModal(false);
    setPassword('');
  };

  const getTrabajadorNombre = (trab) => {
    const trabajador = trabajadores.find(t => t.rut === trab);
    return trabajador ? `${trabajador.apellido_paterno} ${trabajador.apellido_materno},  ${trabajador.nombres}` : 'Desconocido';
  };

  const getMonthName = (monthNumber) => {
    const monthNames = [
      'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
      'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
    ];
    return monthNames[monthNumber - 1]; // Restar 1 ya que el índice del array comienza en 0
  };


  const getClientIp = async () => {
      try {
          const response = await axios.get('https://api.ipify.org?format=json');
          return response.data.ip;
      } catch (error) {
          console.error('Error obteniendo IP del cliente:', error);
          return null;
      }
  };

  const handleSignDocument = async () => {
    try {
      const clientIp = await getClientIp(); // Obtener IP del cliente
      if (!clientIp) {
        Swal.fire({
            icon: 'error',
            title: 'Error al obtener IP',
            text: 'No se pudo obtener la IP del cliente.',
            confirmButtonText: 'OK',
        });
        return;
      }
      const response = await axios.post(`${API_BASE_URL}/users/sign-in-rut`, { userDNI, password,  documentId: selectedDocument.id  });
      if (response.status === 200) {
          await axios.post(`${API_BASE_URL}/documentos/firmar-doc`, {
              userDNI, 
              documentId: selectedDocument.id,
              ip: clientIp // Incluir IP en el payload
          });        Swal.fire({
          icon: 'success',
          title: 'Documento firmado',
          text: 'Tu documento ha sido firmado con éxito.',
          confirmButtonText: 'OK',
        });
        navigate('/UserDashboard')
      } else {
        alert('Password incorrect');
      }
    } catch (error) {
      console.error('Error signing document:', error);
    }
  };

  return (
    <div>
      <Typography variant="h4" component="h1" gutterBottom sx={{ color: 'black' }}>
        Contratos y Anexos
      </Typography>
      <TableContainer component={Paper}>
        <Table>
          <TableHead>
            <TableRow>
              <TableCell sx={{ color: 'black' }}>Trabajador</TableCell>
              <TableCell sx={{ color: 'black' }}>Mes - Año</TableCell>
              <TableCell sx={{ color: 'black' }}>Nombre</TableCell>
              <TableCell sx={{ color: 'black' }}>Acciones</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {currentContracts.map((d) => (
              <TableRow key={d.ruta}>
                <TableCell sx={{ color: 'black' }}>{getTrabajadorNombre(d.trabajador)}</TableCell>
                <TableCell sx={{ color: 'black' }}>{getMonthName(d.mes)} - {d.agno}</TableCell>
                <TableCell sx={{ color: 'black' }}>{d.agno}</TableCell>
                <TableCell sx={{ color: 'black' }}>{d.nombre}</TableCell>
                <TableCell>
                  <Button
                    variant="outlined"
                    color="primary"
                    onClick={() => handleClickOpen(`${API_DOWNLOAD_URL}/${d.ruta}`)}
                    startIcon={<Visibility sx={{ color: 'green' }} />}
                  >
                    Ver Documento
                  </Button>
                  {d.firmado === "0" ? (
                    <Button
                      variant="contained"
                      color="secondary"
                      onClick={() => handleOpenSignModal(d)}
                      sx={{ ml: 2 }}
                    >
                      Firmar Documento
                    </Button>
                  ) : (
                    <Button
                      variant="contained"
                      color="success"
                      sx={{ ml: 2 }}
                    >
                      Firmado
                    </Button>
                  )}
                </TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </TableContainer>

      <Modal
        open={openModal}
        onClose={handleCloseModal}
        aria-labelledby="modal-title"
        aria-describedby="modal-description"
      >
        <Box sx={{
          position: 'absolute',
          top: '50%',
          left: '50%',
          transform: 'translate(-50%, -50%)',
          width: 400,
          bgcolor: 'background.paper',
          boxShadow: 24,
          p: 4,
        }}>
          <Typography id="modal-title" variant="h6" component="h2">
            Firmar Documento
          </Typography>
          <TextField
            label="Ingrese su contraseña"
            type="password"
            fullWidth
            margin="normal"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
          />
          <Box sx={{ mt: 2, textAlign: 'right' }}>
            <Button onClick={handleCloseModal} sx={{ mr: 1 }}>Cancelar</Button>
            <Button onClick={handleSignDocument} variant="contained">Firmar</Button>
          </Box>
        </Box>
      </Modal>
      
      <Dialog open={open} onClose={handleClose} maxWidth="lg" fullWidth>
        <DialogTitle sx={{ color: 'black' }}>Vista previa</DialogTitle>
        <DialogContent>
          {previewPdf && (
            <iframe
              src={previewPdf}
              width="100%"
              height="500px"
              title="PDF Viewer"
              style={{ border: 'none' }}
            />
          )}
        </DialogContent>
      </Dialog>

      <Box mt={2}>
        <Button
          variant="contained"
          color="primary"
          onClick={paginateBackward}
          disabled={currentPage === 1}
          style={{ marginRight: '10px' }}
        >
          Anterior
        </Button>
        <Button
          variant="contained"
          color="primary"
          onClick={paginateForward}
          disabled={indexOfLastContract >= data.length}
        >
          Siguiente
        </Button>
      </Box>
    </div>
  );
};

export default DashTrabDocLabContrCopia;
