import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import authService from '../services/authService';

const Login = () => {
  const [credentials, setCredentials] = useState({
    correo_electronico: '',
    contrasena: ''
  });
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate();

  const handleChange = (e) => {
    const { name, value } = e.target;
    setCredentials({
      ...credentials,
      [name]: value
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError('');

    try {
      const response = await authService.login(
        credentials.correo_electronico,
        credentials.contrasena
      );
      
      // Redireccionar según el rol
      const roles = response.roles || [];
      
      if (roles.includes('Administrador')) {
        navigate('/admin/dashboard');
      } else if (roles.includes('Colaborador')) {
        navigate('/colaborador/dashboard');
      } else if (roles.includes('Exalumno')) {
        navigate('/exalumno/dashboard');
      } else if (roles.includes('Empresa')) {
        navigate('/empresa/dashboard');
      } else {
        navigate('/');
      }
    } catch (error) {
      setError(error.message || 'Error al iniciar sesión');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-gray-100">
      <div className="max-w-md w-full p-6 bg-white rounded-lg shadow-lg">
        <h1 className="text-2xl font-bold text-center text-gray-800 mb-6">
          Iniciar Sesión - AlumniRed
        </h1>
        
        {error && (
          <div className="mb-4 p-3 bg-red-100 text-red-700 rounded">
            {error}
          </div>
        )}
        
        <form onSubmit={handleSubmit}>
          <div className="mb-4">
            <label 
              htmlFor="correo_electronico" 
              className="block text-gray-700 font-medium mb-2"
            >
              Correo Electrónico
            </label>
            <input
              type="email"
              id="correo_electronico"
              name="correo_electronico"
              value={credentials.correo_electronico}
              onChange={handleChange}
              className="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
          </div>
          
          <div className="mb-6">
            <label 
              htmlFor="contrasena" 
              className="block text-gray-700 font-medium mb-2"
            >
              Contraseña
            </label>
            <input
              type="password"
              id="contrasena"
              name="contrasena"
              value={credentials.contrasena}
              onChange={handleChange}
              className="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
          </div>
          
          <button
            type="submit"
            disabled={loading}
            className="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-200"
          >
            {loading ? 'Iniciando sesión...' : 'Iniciar Sesión'}
          </button>
        </form>
      </div>
    </div>
  );
};

export default Login;