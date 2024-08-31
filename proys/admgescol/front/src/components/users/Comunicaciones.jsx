import React, { useState, useEffect } from 'react';
import axios from 'axios';
import API_BASE_URL from '../config/apiConstants'; // Assuming API_BASE_URL is defined here
import { useSelector } from 'react-redux';
import { Grid, Card, CardContent, Typography, Button, Box, Modal, IconButton } from '@mui/material'; // Updated imports
import DeleteIcon from '@mui/icons-material/Delete';
import EditIcon from '@mui/icons-material/Edit';
import AddIcon from '@mui/icons-material/Add';
import CloseIcon from '@mui/icons-material/Close'; // For the close button in the modal

const Comunicaciones = () => {
  const [showForm, setShowForm] = useState(false);
  const [selectedComunicacion, setSelectedComunicacion] = useState(null);
  const [comunicaciones, setComunicaciones] = useState([]);
  const [modalOpen, setModalOpen] = useState(false);
  const [modalData, setModalData] = useState(null);
  const userID = useSelector((state) => state.userDNI); // Assuming userID is stored in Redux
  const empresaId = useSelector((state) => state.empresaId); // Assuming empresaId is stored in Redux
  const [trabajadores, setTrabajadores] = useState([]);

  // Fetch Comunicaciones on component mount
  useEffect(() => {
    const fetchComunicaciones = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/comunicaciones`);
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
  }, [empresaId]);

  const handleEdit = (comunicacion) => {
    setSelectedComunicacion(comunicacion);
    setShowForm(true);
  };

  const handleCancel = () => {
    setShowForm(false);
    setSelectedComunicacion(null);
  };

  const handleCardClick = (comunicacion) => {
    setModalData(comunicacion);
    setModalOpen(true);
  };

  const handleCloseModal = () => {
    setModalOpen(false);
    setModalData(null);
  };

  const getTrabajadorNombre = (trab) => {
    const trabajador = trabajadores.find(t => t.rut === trab);
    return trabajador ? `${trabajador.apellido_paterno} ${trabajador.apellido_materno},  ${trabajador.nombres}` : 'Desconocido';
  };

  return (
    <div className="container Comunicaciones">
      <h3>Comunicaciones</h3>
        <Grid container spacing={2}>
          {comunicaciones.map((comunicacion) => (
            <Grid item xs={12} sm={6} key={comunicacion.id}>
              <Card onClick={() => handleCardClick(comunicacion)} sx={{ cursor: 'pointer' }}>
                <CardContent>
                  <Typography variant="h6">{comunicacion.titulo}</Typography>
                  <Typography variant="body2">{comunicacion.descripcion}</Typography>
                </CardContent>
              </Card>
            </Grid>
          ))}
        </Grid>

      {/* Modal */}
      <Modal
        open={modalOpen}
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
          <IconButton
            sx={{ position: 'absolute', top: 8, right: 8 }}
            onClick={handleCloseModal}
          >
            <CloseIcon />
          </IconButton>
          <Typography id="modal-title" variant="h6" component="h2">
            {modalData?.titulo}
          </Typography>
          <Typography id="modal-description" sx={{ mt: 2 }}>
            {modalData?.descripcion}
          </Typography>
          <Typography sx={{ mt: 2 }}>
            <strong>Usuario:</strong> {getTrabajadorNombre(modalData?.user_id)}
          </Typography>
          <Typography sx={{ mt: 2 }}>
            <strong>Fecha y Hora:</strong> {modalData?.fechahora}
          </Typography>
        </Box>
      </Modal>
    </div>
  );
};

export default Comunicaciones;
