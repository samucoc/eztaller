// components/LiquidacionesToPdf.jsx
import React, { useState, useEffect } from 'react';
import axios from 'axios';
import '../css/LiquidacionesToPdf.css';
import API_BASE_URL from './apiConstants';
import Swal from 'sweetalert2';
import Loader from 'react-loader-spinner';

const Documentos = () => {
  const [month, setMonth] = useState('');
  const [year, setYear] = useState('');
  const [tipo_doc_id, settipo_doc_id] = useState('');
  const [nombre, setnombre] = useState('');
  const [trabajador, settrabajador] = useState('');
  
  const [file, setFile] = useState(null);
  const [loading, setLoading] = useState(false);
  const [workers, setWorkers] = useState([]); // State to store worker data

  const showLoadingAlert = () => {
    Swal.fire({
      title: 'Cargando...',
      allowOutsideClick: false,
      allowEscapeKey: false,
      showConfirmButton: false,
      onBeforeOpen: () => {
        Swal.showLoading();
      }
    });
  };
  const hideLoadingAlert = () => {
    Swal.close();
  };

  const handleMonthChange = (event) => {
    setMonth(event.target.value);
  };

  const handleYearChange = (event) => {
    setYear(event.target.value);
  };

  const handletipo_doc_idChange = (event) => {
    settipo_doc_id(event.target.value);
  };

  const handlenombreChange = (event) => {
    setnombre(event.target.value);
  };

  const handletrabajadorChange = (event) => {
    settrabajador(event.target.value);
  };

  const handleFileChange = (event) => {
    setFile(event.target.files[0]); // Almacena el primer archivo seleccionado
  };

    // Fetch all workers on component mount
    useEffect(() => {
        const fetchWorkers = async () => {
            try {
            const response = await axios.get(`${API_BASE_URL}/trabajadores`); // Assuming your worker endpoint is at /trabajadores
            setWorkers(response.data);
            } catch (error) {
            console.error('Error fetching workers:', error);
            }
        };

        fetchWorkers();
        }, []);

  const handleSubmit = async (event) => {
    event.preventDefault();
    showLoadingAlert();
    
    if (!month || !year || !file || !trabajador || !nombre) {
      alert('Por favor, complete todos los campos.');
      return;
    }

    const formData = new FormData();
    formData.append('month', month);
    formData.append('year', year);
    formData.append('tipo_doc_id', tipo_doc_id);
    formData.append('trabajador', trabajador);
    formData.append('nombre', nombre);
    formData.append('file', file); // Agrega el archivo al FormData

    try {
      setLoading(true);
      const response = await axios.post(`${API_BASE_URL}/documentos`, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      });
      console.log('Respuesta del servidor:', response.data);
      hideLoadingAlert();
      Swal.fire({
        icon: 'success',
        title: 'Respuesta Exitosa',
        text: 'Ha ingresado un documento de forma existosa' // Suponiendo que la respuesta contiene un campo 'message'
        });
      setLoading(false);
    } catch (error) {
      console.error('Error al enviar los datos:', error);
      setLoading(false);
      hideLoadingAlert();
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Ocurrió un error al procesar la solicitud.'
        });
    }
  };
  return (
    <div className="liquidaciones-to-pdf container">
      <h2>Cargar Documentación</h2>
      <form onSubmit={handleSubmit}>
      <div className="mb-3">
          <label htmlFor="tipo_doc_id" className="form-label">Tipo Documento:</label>
          <select id="tipo_doc_id" className="form-select" value={tipo_doc_id} onChange={handletipo_doc_idChange}>
            <option value="">Seleccionar tipo documento...</option>
            <option value="1">Liquidación</option>
            <option value="2">Reglamento</option>
            <option value="3">Contratos y Anexos</option>
          </select>
        </div>
        <div className="mb-3 row">
          <div className="col-6">
            <label htmlFor="month" className="form-label">Mes:</label>
            <select id="month" className="form-select" value={month} onChange={handleMonthChange}>
                <option value="">Seleccionar mes...</option>
                <option value="1">Enero</option>
                <option value="2">Febrero</option>
                <option value="3">Marzo</option>
                <option value="4">Abril</option>
                <option value="5">Mayo</option>
                <option value="6">Junio</option>
                <option value="7">Julio</option>
                <option value="8">Agosto</option>
                <option value="9">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
            </select>
          </div>
          <div className="col-6">        
            <label htmlFor="year" className="form-label">Año:</label>
            <select id="year" className="form-select" value={year} onChange={handleYearChange}>
                <option value="">Seleccionar año...</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
            </select>
          </div>
        </div>
        <div className="mb-3">
            <label htmlFor="trabajador" className="form-label">Trabajador:</label>
            <select id="trabajador" className="form-select" value={trabajador} onChange={handletrabajadorChange} >
                <option value="">Seleccionar Trabajador...</option>
                {workers.map(worker => (
                <option key={worker.rut} value={worker.rut}>
                    {worker.rut} - {worker.nombres} {worker.apellido_paterno} {worker.apellido_materno}
                </option>
                ))}
            </select>
        </div>
        <div className="mb-3">
            <label htmlFor="nombre" className="form-label">Nombre Documento:</label>
            <input type="text" className="form-control" value={nombre} name="nombre" id="nombre" onChange={handlenombreChange} />
        </div>
        <div className="mb-3">
          <label htmlFor="file" className="form-label">Cargar archivo:</label>
          <input type="file" id="file" className="form-control" accept=".pdf" onChange={handleFileChange} />
        </div>
        <div className="mb-3">
          <button type="submit" className="btn btn-primary" disabled={loading}>
            {loading ? 'Enviando...' : 'Cargar Documento'}
          </button>
        </div>
      </form>
    </div>
  );
}

export default Documentos;