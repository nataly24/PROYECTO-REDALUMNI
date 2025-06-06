import axios from 'axios';

const API_URL = 'http://localhost:8000/api';

// Configuración de axios
const api = axios.create({
  baseURL: API_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
  },
  withCredentials: true,
});

// Función para obtener el token CSRF
const getCsrfToken = async () => {
  try {
    await axios.get('http://localhost:8000/sanctum/csrf-cookie', {
      withCredentials: true
    });
  } catch (error) {
    console.error('Error al obtener el token CSRF:', error);
  }
};

// Servicio de autenticación
const authService = {
  // Iniciar sesión
  login: async (correo_electronico, contrasena) => {
    try {
      // Obtener el token CSRF antes de iniciar sesión
      await getCsrfToken();
      
      const response = await api.post('/login', {
        correo_electronico,
        contrasena
      });
      
      if (response.data.token) {
        localStorage.setItem('token', response.data.token);
        localStorage.setItem('user', JSON.stringify(response.data.user));
        localStorage.setItem('roles', JSON.stringify(response.data.roles));
      }
      
      return response.data;
    } catch (error) {
      throw error.response?.data || { message: 'Error al iniciar sesión' };
    }
  },
  
  // Cerrar sesión
  logout: async () => {
    try {
      await api.post('/logout');
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      localStorage.removeItem('roles');
    } catch (error) {
      console.error('Error al cerrar sesión:', error);
    }
  },
  
  // Obtener usuario actual
  getCurrentUser: () => {
    return JSON.parse(localStorage.getItem('user'));
  },
  
  // Verificar si el usuario está autenticado
  isAuthenticated: () => {
    return !!localStorage.getItem('token');
  },
  
  // Obtener roles del usuario
  getUserRoles: () => {
    return JSON.parse(localStorage.getItem('roles')) || [];
  },
  
  // Verificar si el usuario tiene un rol específico
  hasRole: (roleName) => {
    const roles = JSON.parse(localStorage.getItem('roles')) || [];
    return roles.includes(roleName);
  },
  
  // Obtener el token actual
  getToken: () => {
    return localStorage.getItem('token');
  },
  
  // Verificar si el token ha expirado
  isTokenExpired: () => {
    const token = localStorage.getItem('token');
    if (!token) return true;
    
    // Implementación básica - en producción podrías decodificar el JWT
    // y verificar su fecha de expiración
    return false;
  },
  
  // Actualizar información del usuario
  updateUserInfo: (userData) => {
    localStorage.setItem('user', JSON.stringify(userData));
  },
  
  // Obtener usuario desde el servidor
  fetchCurrentUser: async () => {
    try {
      const response = await api.get('/user');
      localStorage.setItem('user', JSON.stringify(response.data));
      return response.data;
    } catch (error) {
      console.error('Error al obtener información del usuario:', error);
      throw error.response?.data || { message: 'Error al obtener información del usuario' };
    }
  }
};

export default authService;
export { api };