import apiClient from '../../../../services/apiClient';

export async function fetchAuditLogs(params = {}) {
  return apiClient.get('/audit-logs', { params });
}
