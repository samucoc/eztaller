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
  
