import { useState, useEffect, useCallback } from 'react';
import { fetchJadwalSiswa } from '../services/jadwalSiswa.service';

export function useJadwalSiswa() {
  const [items, setItems] = useState([]);
  const [loading, setLoading] = useState(true);
  const [isFetching, setIsFetching] = useState(true);
  const [error, setError] = useState(null);

  const load = useCallback(async () => {
    setIsFetching(true);
    setError(null);
    try {
      const data = await fetchJadwalSiswa();
      setItems(Array.isArray(data) ? data : []);
    } catch (err) {
      setError(err.response?.data?.message || 'Gagal memuat jadwal pelajaran.');
      setItems([]);
    } finally {
      setIsFetching(false);
      setLoading(false);
    }
  }, []);

  useEffect(() => {
    load();
  }, [load]);

  return { items, loading, isFetching, error, reload: load };
}
