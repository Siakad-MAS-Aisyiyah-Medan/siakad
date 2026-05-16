import { Routes, Route, Navigate } from 'react-router-dom';
import { PermissionRoute, ProtectedRoute } from './ProtectedRoute';
import { ROUTE_PERMISSIONS } from '../../config/routePermissions.config';
import LoginPage from '../../features/auth/login';
import LandingPage from '../../features/public/landing-page';
import NewsDetail from '../../features/public/news-detail';
import RegisterPage from '../../features/public/register';
import DashboardRouter from './DashboardRouter';
import FeaturePlaceholder from '../../shared/components/FeaturePlaceholder';
import ForbiddenPage from '../../shared/components/ForbiddenPage';
import NotFoundPage from '../../shared/components/NotFoundPage';

import AdminDashboard from '../../features/admin/dashboard';
import AdminProfilSekolah from '../../features/admin/profil-sekolah';
import AdminPengumuman from '../../features/admin/pengumuman';
import AdminPrestasi from '../../features/admin/prestasi';
import AdminMurid from '../../features/admin/murid';
import AdminGuru from '../../features/admin/guru';
import AdminKelas from '../../features/admin/kelas';
import AdminMapel from '../../features/admin/mapel';
import AdminJadwal from '../../features/admin/jadwal';
import AdminEkskul from '../../features/admin/ekskul';
import AdminPpdb from '../../features/admin/ppdb';
import AdminHakAkses from '../../features/admin/hak-akses';
import AdminLaporan from '../../features/admin/laporan';
import AdminAbsensiGuru from '../../features/admin/absensi-guru';
import AdminAuditLogs from '../../features/admin/audit-logs';

import KepsekDashboard from '../../features/kepsek/dashboard';
import GuruDashboard from '../../features/guru/dashboard';
import GuruJadwal from '../../features/guru/jadwal';
import GuruAbsensi from '../../features/guru/absensi';
import GuruRiwayatAbsensi from '../../features/guru/riwayat-absensi';
import WaliKelasDashboard from '../../features/wali-kelas/dashboard';
import SiswaDashboard from '../../features/siswa/dashboard';
import SiswaJadwal from '../../features/siswa/jadwal';
import SiswaAbsensi from '../../features/siswa/absensi';
import WaliAbsensi from '../../features/wali-kelas/absensi';
import KepsekLaporanAbsensi from '../../features/kepsek/laporan-absensi';
import KepsekLaporanNilai from '../../features/kepsek/laporan-nilai';
import GuruNilai from '../../features/guru/nilai';
import WaliNilai from '../../features/wali-kelas/nilai';
import WaliLaporan from '../../features/wali-kelas/laporan';
import SiswaNilai from '../../features/siswa/nilai';
import KepsekLaporanHub from '../../features/kepsek/laporan';
import CalonSiswaDashboard from '../../features/calon-siswa/dashboard';

function wrapPerm(path, element, permissionsOverride) {
  if (permissionsOverride?.length) {
    return <PermissionRoute permissions={permissionsOverride}>{element}</PermissionRoute>;
  }
  const permission = ROUTE_PERMISSIONS[path];
  if (!permission) {
    return element;
  }
  return <PermissionRoute permission={permission}>{element}</PermissionRoute>;
}

function placeholder(title, description) {
  return <FeaturePlaceholder title={title} description={description} />;
}

export default function AppRouter() {
  return (
    <Routes>
      <Route path="/" element={<LoginPage />} />
      <Route path="/home" element={<LandingPage />} />
      <Route path="/news/:id" element={<NewsDetail />} />
      <Route path="/register" element={<RegisterPage />} />
      <Route path="/dashboard" element={<DashboardRouter />} />

      {/* Admin */}
      <Route path="/admin/dashboard" element={wrapPerm('/admin/dashboard', <AdminDashboard />)} />
      <Route
        path="/admin/profil-sekolah"
        element={wrapPerm('/admin/profil-sekolah', <AdminProfilSekolah />)}
      />
      <Route path="/admin/profil" element={<Navigate to="/admin/profil-sekolah" replace />} />
      <Route path="/admin/pengumuman" element={wrapPerm('/admin/pengumuman', <AdminPengumuman />)} />
      <Route path="/admin/prestasi" element={wrapPerm('/admin/prestasi', <AdminPrestasi />)} />
      <Route path="/admin/berita" element={<Navigate to="/admin/prestasi" replace />} />
      <Route path="/admin/murid" element={wrapPerm('/admin/murid', <AdminMurid />)} />
      <Route path="/admin/guru" element={wrapPerm('/admin/guru', <AdminGuru />)} />
      <Route path="/admin/kelas" element={wrapPerm('/admin/kelas', <AdminKelas />)} />
      <Route path="/admin/mapel" element={wrapPerm('/admin/mapel', <AdminMapel />)} />
      <Route path="/admin/jadwal" element={wrapPerm('/admin/jadwal', <AdminJadwal />)} />
      <Route path="/admin/ekskul" element={wrapPerm('/admin/ekskul', <AdminEkskul />)} />
      <Route path="/admin/ppdb" element={wrapPerm('/admin/ppdb', <AdminPpdb />)} />
      <Route path="/admin/pengajuan" element={<Navigate to="/admin/ppdb" replace />} />
      <Route path="/admin/hak-akses" element={wrapPerm('/admin/hak-akses', <AdminHakAkses />)} />
      <Route path="/admin/roles" element={<Navigate to="/admin/hak-akses" replace />} />
      <Route path="/admin/laporan" element={wrapPerm('/admin/laporan', <AdminLaporan />)} />
      <Route
        path="/admin/absensi-guru"
        element={wrapPerm('/admin/absensi-guru', <AdminAbsensiGuru />)}
      />
      <Route
        path="/admin/audit-logs"
        element={wrapPerm('/admin/audit-logs', <AdminAuditLogs />)}
      />

      {/* Kepsek */}
      <Route
        path="/kepsek/dashboard"
        element={wrapPerm('/kepsek/dashboard', <KepsekDashboard />)}
      />
      <Route
        path="/kepsek/data"
        element={wrapPerm('/kepsek/data', <KepsekLaporanHub initialJenis="siswa" />)}
      />
      <Route
        path="/kepsek/ppdb"
        element={wrapPerm('/kepsek/ppdb', <KepsekLaporanHub initialJenis="ppdb" />)}
      />
      <Route path="/kepsek/laporan" element={wrapPerm('/kepsek/laporan', <KepsekLaporanHub />)} />
      <Route
        path="/kepsek/absensi-guru"
        element={wrapPerm('/kepsek/absensi-guru', <KepsekLaporanAbsensi initialTab="guru" />)}
      />
      <Route
        path="/kepsek/laporan-absensi"
        element={wrapPerm('/kepsek/laporan-absensi', <KepsekLaporanAbsensi />)}
      />
      <Route
        path="/kepsek/laporan-nilai"
        element={wrapPerm('/kepsek/laporan-nilai', <KepsekLaporanNilai />)}
      />

      {/* Guru */}
      <Route path="/guru/dashboard" element={wrapPerm('/guru/dashboard', <GuruDashboard />)} />
      <Route path="/guru/jadwal" element={wrapPerm('/guru/jadwal', <GuruJadwal />)} />
      <Route
        path="/guru/murid"
        element={wrapPerm(
          '/guru/murid',
          placeholder('Data Murid', 'Daftar murid per kelas yang Anda ampu.')
        )}
      />
      <Route path="/guru/absensi" element={wrapPerm('/guru/absensi', <GuruAbsensi />)} />
      <Route path="/guru/nilai" element={wrapPerm('/guru/nilai', <GuruNilai />)} />
      <Route path="/guru/riwayat-absensi" element={wrapPerm('/guru/riwayat-absensi', <GuruRiwayatAbsensi />)} />

      {/* Wali kelas */}
      <Route
        path="/wali/dashboard"
        element={wrapPerm('/wali/dashboard', <WaliKelasDashboard />)}
      />
      <Route
        path="/wali/murid"
        element={wrapPerm(
          '/wali/murid',
          placeholder('Data Murid Kelas', 'Daftar siswa di kelas Anda.')
        )}
      />
      <Route path="/wali/absensi" element={wrapPerm('/wali/absensi', <WaliAbsensi />)} />
      <Route path="/wali/nilai" element={wrapPerm('/wali/nilai', <WaliNilai />)} />
      <Route path="/wali/leger" element={<Navigate to="/wali/nilai" replace />} />
      <Route
        path="/wali/laporan"
        element={wrapPerm('/wali/laporan', <WaliLaporan />, [
          'view_absensi_kelas',
          'validate_nilai',
          'view_siswa_kelas',
        ])}
      />
      <Route
        path="/wali/ekskul"
        element={wrapPerm(
          '/wali/ekskul',
          placeholder('Kepribadian & Ekskul', 'Data kepribadian dan ekstrakurikuler siswa.')
        )}
      />

      {/* Siswa */}
      <Route path="/siswa/dashboard" element={wrapPerm('/siswa/dashboard', <SiswaDashboard />)} />
      <Route path="/siswa/jadwal" element={wrapPerm('/siswa/jadwal', <SiswaJadwal />)} />
      <Route path="/siswa/absensi" element={wrapPerm('/siswa/absensi', <SiswaAbsensi />)} />
      <Route path="/siswa/nilai" element={wrapPerm('/siswa/nilai', <SiswaNilai />)} />

      {/* Calon siswa */}
      <Route
        path="/calon-siswa/dashboard"
        element={wrapPerm('/calon-siswa/dashboard', <CalonSiswaDashboard />)}
      />

      <Route path="/forbidden" element={<ProtectedRoute><ForbiddenPage /></ProtectedRoute>} />
      <Route path="*" element={<NotFoundPage />} />
    </Routes>
  );
}
