import React from 'react';
import { useNavigate } from 'react-router-dom';
import authService from '../../services/authService';

const AdminSettings = () => {
  const navigate = useNavigate();
  const user = authService.getCurrentUser();

  // Verificar autenticación y rol
  React.useEffect(() => {
    if (!authService.isAuthenticated() || !authService.hasRole('Administrador')) {
      navigate('/login');
    }
  }, [navigate]);

  return (
    <div className="min-h-screen bg-gray-100">
      <div className="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div className="px-4 py-6 sm:px-0">
          <h1 className="text-3xl font-bold text-gray-900 mb-8">
            Configuración del Sistema
          </h1>
          
          <div className="bg-white shadow overflow-hidden sm:rounded-lg">
            <div className="px-4 py-5 sm:p-6">
              <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                {/* Configuración General */}
                <div className="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                  <h2 className="text-xl font-semibold text-gray-800 mb-4">Configuración General</h2>
                  <p className="text-gray-600 mb-4">Ajustes generales del sistema.</p>
                  <button className="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">
                    Modificar
                  </button>
                </div>

                {/* Configuración de Seguridad */}
                <div className="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                  <h2 className="text-xl font-semibold text-gray-800 mb-4">Seguridad</h2>
                  <p className="text-gray-600 mb-4">Gestiona la seguridad del sistema.</p>
                  <button className="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors">
                    Configurar
                  </button>
                </div>

                {/* Configuración de Notificaciones */}
                <div className="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                  <h2 className="text-xl font-semibold text-gray-800 mb-4">Notificaciones</h2>
                  <p className="text-gray-600 mb-4">Configura las notificaciones del sistema.</p>
                  <button className="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600 transition-colors">
                    Ajustar
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default AdminSettings;