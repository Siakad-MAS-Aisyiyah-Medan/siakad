import AdminPageShell from '@app/shared/components/AdminPageShell';
import GuruTable from '@app/shared/akademik/guru/components/GuruTable';
import GuruForm from '@app/shared/akademik/guru/components/GuruForm';
import { useGuru } from '@app/shared/akademik/guru/hooks/useGuru';
import { useState } from 'react';
import AbsensiGuruView from './AbsensiGuruView';

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
    isFetching,
  } = useGuru();

  const [activeTab, setActiveTab] = useState('data');

  return (
    <AdminPageShell>
      <div className="flex gap-4 mb-6 border-b border-slate-200/50 pb-2">
        <button
          onClick={() => setActiveTab('data')}
          className={`px-4 py-2 font-medium rounded-t-lg transition-colors ${
            activeTab === 'data' 
              ? 'bg-emerald-500 text-white shadow-md shadow-emerald-500/20' 
              : 'text-slate-600 hover:bg-white/50'
          }`}
        >
          Data Guru & Pegawai
        </button>
        <button
          onClick={() => setActiveTab('absensi')}
          className={`px-4 py-2 font-medium rounded-t-lg transition-colors ${
            activeTab === 'absensi' 
              ? 'bg-emerald-500 text-white shadow-md shadow-emerald-500/20' 
              : 'text-slate-600 hover:bg-white/50'
          }`}
        >
          Absensi Guru
        </button>
      </div>

      {activeTab === 'data' && view === 'list' && (
        <GuruTable
          filteredData={filteredData}
          searchQuery={searchQuery}
          onSearchChange={setSearchQuery}
          onAdd={openAdd}
          onEdit={openEdit}
          onDelete={removeGuru}
          isFetching={isFetching}
        />
      )}
      {activeTab === 'data' && (view === 'add' || view === 'edit') && (
        <GuruForm
          view={view}
          formData={formData}
          loading={loading}
          onChange={handleChange}
          onSubmit={submitForm}
          onCancel={cancelForm}
        />
      )}

      {activeTab === 'absensi' && <AbsensiGuruView />}
    </AdminPageShell>
  );
}
