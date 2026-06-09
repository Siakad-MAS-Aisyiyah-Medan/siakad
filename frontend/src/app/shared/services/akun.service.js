import apiClient from './apiClient';
import { unwrapData } from './apiHelpers';

export async function fetchAdminAkunList() {
  const response = await apiClient.get('/admin/akun');
  return unwrapData(response);
}

export async function createAdminAkun(data) {
  const response = await apiClient.post('/admin/akun', data);
  return unwrapData(response);
}
