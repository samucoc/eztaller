import React, { useState, useEffect } from 'react';
import { useSelector } from 'react-redux';
import {
  Grid, Card, CardContent, Typography, Button, Box,
  FormControl, InputLabel, Select, MenuItem
} from '@material-ui/core'; // Import Material-UI components
import DeleteIcon from '@material-ui/icons/Delete';
import EditIcon from '@material-ui/icons/Edit';
import AddIcon from '@material-ui/icons/Add';
import Swal from 'sweetalert2';
import useAuthAxios from '../../axiosSetup'; // Import the configured axios instance
import ComunicacionesForm from './ComunicacionesForm';
import ComunicacionView from './ComunicacionesView';
import '../../css/Empresas.css';



const ComunicacionesCard = () => {
  const [showForm, setShowForm] = useState(false);
  const [showForm1, setShowForm1] = useState(false);
  const [selectedComunicacion, setSelectedComunicacion] = useState(null);
  const [comunicaciones, setComunicaciones] = useState([]);
  const [itemsPerPage, setItemsPerPage] = useState(5);
  const [currentPage, setCurrentPage] = useState(1);

  const userID = useSelector((state) => state.userDNI); // Assuming userID is stored in Redux
  const empresaId = useSelector((state) => state.empresaId); // Assuming empresaId is stored in Redux
  const token = useSelector((state) => state.token);
  const api = useAuthAxios(); // Use the configured axios instance

  // Fetch Comunicaciones on component mount
  useEffect(() => {
    const fetchComunicaciones = async () => {
      try {
        const response = await api.get(`/comunicaciones/all/${token}`);
        setComunicaciones(
          response.data
            .filter((empr) => empr.empresa_id === empresaId)
            .sort((a, b) => new Date(b.created_at) - new Date(a.created_at)) // Ordenar de reciente a antigua
        );
        } catch (error) {
        console.error('Error fetching comunicaciones:', error);
      }
    };

    if (token && empresaId) {
      fetchComunicaciones();
    }
  }, [token, empresaId, api]);

  const deleteComunicacion = async (id) => {
    try {
      const result = await Swal.fire({
        title: '¿Estás seguro?',
        text: '¡No podrás revertir esto!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarlo',
        cancelButtonText: 'Cancelar',
      });

      if (result.isConfirmed) {
        const response = await api.delete(`/comunicaciones/${id}`);

        if (response.status === 200) {
          setComunicaciones(comunicaciones.filter((comunicacion) => comunicacion.id !== id));
          Swal.fire('¡Eliminado!', 'El registro ha sido eliminado exitosamente.', 'success');
        } else {
          Swal.fire('Error', 'Hubo un problema al eliminar el registro.', 'error');
        }
      }
    } catch (error) {
      Swal.fire('Error', 'Ocurrió un error durante la eliminación.', 'error');
      console.error('Error durante la eliminación:', error);
    }
  };

  const addOrUpdateComunicacion = async (comunicacionData) => {
    try {
      const isUpdate = selectedComunicacion !== null;
      const url = isUpdate
        ? `/comunicaciones/${selectedComunicacion.id}`
        : '/comunicaciones';
      const method = isUpdate ? 'PUT' : 'POST';

      const response = await api({
        method,
        url,
        data: comunicacionData,
      });

      if (response.status === 200 || response.status === 201) {
        const updatedComunicacion = response.data;

        if (isUpdate) {
          setComunicaciones(comunicaciones.map((comunicacion) =>
            comunicacion.id === updatedComunicacion.id ? updatedComunicacion : comunicacion
          ));
        } else {
          setComunicaciones([...comunicaciones, updatedComunicacion]);
        }

        setShowForm(false);
        setSelectedComunicacion(null);
      }
    } catch (error) {
      console.error('Error durante la creación/actualización:', error);
    }
  };

  const handleView = (comunicacion) => {
    setSelectedComunicacion(comunicacion);
    setShowForm1(true);
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
    setCurrentPage(1);
  };

  const paginatedComunicaciones = comunicaciones.slice(
    (currentPage - 1) * itemsPerPage,
    currentPage * itemsPerPage
  );

  const totalPages = Math.ceil(comunicaciones.length / itemsPerPage);

  return (
    <div className="container Comunicaciones">
      <h3>Comunicaciones</h3>

      {showForm ? (
        <ComunicacionesForm
          onSubmit={addOrUpdateComunicacion}
          initialComunicacion={selectedComunicacion}
          onCancel={handleCancel}
        />
      ) : showForm1 ? (
        <ComunicacionView
          modalData={selectedComunicacion}
          onCancel={handleCancel}
        />
        ) : (
          <>
            <Box sx={{ display: 'flex', justifyContent: 'space-between', mb: 3 }}>
              <div></div>
              <Button
                variant="contained"
                className="crear-empresa-btn" 
                startIcon={<AddIcon />}
                onClick={() => setShowForm(true)}
              >
                Nueva Comunicación
              </Button>
            </Box>
            <Grid container spacing={2} sx={{ overflowY: 'auto', maxHeight: '500px' }}>
              {paginatedComunicaciones.map((comunicacion) => (
                <Grid item xs={12} sm={6} key={comunicacion.id}>
                  <Card>
                    <CardContent>
                      <Typography variant="h6">{comunicacion.titulo}</Typography>
                      <Typography 
                        variant="body2" 
                        dangerouslySetInnerHTML={{ 
                          __html: comunicacion.descripcion.length > 500 
                            ? comunicacion.descripcion.substring(0, 500) + "..." 
                            : comunicacion.descripcion 
                        }} 
                      />
                      <Box sx={{ display: 'flex', justifyContent: 'flex-end', mt: 2 }}>
                        <Button
                          variant="outlined"
                          color="primary"
                          onClick={() => handleView(comunicacion)}
                          sx={{ mr: 1 }}
                        >
                          Leer Más
                        </Button>
                        <Button
                          variant="outlined"
                          color="primary"
                          onClick={() => handleEdit(comunicacion)}
                          startIcon={<EditIcon />}
                          sx={{ mr: 1 }}
                        >
                        </Button>
                        <Button
                          variant="outlined"
                          color="secondary"
                          onClick={() => deleteComunicacion(comunicacion.id)}
                          startIcon={<DeleteIcon />}
                        >
                        </Button>
                      </Box>
                    </CardContent>
                  </Card>
                </Grid>
              ))}
              <div className="d-flex justify-content-between align-items-center mt-3">
                <div className="d-flex">
                  <Button
                    variant="contained"
                    color="primary"
                    onClick={() => handlePageChange(currentPage - 1)}
                    disabled={currentPage === 1}
                    style={{ marginRight: '10px' }}
                  >
                    Anterior
                  </Button>
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

                <span className="mx-auto">Página {currentPage} de {totalPages}</span>
                
              </div>

            </Grid>          
          </>
        )}
    </div>
  );
};

export default ComunicacionesCard;
