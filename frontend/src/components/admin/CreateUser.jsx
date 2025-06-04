import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import authService from '../../services/authService';

const CreateUser = () => {
  const navigate = useNavigate();
  const [formData, setFormData] = useState({
    correo_electronico: '',
    contrasena: '',
    confirmar_contrasena: '',
    rol: '',
    // Campos para Exalumno
    primer_nombre: '',
    segundo_nombre: '',
    primer_apellido: '',
    segundo_apellido: '',
    genero: '',
    fecha_nacimiento: '',
    direccion_domicilio: '',
    celular_contacto: '',
    // Campos para Empresa
    nombre_empresa: '',
    nit: '',
    tipo_empresa: '',
    telefono_empresa: '',
    direccion_empresa: '',
    descripcion_empresa: ''
  });

  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData(prevState => ({
      ...prevState,
      [name]: value
    }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');
    setLoading(true);

    if (formData.contrasena !== formData.confirmar_contrasena) {
      setError('Las contraseñas no coinciden');
      setLoading(false);
      return;
    }

    try {
      const userData = {
        correo_electronico: formData.correo_electronico,
        contrasena: formData.contrasena,
        rol: formData.rol,
        estado_cuenta: 'activo' 
      };

      if (formData.rol === 'Exalumno') {
        userData.persona = {
          primer_nombre: formData.primer_nombre,
          segundo_nombre: formData.segundo_nombre || null, 
          primer_apellido: formData.primer_apellido,
          segundo_apellido: formData.segundo_apellido || null,
          genero: formData.genero,
          fecha_nacimiento: formData.fecha_nacimiento,
          direccion_domicilio: formData.direccion_domicilio,
          celular_contacto: formData.celular_contacto
        };
      } else if (formData.rol === 'Empresa') {
        userData.empresa = {
          nombre_empresa: formData.nombre_empresa,
          nit: formData.nit,
          tipo_empresa: formData.tipo_empresa,
          telefono: formData.telefono_empresa,
          direccion_empresa: formData.direccion_empresa,
          descripcion_empresa: formData.descripcion_empresa || null
        };
      }

      console.log('Datos a enviar:', userData); // Para debugging

      const response = await fetch('http://localhost:8000/api/usuarios', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${authService.getToken()}`,
          'Accept': 'application/json'
        },
        credentials: 'include',
        body: JSON.stringify(userData)
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || 'Error al crear el usuario');
      }
  
      const data = await response.json();
      console.log('Response:', data);
      navigate('/admin/users');
        } catch (err) {
        console.error('Error details:', err);
        setError(err.message);
        } finally {
        setLoading(false);
        }
  };

  return (
    <div className="min-h-screen bg-gray-100">
      <div className="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div className="px-4 py-6 sm:px-0">
          <div className="flex items-center justify-between mb-8">
            <h1 className="text-3xl font-bold text-gray-900">Crear Nuevo Usuario</h1>
            <button
              onClick={() => navigate('/admin/users')}
              className="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors"
            >
              Volver
            </button>
          </div>

          <div className="bg-white shadow overflow-hidden sm:rounded-lg">
            <form onSubmit={handleSubmit} className="p-6">
              {error && (
                <div className="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                  {error}
                </div>
              )}

              {/* Campos básicos */}
              <div className="grid grid-cols-1 gap-6 mb-6">
                <div>
                  <label className="block text-gray-700 text-sm font-bold mb-2">
                    Correo Electrónico *
                  </label>
                  <input
                    type="email"
                    name="correo_electronico"
                    value={formData.correo_electronico}
                    onChange={handleChange}
                    className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required
                  />
                </div>

                <div>
                  <label className="block text-gray-700 text-sm font-bold mb-2">
                    Contraseña *
                  </label>
                  <input
                    type="password"
                    name="contrasena"
                    value={formData.contrasena}
                    onChange={handleChange}
                    className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required
                  />
                </div>

                <div>
                  <label className="block text-gray-700 text-sm font-bold mb-2">
                    Confirmar Contraseña *
                  </label>
                  <input
                    type="password"
                    name="confirmar_contrasena"
                    value={formData.confirmar_contrasena}
                    onChange={handleChange}
                    className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required
                  />
                </div>

                <div>
                  <label className="block text-gray-700 text-sm font-bold mb-2">
                    Rol *
                  </label>
                  <select
                    name="rol"
                    value={formData.rol}
                    onChange={handleChange}
                    className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required
                  >
                    <option value="">Seleccionar rol</option>
                    <option value="Exalumno">Exalumno</option>
                    <option value="Empresa">Empresa</option>
                    <option value="Colaborador">Colaborador</option>
                  </select>
                </div>
              </div>

              {/* Campos específicos para Exalumno */}
              {formData.rol === 'Exalumno' && (
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                  <div>
                    <label className="block text-gray-700 text-sm font-bold mb-2">
                      Primer Nombre *
                    </label>
                    <input
                      type="text"
                      name="primer_nombre"
                      value={formData.primer_nombre}
                      onChange={handleChange}
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      required
                    />
                  </div>
                  <div>
                    <label className="block text-gray-700 text-sm font-bold mb-2">
                      Segundo Nombre
                    </label>
                    <input
                      type="text"
                      name="segundo_nombre"
                      value={formData.segundo_nombre}
                      onChange={handleChange}
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    />
                  </div>
                  <div>
                    <label className="block text-gray-700 text-sm font-bold mb-2">
                      Primer Apellido *
                    </label>
                    <input
                      type="text"
                      name="primer_apellido"
                      value={formData.primer_apellido}
                      onChange={handleChange}
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      required
                    />
                  </div>
                  <div>
                    <label className="block text-gray-700 text-sm font-bold mb-2">
                      Segundo Apellido
                    </label>
                    <input
                      type="text"
                      name="segundo_apellido"
                      value={formData.segundo_apellido}
                      onChange={handleChange}
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    />
                  </div>
                  <div>
                    <label className="block text-gray-700 text-sm font-bold mb-2">
                      Género *
                    </label>
                    <select
                      name="genero"
                      value={formData.genero}
                      onChange={handleChange}
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      required
                    >
                      <option value="">Seleccionar género</option>
                      <option value="M">Masculino</option>
                      <option value="F">Femenino</option>
                      <option value="O">Otro</option>
                    </select>
                  </div>
                  <div>
                    <label className="block text-gray-700 text-sm font-bold mb-2">
                      Fecha de Nacimiento *
                    </label>
                    <input
                      type="date"
                      name="fecha_nacimiento"
                      value={formData.fecha_nacimiento}
                      onChange={handleChange}
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      required
                    />
                  </div>
                  <div>
                    <label className="block text-gray-700 text-sm font-bold mb-2">
                      Dirección *
                    </label>
                    <input
                      type="text"
                      name="direccion_domicilio"
                      value={formData.direccion_domicilio}
                      onChange={handleChange}
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      required
                    />
                  </div>
                  <div>
                    <label className="block text-gray-700 text-sm font-bold mb-2">
                      Celular *
                    </label>
                    <input
                      type="tel"
                      name="celular_contacto"
                      value={formData.celular_contacto}
                      onChange={handleChange}
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      required
                    />
                  </div>
                </div>
              )}

              {/* Campos específicos para Empresa */}
              {formData.rol === 'Empresa' && (
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                  <div>
                    <label className="block text-gray-700 text-sm font-bold mb-2">
                      Nombre de la Empresa *
                    </label>
                    <input
                      type="text"
                      name="nombre_empresa"
                      value={formData.nombre_empresa}
                      onChange={handleChange}
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      required
                    />
                  </div>
                  <div>
                    <label className="block text-gray-700 text-sm font-bold mb-2">
                      NIT *
                    </label>
                    <input
                      type="text"
                      name="nit"
                      value={formData.nit}
                      onChange={handleChange}
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      required
                    />
                  </div>
                  <div>
                    <label className="block text-gray-700 text-sm font-bold mb-2">
                      Tipo de Empresa *
                    </label>
                    <select
                      name="tipo_empresa"
                      value={formData.tipo_empresa}
                      onChange={handleChange}
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      required
                    >
                      <option value="">Seleccionar tipo</option>
                      <option value="Privada">Privada</option>
                      <option value="Pública">Pública</option>
                      <option value="Mixta">Mixta</option>
                    </select>
                  </div>
                  <div>
                    <label className="block text-gray-700 text-sm font-bold mb-2">
                      Teléfono *
                    </label>
                    <input
                      type="tel"
                      name="telefono_empresa"
                      value={formData.telefono_empresa}
                      onChange={handleChange}
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      required
                    />
                  </div>
                  <div className="md:col-span-2">
                    <label className="block text-gray-700 text-sm font-bold mb-2">
                      Dirección *
                    </label>
                    <input
                      type="text"
                      name="direccion_empresa"
                      value={formData.direccion_empresa}
                      onChange={handleChange}
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      required
                    />
                  </div>
                  <div className="md:col-span-2">
                    <label className="block text-gray-700 text-sm font-bold mb-2">
                      Descripción
                    </label>
                    <textarea
                      name="descripcion_empresa"
                      value={formData.descripcion_empresa}
                      onChange={handleChange}
                      className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      rows="4"
                    ></textarea>
                  </div>
                </div>
              )}

              <div className="flex items-center justify-end">
                <button
                  type="submit"
                  disabled={loading}
                  className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                >
                  {loading ? 'Creando...' : 'Crear Usuario'}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
};

export default CreateUser;
