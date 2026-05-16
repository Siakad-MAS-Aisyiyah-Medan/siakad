import apiClient from '../../../../services/apiClient';
import { unwrapData } from '../../../../services/apiHelpers';

export async function fetchJadwalMengajar(params = {}) {
  const response = await apiClient.get('/guru/jadwal', { params });
  return unwrapData(response) ?? [];
}
