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
};

const rootReducer = (state = initialState, action) => {
  switch (action.type) {
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
    default:
      return state;
  }
};

export default rootReducer;
