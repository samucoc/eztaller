import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { API_BASE_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here
import { useSelector } from 'react-redux';
import { Grid, Card, CardHeader, Avatar, CardContent, Typography, Button, Box, Modal, IconButton } from '@mui/material';
import CloseIcon from '@mui/icons-material/Close';
import moment from 'moment'; // For date formatting

const ComunicacionModal = ({ modalData, onCancel }) => {

    const [trabajadores, setTrabajadores] = useState([]);

    // Fetch Comunicaciones on component mount
    useEffect(() => {
        const fetchTrabajadores = async () => {
        try {
            const response = await axios.get(`${API_BASE_URL}/trabajadores`);
            setTrabajadores(response.data);
        } catch (error) {
            console.error('Error fetching trabajadores:', error);
        }
        };

        fetchTrabajadores();
    }, []);

    const getTrabajadorNombre = (trab) => {
        const trabajador = trabajadores.find(t => t.rut === trab);
        return trabajador ? `${trabajador.apellido_paterno} ${trabajador.apellido_materno}, ${trabajador.nombres}` : 'Desconocido';
    };

    const formatDate = (dateString) => {
        return moment(dateString).format('DD-MM-YYYY HH:mm:ss');
    };

  return (
    <Card sx={{ margin: 'auto', boxShadow: 3 }}>
      <CardHeader
        avatar={
          <Avatar sx={{ bgcolor: 'primary.main' }}>
            {modalData?.titulo?.charAt(0) || 'U'}
          </Avatar>
        }
        title={modalData?.titulo}
        subheader={modalData?.fechahora ? formatDate(modalData?.fechahora) : 'Fecha no disponible'}
      />
      <CardContent>
        <Typography variant="body1" color="textSecondary"dangerouslySetInnerHTML={{ __html: modalData?.descripcion }} />
        <Typography sx={{ mt: 2 }}>
          <strong>Publicado por:</strong> {getTrabajadorNombre(modalData?.user_id)}
        </Typography>
        <Typography sx={{ mt: 2 }}>
          <strong>Fecha y Hora:</strong> {modalData?.fechahora ? formatDate(modalData?.fechahora) : 'Fecha no disponible'}
        </Typography>
      </CardContent>
    </Card>
  );
};

export default ComunicacionModal;
