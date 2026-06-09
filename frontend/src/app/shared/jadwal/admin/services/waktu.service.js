import apiClient from '@app/shared/services/apiClient';

export async function fetchWaktuPelajaran() {
  const response = await apiClient.get('/waktu-pelajaran');
  return response.data;
}

export async function generateWaktuPelajaran(payload) {
  const response = await apiClient.post('/waktu-pelajaran/generate', payload);
  return response.data;
}
