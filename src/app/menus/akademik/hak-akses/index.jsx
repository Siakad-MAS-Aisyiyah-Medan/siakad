import Swal from 'sweetalert2';
import AdminPageShell from '@app/shared/components/AdminPageShell';
import AdminModulePlaceholder from '@app/shared/components/AdminModulePlaceholder';

export default function HakAksesPage() {
  const handleAdd = () => {
    Swal.fire('Info', 'Manajemen role akan diintegrasikan dengan backend.', 'info');
  };

  return (
    <AdminPageShell>
      <AdminModulePlaceholder
        title="Akun & Hak Akses"
        subtitle="Kelola role pengguna dan hak akses menu di sistem SIAKAD."
        stats={[
          { label: 'Total Akun', value: '-', color: 'blue' },
          { label: 'Role Aktif', value: '6', color: 'green' },
        ]}
        columns={['No', 'Username', 'Role', 'Status', 'Aksi']}
        emptyMessage="Belum ada data akun ditampilkan"
        addLabel="Tambah Akun"
        onAdd={handleAdd}
      />
    </AdminPageShell>
  );
}
