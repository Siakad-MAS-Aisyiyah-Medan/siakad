import { useState } from 'react';
import { Link } from 'react-router-dom';
import { Menu, X } from 'lucide-react';
import AppLogo from '@app/shared/components/AppLogo';
import { usePpdbContent } from '../context/PpdbContentContext';

export default function PpdbNavbar() {
  const { content } = usePpdbContent();
  const [menuOpen, setMenuOpen] = useState(false);

  return (
    <>
      <header className="pp-navbar" role="banner">
        <div className="pp-container pp-navbar__inner">
          <Link to="/home" className="pp-navbar__brand" aria-label="Beranda sekolah">
            <AppLogo size="sm" variant="navbar" />
            <div className="pp-navbar__brand-text">
              <span className="pp-navbar__brand-title">{content.schoolName}</span>
              <span className="pp-navbar__brand-sub">PPDB Online {content.academicYear}</span>
            </div>
          </Link>

          <nav className="pp-navbar__menu" aria-label="Navigasi PPDB">
            <a href="#periode">Periode</a>
            <a href="#syarat">Syarat</a>
            <a href="#alur">Alur</a>
            <a href="#kontak">Kontak</a>
          </nav>

          <div className="pp-navbar__actions">
            <Link to="/login" className="pp-btn pp-btn--ghost">
              Login
            </Link>
            <Link to="/register-calon-murid" className="pp-btn pp-btn--primary">
              Daftar Sekarang
            </Link>
            <button
              type="button"
              className="pp-navbar__toggle"
              onClick={() => setMenuOpen((v) => !v)}
              aria-expanded={menuOpen}
              aria-label={menuOpen ? 'Tutup menu' : 'Buka menu'}
            >
              {menuOpen ? <X size={22} /> : <Menu size={22} />}
            </button>
          </div>
        </div>
      </header>

      <div className={`pp-mobile-drawer ${menuOpen ? 'is-open' : ''}`} aria-hidden={!menuOpen}>
        <nav className="pp-mobile-drawer__nav">
          <a href="#periode" onClick={() => setMenuOpen(false)}>Periode</a>
          <a href="#syarat" onClick={() => setMenuOpen(false)}>Syarat</a>
          <a href="#alur" onClick={() => setMenuOpen(false)}>Alur</a>
          <a href="#kontak" onClick={() => setMenuOpen(false)}>Kontak</a>
          <div className="pp-mobile-drawer__actions">
            <Link to="/login" className="pp-btn pp-btn--outline pp-btn--block" onClick={() => setMenuOpen(false)}>
              Login Calon Murid
            </Link>
            <Link
              to="/register-calon-murid"
              className="pp-btn pp-btn--primary pp-btn--block"
              onClick={() => setMenuOpen(false)}
            >
              Daftar Sekarang
            </Link>
          </div>
        </nav>
      </div>

      {menuOpen && (
        <button
          type="button"
          className="pp-mobile-backdrop"
          aria-label="Tutup menu"
          onClick={() => setMenuOpen(false)}
        />
      )}
    </>
  );
}
