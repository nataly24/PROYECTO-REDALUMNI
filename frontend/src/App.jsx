import React from 'react';
import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import CreateUser from './components/admin/CreateUser';
import Login from './components/Login';
import AdminDashboard from './components/dashboards/AdminDashboard';
import AdminContent from './components/admin/AdminContent'; 
import AdminUsers from './components/admin/AdminUsers';
import AdminReports from './components/admin/AdminReports';
import AdminSettings from './components/admin/AdminSettings';
import ColaboradorDashboard from './components/dashboards/ColaboradorDashboard';
import ExalumnoDashboard from './components/dashboards/ExalumnoDashboard';
import EmpresaDashboard from './components/dashboards/EmpresaDashboard';
import authService from './services/authService';


const ProtectedRoute = ({ children, allowedRoles }) => {
  const isAuthenticated = authService.isAuthenticated();
  const userRoles = authService.getUserRoles();
  
  const hasRequiredRole = allowedRoles.some(role => userRoles.includes(role));
  
  if (!isAuthenticated || !hasRequiredRole) {
    return <Navigate to="/login" replace />;
  }
  
  return children;
};

function App() {
  return (
    <Routes>
      <Route path="/login" element={<Login />} />
      <Route path="/admin" element={<Navigate to="/admin/dashboard" replace />} />
      
      <Route 
        path="/admin/dashboard" 
        element={
          <ProtectedRoute allowedRoles={['Administrador']}>
            <AdminDashboard />
          </ProtectedRoute>
        } 
      />
      
      <Route 
        path="/admin/content" 
        element={
          <ProtectedRoute allowedRoles={['Administrador']}>
            <AdminContent />
          </ProtectedRoute>
        } 
      />
      
      <Route 
        path="/admin/users" 
        element={
          <ProtectedRoute allowedRoles={['Administrador']}>
            <AdminUsers />
          </ProtectedRoute>
        } 
      />
      
      <Route 
        path="/admin/users/new" 
        element={
          <ProtectedRoute allowedRoles={['Administrador']}>
            <CreateUser />
          </ProtectedRoute>
        } 
      />
      
      <Route 
        path="/admin/reports" 
        element={
          <ProtectedRoute allowedRoles={['Administrador']}>
            <AdminReports />
          </ProtectedRoute>
        } 
      />
      
      <Route 
        path="/admin/settings" 
        element={
          <ProtectedRoute allowedRoles={['Administrador']}>
            <AdminSettings />
          </ProtectedRoute>
        } 
      />
      

      <Route 
        path="/colaborador/dashboard" 
        element={
          <ProtectedRoute allowedRoles={['Colaborador']}>
            <ColaboradorDashboard />
          </ProtectedRoute>
        } 
      />
      
      <Route 
        path="/exalumno/dashboard" 
        element={
          <ProtectedRoute allowedRoles={['Exalumno']}>
            <ExalumnoDashboard />
          </ProtectedRoute>
        } 
      />
      
      <Route 
        path="/empresa/dashboard" 
        element={
          <ProtectedRoute allowedRoles={['Empresa']}>
            <EmpresaDashboard />
          </ProtectedRoute>
        } 
      />
      

      <Route path="/" element={<Navigate to="/login" replace />} />
      <Route path="*" element={<Navigate to="/login" replace />} />
    </Routes>
  );
}

export default App;