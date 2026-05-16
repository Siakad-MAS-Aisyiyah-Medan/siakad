import AdminPageShell from '../../../shared/components/AdminPageShell';
import PrestasiTable from './components/PrestasiTable';
import PrestasiForm from './components/PrestasiForm';
import { usePrestasi } from './hooks/usePrestasi';

export default function PrestasiPage() {
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
  } = usePrestasi();

  return (
    <AdminPageShell>
      {view === 'list' && (
        <PrestasiTable
          filteredData={filteredData}
          searchQuery={searchQuery}
          onSearchChange={setSearchQuery}
          onAdd={openAdd}
          onEdit={openEdit}
          onDelete={removeItem}
        />
      )}
      {(view === 'add' || view === 'edit') && (
        <PrestasiForm
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
