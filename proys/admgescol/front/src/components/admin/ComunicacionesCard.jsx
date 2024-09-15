import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here
import ComunicacionesForm from './ComunicacionesForm';
import { useSelector } from 'react-redux';
import { Grid, Card, CardContent, Typography, Button, Box, FormControl, InputLabel, Select, MenuItem  } from '@material-ui/core'; // Import Material-UI components
import DeleteIcon from '@material-ui/icons/Delete';
import EditIcon from '@material-ui/icons/Edit';
import AddIcon from '@material-ui/icons/Add';
import Swal from 'sweetalert2';
import useAuthAxios from '../../axiosSetup'; // Import the configured axios instance

const ComunicacionesCard = () => {
  const [showForm, setShowForm] = useState(false);
  const [selectedComunicacion, setSelectedComunicacion] = useState(null);
  const [comunicaciones, setComunicaciones] = useState([]);
  const userID = useSelector((state) => state.userDNI); // Assuming userID is stored in Redux
  const empresaId = useSelector((state) => state.empresaId); // Assuming userID is stored in Redux
  const [itemsPerPage, setItemsPerPage] = useState(5);
  const [currentPage, setCurrentPage] = useState(1);
  const api = useAuthAxios(); // Use the configured axios instance
  const token = useSelector((state) => state.token);

  // Fetch Comunicaciones on component mount
  useEffect(() => {
    const fetchComunicaciones = async () => {
      try {
        const response = await api.get('/comunicaciones/all/'+token); // Replace with your API endpoint
        setComunicaciones(response.data.filter((empr) => empr.empresa_id === empresaId));
      } catch (error) {
        console.error('Error fetching comunicaciones:', error);
      }
    };

    fetchComunicaciones();
  }, []);

  const deleteComunicacion = async (id) => {
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
        const response = await axios.delete(`${API_BASE_URL}/comunicaciones/${id}`);
  
        if (response.status === 200) {
          setComunicaciones(comunicaciones.filter(comunicacion => comunicacion.id !== id));
  
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
        <Grid container spacing={2}  sx={{ overflowY: 'auto', maxHeight: '500px' }}>
          {comunicaciones.map((comunicacion) => (
            <Grid item xs={12} sm={6} key={comunicacion.id}>
              <Card>
                <CardContent>
                  <Typography variant="h6">{comunicacion.titulo}</Typography>
                  <Typography variant="body2" dangerouslySetInnerHTML={{ __html: comunicacion.descripcion }} />
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

export default ComunicacionesCard;
