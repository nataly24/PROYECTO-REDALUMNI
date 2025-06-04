import React, { useEffect, useState, useCallback } from 'react';
import { useNavigate } from 'react-router-dom';
import authService from '../../services/authService';

const AdminDashboard = () => {
  const navigate = useNavigate();
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [greeting, setGreeting] = useState('');
  const [currentTime, setCurrentTime] = useState('');
  const [userData, setUserData] = useState({
    nombre: '',
    cargo: 'Administrador',
  });

  // Obtenemos el usuario una sola vez al inicio
  const user = useCallback(() => authService.getCurrentUser(), []);

  // Manejador de clic fuera del menú
  useEffect(() => {
    const handleClickOutside = (event) => {
      if (isMenuOpen && !event.target.closest('.relative')) {
        setIsMenuOpen(false);
      }
    };

    document.addEventListener('mousedown', handleClickOutside);
    return () => document.removeEventListener('mousedown', handleClickOutside);
  }, [isMenuOpen]);

  // Efecto para configuración inicial
  useEffect(() => {
    if (!authService.isAuthenticated() || !authService.hasRole('Administrador')) {
      navigate('/login');
      return;
    }

    const currentUser = user();
    if (currentUser) {
      const formatUserName = (email) => {
        if (!email) return 'Usuario';
        try {
          return email.split('@')[0].split('.')
            .map(part => part.charAt(0).toUpperCase() + part.slice(1))
            .join(' ');
        } catch {
          return 'Usuario';
        }
      };

      setUserData(prev => ({
        ...prev,
        nombre: formatUserName(currentUser.correo_electronico)
      }));
    }

    // Configurar saludo según hora
    const hour = new Date().getHours();
    setGreeting(
      hour >= 5 && hour < 12 ? '¡Buenos días' :
      hour >= 12 && hour < 19 ? '¡Buenas tardes' : '¡Buenas noches'
    );

    // Configurar y actualizar hora
    const updateTime = () => {
      const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      };
      setCurrentTime(new Date().toLocaleDateString('es-ES', options));
    };

    updateTime();
    const interval = setInterval(updateTime, 60000);
    return () => clearInterval(interval);
  }, [navigate, user]);

  const handleLogout = useCallback(() => {
    authService.logout();
    navigate('/login');
  }, [navigate]);

  const quickAccessCards = [
    {
      title: 'Gestión de Usuarios',
      description: 'Administra usuarios, roles y permisos',
      icon: '👥',
      bgColor: 'bg-blue-100',
      borderColor: 'border-blue-300',
      textColor: 'text-blue-700',
      descColor: 'text-blue-600',
      onClick: () => navigate('/admin/users')
    },
    {
      title: 'Gestión de Exalumnos',
      description: 'Administra perfiles y seguimiento académico',
      icon: '🎓',
      bgColor: 'bg-green-100',
      borderColor: 'border-green-300',
      textColor: 'text-green-700',
      descColor: 'text-green-600',
      onClick: () => navigate('/admin/alumni')
    },
    {
      title: 'Gestión de Empresas',
      description: 'Administra empresas y convenios',
      icon: '🏢',
      bgColor: 'bg-yellow-100',
      borderColor: 'border-yellow-300',
      textColor: 'text-yellow-700',
      descColor: 'text-yellow-600',
      onClick: () => navigate('/admin/companies')
    },
    {
      title: 'Ofertas Laborales',
      description: 'Gestiona ofertas y postulaciones',
      icon: '💼',
      bgColor: 'bg-purple-100',
      borderColor: 'border-purple-300',
      textColor: 'text-purple-700',
      descColor: 'text-purple-600',
      onClick: () => navigate('/admin/jobs')
    },
    {
      title: 'SUBENIL',
      description: 'Gestión de inventario y materiales',
      icon: '📦',
      bgColor: 'bg-red-100',
      borderColor: 'border-red-300',
      textColor: 'text-red-700',
      descColor: 'text-red-600',
      onClick: () => navigate('/admin/subenil')
    },
    {
      title: 'Documentación',
      description: 'Gestión de cartas y convenios',
      icon: '📄',
      bgColor: 'bg-indigo-100',
      borderColor: 'border-indigo-300',
      textColor: 'text-indigo-700',
      descColor: 'text-indigo-600',
      onClick: () => navigate('/admin/documents')
    }
  ];

  return (
    <div className="min-h-screen bg-primary-50 flex flex-col">
      {/* Barra de navegación */}
      <nav className="bg-primary-700 text-white shadow-lg sticky top-0 z-10">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between h-16">
            <div className="flex items-center">
              <span className="text-xl font-bold flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" className="h-8 w-8 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                AlumniRed
              </span>
            </div>
            <div className="flex items-center">
              <div className="hidden md:block mr-4 text-sm">
                <div className="font-medium">{userData.nombre}</div>
                <div className="text-primary-200 text-xs">{userData.cargo}</div>
              </div>
              <div className="relative">
                <button 
                  className="flex items-center focus:outline-none"
                  onClick={() => setIsMenuOpen(!isMenuOpen)}
                  aria-label="Menú de usuario"
                  aria-expanded={isMenuOpen}
                >
                  <div className="w-8 h-8 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold">
                    {userData.nombre ? userData.nombre.charAt(0) : 'U'}
                  </div>
                </button>
                {isMenuOpen && (
                  <div className="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                    <a href="#perfil" className="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-100">Mi Perfil</a>
                    <a href="#configuracion" className="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-100">Configuración</a>
                    <button 
                      onClick={handleLogout}
                      className="block w-full text-left px-4 py-2 text-sm text-rojo-700 hover:bg-rojo-100"
                    >
                      Cerrar Sesión
                    </button>
                  </div>
                )}
              </div>
            </div>
          </div>
        </div>
      </nav>

      {/* Contenido principal */}
      <main className="flex-grow">
        <div className="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
          {/* Encabezado con saludo personalizado */}
          <div className="px-4 py-5 sm:px-6 bg-white shadow rounded-lg mb-6">
            <div className="flex flex-col md:flex-row justify-between items-start md:items-center">
              <div>
                <h1 className="text-2xl font-bold text-gray-800">
                  {greeting}, {userData.nombre.split(' ')[0]}!
                </h1>
                <p className="text-gray-600 mt-1">
                  Panel de Administración AlumniRed
                </p>
              </div>
              <div className="mt-2 md:mt-0 text-sm text-gray-500">
                {currentTime}
              </div>
            </div>
          </div>

          {/* Tarjetas de acceso rápido */}
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-4 py-6">
            {quickAccessCards.map((card, index) => (
              <div
                key={index}
                onClick={card.onClick}
                className={`${card.bgColor} ${card.borderColor} border-2 rounded-lg p-6 cursor-pointer 
                  transform transition-all duration-300 hover:scale-105 hover:shadow-lg`}
              >
                <div className="flex items-center">
                  <span className="text-4xl mr-4">{card.icon}</span>
                  <div>
                    <h3 className={`${card.textColor} text-xl font-bold`}>
                      {card.title}
                    </h3>
                    <p className={`${card.descColor} mt-1`}>
                      {card.description}
                    </p>
                  </div>
                </div>
              </div>
            ))}
          </div>

          {/* Actividad reciente */}
          <RecentActivity />
        </div>
      </main>
      
      {/* Pie de página */}
      <Footer />
    </div>
  );
};

// Componente para actividad reciente
const RecentActivity = () => (
  <div className="px-4 py-6 sm:px-0 mt-4">
    <h2 className="text-lg font-medium text-primary-800 mb-4">Actividad Reciente</h2>
    <div className="bg-white shadow overflow-hidden sm:rounded-md">
      <ul className="divide-y divide-gray-200">
        {[1, 2, 3].map((item) => (
          <li key={item}>
            <div className="px-4 py-4 sm:px-6 hover:bg-gray-50 cursor-pointer">
              <div className="flex items-center justify-between">
                <p className="text-sm font-medium text-primary-700 truncate">
                  {item === 1 ? 'Nueva empresa registrada' : 
                   item === 2 ? 'Oferta laboral publicada' : 
                   'Usuario actualizado'}
                </p>
                <div className="ml-2 flex-shrink-0 flex">
                  <p className="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    {item === 1 ? 'Empresa' : item === 2 ? 'Oferta' : 'Usuario'}
                  </p>
                </div>
              </div>
              <div className="mt-2 sm:flex sm:justify-between">
                <div className="sm:flex">
                  <p className="flex items-center text-sm text-gray-500">
                    {item === 1 ? 'Empresa XYZ se ha registrado en la plataforma' : 
                     item === 2 ? 'Nueva oferta de Desarrollador Frontend publicada' : 
                     'El usuario Juan Pérez ha actualizado su perfil'}
                  </p>
                </div>
                <div className="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                  <svg className="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clipRule="evenodd" />
                  </svg>
                  <p>Hace {item * 2} horas</p>
                </div>
              </div>
            </div>
          </li>
        ))}
      </ul>
    </div>
  </div>
);

// Componente para el pie de página
const Footer = () => (
  <footer className="bg-primary-800 text-white py-4 mt-auto">
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div className="flex flex-col md:flex-row justify-between items-center">
        <p className="text-center">© 2025 Proyecto de Grado - Panel de Administración</p>
        <div className="mt-2 md:mt-0 flex space-x-4">
          <a href="#ayuda" className="text-primary-200 hover:text-white">Ayuda</a>
          <a href="#privacidad" className="text-primary-200 hover:text-white">Privacidad</a>
          <a href="#terminos" className="text-primary-200 hover:text-white">Términos</a>
        </div>
      </div>
    </div>
  </footer>
);

export default AdminDashboard;