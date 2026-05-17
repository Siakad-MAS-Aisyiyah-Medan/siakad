import { Route } from 'react-router-dom';
import LoginPage from '@app/menus/auth/pages/login';
import DashboardRouter from '@app/shared/components/DashboardRouter';

export const authRoutes = (
  <>
    <Route path="/login" element={<LoginPage />} />
    <Route path="/dashboard" element={<DashboardRouter />} />
  </>
);
