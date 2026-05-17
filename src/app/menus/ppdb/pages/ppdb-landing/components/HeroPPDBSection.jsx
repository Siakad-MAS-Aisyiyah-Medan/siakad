import { Link } from 'react-router-dom';
import { ArrowRight, Sparkles } from 'lucide-react';
import { usePpdbContent } from '../context/PpdbContentContext';

export default function HeroPPDBSection() {
  const { content, loading } = usePpdbContent();
  const { title, academicYear, description, heroHighlights } = content;

  return (
    <section className="pp-hero" id="beranda">
      <div className="pp-hero__bg" aria-hidden="true">
        <div className="pp-hero__grid" />
      </div>

      <div className="pp-container pp-hero__layout">
        <div className={`pp-hero__content pp-reveal is-visible ${loading ? 'pp-hero--loading' : ''}`}>
          <span className="pp-badge pp-badge--accent">
            <Sparkles size={14} aria-hidden="true" />
            PPDB Online {academicYear}
          </span>
          <h1 className="pp-hero__title">{title}</h1>
          <p className="pp-hero__subtitle">{description}</p>
          <div className="pp-hero__actions">
            <Link to="/register-calon-murid" className="pp-btn pp-btn--primary pp-btn--lg">
              Daftar Sekarang
              <ArrowRight size={18} aria-hidden="true" />
            </Link>
            <Link to="/login" className="pp-btn pp-btn--outline pp-btn--lg">
              Login Calon Murid
            </Link>
          </div>
        </div>

        <aside
          className={`pp-hero__aside pp-reveal pp-reveal--delay is-visible ${loading ? 'pp-hero--loading' : ''}`}
        >
          <h2 className="pp-hero__aside-title">Informasi Penting</h2>
          <ul className="pp-highlight-list">
            {heroHighlights.map((item) => {
              const Icon = item.icon;
              return (
                <li key={item.text} className="pp-highlight-item">
                  <span className="pp-highlight-item__icon">
                    <Icon size={18} aria-hidden="true" />
                  </span>
                  <span>{item.text}</span>
                </li>
              );
            })}
          </ul>
        </aside>
      </div>
    </section>
  );
}
