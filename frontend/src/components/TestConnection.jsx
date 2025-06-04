import { useState, useEffect } from 'react';
import api from '../services/api';

function TestConnection() {
  const [message, setMessage] = useState('');
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const testBackendConnection = async () => {
      try {
        setLoading(true);
        const response = await api.get('/api/test');
        setMessage(response.data.message);
        setError(null);
      } catch (err) {
        setError('Error al conectar con el backend: ' + (err.response?.data?.message || err.message));
      } finally {
        setLoading(false);
      }
    };

    testBackendConnection();
  }, []);

  return (
    <div className="p-4 bg-white rounded shadow">
      <h2 className="text-xl font-bold mb-4">Prueba de Conexión con Backend</h2>
      {loading ? (
        <p className="text-gray-500">Cargando...</p>
      ) : error ? (
        <p className="text-red-500">{error}</p>
      ) : (
        <p className="text-green-500">{message}</p>
      )}
    </div>
  );
}

export default TestConnection;