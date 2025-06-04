import React from 'react';
import { useNavigate } from 'react-router-dom';
import authService from '../../services/authService';

const AdminContent = () => {
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
            Gestión de Contenido
          </h1>
          
          <div className="bg-white shadow overflow-hidden sm:rounded-lg">
            <div className="px-4 py-5 sm:p-6">
              <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                {/* Sección de Noticias */}
                <div className="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                  <h2 className="text-xl font-semibold text-gray-800 mb-4">Noticias</h2>
                  <p className="text-gray-600 mb-4">Gestiona las noticias y actualizaciones del sistema.</p>
                  <button className="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">
                    Administrar Noticias
                  </button>
                </div>

                {/* Sección de Eventos */}
                <div className="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                  <h2 className="text-xl font-semibold text-gray-800 mb-4">Eventos</h2>
                  <p className="text-gray-600 mb-4">Gestiona los eventos y actividades programadas.</p>
                  <button className="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors">
                    Administrar Eventos
                  </button>
                </div>

                {/* Sección de Recursos */}
                <div className="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                  <h2 className="text-xl font-semibold text-gray-800 mb-4">Recursos</h2>
                  <p className="text-gray-600 mb-4">Gestiona documentos y recursos compartidos.</p>
                  <button className="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600 transition-colors">
                    Administrar Recursos
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

export default AdminContent;