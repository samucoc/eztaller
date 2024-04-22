import React, { useState, useEffect } from 'react';
import axios from 'axios'; // Assuming you're using Axios for API calls
import '../css/LiquidacionesToPdf.css'; // Revisa este archivo para asegurarte de que los estilos se apliquen correctamente
import API_BASE_URL from './apiConstants'; // Asegúrate de importar la URL base de tu API desde apiConstants.js
import API_DOWNLOAD_URL from './apiConstants1'; // Asegúrate de importar la URL base de tu API desde apiConstants.js

const ListadoDocumentos = ({userDNI}) => {
  const [data, setData] = useState(null);
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState(null);
  const userSession = userDNI
  
  useEffect(() => {
    const fetchData = async () => {
      setIsLoading(true);
      setError(null);

      try {
        const response = await axios.get(`${API_BASE_URL}/documentos/showLiquidaciones/${userSession}`)
        setData(response.data);
      } catch (error) {
        console.error('Error fetching data:', error);
        const errorMessage = error.response?.data?.message || 'An error occurred while fetching data';
        setError(errorMessage);
      } finally {
        setIsLoading(false);
      }
    };

    fetchData();
  }, []);

  if (isLoading) {
    return <p>Loading data...</p>;
  }

  if (error) {
    return <p>Error: {error}</p>;
  }

  if (!data || data.length === 0) {
    return <p>No documents found for RUT 16968853.</p>;
  }

  return (
    <div>
    <h3>Liquidaciones</h3>
    <table className="table">
      <thead>
        <tr>
          <th>Mes</th>
          <th>Año</th>
          <th>Nombre</th>
          <th>Trabajador</th>
          <th>Ruta</th>
        </tr>
      </thead>
      <tbody>
        {data.map(d => (
          <tr>
            <td>{d.mes}</td>
            <td>{d.agno}</td>
            <td>{d.nombre}</td>
            <td>{d.trabajador}</td>
            <td><a href={`${API_DOWNLOAD_URL}/${d.ruta}`} download target="_blank">Descargar</a></td>
          </tr>
        ))}
      </tbody>
    </table>
    </div>
  );
};

export default ListadoDocumentos;
