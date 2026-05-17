import AdminPageShell from '@app/shared/components/AdminPageShell';
import GuruTable from './components/GuruTable';
import GuruForm from './components/GuruForm';
import { useGuru } from './hooks/useGuru';

export default function GuruPage() {
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
    removeGuru,
  } = useGuru();

  return (
    <AdminPageShell>
      {view === 'list' && (
        <GuruTable
          filteredData={filteredData}
          searchQuery={searchQuery}
          onSearchChange={setSearchQuery}
          onAdd={openAdd}
          onEdit={openEdit}
          onDelete={removeGuru}
        />
      )}
      {(view === 'add' || view === 'edit') && (
        <GuruForm
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
