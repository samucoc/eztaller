import React, { useState } from 'react';
import {
  Card, CardContent, Typography, Grid, TextField, Button, FormControlLabel, Checkbox
} from '@mui/material';
import ReactQuill from 'react-quill';
import 'react-quill/dist/quill.snow.css'; // Importar estilo de ReactQuill
import Swal from 'sweetalert2';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';
import { useSelector } from 'react-redux';
import { API_BASE_URL, API_DOWNLOAD_URL } from '../config/apiConstants'; // Assuming API_BASE_URL is defined here

const LeyKarinModel = () => {
  const navigate = useNavigate();
  const userDNI = useSelector((state) => state.userDNI);
  const username = useSelector((state) => state.username); // Asumiendo que el nombre de usuario está en Redux
  const nombre = useSelector((state) => state.nombre);

  const [denunciante, setDenunciante] = useState({
    nombre: nombre,
    rut: userDNI,
    email: username,
    anonimato: false,
    denuncia: '',
    victimaOtestigo: '',
    check: '',
  });

  const [implicados, setImplicados] = useState([
    {
      nombre: '',
      apellidos: '',
      lugar: '',
      cargo: ''
    }
  ]);

  const [selectedFilesKarin, setSelectedFilesKarin] = useState([]);
  const [openKarin, setOpenKarin] = useState(false);

  const handleChangeDenuncianteKarin = (e) => {
    const { name, value } = e.target;
    setDenunciante({ ...denunciante, [name]: value });
  };

  const handleChangeDenunciaKarin = (value) => {
    // Update the state with the new value for the "denuncia"
    setDenunciante({ ...denunciante, denuncia: value });
  };

  const addImplicado = () => {
    setImplicados([
      ...implicados,
      { nombre: '', apellidos: '', lugar: '', cargo: '', denuncia: '', archivo: [] }
    ]);
  };

  const removeImplicado = (index) => {
    const updatedImplicados = [...implicados];
    updatedImplicados.splice(index, 1);
    setImplicados(updatedImplicados);
  };

  const handleChangeImplicadoKarin = (index, e) => {
    const { name, value } = e.target;
    const updatedImplicados = [...implicados];
    updatedImplicados[index] = { ...updatedImplicados[index], [name]: value };
    setImplicados(updatedImplicados);
  };

  const handleChangeImplicadoDenunciaKarin = (index, value) => {
    const updatedImplicados = [...implicados];
    updatedImplicados[index] = { ...updatedImplicados[index], denuncia: value };
    setImplicados(updatedImplicados);
  };

  const handleFileChangeKarin = (e) => {
    const selectedFiles = Array.from(e.target.files);
    setSelectedFilesKarin(selectedFiles);
  };

  const validateRut = (rut) => {
    rut = rut.replace(/[.-]/g, '');
    if (rut.length < 8 || rut.length > 9) return false;

    const body = rut.slice(0, -1);
    let dv = rut.slice(-1).toUpperCase();

    let suma = 0;
    let multiplicador = 2;

    for (let i = body.length - 1; i >= 0; i--) {
      suma += multiplicador * body[i];
      multiplicador = multiplicador === 7 ? 2 : multiplicador + 1;
    }

    let expectedDv = 11 - (suma % 11);
    expectedDv = expectedDv === 11 ? '0' : expectedDv === 10 ? 'K' : expectedDv.toString();

    return dv === expectedDv;
  };

  const handleSubmitKarin = async (e) => {
    e.preventDefault();

    if (
      !denunciante.nombre ||
      !denunciante.rut ||
      !denunciante.email ||
      !denunciante.denuncia
    ) {
      Swal.fire({
        icon: 'error',
        title: 'Campos incompletos',
        text: 'Todos los campos del denunciante son obligatorios.',
        confirmButtonText: 'OK',
        customClass: { container: 'swal-container' }
      });
      return;
    }

    
    if (
      !denunciante.check 
    ) {
      Swal.fire({
        icon: 'error',
        title: 'Campos incompletos',
        text: 'Acepte los términos y condiciones establecidos.',
        confirmButtonText: 'OK',
        customClass: { container: 'swal-container' }
      });
      return;
    }

    if (implicados.length === 0) {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Debe ingresar al menos un implicado.',
        confirmButtonText: 'OK',
        customClass: { container: 'swal-container' }
      });
      return;
    }

    const formData = new FormData();
    formData.append('denuncianteNombre', denunciante.nombre);
    formData.append('denuncianteRut', denunciante.rut);
    formData.append('denuncianteEmail', denunciante.email);
    formData.append('denuncianteAnonimato', denunciante.anonimato);
    formData.append('denuncia', denunciante.denuncia);

    implicados.forEach((implicado, index) => {
      formData.append(`implicados[${index}][nombre]`, implicado.nombre);
      formData.append(`implicados[${index}][cargo]`, implicado.cargo);
    });

    selectedFilesKarin.forEach((file, index) => {
      formData.append(`archivos[${index}]`, file);
    });

    try {
      const response = await axios.post(`${API_BASE_URL}/denuncias-karin`, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      });

      Swal.fire({
        icon: 'success',
        title: 'Denuncia enviada',
        text: 'Tu denuncia ha sido enviada con éxito.',
        confirmButtonText: 'OK',
        customClass: { container: 'swal-container' }
      });
      setOpenKarin(false);
      navigate('/UserDashboard');
    } catch (error) {
      console.error('Error al enviar la denuncia:', error);
      Swal.fire({
        icon: 'error',
        title: 'Error al enviar denuncia',
        text: 'Hubo un problema al enviar tu denuncia. Por favor, intenta nuevamente.',
        confirmButtonText: 'OK',
        customClass: { container: 'swal-container' }
      });
      setOpenKarin(false);
      navigate('/UserDashboard');
    }
  };

  const handleCancelKarin = () => {
    setDenunciante({
      nombre: '',
      apellidos: '',
      rut: '',
      celular: '',
      email: '',
      confirmarEmail: '',
      relacionTrabajo: '',
      lugarDenuncia: '',
      anonimato: false
    });
    setImplicados([{ nombre: '', apellidos: '', lugar: '', cargo: '', denuncia: '', archivo: [] }]);
  };

  return (
      <Card>
        <CardContent>
          <Typography variant="h4" gutterBottom>
            Formulario de Denuncia Ley Karin
          </Typography>
          <Card sx={{ backgroundColor: '#E0E0E0'}}>
            <CardContent>
              <Typography variant="h6">Ley Karin: Protegiendo a las Víctimas de Acoso</Typography>
              <Typography>La Ley Karin, creada para proteger a quienes han sido víctimas de acoso, establece mecanismos claros y seguros para denunciar cualquier tipo de comportamiento inapropiado en el ámbito escolar o laboral. Esta ley garantiza un proceso confidencial y justo, asegurando que todas las denuncias sean atendidas y que las personas afectadas reciban el apoyo necesario.</Typography>
            </CardContent>
          </Card>
          <form onSubmit={handleSubmitKarin}>
            <Card sx={{ background: '#E0F2F1', mt: 2 }}>
              <CardContent>
                <FormControlLabel
                  control={
                    <Checkbox
                      name="anonimato"
                      checked={denunciante.anonimato}
                      onChange={handleChangeDenuncianteKarin}
                    />
                  }
                  label={<Typography variant="h6">Deseo mantener esta denuncia de forma anónima</Typography>}
                />
                <Typography variant="body2">De lo contrario, aparecerán tus datos de identificación en el documento.</Typography>
              </CardContent>
            </Card>
            <Grid container spacing={2} sx={{ mt: 2 }}>
              <Grid item xs={12} sm={6}>
                <Typography variant="h6">¿Eres?</Typography>
                <FormControlLabel
                  control={
                    <Checkbox
                      checked={denunciante.victima}
                      onChange={() => setDenunciante({ ...denunciante, victimaOtestigo: 'victima' })}
                    />
                  }
                  label="Víctima"
                />
                <FormControlLabel
                  control={
                    <Checkbox
                      checked={denunciante.testigo}
                      onChange={() => setDenunciante({ ...denunciante, victimaOtestigo: 'testigo' })}
                    />
                  }
                  label="Testigo"
                />
              </Grid>
              <Grid item xs={12} sm={6}>
                <Typography variant="h6">¿Donde se realizó el incidente?</Typography>

                <TextField
                  variant="outlined"
                  fullWidth
                  id="lugarDenuncia"
                  label="Lugar de la denuncia"
                  name="lugarDenuncia"
                  value={denunciante.lugarDenuncia}
                  onChange={handleChangeDenuncianteKarin}
                />
              </Grid>
            </Grid>
          
            <Typography variant="h6" gutterBottom sx={{ mt: 2 }}>
              Identificación de los implicados (Agresor)
            </Typography>
            <Grid container spacing={2} sx={{ mt: 2 }}>
              {Array.isArray(implicados) && implicados.map((implicado, index) => (
                <React.Fragment key={index}>
                  <Grid item xs={12} sm={5}>
                    <TextField
                      variant="outlined"
                      fullWidth
                      id={`nombreImplicado-${index}`}
                      label="Nombre del Implicado"
                      name="nombre"
                      value={implicado.nombre}
                      onChange={(e) => handleChangeImplicadoKarin(index, e)}
                      sx={{ color: 'black' }}
                      InputLabelProps={{ 
                        style: { color: 'black' }  // Set label color
                      }}
                      InputProps={{ 
                        style: { color: 'black' }  // Set input text color
                      }}
                    />
                  </Grid>
                  <Grid item xs={12} sm={5}>
                    <TextField
                      variant="outlined"
                      fullWidth
                      id={`cargoImplicado-${index}`}
                      label="Cargo del Implicado"
                      name="cargo"
                      value={implicado.cargo}
                      onChange={(e) => handleChangeImplicadoKarin(index, e)}
                      sx={{ color: 'black' }}
                      InputLabelProps={{ 
                        style: { color: 'black' }  // Set label color
                      }}
                      InputProps={{ 
                        style: { color: 'black' }  // Set input text color
                      }}
                    />
                  </Grid>
                  <Grid item xs={2}>
                    <Button
                      variant="outlined"
                      color="secondary"
                      onClick={() => removeImplicado(index)}
                      fullWidth
                    >
                      Eliminar Implicado
                    </Button>
                  </Grid>
                </React.Fragment>
              ))}
              <Grid item xs={12}>
                <Button
                  variant="contained"
                  color="primary"
                  onClick={addImplicado}
                  fullWidth
                >
                  Agregar Implicado
                </Button>
              </Grid>
            </Grid>

            <Typography variant="h6" gutterBottom sx={{ mt: 2 }}>
              Detalle de denuncia
            </Typography>
            <Grid container spacing={2} sx={{ mt: 2 }}>
              <Grid item xs={12}>
                <ReactQuill 
                  id='denuncia'
                  theme="snow" 
                  value={denunciante.denuncia}
                  onChange={handleChangeDenunciaKarin}
                  placeholder="Escribe la descripción aquí..." 
                  style={{ height: '250px', overflow: 'auto' }} // Set a specific height and allow overflow
                  sx={{ color: 'black' }}
                /> 
              </Grid>
              <Grid item xs={12} sx={{ mt: 2 }}> {/* Added margin top */}
                <Button variant="contained" component="label" fullWidth>
                  Adjuntar Archivos
                  <input
                    type="file"
                    hidden
                    onChange={(e) => handleFileChangeKarin(e)}
                    multiple
                  />
                </Button>
              </Grid>
            </Grid>

            <Card sx={{ backgroundColor: '#E0E0E0', padding: 2 }}>
              <CardContent>
              <Typography
                variant="h6"
                sx={{
                  textAlign: 'center',
                  marginBottom: 2, // Add some spacing below the title
                }}
              >
                Aviso de Responsabilidad
              </Typography>
              <Typography
                sx={{
                  textAlign: 'justify', // Justify the text
                  marginBottom: 2, // Add some spacing between paragraphs
                  marginX: '20%',   // Center text with 20% margin on left and right
                }}
              >
                La información proporcionada en este formulario será tratada de manera estrictamente confidencial. Solo el personal autorizado tendrá acceso a los datos, con el objetivo de investigar y tomar las medidas necesarias para proteger a quienes han sido afectados. Al completar este formulario, aceptas que la información será utilizada para realizar las investigaciones correspondientes según lo establecido por la Ley Karin.
              </Typography>
              <Typography
                sx={{
                  textAlign: 'justify', // Justify the text
                  marginBottom: 2,
                  marginX: '20%',
                }}
              >
                Es importante recordar que la información entregada debe ser veraz y precisa. Proporcionar información falsa o engañosa puede perjudicar la investigación y tener consecuencias legales. Si deseas mantener el anonimato, te recordamos que es posible presentar la denuncia de forma anónima.
              </Typography>

                <FormControlLabel
                  sx={{
                    textAlign: 'justify', // Justify the text
                    marginBottom: 2,
                    marginX: '20%',
                  }}
                  control={
                    <Checkbox
                      name="check"
                      checked={denunciante.check}
                      onChange={handleChangeDenuncianteKarin}
                    />
                  }
                  label='Al enviar este formulario, aceptas los términos y condiciones establecidos en este aviso de responsabilidad, comprometiéndote a proporcionar información verdadera y a colaborar con el proceso de investigación.'
                />
              </CardContent>
            </Card>


            <Grid container spacing={2} sx={{ mt: 2 }}>
              <Grid item xs={12}>
                <Button type="submit" fullWidth variant="contained" color="primary">
                  Enviar Denuncia
                </Button>
              </Grid>
            </Grid>
          </form>
        </CardContent>
      </Card>
  );
};

export default LeyKarinModel;
