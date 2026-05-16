/**
 * FALLBACK menu per role — dipakai hanya jika API login tidak mengembalikan menus.
 * Sumber utama: tabel menu_items (RBAC) via backend PermissionService.
 */
export const menuByRole = {
  admin: [
    { iconKey: 'LayoutDashboard', label: 'Dashboard', path: '/admin/dashboard' },
    { iconKey: 'School', label: 'Profil Sekolah', path: '/admin/profil-sekolah' },
    { iconKey: 'School', label: 'Pengumuman Sekolah', path: '/admin/pengumuman' },
    { iconKey: 'Bell', label: 'Berita & Prestasi', path: '/admin/prestasi' },
    { iconKey: 'Users', label: 'Data Guru', path: '/admin/guru' },
    { iconKey: 'GraduationCap', label: 'Data Murid', path: '/admin/murid' },
    { iconKey: 'BookOpen', label: 'Data Kelas', path: '/admin/kelas' },
    { iconKey: 'ClipboardList', label: 'Mata Pelajaran', path: '/admin/mapel' },
    { iconKey: 'Calendar', label: 'Jadwal Pelajaran', path: '/admin/jadwal' },
    { iconKey: 'Star', label: 'Ekstrakurikuler', path: '/admin/ekskul' },
    { iconKey: 'UserCheck', label: 'Verifikasi PPDB', path: '/admin/ppdb' },
    { iconKey: 'Settings', label: 'Akun & Hak Akses', path: '/admin/hak-akses' },
    { iconKey: 'FileText', label: 'Laporan', path: '/admin/laporan' },
    { iconKey: 'BarChart3', label: 'Absensi Guru', path: '/admin/absensi-guru' },
    { iconKey: 'Shield', label: 'Audit Log', path: '/admin/audit-logs' },
  ],
  kepsek: [
    { iconKey: 'LayoutDashboard', label: 'Dashboard', path: '/kepsek/dashboard' },
    { iconKey: 'Users', label: 'Data Murid & Guru', path: '/kepsek/data' },
    { iconKey: 'UserCheck', label: 'Data PPDB Baru', path: '/kepsek/ppdb' },
    { iconKey: 'BarChart3', label: 'Absensi Guru', path: '/kepsek/absensi-guru' },
    { iconKey: 'ClipboardList', label: 'Laporan Absensi Murid', path: '/kepsek/laporan-absensi' },
    { iconKey: 'FileText', label: 'Laporan Nilai Murid', path: '/kepsek/laporan-nilai' },
    { iconKey: 'FileText', label: 'Pusat Laporan', path: '/kepsek/laporan' },
  ],
  guru: [
    { iconKey: 'LayoutDashboard', label: 'Dashboard', path: '/guru/dashboard' },
    { iconKey: 'Calendar', label: 'Jadwal Mengajar', path: '/guru/jadwal' },
    { iconKey: 'Users', label: 'Data Murid', path: '/guru/murid' },
    { iconKey: 'ClipboardList', label: 'Kelola Absensi', path: '/guru/absensi' },
    { iconKey: 'FileText', label: 'Kelola Nilai', path: '/guru/nilai' },
    { iconKey: 'Calendar', label: 'Riwayat Absensiku', path: '/guru/riwayat-absensi' },
  ],
  wali_kelas: [
    { iconKey: 'LayoutDashboard', label: 'Dashboard', path: '/wali/dashboard' },
    { iconKey: 'Calendar', label: 'Jadwal Mengajar', path: '/guru/jadwal' },
    { iconKey: 'Users', label: 'Data Murid', path: '/guru/murid' },
    { iconKey: 'ClipboardList', label: 'Kelola Absensi', path: '/guru/absensi' },
    { iconKey: 'FileText', label: 'Kelola Nilai', path: '/guru/nilai' },
    { iconKey: 'BarChart3', label: 'Rekap Absensi Kelas', path: '/wali/absensi' },
    { iconKey: 'FileText', label: 'Leger & Validasi Nilai', path: '/wali/nilai' },
    { iconKey: 'BarChart3', label: 'Laporan Kelas', path: '/wali/laporan' },
    { iconKey: 'Star', label: 'Kepribadian & Ekskul', path: '/wali/ekskul' },
  ],
  siswa: [
    { iconKey: 'LayoutDashboard', label: 'Dashboard', path: '/siswa/dashboard' },
    { iconKey: 'Calendar', label: 'Jadwal Pelajaran', path: '/siswa/jadwal' },
    { iconKey: 'ClipboardList', label: 'Riwayat Absensi', path: '/siswa/absensi' },
    { iconKey: 'FileText', label: 'Nilai Pribadi', path: '/siswa/nilai' },
  ],
  calon_siswa: [
    { iconKey: 'LayoutDashboard', label: 'Status Pendaftaran', path: '/calon-siswa/dashboard' },
  ],
};

export function getMenuForRole(role) {
  return menuByRole[role] || [];
}
