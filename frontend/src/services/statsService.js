import axios from 'axios';
import authService from './authService';
import api from './api';

const API_URL = 'http://localhost/proyectoalumnired/backend/api/';

const MAX_RETRIES = 3;
const RETRY_DELAY = 1000;

const sleep = (ms) => new Promise(resolve => setTimeout(resolve, ms));

const getAdminStats = async (retries = 0) => {
  try {
    const response = await api.get('/admin/stats');  
    return response.data;
  } catch (error) {
    console.error('Error in getAdminStats:', error);
    
    if (retries < MAX_RETRIES && error.response?.status !== 401) {
      await sleep(RETRY_DELAY);
      return getAdminStats(retries + 1);
    }
    
    return {
      totalUsuarios: 0,
      empresasRegistradas: 0,
      ofertasLaborales: 0,
      exalumnosRegistrados: 0,
      notificaciones: 0
    };
  }
};

// Resto de funciones con manejo de errores similar
const getUsersCount = async () => {
  try {
    const token = authService.getToken();
    const response = await axios.get(`${API_URL}usuarios/count`, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    });
    return response.data;
  } catch (error) {
    console.error('Error en getUsersCount:', error);
    return { count: 7 };
  }
};

const getCompaniesCount = async () => {
  try {
    const token = authService.getToken();
    const response = await axios.get(`${API_URL}empresas/count`, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    });
    return response.data;
  } catch (error) {
    console.error('Error en getCompaniesCount:', error);
    return { count: 2 };
  }
};

const getJobOffersCount = async () => {
  try {
    const token = authService.getToken();
    const response = await axios.get(`${API_URL}ofertas/count`, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    });
    return response.data;
  } catch (error) {
    console.error('Error en getJobOffersCount:', error);
    return { count: 5 };
  }
};

const getAlumniCount = async () => {
  try {
    const token = authService.getToken();
    const response = await axios.get(`${API_URL}exalumnos/count`, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    });
    return response.data;
  } catch (error) {
    console.error('Error en getAlumniCount:', error);
    return { count: 4 };
  }
};

const statsService = {
  getAdminStats,
  getUsersCount,
  getCompaniesCount,
  getJobOffersCount,
  getAlumniCount
};

export default statsService;