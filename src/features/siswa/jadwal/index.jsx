import MainLayout from '../../../app/layouts/MainLayout';
import JadwalScheduleView from '../../../shared/components/JadwalScheduleView';
import { getStoredUser, getStoredProfile } from '../../../services/auth.service';
import { getDisplayName } from '../../../shared/utils/profile';
import { useJadwalSiswa } from './hooks/useJadwalSiswa';

export default function SiswaJadwalPage() {
  const user = getStoredUser();
  const profile = getStoredProfile();
  const name = getDisplayName(profile, user?.role, user?.username);
  const { items, loading, error } = useJadwalSiswa();

  return (
    <MainLayout role="siswa" name={name}>
      {loading && (
        <div className="glass p-6 text-secondary">Memuat jadwal pelajaran...</div>
      )}
      {error && !loading && (
        <div className="glass p-6 text-red-500" style={{ borderRadius: '12px' }}>
          {error}
        </div>
      )}
      {!loading && !error && (
        <JadwalScheduleView
          title="Jadwal Pelajaran"
          subtitle="Jadwal pelajaran kelas Anda."
          items={items}
          showGuru
          emptyMessage="Belum ada jadwal untuk kelas Anda."
        />
      )}
    </MainLayout>
  );
}
