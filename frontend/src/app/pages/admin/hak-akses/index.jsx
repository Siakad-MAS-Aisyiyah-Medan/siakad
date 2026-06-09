import React, { useState, useEffect } from 'react';
import { Plus, X } from 'lucide-react';
import Swal from 'sweetalert2';
import AdminPageShell from '@app/shared/components/AdminPageShell';
import { useAuditLogs } from '@app/shared/akademik/audit-logs/hooks/useAuditLogs';
import { fetchAdminAkunList, createAdminAkun } from '@app/shared/services/akun.service';

export default function HakAksesPage() {
  const { items, meta, loading, search, setSearch, action, setAction, reload } = useAuditLogs();
  
  const [akunData, setAkunData] = useState([]);
  const [stats, setStats] = useState({ total_akun: '-', role_aktif: '-' });
  const [isAkunLoading, setIsAkunLoading] = useState(true);

  // Modal State
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [formData, setFormData] = useState({
    name: '',
    username: '',
    email: '',
    password: '',
    role: 'operator'
  });
  const [isSubmitting, setIsSubmitting] = useState(false);

  const loadAkun = async () => {
    setIsAkunLoading(true);
    try {
      const data = await fetchAdminAkunList();
      if (data) {
        setAkunData(data.users || []);
        setStats({
          total_akun: data.total_akun,
          role_aktif: data.role_aktif,
        });
      }
    } catch (error) {
      console.error('Failed to load accounts:', error);
    } finally {
      setIsAkunLoading(false);
    }
  };

  useEffect(() => {
    loadAkun();
  }, []);

  const handleAdd = () => {
    setIsModalOpen(true);
  };

  const handleCloseModal = () => {
    setIsModalOpen(false);
    setFormData({ name: '', username: '', email: '', password: '', role: 'operator' });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setIsSubmitting(true);
    try {
      await createAdminAkun(formData);
      Swal.fire('Sukses', 'Akun baru berhasil ditambahkan', 'success');
      handleCloseModal();
      loadAkun();
    } catch (error) {
      console.error(error);
      Swal.fire('Gagal', 'Terjadi kesalahan saat menambahkan akun. Periksa data Anda.', 'error');
    } finally {
      setIsSubmitting(false);
    }
  };

  return (
    <AdminPageShell>
      {/* Real implementation of Akun List */}
      <div className="data-panel view-list">
        <div className="panel-header glass">
          <div className="header-text">
            <h2>Akun & Hak Akses</h2>
            <p>Kelola role pengguna dan hak akses menu di sistem SIAKAD.</p>
          </div>
          <div className="header-actions">
            <button type="button" onClick={handleAdd} className="btn-primary">
              <Plus size={18} /> Tambah Akun
            </button>
          </div>
        </div>

        <div className="stats-info-grid mt-6">
          <div className="stat-box glass border-blue">
            <div className="stat-content">
              <div className="stat-value">{isAkunLoading ? '...' : stats.total_akun}</div>
              <div className="stat-label">Total Akun</div>
            </div>
          </div>
          <div className="stat-box glass border-green">
            <div className="stat-content">
              <div className="stat-value">{isAkunLoading ? '...' : stats.role_aktif}</div>
              <div className="stat-label">Role Aktif</div>
            </div>
          </div>
        </div>

        <div className="table-container glass mt-6">
          <table className="data-table">
            <thead>
              <tr>
                <th>No</th>
                <th>Username</th>
                <th>Role</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              {isAkunLoading ? (
                <tr>
                  <td colSpan="5" className="text-center p-6">Memuat data akun...</td>
                </tr>
              ) : akunData.length > 0 ? (
                akunData.map((akun, index) => (
                  <tr key={akun.id}>
                    <td>{index + 1}</td>
                    <td className="font-medium">{akun.username}</td>
                    <td>
                      <span className="badge badge-success" style={{ background: 'var(--color-primary-soft)', color: 'var(--color-primary-dark)' }}>
                        {akun.role.replace('_', ' ').toUpperCase()}
                      </span>
                    </td>
                    <td>
                      <span className={`badge ${akun.status === 'aktif' ? 'badge-success' : 'badge-pending'}`}>
                        {akun.status === 'aktif' ? 'Aktif' : 'Nonaktif'}
                      </span>
                    </td>
                    <td>
                      <button className="btn-outline" style={{ padding: '0.25rem 0.5rem', fontSize: '0.75rem' }} onClick={() => Swal.fire('Info', 'Fitur edit akun sedang dalam pengembangan', 'info')}>
                        Edit
                      </button>
                    </td>
                  </tr>
                ))
              ) : (
                <tr>
                  <td colSpan="5" className="text-center p-6 text-secondary">Belum ada data akun</td>
                </tr>
              )}
            </tbody>
          </table>
        </div>
      </div>

      {isModalOpen && (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
          <div className="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in-95 duration-200">
            <div className="flex justify-between items-center p-6 border-b border-slate-100">
              <h3 className="text-lg font-bold text-slate-800">Tambah Akun Baru</h3>
              <button onClick={handleCloseModal} className="text-slate-400 hover:text-slate-600 transition-colors">
                <X size={20} />
              </button>
            </div>
            <form onSubmit={handleSubmit} className="p-6">
              <div className="space-y-4">
                <div>
                  <label className="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                  <input type="text" required className="form-input w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none" value={formData.name} onChange={(e) => setFormData({...formData, name: e.target.value})} placeholder="Masukkan nama..." />
                </div>
                <div>
                  <label className="block text-sm font-semibold text-slate-700 mb-1">Username</label>
                  <input type="text" required className="form-input w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none" value={formData.username} onChange={(e) => setFormData({...formData, username: e.target.value})} placeholder="Masukkan username..." />
                </div>
                <div>
                  <label className="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                  <input type="email" required className="form-input w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none" value={formData.email} onChange={(e) => setFormData({...formData, email: e.target.value})} placeholder="Masukkan email..." />
                </div>
                <div>
                  <label className="block text-sm font-semibold text-slate-700 mb-1">Password</label>
                  <input type="password" required minLength="6" className="form-input w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none" value={formData.password} onChange={(e) => setFormData({...formData, password: e.target.value})} placeholder="Minimal 6 karakter" />
                </div>
                <div>
                  <label className="block text-sm font-semibold text-slate-700 mb-1">Role</label>
                  <select className="form-input w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none" value={formData.role} onChange={(e) => setFormData({...formData, role: e.target.value})}>
                    <option value="admin">Admin</option>
                    <option value="operator">Operator</option>
                    <option value="kepsek">Kepala Sekolah</option>
                    <option value="guru">Guru</option>
                    <option value="wali_kelas">Wali Kelas</option>
                    <option value="siswa">Siswa</option>
                    <option value="calon_siswa">Calon Siswa</option>
                  </select>
                </div>
              </div>
              <div className="mt-8 flex justify-end gap-3">
                <button type="button" onClick={handleCloseModal} className="px-4 py-2 text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg font-medium transition-colors">Batal</button>
                <button type="submit" disabled={isSubmitting} className="px-4 py-2 text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg font-medium transition-colors flex items-center gap-2">
                  {isSubmitting ? 'Menyimpan...' : 'Simpan Akun'}
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </AdminPageShell>
  );
}
