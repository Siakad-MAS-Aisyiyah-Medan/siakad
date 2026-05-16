import apiClient from '../../../../services/apiClient';
import { unwrapData } from '../../../../services/apiHelpers';

export async function fetchAbsensiSiswa(params = {}) {
  const response = await apiClient.get('/siswa/absensi', { params });
  return unwrapData(response) ?? [];
}
