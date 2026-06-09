import apiClient from './apiClient';
import { unwrapData } from './apiHelpers';

export async function fetchAdminDashboardStats() {
  const response = await apiClient.get('/admin/dashboard');
  return unwrapData(response);
}
