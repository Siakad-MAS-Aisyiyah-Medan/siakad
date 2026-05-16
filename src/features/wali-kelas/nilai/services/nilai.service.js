import apiClient from '../../../../services/apiClient';
import { unwrapData } from '../../../../services/apiHelpers';

export async function fetchLeger(params) {
  const response = await apiClient.get('/wali/nilai/leger', { params });
  return unwrapData(response);
}

export async function validateNilai(payload) {
  const response = await apiClient.patch('/wali/nilai/validate', payload);
  return unwrapData(response);
}
