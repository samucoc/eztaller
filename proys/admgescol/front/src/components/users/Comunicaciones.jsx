import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { API_BASE_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here
import { useSelector } from 'react-redux';
import { Grid, Card, CardContent, Typography, Button, Box, Modal, IconButton, FormControl, InputLabel, Select, MenuItem } from '@mui/material';
import CloseIcon from '@mui/icons-material/Close'; // For the close button in the modal
import moment from 'moment'; // For date formatting
import ComunicacionesModal from './ComunicacionModal';

const Comunicaciones = () => {
  const [showForm, setShowForm] = useState(false);
  const [selectedComunicacion, setSelectedComunicacion] = useState(null);
  const [comunicaciones, setComunicaciones] = useState([]);
  const [modalOpen, setModalOpen] = useState(false);
  const [modalData, setModalData] = useState(null);
  const userID = useSelector((state) => state.userDNI); // Assuming userID is stored in Redux
  const empresaId = useSelector((state) => state.empresaId); // Assuming empresaId is stored in Redux
  const [trabajadores, setTrabajadores] = useState([]);
  const [itemsPerPage, setItemsPerPage] = useState(5);
  const [currentPage, setCurrentPage] = useState(1);
  const token = useSelector((state) => state.token);

  // Fetch Comunicaciones on component mount
  useEffect(() => {
    const fetchComunicaciones = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/comunicaciones/all/${token}`); // Replace with your API endpoint
        setComunicaciones(response.data.filter((empr) => empr.empresa_id === empresaId));
      } catch (error) {
        console.error('Error fetching comunicaciones:', error);
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
    fetchComunicaciones();
  }, []);

  const handleEdit = (comunicacion) => {
    setSelectedComunicacion(comunicacion);
    setShowForm(true);
  };

  const handleCancel = () => {
    setShowForm(false);
    setSelectedComunicacion(null);
  };

  const handleCardClick = (comunicacion) => {
    setSelectedComunicacion(comunicacion);
    setShowForm(true);
  };

  const handleCloseModal = () => {
    setModalOpen(false);
    setModalData(null);
  };

  const getTrabajadorNombre = (trab) => {
    const trabajador = trabajadores.find(t => t.rut === trab);
    return trabajador ? `${trabajador.apellido_paterno} ${trabajador.apellido_materno}, ${trabajador.nombres}` : 'Desconocido';
  };

  const formatDate = (dateString) => {
    return moment(dateString).format('DD-MM-YYYY HH:mm:ss');
  };

  const handlePageChange = (newPage) => {
    setCurrentPage(newPage);
  };

  const handleItemsPerPageChange = (event) => {
    setItemsPerPage(Number(event.target.value));
    setCurrentPage(1); // Reset to first page when changing items per page
  };

  const currentEmpresas = comunicaciones.slice(
    (currentPage - 1) * itemsPerPage,
    currentPage * itemsPerPage
  );

  const totalPages = Math.ceil(comunicaciones.length / itemsPerPage);

  return (
    <div className="container Comunicaciones">
      <h3>Comunicaciones</h3>
      {showForm ? (
        <ComunicacionesModal
          modalData={selectedComunicacion}
          onCancel={handleCancel}
        />
      ) : (
      <Grid container spacing={2}>
        {comunicaciones.map((comunicacion) => (
          <Grid item xs={12} sm={6} key={comunicacion.id}>
            <Card onClick={() => handleCardClick(comunicacion)} sx={{ cursor: 'pointer' }}>
              <CardContent>
                <Typography variant="h6">{comunicacion.titulo}</Typography>
                <Typography variant="body2" dangerouslySetInnerHTML={{ __html: comunicacion.descripcion }} />
              </CardContent>
            </Card>
          </Grid>
        ))}
          <div className="d-flex justify-content-between align-items-center mt-3">
            <div className="pagination">
              <Button
                variant="contained"
                color="primary"
                onClick={() => handlePageChange(currentPage - 1)}
                disabled={currentPage === 1}
                style={{ marginRight: '10px' }}
              >
                Anterior
              </Button>
              <span>Página {currentPage} de {totalPages}</span>
              <Button
                variant="contained"
                color="primary"
                onClick={() => handlePageChange(currentPage + 1)}
                disabled={currentPage === totalPages}
                style={{ marginLeft: '10px' }}
              >
                Siguiente
              </Button>
            </div>
            <FormControl variant="outlined" className="ml-auto">
              <InputLabel id="items-per-page-label">Items por página</InputLabel>
              <Select
                labelId="items-per-page-label"
                value={itemsPerPage}
                onChange={handleItemsPerPageChange}
                label="Items por página"
              >
                <MenuItem value={5}>5</MenuItem>
                <MenuItem value={10}>10</MenuItem>
                <MenuItem value={25}>25</MenuItem>
              </Select>
            </FormControl>
          </div>
      </Grid>
      )}
      
    </div>
  );
};

export default Comunicaciones;
