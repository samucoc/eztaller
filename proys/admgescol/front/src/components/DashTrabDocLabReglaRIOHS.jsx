import React, { useState, useEffect } from 'react';
import axios from 'axios';
import API_BASE_URL from './apiConstants'; // Asegúrate de importar la URL base de tu API
import API_DOWNLOAD_URL from './apiConstants1'; // Asegúrate de importar la URL de descarga de tu API
import { useSelector } from 'react-redux'; // Importar useSelector
import { IconButton, Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Button, Dialog, DialogTitle, DialogContent, Paper, Typography, Box } from '@mui/material';
import { Visibility } from '@mui/icons-material';

const DashTrabDocLabReglaCarga = () => {
  const userDNI = useSelector((state) => state.userDNI); // Obtener userDNI de Redux
  const empresaId = useSelector((state) => state.empresaId); // Obtener empresaId de Redux
  const roleSession = useSelector((state) => state.roleSession); // Obtener empresaId de Redux

  const [data, setData] = useState([]);
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState(null);
  const [currentPage, setCurrentPage] = useState(1);
  const [previewPdf, setPreviewPdf] = useState(null);
  const [open, setOpen] = useState(false);
  const [trabajadores, setTrabajadores] = useState([]);

  const contractsPerPage = 10;
  const indexOfLastContract = currentPage * contractsPerPage;
  const indexOfFirstContract = indexOfLastContract - contractsPerPage;

  useEffect(() => {
    const fetchData = async () => {
      setIsLoading(true);
      setError(null);
      try {
        const response = roleSession == 2 ? await axios.get(`${API_BASE_URL}/documentos/showRIOHSByEmp/${empresaId}`): await axios.get(`${API_BASE_URL}/documentos/showRIOHSByUserByEmp/${userDNI}/${empresaId}`); // Replace with your API endpoint
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
        setTrabajadores(response.data);
      } catch (error) {
        console.error('Error fetching trabajadores:', error);
      }
    };

    fetchTrabajadores();
    fetchData();
  }, [userDNI]);

  if (isLoading) {
    return <p>Loading data...</p>;
  }

  if (error) {
    return <p>Error: {error}</p>;
  }

  if (!data.length) {
    return <p>No documents found for RUT {userDNI}.</p>;
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

  const getTrabajadorNombre = (trab) => {
    for (let i = 0; i < trabajadores.length; i++) {
      if (trabajadores[i].rut === trab) {
        return `${trabajadores[i].nombres} ${trabajadores[i].apellido_paterno} ${trabajadores[i].apellido_materno}`;
      }
    }
    console.warn(`Trabajador con RUT ${trab} no encontrado.`);
    return 'Desconocido';
  };

  return (
    <div>
      <Typography variant="h3" gutterBottom>
        RIOHS
      </Typography>
      <TableContainer component={Paper}>
        <Table>
          <TableHead>
            <TableRow>
              <TableCell>Trabajador</TableCell>
              <TableCell>Mes</TableCell>
              <TableCell>Año</TableCell>
              <TableCell>Nombre</TableCell>
              <TableCell>Acciones</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {currentContracts
              .map((d) => (
                <TableRow key={d.ruta}>
                  <TableCell>{getTrabajadorNombre(d.trabajador)}</TableCell>
                  <TableCell>{d.mes}</TableCell>
                  <TableCell>{d.agno}</TableCell>
                  <TableCell>{d.nombre}</TableCell>
                  <TableCell>
                    <IconButton
                      color="primary"
                      onClick={() => handleClickOpen(`${API_DOWNLOAD_URL}/${d.ruta}`)}
                    >
                      <Visibility />
                    </IconButton>
                  </TableCell>
                </TableRow>
              ))}
          </TableBody>
        </Table>
      </TableContainer>

      <Dialog open={open} onClose={handleClose} maxWidth="lg" fullWidth>
        <DialogTitle>Vista previa</DialogTitle>
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

export default DashTrabDocLabReglaCarga;
