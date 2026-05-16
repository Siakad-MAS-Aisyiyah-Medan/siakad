import apiClient from '../../../../services/apiClient';
import { unwrapData } from '../../../../services/apiHelpers';

export async function fetchJadwalSiswa(params = {}) {
  const response = await apiClient.get('/siswa/jadwal', { params });
  return unwrapData(response) ?? [];
}
