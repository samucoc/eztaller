import React, { useState, useEffect } from 'react';
import axios from 'axios'; // Assuming you're using Axios for API calls
import '../css/LiquidacionesToPdf.css'; // Revisa este archivo para asegurarte de que los estilos se apliquen correctamente
import API_BASE_URL from './apiConstants'; // Asegúrate de importar la URL base de tu API desde apiConstants.js
import API_DOWNLOAD_URL from './apiConstants1'; // Asegúrate de importar la URL base de tu API desde apiConstants.js

function Trabajadores() {
    const [trabajadores, setTrabajadores] = useState([]);
    const [empresas, setEmpresas] = useState([]);

    const [formData, setFormData] = useState({
        empresa_id: '',
        user_id: '',
        rut: '',
        dv: '',
        apellido_paterno: '',
        apellido_materno: '',
        nombres: '',
        nombre_social: '',
        fecha_nac: '',
        nacionalidad: '',
        cargo_id: '',
        sexo_id: '',
        foto: '',
        direccion: '',
        comuna_id: '',
        telefono: '',
        email: '',
        contacto_emergencia: '',
        telefono_emergencia: '',
        estado_id: '',
        // otros campos...
    });

    useEffect(() => {
        fetchTrabajadores();
        fetchEmpresas();

    }, []);

    const fetchTrabajadores = async () => {
        try {
            const response = await axios.get(`${API_BASE_URL}/trabajadores`);
            setTrabajadores(response.data);
        } catch (error) {
            console.error('Error al obtener la lista de trabajadores:', error);
        }
    };

    const fetchEmpresas = async () => {
      try {
          const response = await axios.get('/api/empresas');
          setEmpresas(response.data);
      } catch (error) {
          console.error('Error al obtener la lista de empresas:', error);
      }
    };

    const handleInputChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            await axios.post(`${API_BASE_URL}/trabajadores`, formData);
            fetchTrabajadores();
            // Limpiar formulario después de crear un trabajador
            setFormData({
              empresa_id: '',
              user_id: '',
              rut: '',
              dv: '',
              apellido_paterno: '',
              apellido_materno: '',
              nombres: '',
              nombre_social: '',
              fecha_nac: '',
              nacionalidad: '',
              cargo_id: '',
              sexo_id: '',
              foto: '',
              direccion: '',
              comuna_id: '',
              telefono: '',
              email: '',
              contacto_emergencia: '',
              telefono_emergencia: '',
              estado_id: '',
            });
        } catch (error) {
            console.error('Error al crear un trabajador:', error);
        }
    };

    const handleDelete = async (id) => {
        try {
            await axios.delete(`${API_BASE_URL}/trabajadores/${id}`);
            fetchTrabajadores();
        } catch (error) {
            console.error('Error al eliminar el trabajador:', error);
        }
    };

    return (
        <div>
            <h3>Trabajadores</h3>
            <form onSubmit={handleSubmit}>
                <select name="empresa_id" value={formData.empresa_id} onChange={handleInputChange}>
                    <option value="">Selecciona una empresa</option>
                    {empresas.map(empresa => (
                        <option key={empresa.id} value={empresa.id}>{empresa.nombre}</option>
                    ))}
                </select>

                <input type="text" name="empresa_id" value={formData.empresa_id} onChange={handleInputChange} />
                <button type="submit">Crear Trabajador</button>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Apellido Paterno</th>
                        {/* Otros encabezados de columna */}
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {trabajadores.map(trabajador => (
                        <tr key={trabajador.id}>
                            <td>{trabajador.id}</td>
                            <td> {trabajador.nombres} {trabajador.apellido_paterno} {trabajador.apellido_paterno}</td>
                            <td> {trabajador.estado_id}</td>
                            {/* Otras celdas de datos */}
                            <td>
                                <button onClick={() => handleDelete(trabajador.id)}>Eliminar</button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}

export default Trabajadores;