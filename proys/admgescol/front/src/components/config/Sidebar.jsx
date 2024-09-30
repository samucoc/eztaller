import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { useDispatch, useSelector } from 'react-redux';
import {
  List, ListItem, ListItemText, ListItemIcon, Divider, Typography, Avatar, Button, Box, IconButton, Collapse, 
} from '@mui/material';
import {
  Business, Description, Group, AccountCircle, Settings, Home, ExitToApp, EventNote, BeachAccess, Receipt, Gavel, 
  Folder, People, Person, AdminPanelSettings, LocationCity, Work, Wc, FolderOpen, Assignment, Verified, Mail, ExpandLess, 
  MonetizationOn, AttachMoney, ExpandMore,  
} from '@mui/icons-material';
import { green } from '@mui/material/colors';
import { grey } from '@mui/material/colors';

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

  const [openSA, setOpenSA] = useState(false);

  const handleToggleSA = () => {
    setOpenSA(!openSA);
  };


  const [openA, setOpenA] = useState(false);

  const handleToggleA = () => {
    setOpenA(!openA);
  };

  const [openU, setOpenU] = useState(false);

  const handleToggleU = () => {
    setOpenU(!openU);
  };

  const [openUS, setOpenUS] = useState(false);

  const handleToggleUS = () => {
    setOpenUS(!openUS);
  };


  return (
    <Box
      sx={{
        width: 250,
        bgcolor: '#E0F2F1',
        height: '100vh',
        padding: 2,
        boxShadow: 2,
        display: 'flex',
        flexDirection: 'column',
        justifyContent: 'space-between',
      }}
    >
      <div>
        <Typography variant="h6" sx={{ color: grey[900], mb: 2 }}>Menú</Typography>
        <List>
          {role === 1 && (
            <>
              <ListItem button onClick={() => handleOptionChange('Empresas')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <Business sx={{ color: grey[700] }} />
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
                  <Description sx={{ color: grey[700] }} />
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
                  <People sx={{ color: grey[700] }} />
                </ListItemIcon>
                <ListItemText primary="Trabajadores" />
              </ListItem>
              <ListItem button onClick={() => handleOptionChange('LeyKarin')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <Gavel sx={{ color: grey[700] }} />
                </ListItemIcon>
                <ListItemText primary="Ley Karin" />
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
                  <Person sx={{ color: grey[700] }} />
                </ListItemIcon>
                <ListItemText primary="Usuarios" />
              </ListItem>
              <Divider sx={{ my: 2 }} />
              <ListItem
                button
                onClick={handleToggleSA}
                sx={{ padding: 0, margin: 0 }}
              >
                <ListItemText>
                  <Typography variant="subtitle1" sx={{ color: grey[800], mb: 1 }}>Mantenedores</Typography>
                </ListItemText>
                <IconButton>
                  {openSA ? <ExpandLess sx={{ color: grey[800] }} /> : <ExpandMore sx={{ color: grey[800] }} />}
                </IconButton>
              </ListItem>

              <Collapse in={openSA} timeout="auto" unmountOnExit>
                <ListItem button onClick={() => handleOptionChange('Roles')} sx={{ padding: 0, margin: 0 }}>
                  <ListItemIcon>
                    <AdminPanelSettings sx={{ color: grey[700] }} />
                  </ListItemIcon>
                  <ListItemText primary="Roles" />
                </ListItem>
                <ListItem button onClick={() => handleOptionChange('Comunas')} sx={{ padding: 0, margin: 0 }}>
                  <ListItemIcon>
                    <LocationCity sx={{ color: grey[700] }} />
                  </ListItemIcon>
                  <ListItemText primary="Comunas" />
                </ListItem>
                <ListItem button onClick={() => handleOptionChange('Cargos')} sx={{ padding: 0, margin: 0 }}>
                  <ListItemIcon>
                    <Work sx={{ color: grey[700] }} />
                  </ListItemIcon>
                  <ListItemText primary="Cargos" />
                </ListItem>
                <ListItem button onClick={() => handleOptionChange('Sexo')} sx={{ padding: 0, margin: 0 }}>
                  <ListItemIcon>
                    <Wc sx={{ color: grey[700] }} />
                  </ListItemIcon>
                  <ListItemText primary="Sexo" />
                </ListItem>
                <ListItem button onClick={() => handleOptionChange('TipoDocs')} sx={{ padding: 0, margin: 0 }}>
                  <ListItemIcon>
                    <FolderOpen sx={{ color: grey[700] }} />
                  </ListItemIcon>
                  <ListItemText primary="Tipo Documentos" />
                </ListItem>
                <ListItem button onClick={() => handleOptionChange('TipoSol')} sx={{ padding: 0, margin: 0 }}>
                  <ListItemIcon>
                    <Assignment sx={{ color: grey[700] }} />
                  </ListItemIcon>
                  <ListItemText primary="Tipo Solicitudes" />
                </ListItem>
                <ListItem button onClick={() => handleOptionChange('EstadoSol')} sx={{ padding: 0, margin: 0 }}>
                  <ListItemIcon>
                    <Verified sx={{ color: grey[700] }} />
                  </ListItemIcon>
                  <ListItemText primary="Estados Solicitudes" />
                </ListItem>
              </Collapse>
            </>
            
          )}
          {role === 2 && (
            <>
              <ListItem button onClick={() => handleOptionChange('Empresas/' + selectedEmpresa)}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <Business sx={{ color: grey[700] }} />
                </ListItemIcon>
                <ListItemText primary="Inicio" />
              </ListItem>
              <ListItem
                button
                onClick={handleToggleA}
                sx={{
                  padding: 0,
                  margin: 0,
                  '&.Mui-selected': {
                    backgroundColor: 'transparent',
                  },
                }}>
                <ListItemIcon>
                  <Description sx={{ color: grey[700] }} />
                </ListItemIcon>
                <ListItemText primary="Documentos" />
                <IconButton>
                  {openA ? <ExpandLess sx={{ color: grey[800] }} /> : <ExpandMore sx={{ color: grey[800] }} />}
                </IconButton>
              </ListItem>
              <Collapse in={openA} timeout="auto" unmountOnExit>
                <ListItem button onClick={() => handleOptionChange('DocumentosCard')} sx={{ padding: 0, margin: 0 }}>
                  <ListItemIcon>
                    <Description sx={{ color: grey[700] }} />
                  </ListItemIcon>
                  <ListItemText primary="Cargar Documentos" />
                </ListItem>
                <ListItem button onClick={() => handleOptionChange('Documentos')} sx={{ padding: 0, margin: 0 }}>
                  <ListItemIcon>
                    <Description sx={{ color: grey[700] }} />
                  </ListItemIcon>
                  <ListItemText primary="Consultar Documentos" />
                </ListItem>
              </Collapse>

              <ListItem button onClick={() => handleOptionChange('SolicitudesCard')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <Description sx={{ color: grey[700] }} />
                </ListItemIcon>
                <ListItemText primary="Solicitudes" />
              </ListItem>
              
              <ListItem button onClick={() => handleOptionChange('ComunicacionesCard')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <Description sx={{ color: grey[700] }} />
                </ListItemIcon>
                <ListItemText primary="Comunicaciones" />
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
                  <Group sx={{ color: grey[700] }} />
                </ListItemIcon>
                <ListItemText primary="Trabajadores" />
              </ListItem>
              <ListItem button onClick={() => handleOptionChange('LeyKarin')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <Gavel sx={{ color: grey[700] }} />
                </ListItemIcon>
                <ListItemText primary="Ley Karin" />
              </ListItem>
            </>
          )}
          {(role === 3) && (
            <>
            {/* Sección de Consultar Documentos */}
              <ListItem button onClick={() => handleOptionChange('UserDashboard')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <Business sx={{ color: grey[700] }} />
                </ListItemIcon>
                <ListItemText primary="Inicio" />
              </ListItem>

              <ListItem
                button
                onClick={handleToggleU}
                sx={{ padding: 0, margin: 0 }}
              >
                <ListItemText>
                  <Typography variant="subtitle1" sx={{ color: grey[800], mb: 1 }}>Documentos</Typography>
                </ListItemText>
                <IconButton>
                  {openU ? <ExpandLess sx={{ color: grey[800] }} /> : <ExpandMore sx={{ color: grey[800] }} />}
                </IconButton>
              </ListItem>

              <Collapse in={openU} timeout="auto" unmountOnExit>

                <ListItem button onClick={() => handleOptionChange('LiquidacionesUser')}
                    sx={{
                      padding: 0,
                      margin: 0,
                      '&.Mui-selected': {
                        backgroundColor: 'transparent',
                      },
                    }}>
                  <ListItemIcon>
                    <Receipt sx={{ color: grey[700] }} />
                  </ListItemIcon>
                  <ListItemText primary="Consultar Liquidaciones" />
                </ListItem>
                <ListItem button onClick={() => handleOptionChange('ContratosUser')}
                    sx={{
                      padding: 0,
                      margin: 0,
                      '&.Mui-selected': {
                        backgroundColor: 'transparent',
                      },
                    }}>
                  <ListItemIcon>
                    <Description sx={{ color: grey[700] }} />
                  </ListItemIcon>
                  <ListItemText primary="Consultar Contratos y Anexos" />
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
                    <Gavel sx={{ color: grey[700] }} />
                  </ListItemIcon>
                  <ListItemText primary="Consultar Reglamentos" />
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
                    <FolderOpen sx={{ color: grey[700] }} />
                  </ListItemIcon>
                  <ListItemText primary="Consultar Otros Documentos" />
                </ListItem>
              </Collapse>
             
            
            
              {/* Sección de Realizar Solicitudes */}
              <ListItem
                button
                onClick={handleToggleUS}
                sx={{ padding: 0, margin: 0 }}
              >
                <ListItemText>
                  <Typography variant="subtitle1" sx={{ color: grey[800], mb: 1 }}>Solicitudes</Typography>
                </ListItemText>
                <IconButton>
                  {openUS ? <ExpandLess sx={{ color: grey[800] }} /> : <ExpandMore sx={{ color: grey[800] }} />}
                </IconButton>
              </ListItem>
              <Collapse in={openUS} timeout="auto" unmountOnExit>
                <ListItem button onClick={() => handleOptionChange('SolicitarAnticipo')}
                    sx={{
                      padding: 0,
                      margin: 0,
                      '&.Mui-selected': {
                        backgroundColor: 'transparent',
                      },
                    }}>
                  <ListItemIcon>
                    <MonetizationOn sx={{ color: grey[700] }} />
                  </ListItemIcon>
                  <ListItemText primary="Anticipo" />
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
                    <AttachMoney sx={{ color: grey[700] }} />
                  </ListItemIcon>
                  <ListItemText primary="Préstamo" />
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
                    <EventNote sx={{ color: grey[700] }} />
                  </ListItemIcon>
                  <ListItemText primary="Permiso" />
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
                    <BeachAccess sx={{ color: grey[700] }} />
                  </ListItemIcon>
                  <ListItemText primary="Beneficios" />
                </ListItem>
              </Collapse>

              {/* Sección de Comunicaciones */}
              <ListItem button onClick={() => handleOptionChange('ComunicacionesUsers')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <Mail sx={{ color: grey[700] }} />
                </ListItemIcon>
                <ListItemText primary="Comunicaciones" />
              </ListItem>
              <ListItem button onClick={() => handleOptionChange('LeyKarinModel')}
                  sx={{
                    padding: 0,
                    margin: 0,
                    '&.Mui-selected': {
                      backgroundColor: 'transparent',
                    },
                  }}>
                <ListItemIcon>
                  <Gavel sx={{ color: grey[700] }} />
                </ListItemIcon>
                <ListItemText primary="Ley Karin" />
              </ListItem>
            </>
            
          )}
        </List>
      </div>
      {/* <Button
        variant="contained"
        color="secondary"
        onClick={handleLogout}
        sx={{ bgcolor: grey[700], '&:hover': { bgcolor: grey[900] } }}
        startIcon={<ExitToApp />}
      >
        Cerrar Sesión
      </Button> */}
    </Box>
  );
};

export default Sidebar;
