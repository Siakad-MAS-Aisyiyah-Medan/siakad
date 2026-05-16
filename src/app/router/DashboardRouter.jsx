import { Navigate } from 'react-router-dom';
import { isAuthenticated, getStoredUser, getRedirectPathForRole } from '../../services/auth.service';

/** Legacy /dashboard — redirect ke dashboard per role */
export default function DashboardRouter() {
  if (!isAuthenticated()) {
    return <Navigate to="/" replace />;
  }

  const user = getStoredUser();
  return <Navigate to={getRedirectPathForRole(user?.role)} replace />;
}
