import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { API_BASE_URL } from '../config/apiConstants'; // Asegurando la correcta referencia de la URL base
import { Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper, Button, 
          Box, FormControl, InputLabel, Select, MenuItem, Chip, TextField } from '@material-ui/core';
import DeleteIcon from '@material-ui/icons/Delete';
import EditIcon from '@material-ui/icons/Edit';
import Swal from 'sweetalert2';
import { useSelector } from 'react-redux';
import { blue, orange } from '@material-ui/core/colors';

import DenunciaForm from './LeyKarinForm';
import '../../css/LeyKarin.css';

const LeyKarin = () => {
  const [showForm, setShowForm] = useState(false); // Controla la visibilidad del formulario
  const [selectedDenuncia, setSelectedDenuncia] = useState(null); // Denuncia seleccionada para editar
  const [Denuncias, setDenuncias] = useState([]); // Lista de denuncias
  const token = useSelector((state) => state.token);
  const [itemsPerPage, setItemsPerPage] = useState(5); // Elementos por página
  const [currentPage, setCurrentPage] = useState(1); // Página actual
  const [searchTerm, setSearchTerm] = useState(''); // Término de búsqueda
  const [year, setYear] = useState(''); // Año para filtrar
  const [month, setMonth] = useState(''); // Mes para filtrar

  useEffect(() => {
    const fetchDenuncias = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/denuncias-karin/all/${token}`);
        setDenuncias(response.data);
      } catch (error) {
        console.error('Error fetching Denuncias:', error);
      }
    };
    fetchDenuncias();
  }, [token]);

  const editDenuncia = (Denuncia) => {
    setSelectedDenuncia(Denuncia);
    setShowForm(true);
  };

  const handleCancel = () => {
    setShowForm(false);
    setSelectedDenuncia(null);
  };

  const handlePageChange = (newPage) => {
    setCurrentPage(newPage);
  };

  const handleItemsPerPageChange = (event) => {
    setItemsPerPage(Number(event.target.value));
    setCurrentPage(1); // Reiniciar a la página 1 cuando cambie el número de ítems por página
  };

  const currentDenuncias = Denuncias.slice(
    (currentPage - 1) * itemsPerPage,
    currentPage * itemsPerPage
  );

  const totalPages = Math.ceil(Denuncias.length / itemsPerPage);

  const handleSearch = (event) => {
    setSearchTerm(event.target.value);
    setCurrentPage(1); // Reiniciar a la página 1 cuando cambie el término de búsqueda
  };

  const handleYearChange = (event) => {
    setYear(event.target.value);
    setCurrentPage(1); // Reiniciar a la página 1 cuando cambie el año
  };

  const handleMonthChange = (event) => {
    setMonth(event.target.value);
    setCurrentPage(1); // Reiniciar a la página 1 cuando cambie el mes
  };
  
  const getLastTenYears = () => {
    const currentYear = new Date().getFullYear();
    const years = [];
    
    for (let i = 0; i < 10; i++) {
      years.push(currentYear - i);
    }
    
    return years;
  };
  
  // Filtrar Denuncias
  const filteredDenuncias = currentDenuncias.filter((Denuncia) => {
    const denunciaDate = new Date(Denuncia.created_at.date);
    const denunciaYear = denunciaDate.getFullYear();
    const denunciaMonth = denunciaDate.getMonth() + 1; // getMonth() retorna 0-indexed

    return (
      (Denuncia.denuncianteApellidos.toLowerCase().includes(searchTerm.toLowerCase()) ||
      Denuncia.denuncianteNombre.toLowerCase().includes(searchTerm.toLowerCase())) &&
      (year ? denunciaYear === parseInt(year, 10) : true) &&
      (month ? denunciaMonth === parseInt(month, 10) : true)
    );
  });

  return (
    <div className="container Denuncias">
      <h3>Denuncias Ley Karin</h3>
      <div className="d-flex justify-content-between mb-3">
        {!showForm && (
          <>
            <div className="col-6 d-flex justify-content-start">
              <FormControl variant="outlined" style={{ marginBottom: '1rem' }}>
                <TextField
                  label="Buscar"
                  variant="outlined"
                  value={searchTerm}
                  onChange={handleSearch}
                />
              </FormControl>
            </div>
            <div className="col-6 d-flex justify-content-end">
              <FormControl variant="outlined" style={{ marginRight: '1rem', minWidth: '120px' }}>
                <InputLabel id="year-select-label">Año</InputLabel>
                <Select
                  labelId="year-select-label"
                  id="year"
                  value={year}
                  onChange={handleYearChange}
                  label="Año"
                >
                  <MenuItem value="">
                    <em>Seleccionar año...</em>
                  </MenuItem>
                  {getLastTenYears().map((year) => (
                    <MenuItem key={year} value={year}>
                      {year}
                    </MenuItem>
                  ))}
                </Select>
              </FormControl>

              <FormControl variant="outlined" style={{ minWidth: '120px' }}>
                <InputLabel id="month-select-label">Mes</InputLabel>
                <Select
                  labelId="month-select-label"
                  id="month-select"
                  value={month}
                  onChange={handleMonthChange}
                  label="Mes"
                >
                  <MenuItem value="">
                    <em>Seleccionar mes...</em>
                  </MenuItem>
                  <MenuItem value="1">Enero</MenuItem>
                  <MenuItem value="2">Febrero</MenuItem>
                  <MenuItem value="3">Marzo</MenuItem>
                  <MenuItem value="4">Abril</MenuItem>
                  <MenuItem value="5">Mayo</MenuItem>
                  <MenuItem value="6">Junio</MenuItem>
                  <MenuItem value="7">Julio</MenuItem>
                  <MenuItem value="8">Agosto</MenuItem>
                  <MenuItem value="9">Septiembre</MenuItem>
                  <MenuItem value="10">Octubre</MenuItem>
                  <MenuItem value="11">Noviembre</MenuItem>
                  <MenuItem value="12">Diciembre</MenuItem>
                </Select>
              </FormControl>
            </div>
            
          </>
        )}
      </div>
      {showForm ? (
        <DenunciaForm
          initialDenuncia={selectedDenuncia}
          onCancel={handleCancel}
        />
      ) : (
        <TableContainer component={Paper}>
          <Table>
            <TableHead>
              <TableRow>
                <TableCell>#</TableCell>
                <TableCell>Denunciante</TableCell>
                <TableCell>Fecha</TableCell>
                <TableCell>Implicado(s)</TableCell>
                <TableCell>Evidencias</TableCell>
                <TableCell>Acciones</TableCell>
              </TableRow>
            </TableHead>
            <TableBody>
              {filteredDenuncias.map((Denuncia) => (
                <TableRow key={Denuncia.id}>
                  <TableCell>{Denuncia.id}</TableCell>
                  <TableCell>{Denuncia.denuncianteApellidos}, {Denuncia.denuncianteNombre}</TableCell>
                  <TableCell>
                    {new Date(Denuncia.created_at.date).toLocaleDateString('es-ES', {
                      year: 'numeric',
                      month: 'long'
                    })}
                  </TableCell>
                  <TableCell>
                    {Array.isArray(Denuncia.implicados) && Denuncia.implicados.length > 0 ? (
                      Denuncia.implicados.length === 1 ? (
                        <span key={Denuncia.implicados[0].id}>
                          {Denuncia.implicados[0].apellidos}, {Denuncia.implicados[0].nombre}
                        </span>
                      ) : (
                        Denuncia.implicados.map((implicado, index) => (
                          <span key={implicado.id || index}>
                            {implicado.apellidos}, {implicado.nombre}
                            {index < Denuncia.implicados.length - 1 ? ' || ' : ''}
                          </span>
                        ))
                      )
                    ) : (
                      'Sin implicados'
                    )}
                  </TableCell>
                  <TableCell>
                    {Denuncia.adjuntos && Denuncia.adjuntos.length > 0 ? (
                      <Chip className="chip-evidencias" label="Evidencias" />
                    ) : (
                      <Chip
                        className="chip-sin-evidencias"
                        variant="outlined"
                        label="Sin Evidencias"
                      />
                    )}
                  </TableCell>
                  <TableCell> 
                    <Button
                      variant="outlined"
                      color="primary"
                      onClick={() => editDenuncia(Denuncia)}
                    >
                      Leer Denuncia
                    </Button>
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </TableContainer>
    
      )}
      {!showForm && (
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
      )}
    </div>
  );
};

export default LeyKarin;
