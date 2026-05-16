import { fetchLaporan } from '../../../../shared/laporan/laporan.service';

export async function fetchAdminLaporan(params) {
  return fetchLaporan('/laporan', params);
}
