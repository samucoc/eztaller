// components/LiquidacionesToPdf.jsx
import React, { useState } from 'react';
import axios from 'axios';
import '../css/LiquidacionesToPdf.css';
import API_BASE_URL from './apiConstants';

const LiquidacionesToPdf = () => {
  const [month, setMonth] = useState('');
  const [year, setYear] = useState('');
  const [file, setFile] = useState(null);
  const [loading, setLoading] = useState(false);

  const handleMonthChange = (event) => {
    setMonth(event.target.value);
  };

  const handleYearChange = (event) => {
    setYear(event.target.value);
  };

  const handleFileChange = (event) => {
    setFile(event.target.files[0]); // Almacena el primer archivo seleccionado
  };

  const handleSubmit = async (event) => {
    event.preventDefault();

    if (!month || !year || !file) {
      alert('Por favor, complete todos los campos.');
      return;
    }

    const formData = new FormData();
    formData.append('month', month);
    formData.append('year', year);
    formData.append('file', file); // Agrega el archivo al FormData

    try {
      setLoading(true);
      const response = await axios.post(`${API_BASE_URL}/documentos/upload`, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      });
      console.log('Respuesta del servidor:', response.data);
      setLoading(false);
    } catch (error) {
      console.error('Error al enviar los datos:', error);
      setLoading(false);
    }
  };
  return (
    <div className="liquidaciones-to-pdf container">
      <h2>Generar Liquidaciones a PDF</h2>
      <form onSubmit={handleSubmit}>
        <div className="mb-3">
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
        <div className="mb-3">
          <label htmlFor="year" className="form-label">Año:</label>
          <select id="year" className="form-select" value={year} onChange={handleYearChange}>
            <option value="">Seleccionar año...</option>
            <option value="2022">2022</option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
          </select>
        </div>
        <div className="mb-3">
          <label htmlFor="file" className="form-label">Cargar archivo:</label>
          <input type="file" id="file" className="form-control" accept=".pdf" onChange={handleFileChange} />
        </div>
        <div className="mb-3">
          <button type="submit" className="btn btn-primary" disabled={loading}>
            {loading ? 'Enviando...' : 'Generar PDF'}
          </button>
        </div>
      </form>
    </div>
  );
}

export default LiquidacionesToPdf;