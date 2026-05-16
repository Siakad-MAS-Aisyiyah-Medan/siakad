import apiClient from '../../services/apiClient';
import { unwrapData } from '../../services/apiHelpers';

export async function fetchLaporan(apiPath, params) {
  const response = await apiClient.get(apiPath, { params });
  return unwrapData(response);
}
