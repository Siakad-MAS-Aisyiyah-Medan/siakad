import { Navigate, Route } from 'react-router-dom';
import { PermissionRoute, RoleRoute } from '@app/shared/components/ProtectedRoute';
import InformasiPendaftaran from './pages/InformasiPendaftaran';
import RegisterCalonMurid from './pages/RegisterCalonMurid';
import DashboardCalonMurid from './pages/DashboardCalonMurid';
import FormulirPendaftaran from './pages/FormulirPendaftaran';
import UploadBerkas from './pages/UploadBerkas';
import StatusPendaftaran from './pages/StatusPendaftaran';
import BuktiPendaftaran from './pages/BuktiPendaftaran';
import AdminDaftarPendaftar from './pages/AdminDaftarPendaftar';
import AdminDetailPendaftar from './pages/AdminDetailPendaftar';
import AdminVerifikasiPendaftar from './pages/AdminVerifikasiPendaftar';

export const ppdbPublicRoutes = (
  <>
    <Route path="/pendaftaran" element={<InformasiPendaftaran />} />
    <Route path="/register-calon-murid" element={<RegisterCalonMurid />} />
    {/* Legacy redirects */}
    <Route path="/ppdb/info" element={<Navigate to="/pendaftaran" replace />} />
    <Route path="/ppdb/daftar" element={<Navigate to="/register-calon-murid" replace />} />
    <Route path="/register" element={<Navigate to="/register-calon-murid" replace />} />
  </>
);

export const ppdbCalonRoutes = (
  <>
    <Route
      path="/calon-murid/dashboard"
      element={
        <RoleRoute allowedRoles={['calon_siswa']}>
          <DashboardCalonMurid />
        </RoleRoute>
      }
    />
    <Route
      path="/calon-murid/formulir"
      element={
        <RoleRoute allowedRoles={['calon_siswa']}>
          <FormulirPendaftaran />
        </RoleRoute>
      }
    />
    <Route
      path="/calon-murid/berkas"
      element={
        <RoleRoute allowedRoles={['calon_siswa']}>
          <UploadBerkas />
        </RoleRoute>
      }
    />
    <Route
      path="/calon-murid/status"
      element={
        <RoleRoute allowedRoles={['calon_siswa']}>
          <StatusPendaftaran />
        </RoleRoute>
      }
    />
    <Route
      path="/calon-murid/bukti"
      element={
        <RoleRoute allowedRoles={['calon_siswa']}>
          <BuktiPendaftaran />
        </RoleRoute>
      }
    />
    <Route path="/ppdb/dashboard" element={<Navigate to="/calon-murid/dashboard" replace />} />
    <Route path="/ppdb/formulir" element={<Navigate to="/calon-murid/formulir" replace />} />
    <Route path="/ppdb/berkas" element={<Navigate to="/calon-murid/berkas" replace />} />
    <Route path="/ppdb/status" element={<Navigate to="/calon-murid/status" replace />} />
    <Route path="/ppdb/bukti" element={<Navigate to="/calon-murid/bukti" replace />} />
    <Route path="/calon-siswa/dashboard" element={<Navigate to="/calon-murid/dashboard" replace />} />
  </>
);

export const ppdbAdminRoutes = (
  <>
    <Route
      path="/admin/ppdb"
      element={
        <PermissionRoute permission="manage_ppdb">
          <AdminDaftarPendaftar />
        </PermissionRoute>
      }
    />
    <Route
      path="/admin/ppdb/:id"
      element={
        <PermissionRoute permission="manage_ppdb">
          <AdminDetailPendaftar />
        </PermissionRoute>
      }
    />
    <Route
      path="/admin/ppdb/:id/verifikasi"
      element={
        <PermissionRoute permission="manage_ppdb">
          <AdminVerifikasiPendaftar />
        </PermissionRoute>
      }
    />
  </>
);
