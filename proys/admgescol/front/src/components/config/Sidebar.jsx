import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { useDispatch, useSelector } from 'react-redux';
import {
  List, ListItem, ListItemText, ListItemIcon, Divider, Typography, Avatar, Button, Box
} from '@mui/material';
import {
  Business, Description, Group, AccountCircle, Settings, Home, ExitToApp, EventNote, BeachAccess, Receipt, Gavel,
  Folder, People, Person, AdminPanelSettings, LocationCity, Work, Wc, FolderOpen, Assignment, Verified, Mail, MonetizationOn, AttachMoney, 
} from '@mui/icons-material';
import { green } from '@mui/material/colors';
import {
  setEmpresaId
} from '../../actions';

const Sidebar = ({ handleLogout, selectedEmpresa }) => {
  const [role, setRole] = useState(null);
  const navigate = useNavigate();
  const {
    roleSession,
    photoWorker,
    nombre,
    cargo,
  } = useSelector((state) => state);
  const dispatch = useDispatch();

  useEffect(() => {
    if (roleSession) setRole(JSON.parse(roleSession));
    dispatch(setEmpresaId(selectedEmpresa));
  }, [selectedEmpresa, dispatch, roleSession]);

  const defaultPhoto = 'https://www.gravatar.com/avatar/?d=mp';

  const handleOptionChange = (option) => {
    navigate(`/${option}`);
  };

  return (
    <Box
      sx={{
        width: 250,
        bgcolor: green[100],
        height: '100vh',
        padding: 2,
        boxShadow: 2,
        display: 'flex',
        flexDirection: 'column',
        justifyContent: 'space-between',
      }}
    >
      <div>
        <Typography variant="h6" sx={{ color: green[900], mb: 2 }}>Menú</Typography>
        <List>
          {role === 1 && (
            <>
              <Typography variant="subtitle1" sx={{ color: green[800], mb: 1 }}>Funcionalidades</Typography>
              <ListItem button onClick={() => handleOptionChange('Empresas')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <Business sx={{ color: green[700] }} />
                </ListItemIcon>
                <ListItemText primary="Lista de Empresas" />
              </ListItem>
              <ListItem button onClick={() => handleOptionChange('Documentos')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <Description sx={{ color: green[700] }} />
                </ListItemIcon>
                <ListItemText primary="Documentos" />
              </ListItem>
              <ListItem button onClick={() => handleOptionChange('Trabajadores')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <People sx={{ color: green[700] }} />
                </ListItemIcon>
                <ListItemText primary="Trabajadores" />
              </ListItem>
              <ListItem button onClick={() => handleOptionChange('Usuarios')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <Person sx={{ color: green[700] }} />
                </ListItemIcon>
                <ListItemText primary="Usuarios" />
              </ListItem>
              <Divider sx={{ my: 2 }} />
              <Typography variant="subtitle1" sx={{ color: green[800], mb: 1 }}>Mantenedores</Typography>
              <ListItem button onClick={() => handleOptionChange('Roles')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <AdminPanelSettings sx={{ color: green[700] }} />
                </ListItemIcon>
                <ListItemText primary="Roles" />
              </ListItem>
              <ListItem button onClick={() => handleOptionChange('Comunas')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <LocationCity sx={{ color: green[700] }} />
                </ListItemIcon>
                <ListItemText primary="Comunas" />
              </ListItem>
              <ListItem button onClick={() => handleOptionChange('Cargos')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <Work sx={{ color: green[700] }} />
                </ListItemIcon>
                <ListItemText primary="Cargos" />
              </ListItem>
              <ListItem button onClick={() => handleOptionChange('Sexo')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <Wc sx={{ color: green[700] }} />
                </ListItemIcon>
                <ListItemText primary="Sexo" />
              </ListItem>
              <ListItem button onClick={() => handleOptionChange('TipoDocs')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <FolderOpen sx={{ color: green[700] }} />
                </ListItemIcon>
                <ListItemText primary="Tipo Documentos" />
              </ListItem>
              <ListItem button onClick={() => handleOptionChange('TipoSol')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <Assignment sx={{ color: green[700] }} />
                </ListItemIcon>
                <ListItemText primary="Tipo Solicitudes" />
              </ListItem>
              <ListItem button onClick={() => handleOptionChange('EstadoSol')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <Verified sx={{ color: green[700] }} />
                </ListItemIcon>
                <ListItemText primary="Estados Solicitudes" />
              </ListItem>
            </>
            
          )}
          {role === 2 && (
            <>
              <Typography variant="subtitle1" sx={{ color: green[800], mb: 1 }}>Funcionalidades</Typography>
              <ListItem button onClick={() => handleOptionChange('Empresas/' + selectedEmpresa)}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <Business sx={{ color: green[700] }} />
                </ListItemIcon>
                <ListItemText primary="Empresa" />
              </ListItem>
              <ListItem button onClick={() => handleOptionChange('Documentos')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <Description sx={{ color: green[700] }} />
                </ListItemIcon>
                <ListItemText primary="Documentos" />
              </ListItem>
              <ListItem button onClick={() => handleOptionChange('Trabajadores')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <Group sx={{ color: green[700] }} />
                </ListItemIcon>
                <ListItemText primary="Trabajadores" />
              </ListItem>
            </>
          )}
          {(role === 3) && (
            <>
            {/* Sección de Consultar Documentos */}
            <Typography variant="subtitle1" sx={{ color: green[800], mb: 1 }}>Consultar Documentos</Typography>
              <ListItem button onClick={() => handleOptionChange('ContratosUser')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <Description sx={{ color: green[700] }} />
                </ListItemIcon>
                <ListItemText primary="Contratos y Anexos" />
              </ListItem>
              <ListItem button onClick={() => handleOptionChange('LiquidacionesUser')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <Receipt sx={{ color: green[700] }} />
                </ListItemIcon>
                <ListItemText primary="Liquidaciones" />
              </ListItem>
              <ListItem button onClick={() => handleOptionChange('ReglamentosUser')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <Gavel sx={{ color: green[700] }} />
                </ListItemIcon>
                <ListItemText primary="Reglamentos" />
              </ListItem>
              <ListItem button onClick={() => handleOptionChange('OtrosUser')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <FolderOpen sx={{ color: green[700] }} />
                </ListItemIcon>
                <ListItemText primary="Otros" />
              </ListItem>
            
              <Divider sx={{ my: 2 }} />
            
              {/* Sección de Realizar Solicitudes */}
              <Typography variant="subtitle1" sx={{ color: green[800], mb: 1 }}>Realizar Solicitudes</Typography>
              <ListItem button onClick={() => handleOptionChange('SolicitarAnticipo')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <MonetizationOn sx={{ color: green[700] }} />
                </ListItemIcon>
                <ListItemText primary="Solicitar Anticipo" />
              </ListItem>
              <ListItem button onClick={() => handleOptionChange('SolicitarPrestamo')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <AttachMoney sx={{ color: green[700] }} />
                </ListItemIcon>
                <ListItemText primary="Solicitar Préstamo" />
              </ListItem>
              <ListItem button onClick={() => handleOptionChange('SolicitarPermiso')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <EventNote sx={{ color: green[700] }} />
                </ListItemIcon>
                <ListItemText primary="Solicitar Permiso" />
              </ListItem>
              <ListItem button onClick={() => handleOptionChange('SolicitarVacaciones')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <BeachAccess sx={{ color: green[700] }} />
                </ListItemIcon>
                <ListItemText primary="Solicitar Vacaciones" />
              </ListItem>
            
              <Divider sx={{ my: 2 }} />
            
              {/* Sección de Comunicaciones */}
              <Typography variant="subtitle1" sx={{ color: green[800], mb: 1 }}>Comunicaciones</Typography>
              <ListItem button onClick={() => handleOptionChange('ComunicacionesUsers')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <Mail sx={{ color: green[700] }} />
                </ListItemIcon>
                <ListItemText primary="Comunicaciones" />
              </ListItem>
            </>
            
          )}
        </List>
      </div>
      {/* <Button
        variant="contained"
        color="secondary"
        onClick={handleLogout}
        sx={{ bgcolor: green[700], '&:hover': { bgcolor: green[900] } }}
        startIcon={<ExitToApp />}
      >
        Cerrar Sesión
      </Button> */}
    </Box>
  );
};

export default Sidebar;
