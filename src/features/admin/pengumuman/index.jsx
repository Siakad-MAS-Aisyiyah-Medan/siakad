import AdminPageShell from '../../../shared/components/AdminPageShell';
import PengumumanTable from './components/PengumumanTable';
import PengumumanForm from './components/PengumumanForm';
import { usePengumuman } from './hooks/usePengumuman';

export default function PengumumanPage() {
  const {
    view,
    searchQuery,
    setSearchQuery,
    filteredData,
    formData,
    loading,
    openAdd,
    openEdit,
    cancelForm,
    handleChange,
    submitForm,
    removeItem,
  } = usePengumuman();

  return (
    <AdminPageShell>
      {view === 'list' && (
        <PengumumanTable
          filteredData={filteredData}
          searchQuery={searchQuery}
          onSearchChange={setSearchQuery}
          onAdd={openAdd}
          onEdit={openEdit}
          onDelete={removeItem}
        />
      )}
      {(view === 'add' || view === 'edit') && (
        <PengumumanForm
          view={view}
          formData={formData}
          loading={loading}
          onChange={handleChange}
          onSubmit={submitForm}
          onCancel={cancelForm}
        />
      )}
    </AdminPageShell>
  );
}
