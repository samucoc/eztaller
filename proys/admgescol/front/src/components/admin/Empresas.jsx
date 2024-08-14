import React, { useState, useEffect } from 'react';
import axios from 'axios';
import API_BASE_URL from '../config/apiConstants';
import EmpresaForm from './EmpresaForm';
import ManageEmpresa from './ManageEmpresa'; // Asegúrate de importar este componente si ya está definido
import { Button } from '@material-ui/core'; // No es necesario importar Table, TableBody, etc., si no se utilizan
import DeleteIcon from '@material-ui/icons/Delete';
import EditIcon from '@material-ui/icons/Edit';
import AddIcon from '@material-ui/icons/Add';

const Empresas = () => {
  const [showForm, setShowForm] = useState(false);
  const [selectedEmpresa, setSelectedEmpresa] = useState(null);
  const [empresas, setEmpresas] = useState([]);
  const [comunas, setComunas] = useState([]);

  // Fetch Empresas and Comunas on component mount
  useEffect(() => {
    const fetchEmpresas = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/empresas`);
        setEmpresas(response.data);
      } catch (error) {
        console.error('Error fetching Empresas:', error);
      }
    };

    const fetchComunas = async () => {
      try {
        const response = await axios.get(`${API_BASE_URL}/comunas`);
        setComunas(response.data);
      } catch (error) {
        console.error('Error fetching Comunas:', error);
      }
    };

    fetchEmpresas();
    fetchComunas();
  }, []);

  const deleteEmpresa = async (id) => {
    try {
      const response = await axios.delete(`${API_BASE_URL}/empresas/${id}`);

      if (response.status === 200) {
        setEmpresas(empresas.filter(empresa => empresa.id !== id));
        console.log('Empresa eliminada exitosamente');
      } else {
        console.error('Error al eliminar la Empresa:', response.data);
      }
    } catch (error) {
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

  const handleCancel = () => {
    setShowForm(false);
    setSelectedEmpresa(null);
  };

  const manageEmpresa = (empresaId) => {
    const empresa = empresas.find(emp => emp.id === empresaId);
    setSelectedEmpresa(empresa);
  };

  return (
    <div className="container empresas">
      {selectedEmpresa && !showForm ? (
        <ManageEmpresa empresa={selectedEmpresa} />
      ) : (
        <>
          <h3>Empresas</h3>
          <div className="d-flex justify-content-between mb-3">
            <div></div> {/* Espacio en blanco */}
            <Button
              variant="contained"
              color="primary"
              startIcon={<AddIcon />}
              onClick={() => {
                setSelectedEmpresa(null);
                setShowForm(true);
              }}
            >
              Agregar Empresa
            </Button>
          </div>
          {showForm ? (
            <EmpresaForm
              onSubmit={addOrUpdateEmpresa}
              initialEmpresa={selectedEmpresa}
              onCancel={handleCancel}
              comunas={comunas}
            />
          ) : (
            <div className="row">
              {empresas.map(empresa => (
                <div key={empresa.id} className="col-12">
                  <div className="card mb-3">
                    <div className="card-body">
                      <h5 className="card-title">{empresa.RazonSocial}</h5>
                      <p className="card-text">{empresa.NombreFantasia}</p>
                      <div className="d-flex justify-content-end">
                        <Button
                          variant="contained"
                          color="primary"
                          startIcon={<EditIcon />}
                          onClick={() => manageEmpresa(empresa.id)}
                        >
                          Gestionar
                        </Button>
                        <Button
                          variant="contained"
                          color="secondary"
                          startIcon={<DeleteIcon />}
                          onClick={() => deleteEmpresa(empresa.id)}
                          style={{ marginLeft: '10px' }}
                        >
                          Eliminar
                        </Button>
                      </div>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          )}
        </>
      )}
    </div>
  );
};

export default Empresas;
