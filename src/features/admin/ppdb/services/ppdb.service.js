import apiClient from '../../../../services/apiClient';
import { unwrapPaginated } from '../../../../services/apiHelpers';

export async function fetchPpdbList(params = {}) {
  const response = await apiClient.get('/ppdb', { params });
  const { items } = unwrapPaginated(response);
  return items;
}

export async function updatePpdbStatus(id, payload) {
  const response = await apiClient.patch(`/ppdb/${id}/status`, payload);
  return response.data;
}
