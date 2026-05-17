import axios from 'axios';
import { apiConfig } from '@/config/api.config';
import { clearSession } from './auth.service';
import { getAuthItem } from '@app/shared/utils/sessionAuthStorage';

const apiClient = axios.create({
  baseURL: apiConfig.baseURL,
  timeout: apiConfig.timeout,
  headers: apiConfig.headers,
});

apiClient.interceptors.request.use((config) => {
  const token = getAuthItem('token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

apiClient.interceptors.response.use(
  (response) => response,
  (error) => {
    const status = error.response?.status;
    if (status === 401) {
      clearSession();
      const msg = error.response?.data?.message || 'Sesi Anda telah berakhir. Silakan login kembali.';
      if (!window.location.pathname.startsWith('/login')) {
        window.location.href = `/login?expired=1&message=${encodeURIComponent(msg)}`;
      }
      return Promise.reject(error);
    }
    if (status === 403) {
      const msg = error.response?.data?.message || 'Akses ditolak.';
      if (!window.location.pathname.startsWith('/forbidden')) {
        window.location.href = `/forbidden?message=${encodeURIComponent(msg)}`;
      }
    }
    return Promise.reject(error);
  }
);

export default apiClient;
