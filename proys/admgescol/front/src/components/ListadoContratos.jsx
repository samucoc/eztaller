import React, { useState, useEffect } from 'react';
import axios from 'axios';
import API_BASE_URL from './apiConstants'; // Asegúrate de importar la URL base de tu API
import API_DOWNLOAD_URL from './apiConstants1'; // Asegúrate de importar la URL de descarga de tu API
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faEye } from '@fortawesome/free-solid-svg-icons';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';

const ListadoContratos = ({ userDNI, empresaId }) => {
  const [data, setData] = useState([]);
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState(null);
  const [currentPage, setCurrentPage] = useState(1);
  const [previewPdf, setPreviewPdf] = useState(null);

  const contractsPerPage = 10;
  const indexOfLastContract = currentPage * contractsPerPage;
  const indexOfFirstContract = indexOfLastContract - contractsPerPage;

  useEffect(() => {
    const fetchData = async () => {
      setIsLoading(true);
      setError(null);
      try {
        const response = await axios.get(`${API_BASE_URL}/documentos/showContratos/${userDNI}`);
        setData(response.data);
      } catch (error) {
        const errorMessage = error.response?.data?.message || 'An error occurred while fetching data';
        setError(errorMessage);
      } finally {
        setIsLoading(false);
      }
    };

    fetchData();
  }, [userDNI]);

  if (isLoading) {
    return <p>Loading data...</p>;
  }

  if (error) {
    return <p>Error: {error}</p>;
  }

  if (!data.length) {
    return <p>No documents found for RUT {userDNI}.</p>;
  }

  const currentContracts = data.slice(indexOfFirstContract, indexOfLastContract);
  const paginateForward = () => setCurrentPage(currentPage + 1);
  const paginateBackward = () => setCurrentPage(currentPage - 1);

  return (
    <div>
      <h3>Reglamento Interno</h3>
      <table className="table">
        <thead>
          <tr>
            <th>Mes</th>
            <th>Año</th>
            <th>Nombre</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {currentContracts
            .filter((d) => d.empresa_id === empresaId)
            .map((d) => (
              <tr key={d.ruta}>
                <td>{d.mes}</td>
                <td>{d.agno}</td>
                <td>{d.nombre}</td>
                <td>
                  <a href="#"
                    className="btn btn-primary"
                    onClick={() => setPreviewPdf(`${API_DOWNLOAD_URL}/${d.ruta}`)}
                    data-bs-toggle="modal"
                    data-bs-target="#pdfModal"
                  >
                    <FontAwesomeIcon icon={faEye} /> Ver Archivo
                  </a>
                </td>
              </tr>
            ))}
        </tbody>
      </table>

      <div className="modal fade" id="pdfModal" tabIndex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div className="modal-dialog modal-lg">
          <div className="modal-content">
            <div className="modal-header">
              <h5 className="modal-title" id="pdfModalLabel">Vista previa</h5>
            </div>
            <div className="modal-body">
              {previewPdf && <iframe src={previewPdf} width="100%" height="500px" title="PDF Viewer"></iframe>}
            </div>
          </div>
        </div>
      </div>

      <div>
        <button onClick={paginateBackward} disabled={currentPage === 1}>
          Anterior
        </button>
        <button onClick={paginateForward} disabled={indexOfLastContract >= data.length}>
          Siguiente
        </button>
      </div>
    </div>
  );
};

export default ListadoContratos;
