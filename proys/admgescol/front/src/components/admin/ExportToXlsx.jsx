import React, { useState, useEffect } from 'react';
import { useSelector } from 'react-redux';
import { useNavigate } from 'react-router-dom';
import axios from 'axios'; // Importa axios
import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here
import { Button, TextField, FormControl, InputLabel, Select, MenuItem, Card, CardContent, Typography } from '@mui/material';
import * as XLSX from 'xlsx';

const ExportToXlsx = ({ exportData }) => {
    const [exportType, setExportType] = useState('');
    const [startDate, setStartDate] = useState('');
    const [endDate, setEndDate] = useState('');
    const [status, setStatus] = useState('');
    const [trabajadores, setTrabajadores] = useState([]);
    const [statuses, setStatuses] = useState([]);
    const [empresas, setEmpresas] = useState([]);
    const token = useSelector((state) => state.token);

    useEffect(() => {
        const fetchSolicitudes = async () => {
            // Fetch trabajadores data
            try {
                const trabajadoresResponse = await axios.get(`${API_BASE_URL}/trabajadores/all/${token}`); // Replace with your API endpoint
                setTrabajadores(trabajadoresResponse.data);
                const statusResponse = await axios.get(`${API_BASE_URL}/estadoSol/all/${token}`); // Replace with your API endpoint
                setStatuses(statusResponse.data);
                
                } catch (error) {
                console.error('Error fetching trabajadores:', error);
                }
                        
            try {
                const response = await axios.get(`${API_BASE_URL}/empresas/all/${token}`); // Replace with your API endpoint
                setEmpresas(response.data);
                } catch (error) {
                console.error('Error fetching Empresas:', error);
                }
        };
        fetchSolicitudes();
    }, []);     

    const handleExport = () => {
        // Filter data based on exportType, startDate, endDate, and status
        let filteredData = exportData;

        if(exportType === "anticipos") filteredData = filteredData.anticipos
        if(exportType === "prestamos") filteredData = filteredData.prestamos
        if(exportType === "permisos") filteredData = filteredData.permisos
        if(exportType === "beneficios") filteredData = filteredData.beneficios

        if (startDate) {
        filteredData = filteredData.filter(item => new Date(item.fecha) >= new Date(startDate));
        }
        if (endDate) {
        filteredData = filteredData.filter(item => new Date(item.fecha) <= new Date(endDate));
        }
        if (status) {
        filteredData = filteredData.filter(item => item.status === status);
        }
    
        // Map over filteredData to replace fields with names
        filteredData = filteredData.map(item => ({
            ...item,
            tipo_sol_id: exportType,
            empresa_id: getEmpresaNombre(item.empresa_id),
            trabajador: getTrabajadorNombre(item.trabajador),
            status: getStatusNombre(item.status)
        }));
        
        // Create a new workbook and worksheet
        const ws = XLSX.utils.json_to_sheet(filteredData);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Solicitudes');

        // Write the workbook to file
        XLSX.writeFile(wb, 'Solicitudes.xlsx');
    };

    const getTrabajadorNombre = (rut) => {
        const trabajador = trabajadores.find(t => t.rut === rut);
        return trabajador ? `${trabajador.apellido_paterno} ${trabajador.apellido_materno}, ${trabajador.nombres} ` : 'Desconocido';
    };

    const getStatusNombre = (id) => {
        const status = statuses.find(t => t.id === id);
        return status ? `${status.nombre}` : 'Desconocido';
    };
    const getEmpresaNombre = (id) => {
        const empresa = empresas.find(t => t.id === id);
        return empresa ? `${empresa.RazonSocial}` : 'Desconocido';
    };
    
  return (
    <div>
        <Card sx={{ maxWidth: 600, margin: 'auto', padding: 2 }}>
            <CardContent>
                <Typography variant="h5" gutterBottom>
                    Exportar a XLSX
                </Typography>
                <FormControl fullWidth sx={{ mb: 2 }}>
                    <InputLabel id="export-type-label">Tipo de Solicitud</InputLabel>
                    <Select
                    labelId="export-type-label"
                    value={exportType}
                    onChange={(e) => setExportType(e.target.value)}
                    label="Tipo de Solicitud"
                        sx={{ color: 'black',  mb: 2  }}
                        InputLabelProps={{ 
                            style: { color: 'black' }  // Set label color
                        }}
                        InputProps={{ 
                            style: { color: 'black' }  // Set input text color
                        }}
                    >
                    <MenuItem value="anticipos">Anticipos</MenuItem>
                    <MenuItem value="beneficios">Beneficios</MenuItem>
                    <MenuItem value="permisos">Permisos</MenuItem>
                    <MenuItem value="prestamos">Préstamos</MenuItem>
                    </Select>
                </FormControl>
                <TextField
                    label="Desde"
                    type="date"
                    InputLabelProps={{ shrink: true }}
                    fullWidth
                    value={startDate}
                    onChange={(e) => setStartDate(e.target.value)}
                    sx={{ color: 'black',  mb: 2  }}
                    InputLabelProps={{ 
                    style: { color: 'black' }  // Set label color
                    }}
                    InputProps={{ 
                    style: { color: 'black' }  // Set input text color
                    }}
                    
                />
                <TextField
                    label="Hasta"
                    type="date"
                    InputLabelProps={{ shrink: true }}
                    fullWidth
                    value={endDate}
                    onChange={(e) => setEndDate(e.target.value)}
                    sx={{ color: 'black',  mb: 2  }}
                    InputLabelProps={{ 
                    style: { color: 'black' }  // Set label color
                    }}
                    InputProps={{ 
                    style: { color: 'black' }  // Set input text color
                    }}
                />
                <FormControl fullWidth sx={{ mb: 2 }}>
                    <InputLabel id="status-label">Estado de Solicitud</InputLabel>
                    <Select
                    labelId="status-label"
                    value={status}
                    onChange={(e) => setStatus(e.target.value)}
                    label="Estado de Solicitud"
                    sx={{ color: 'black',  mb: 2  }}
                    InputLabelProps={{ 
                        style: { color: 'black' }  // Set label color
                    }}
                    InputProps={{ 
                        style: { color: 'black' }  // Set input text color
                    }}
                    >
                    <MenuItem value="1">Pendiente</MenuItem>
                    <MenuItem value="2">Aprobada</MenuItem>
                    <MenuItem value="3">Rechazada</MenuItem>
                    </Select>
                </FormControl>
                <Button variant="contained" color="info" onClick={handleExport} fullWidth>
                    Exportar a XLSX
                </Button>
            </CardContent>
        </Card>
    </div>
  );
};

export { ExportToXlsx };
