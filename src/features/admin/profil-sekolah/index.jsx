import Swal from 'sweetalert2';
import AdminPageShell from '../../../shared/components/AdminPageShell';
import AdminModulePlaceholder from '../../../shared/components/AdminModulePlaceholder';
import AppLogo from '../../../shared/components/AppLogo';

export default function ProfilSekolahPage() {
  const handleAdd = () => {
    Swal.fire('Info', 'Editor profil sekolah akan tersedia pada update berikutnya.', 'info');
  };

  return (
    <AdminPageShell>
      <div className="profil-sekolah-brand">
        <AppLogo size="xl" />
        <div>
          <h2>MAS Aisyiyah Medan</h2>
          <p>Profil dan informasi publik madrasah</p>
        </div>
      </div>
      <AdminModulePlaceholder
        title="Pengelolaan Profil Sekolah"
        subtitle="Ubah visi, misi, kata sambutan kepala sekolah, dan informasi publik madrasah."
        stats={[
          { label: 'Bagian Profil', value: '4', color: 'blue' },
          { label: 'Terakhir Diubah', value: '-', color: 'purple' },
        ]}
        columns={['No', 'Bagian', 'Status', 'Aksi']}
        emptyMessage="Belum ada konfigurasi profil yang disimpan"
        addLabel="Kelola Profil"
        onAdd={handleAdd}
      />
    </AdminPageShell>
  );
}
