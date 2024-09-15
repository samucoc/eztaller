import axios from 'axios';
import { useSelector } from 'react-redux';
import { API_BASE_URL, API_DOWNLOAD_URL } from './components/config/apiConstants';

// Create an Axios instance
const api = axios.create({
  baseURL: API_BASE_URL
});

const useAuthAxios = () => {
  const token = useSelector((state) => state.token);

  api.interceptors.request.use(
    (config) => {
      if (token) {
        config.headers['Authorization'] = `Bearer ${token}`;
      }
      return config;
    },
    (error) => Promise.reject(error)
  );

  return api;
};

export default useAuthAxios;