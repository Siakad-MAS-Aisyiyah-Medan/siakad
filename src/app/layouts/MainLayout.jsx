import React from 'react';
import { useNavigate, NavLink } from 'react-router-dom';
import { LogOut } from 'lucide-react';
import Swal from 'sweetalert2';
import { renderMenuIcon } from '../../shared/constants/icons';
import AppLogo from '../../shared/components/AppLogo';
import { ROLE_LABELS } from '../../config/roles.config';
import { logout, getMenuItems } from '../../services/auth.service';

const MainLayout = ({ children, role, name }) => {
  const navigate = useNavigate();
  const menuItems = getMenuItems();

  const handleLogout = () => {
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: 'Anda akan keluar dari sistem!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#198754',
      cancelButtonColor: '#dc3545',
      confirmButtonText: 'Ya, Keluar!',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        logout();
        Swal.fire({
          icon: 'success',
          title: 'Berhasil Logout',
          text: 'Terima kasih telah menggunakan sistem SIAKAD.',
          showConfirmButton: false,
          timer: 1500,
        });
        setTimeout(() => navigate('/'), 1500);
      }
    });
  };

  const roleLabel = ROLE_LABELS[role] || role.replace('_', ' ').toUpperCase();

  return (
    <div className="dashboard-layout">
      <aside className="sidebar">
        <div className="sidebar-brand">
          <AppLogo size="md" variant="sidebar" />
          <span>SIAKAD</span>
        </div>
        <nav className="sidebar-nav">
          {menuItems.map((item, index) => (
            <NavLink
              key={`${item.path}-${index}`}
              to={item.path}
              className={({ isActive }) => `nav-item ${isActive ? 'active' : ''}`}
            >
              {renderMenuIcon(item.iconKey)} {item.label}
            </NavLink>
          ))}
        </nav>
        <button type="button" onClick={handleLogout} className="logout-btn">
          <LogOut size={20} /> Keluar
        </button>
      </aside>

      <main className="dashboard-content">
        <header className="content-header">
          <h1>Sistem Informasi Akademik</h1>
          <div className="user-info">
            <span>
              Halo, <strong>{name}</strong>
            </span>
            <span className="role-badge">{roleLabel}</span>
          </div>
        </header>
        {children}
      </main>
    </div>
  );
};

export default MainLayout;
