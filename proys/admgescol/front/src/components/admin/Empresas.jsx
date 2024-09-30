import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here
import EmpresaForm from './EmpresaForm';
import ManageEmpresa from './ManageEmpresa';
import { Button, TextField, MenuItem, Select, FormControl, InputLabel, Menu } from '@material-ui/core';
import DeleteIcon from '@material-ui/icons/Delete';
import EditIcon from '@material-ui/icons/Edit';
import AddIcon from '@material-ui/icons/Add';
import ListIcon from '@mui/icons-material/List';
import '../../css/Empresas.css';
import { useDispatch, useSelector } from 'react-redux';
import { useParams, useNavigate } from 'react-router-dom';
import { setEmpresaId } from '../../actions';
import Swal from 'sweetalert2';

const Empresas = ({ empresaId }) => {
  const [showForm, setShowForm] = useState(false);
  const [showMenu, setshowMenu] = useState(false);
  const [selectedEmpresa, setSelectedEmpresa] = useState(null);
  const [empresas, setEmpresas] = useState([]);
  const [comunas, setComunas] = useState([]);
  const [searchTerm, setSearchTerm] = useState('');
  const [itemsPerPage, setItemsPerPage] = useState(5);
  const [currentPage, setCurrentPage] = useState(1);
  const token = useSelector((state) => state.token);

  const dispatch = useDispatch();
  const empresaIdS = useSelector((state) => state.empresaId);

  const { id } = useParams();

  const navigate = useNavigate();
  const fetchEmpresas = async () => {
    try {
      const response = await axios.get(`${API_BASE_URL}/empresas/all/${token}`); // Replace with your API endpoint
      setEmpresas(response.data);
    } catch (error) {
      console.error('Error fetching Empresas:', error);
    }
  };

  const fetchComunas = async () => {
    try {
      const response = await axios.get(`${API_BASE_URL}/comunas/all/${token}`); // Replace with your API endpoint
      setComunas(response.data);
    } catch (error) {
      console.error('Error fetching Comunas:', error);
    }
  };


  useEffect(() => {
    fetchEmpresas();
    fetchComunas();
  }, []);

  const deleteEmpresa = async (id) => {
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
        const response = await axios.delete(`${API_BASE_URL}/empresas/${id}`);
  
        if (response.status === 200) {
          setEmpresas(empresas.filter(comunicacion => comunicacion.id !== id));
  
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

  const addOrUpdateEmpresa = async (empresaData) => {
    try {
      const url = selectedEmpresa
        ? `${API_BASE_URL}/empresas/${selectedEmpresa.id}`
        : `${API_BASE_URL}/empresas`;
      const method = selectedEmpresa ? 'PUT' : 'POST';

      const response = await axios({
        method,
        url,
        data: empresaData,
      });

      if (response.status === 200 || response.status === 201) {
        const updatedEmpresa = response.data;

        if (selectedEmpresa) {
          setEmpresas(empresas.map(empresa => empresa.id === updatedEmpresa.id ? updatedEmpresa : empresa));
        } else {
          setEmpresas([...empresas, updatedEmpresa]);
        }

        setShowForm(false);
        setSelectedEmpresa(null);
        console.log(selectedEmpresa ? 'Empresa actualizada exitosamente' : 'Empresa agregada exitosamente');
      } else {
        console.error('Error al guardar la Empresa:', response.data);
      }
    } catch (error) {
      console.error('Error durante la operación:', error);
    }
  };

  const editEmpresa = (empresa) => {
    setSelectedEmpresa(empresa);
    setShowForm(true);
  };

  const manageEmpresa = (empresaId) => {
    const empresa = empresas.find(emp => emp.id === empresaId);
    dispatch(setEmpresaId(empresa?.id));
    navigate(`/Empresas/${empresaId}`);
  };

  const filteredEmpresas = empresas.filter(empresa => 
    empresa.NombreFantasia.toLowerCase().includes(searchTerm.toLowerCase()) ||
    empresa.RazonSocial.toLowerCase().includes(searchTerm.toLowerCase())
  );

  const handlePageChange = (newPage) => {
    setCurrentPage(newPage);
  };

  const handleItemsPerPageChange = (event) => {
    setItemsPerPage(Number(event.target.value));
    setCurrentPage(1); // Reset to first page when changing items per page
  };

  const currentEmpresas = filteredEmpresas.slice(
    (currentPage - 1) * itemsPerPage,
    currentPage * itemsPerPage
  );

  const totalPages = Math.ceil(filteredEmpresas.length / itemsPerPage);

  const [anchorElOpcion, setAnchorElOpcion] = useState(null);

  const handleClickOpcion = (event, empresa) => {
    setAnchorElOpcion(event.currentTarget);  // Open the menu at the clicked button
    setSelectedEmpresa(empresa);  
    setshowMenu(true)           // Store the selected empresa
  };
  
  const handleCloseOpcion = () => {
    setAnchorElOpcion(null); // Close the menu
    setSelectedEmpresa(null); // Clear the selected empresa
    setshowMenu(false)           // Store the selected empresa

  };


  return (
    <div className="container empresas">
      {selectedEmpresa && !showForm && !showMenu? (
        <ManageEmpresa empresa={selectedEmpresa} />
      ) : (
        <>
          <h3>Empresas</h3>
          {showForm ? (
            <EmpresaForm
              onSubmit={addOrUpdateEmpresa}
              initialEmpresa={selectedEmpresa}
              onCancel={() => {
                                setShowForm(false)
                                setSelectedEmpresa(null)
                                fetchEmpresas()
                              }
                        }
              comunas={comunas}
            />
          ) : (
            <>
              <div className="d-flex justify-content-between mb-3">
                <div></div>
                <Button
                  variant="contained"
                  startIcon={<AddIcon />}
                  onClick={() => {
                    setSelectedEmpresa(null);
                    setShowForm(true);
                  }}
                  className="crear-empresa-btn" 
                  >
                  Crear Empresa
                </Button>
              </div>
              <TextField
                label="Buscar Empresa"
                variant="outlined"
                fullWidth
                margin="normal"
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                placeholder="Buscar por Razón Social o Nombre Fantasía"
              />
              <div className="row" style={{ overflowY: 'auto', maxHeight: '500px' }}>
                {currentEmpresas.map(empresa => (
                  <div key={empresa.id} className="col-12">
                    <div className="card mb-3">
                      <div className="card-body d-flex justify-content-between align-items-center">
                        {/* Flex container for title and text */}
                        <div className="d-flex flex-column">
                          <h5 className="mb-0">{empresa.NombreFantasia}</h5>
                          <p className="mb-0 small">{empresa.RazonSocial}</p>
                        </div>
                        {/* Button group */}
                        <div className="d-flex">
                          <Button
                            variant="outlined"
                            color="primary"
                            startIcon={<EditIcon />}
                            onClick={() => manageEmpresa(empresa.id)}
                            style={{ marginLeft: '10px' }}
                            disabled={empresa.empresaStatus === "0"} // Disable when empresaStatus is 0
                          >
                            Gestionar
                          </Button>
                          <Button
                            variant="text"
                            color="primary"
                            startIcon={<ListIcon />}
                            onClick={(event) => handleClickOpcion(event, empresa)} // Pass the empresa to handleClickOpcion
                            style={{ marginLeft: '10px' }}

                          ></Button>
                          <Menu
                            anchorEl={anchorElOpcion}
                            open={Boolean(anchorElOpcion)}
                            onClose={handleCloseOpcion}
                          >
                            <MenuItem 
                              startIcon={<EditIcon />}
                              onClick={() => {
                                              if (selectedEmpresa) {
                                                editEmpresa(selectedEmpresa); // Use the selectedEmpresa
                                              }
                                              setAnchorElOpcion(null)
                                              }
                                }
                              style={{ marginLeft: '10px' }}>Editar
                            </MenuItem>
                            <MenuItem 
                              startIcon={<DeleteIcon />}
                              onClick={() => {
                                if (selectedEmpresa) {
                                  deleteEmpresa(selectedEmpresa.id); // Use the selectedEmpresa's id
                                }
                                handleCloseOpcion();
                              }}
                              style={{ marginLeft: '10px' }}>Eliminar
                            </MenuItem>
                          </Menu>
                        </div>
                      </div>
                    </div>
                  </div>
                ))}
              </div>
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
            </>
          )}
        </>
      )}
    </div>
  );
};

export default Empresas;
