// src/reducers.js

const initialState = {
  loggedIn: false,
  userDNI: '',
  empresaId: '',
  empresas: [],
  currentOption: '',
  roleSession: '',
  showDashTrab: true,
  username: '',
  password: '',
  userSession: '',
  photoWorker: '',
  cargo: '',
  nombre: '',
  notificaciones: [],
  notificacionesNoVistas: 0, // Contador de no vistas
};

const rootReducer = (state = initialState, action) => {
  switch (action.type) {
    case 'SET_NOTIFICACIONES':
      return {
        ...state,
        notificaciones: action.payload,
        notificacionesNoVistas: action.payload.filter(notif => notif.vista === 'false' ||  notif.vista === null).length,
      };
    case 'SET_NOTIFICACIONES_VISTAS':
      return {
        ...state,
        notificaciones: state.notificaciones.map(notif => ({
          ...notif,
          vista: 'true',
        })),
        notificacionesNoVistas: 0,
      };
    case 'SET_LOGGED_IN':
      return { ...state, loggedIn: action.payload };
    case 'SET_USER_DNI':
      return { ...state, userDNI: action.payload };
    case 'SET_EMPRESA_ID':
      return { ...state, empresaId: action.payload };
    case 'SET_EMPRESAS':
      return { ...state, empresas: action.payload };
    case 'SET_CURRENT_OPTION':
      return { ...state, currentOption: action.payload };
    case 'SET_ROLE_SESSION':
      return { ...state, roleSession: action.payload };
    case 'SET_SHOW_DASH_TRAB':
      return { ...state, showDashTrab: action.payload };
    case 'SET_USERNAME':
      return { ...state, username: action.payload };
    case 'SET_PASSWORD':
      return { ...state, password: action.payload };
    case 'SET_USER_SESSION':
      return { ...state, userSession: action.payload };
    case 'SET_PHOTO_WORKER':
      return { ...state, photoWorker: action.payload };
    case 'SET_CARGO':
      return { ...state, cargo: action.payload };
    case 'SET_NOMBRE':
      return { ...state, nombre: action.payload };
    case 'SET_TOKEN':
      return {
        ...state,
        token: action.payload
      };
    default:
      return state;
  }
};

export default rootReducer;
