import { getJsonItem } from '../../../shared/utils/storage';
import { getDisplayName } from '../../../shared/utils/profile';
import MainLayout from '../../../app/layouts/MainLayout';
import { GraduationCap } from 'lucide-react';

export default function GuruDashboard() {
  const user = getJsonItem('user');
  const profile = getJsonItem('profile');
  const name = getDisplayName(profile, user?.role ?? 'guru', user?.username);

  return (
    <MainLayout role="guru" name={name}>
      <div className="welcome-banner glass animate-fade-in">
        <div className="banner-icon">
          <GraduationCap size={48} className="text-purple-500" />
        </div>
        <div className="banner-text">
          <h2>Panel Guru</h2>
          <p>Kelola nilai siswa, presensi, dan materi pembelajaran dengan lebih efisien.</p>
        </div>
      </div>

      <div className="stats-grid">
        <div className="stat-card glass">
          <h3>Kelas Diampu</h3>
          <p className="stat-value">5 Kelas</p>
        </div>
        <div className="stat-card glass">
          <h3>Nilai Belum Input</h3>
          <p className="stat-value">12 Siswa</p>
        </div>
      </div>
    </MainLayout>
  );
}
