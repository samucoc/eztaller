import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here
import ComunicacionesForm from './ComunicacionesForm';
import { useSelector } from 'react-redux';
import { Grid, Card, CardContent, Typography, Button, Box } from '@material-ui/core'; // Import Material-UI components
import DeleteIcon from '@material-ui/icons/Delete';
import EditIcon from '@material-ui/icons/Edit';
import AddIcon from '@material-ui/icons/Add';

const ComunicacionesCard = () => {
  const [showForm, setShowForm] = useState(false);
  const [selectedComunicacion, setSelectedComunicacion] = useState(null);
  const [comunicaciones, setComunicaciones] = useState([]);
  const userID = useSelector((state) => state.userDNI); // Assuming userID is stored in Redux
  const empresaId = useSelector((state) => state.empresaId); // Assuming userID is stored in Redux

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

    fetchComunicaciones();
  }, []);

  const deleteComunicacion = async (id) => {
    try {
      const response = await axios.delete(`${API_BASE_URL}/comunicaciones/${id}`);
      if (response.status === 200) {
        setComunicaciones(comunicaciones.filter(comunicacion => comunicacion.id !== id));
        console.log('Comunicacion eliminada exitosamente');
      } else {
        console.error('Error al eliminar la comunicacion:', response.data);
      }
    } catch (error) {
      console.error('Error durante la eliminación:', error);
    }
  };

  const addOrUpdateComunicacion = async (comunicacionData) => {
    try {
      const isUpdate = selectedComunicacion !== null;
      const url = isUpdate ? `${API_BASE_URL}/comunicaciones/${selectedComunicacion.id}` : `${API_BASE_URL}/comunicaciones`;
      const method = isUpdate ? 'PUT' : 'POST';

      const response = await axios({
        method,
        url,
        data: comunicacionData,
      });

      if (response.status === 200 || response.status === 201) {
        const updatedComunicacion = response.data;

        if (isUpdate) {
          setComunicaciones(comunicaciones.map(comunicacion => comunicacion.id === updatedComunicacion.id ? updatedComunicacion : comunicacion));
        } else {
          setComunicaciones([...comunicaciones, updatedComunicacion]);
        }

        setShowForm(false);
        setSelectedComunicacion(null);
        console.log(isUpdate ? 'Comunicacion actualizada exitosamente' : 'Comunicacion agregada exitosamente');
      } else {
        console.error(isUpdate ? 'Error al actualizar la comunicacion:' : 'Error al agregar la comunicacion:', response.data);
      }
    } catch (error) {
      console.error('Error durante la creación/actualización:', error);
    }
  };

  const handleEdit = (comunicacion) => {
    setSelectedComunicacion(comunicacion);
    setShowForm(true);
  };

  const handleCancel = () => {
    setShowForm(false);
    setSelectedComunicacion(null);
  };

  return (
    <div className="container Comunicaciones">
      <h3>Comunicaciones</h3>
      <Box sx={{ display: 'flex', justifyContent: 'space-between', mb: 3 }}>
        <div></div>
        <Button
          variant="contained"
          color="primary"
          startIcon={<AddIcon />}
          onClick={() => setShowForm(true)}
        >
          Agregar Comunicación
        </Button>
      </Box>
      {showForm ? (
        <ComunicacionesForm
          onSubmit={addOrUpdateComunicacion}
          initialComunicacion={selectedComunicacion}
          onCancel={handleCancel}
        />
      ) : (
        <Grid container spacing={2}>
          {comunicaciones.map((comunicacion) => (
            <Grid item xs={12} sm={6} key={comunicacion.id}>
              <Card>
                <CardContent>
                  <Typography variant="h6">{comunicacion.titulo}</Typography>
                  <Typography variant="body2">{comunicacion.descripcion}</Typography>
                  <Box sx={{ display: 'flex', justifyContent: 'flex-end', mt: 2 }}>
                    <Button
                      variant="contained"
                      color="primary"
                      onClick={() => handleEdit(comunicacion)}
                      startIcon={<EditIcon />}
                      sx={{ mr: 1 }}
                    >
                      Editar
                    </Button>
                    <Button
                      variant="contained"
                      color="secondary"
                      onClick={() => deleteComunicacion(comunicacion.id)}
                      startIcon={<DeleteIcon />}
                    >
                      Eliminar
                    </Button>
                  </Box>
                </CardContent>
              </Card>
            </Grid>
          ))}
        </Grid>
      )}
    </div>
  );
};

export default ComunicacionesCard;
