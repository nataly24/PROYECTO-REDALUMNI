import React from 'react';
import { useNavigate } from 'react-router-dom';
import authService from '../../services/authService';

const AdminReports = () => {
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
            Reportes y Estadísticas
          </h1>
          
          <div className="bg-white shadow overflow-hidden sm:rounded-lg">
            <div className="px-4 py-5 sm:p-6">
              <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                {/* Sección de Reportes de Usuarios */}
                <div className="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                  <h2 className="text-xl font-semibold text-gray-800 mb-4">Reportes de Usuarios</h2>
                  <p className="text-gray-600 mb-4">Estadísticas y análisis de usuarios registrados.</p>
                  <button className="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">
                    Ver Reportes
                  </button>
                </div>

                {/* Sección de Reportes de Actividad */}
                <div className="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                  <h2 className="text-xl font-semibold text-gray-800 mb-4">Actividad del Sistema</h2>
                  <p className="text-gray-600 mb-4">Monitoreo de actividades y eventos del sistema.</p>
                  <button className="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors">
                    Ver Actividad
                  </button>
                </div>

                {/* Sección de Reportes Personalizados */}
                <div className="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                  <h2 className="text-xl font-semibold text-gray-800 mb-4">Reportes Personalizados</h2>
                  <p className="text-gray-600 mb-4">Genera reportes específicos según tus necesidades.</p>
                  <button className="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600 transition-colors">
                    Crear Reporte
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

export default AdminReports;