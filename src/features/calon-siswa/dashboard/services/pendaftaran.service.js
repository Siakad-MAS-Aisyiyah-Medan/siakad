import apiClient from '../../../../services/apiClient';
import { unwrapData } from '../../../../services/apiHelpers';

export async function fetchPendaftaran() {
  const response = await apiClient.get('/pendaftaran');
  return unwrapData(response);
}

export async function savePendaftaranDraft(formData, files) {
  const data = new FormData();
  Object.keys(formData).forEach((key) => {
    if (formData[key] !== null && formData[key] !== undefined) {
      data.append(key, formData[key]);
    }
  });
  Object.keys(files).forEach((key) => {
    if (files[key]) data.append(key, files[key]);
  });

  const response = await apiClient.put('/pendaftaran', data, {
    headers: { 'Content-Type': 'multipart/form-data' },
  });
  return unwrapData(response);
}

export async function submitPendaftaran() {
  const response = await apiClient.post('/pendaftaran/submit');
  return unwrapData(response);
}
