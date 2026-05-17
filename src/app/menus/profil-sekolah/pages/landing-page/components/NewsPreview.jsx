import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { ArrowRight, Search } from 'lucide-react';
import SectionHeader from './SectionHeader';
import { NEWS_DATA } from '../data/landingData';

export default function NewsPreview() {
  const navigate = useNavigate();
  const [searchQuery, setSearchQuery] = useState('');

  const filtered = NEWS_DATA.filter((item) =>
    item.title.toLowerCase().includes(searchQuery.toLowerCase()),
  );

  return (
    <section id="berita" className="lp-section lp-section--soft">
      <div className="lp-container">
        <SectionHeader
          eyebrow="Berita & Prestasi"
          title="Kabar Terbaru dari Sekolah"
          subtitle="Informasi kegiatan, prestasi siswa, dan perkembangan madrasah."
        />

        <div className="lp-search lp-reveal">
          <Search size={18} aria-hidden="true" />
          <input
            type="search"
            placeholder="Cari berita atau prestasi..."
            value={searchQuery}
            onChange={(e) => setSearchQuery(e.target.value)}
            aria-label="Cari berita"
          />
        </div>

        <div className="lp-news-grid">
          {filtered.map((news) => {
            const Icon = news.image;
            return (
              <article key={news.id} className="lp-card lp-news-card lp-reveal">
                <div className="lp-news-card__thumb">
                  <Icon size={48} strokeWidth={1.5} aria-hidden="true" />
                </div>
                <div className="lp-news-card__body">
                  <div className="lp-news-card__meta">
                    <span className="lp-tag">{news.category}</span>
                    <time dateTime={news.date}>{news.date}</time>
                  </div>
                  <h3>{news.title}</h3>
                  <p>{news.excerpt}</p>
                  <button
                    type="button"
                    className="lp-link-btn"
                    onClick={() => navigate(`/berita-prestasi/${news.id}`)}
                  >
                    Baca Selengkapnya
                    <ArrowRight size={16} aria-hidden="true" />
                  </button>
                </div>
              </article>
            );
          })}
        </div>

        {filtered.length === 0 && (
          <p className="lp-empty-state">Tidak ada berita yang cocok dengan pencarian Anda.</p>
        )}
      </div>
    </section>
  );
}
