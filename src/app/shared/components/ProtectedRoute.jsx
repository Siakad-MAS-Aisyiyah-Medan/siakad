import { Navigate, useLocation } from 'react-router-dom';
import {
  isAuthenticated,
  getStoredUser,
  hasPermission,
  hasAnyPermission,
} from '@app/shared/services/auth.service';
import ForbiddenPage from '@app/shared/components/ForbiddenPage';

export function ProtectedRoute({ children }) {
  if (!isAuthenticated()) {
    return <Navigate to="/login" replace />;
  }
  return children;
}

export function PermissionRoute({ children, permission, permissions }) {
  const location = useLocation();

  if (!isAuthenticated()) {
    return <Navigate to="/login" replace state={{ from: location.pathname }} />;
  }

  const required = permissions ?? (permission ? [permission] : []);

  if (required.length > 0 && !hasAnyPermission(required)) {
    return (
      <ForbiddenPage
        message={`Anda tidak memiliki izin (${required.join(', ')}) untuk halaman ini.`}
      />
    );
  }

  return children;
}

export function RoleRoute({ children, allowedRoles }) {
  if (!isAuthenticated()) {
    return <Navigate to="/login" replace />;
  }

  const user = getStoredUser();
  if (allowedRoles?.includes(user?.role) || hasPermission('manage_all')) {
    return children;
  }

  return <ForbiddenPage message="Role Anda tidak diizinkan mengakses halaman ini." />;
}

export function AdminRoute({ children }) {
  return <PermissionRoute permission="manage_all">{children}</PermissionRoute>;
}
