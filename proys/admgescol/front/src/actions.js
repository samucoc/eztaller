// src/actions.js

export const setLoggedIn = (loggedIn) => ({
    type: 'SET_LOGGED_IN',
    payload: loggedIn,
  });
  
  export const setUserDNI = (userDNI) => ({
    type: 'SET_USER_DNI',
    payload: userDNI,
  });
  
  export const setEmpresaId = (empresaId) => ({
    type: 'SET_EMPRESA_ID',
    payload: empresaId,
  });
  
  export const setEmpresas = (empresas) => ({
    type: 'SET_EMPRESAS',
    payload: empresas,
  });
  
  export const setCurrentOption = (option) => ({
    type: 'SET_CURRENT_OPTION',
    payload: option,
  });
  
  export const setRoleSession = (roleSession) => ({
    type: 'SET_ROLE_SESSION',
    payload: roleSession,
  });
  
  export const setShowDashTrab = (showDashTrab) => ({
    type: 'SET_SHOW_DASH_TRAB',
    payload: showDashTrab,
  });
  
  export const setUsername = (username) => ({
    type: 'SET_USERNAME',
    payload: username,
  });
  
  export const setPassword = (password) => ({
    type: 'SET_PASSWORD',
    payload: password,
  });
  
  export const setUserSession = (userSession) => ({
    type: 'SET_USER_SESSION',
    payload: userSession,
  });
  
  export const setPhotoWorker = (photoWorker) => ({
    type: 'SET_PHOTO_WORKER',
    payload: photoWorker,
  });
  
  export const setCargo = (cargo) => ({
    type: 'SET_CARGO',
    payload: cargo,
  });
  
  export const setNombre = (nombre) => ({
    type: 'SET_NOMBRE',
    payload: nombre,
  });
  
  export const setNotificaciones = (notificaciones) => ({
    type: 'SET_NOTIFICACIONES',
    payload: notificaciones,
  });
  
  export const setNotificacionesVistas = () => ({
    type: 'SET_NOTIFICACIONES_VISTAS',
  });