import apiClient from '../../../../services/apiClient';
import { unwrapData, unwrapPaginated } from '../../../../services/apiHelpers';

export async function fetchAbsensiGuruList(params = {}) {
  const response = await apiClient.get('/absensi-guru', { params });
  const { items } = unwrapPaginated(response);
  return items;
}

export async function fetchRekapAbsensiGuru(params = {}) {
  const response = await apiClient.get('/absensi-guru/rekap', { params });
  return unwrapData(response);
}
