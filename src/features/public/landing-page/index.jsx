import React, { useState } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import { getToken } from '../../../services/auth.service';
import { 
    School, MapPin, Award, Book, Users, Star, 
    ArrowRight, CheckCircle, Search, ArrowLeft 
} from 'lucide-react';
import AppLogo from '../../../shared/components/AppLogo';

const LandingPage = () => {
    const navigate = useNavigate();
    const token = getToken();
    const [searchQuery, setSearchQuery] = useState('');

    const scrollToSection = (id) => {
        const element = document.getElementById(id);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
        }
    };

    const handlePendaftaranClick = () => {
        if (token) navigate('/dashboard'); else navigate('/');
    };

    // Dummy Data for Logic
    const newsData = [
        { id: 1, title: 'Juara 1 Lomba MTK Nasional', date: '12 April 2026', image: <Award size={64}/>, excerpt: 'Siswa MAS Aisyiyah meraih prestasi membanggakan...' },
        { id: 2, title: 'Kegiatan Bakti Sosial 2026', date: '10 April 2026', image: <Users size={64}/>, excerpt: 'Seluruh siswa berpartisipasi dalam agenda tahunan...' },
        { id: 3, title: 'Peresmian Laboratorium Baru', date: '05 April 2026', image: <Book size={64}/>, excerpt: 'Fasilitas baru untuk mendukung praktik sains...' },
    ];

    const ekskulData = [
        { name: 'Pramuka', desc: 'Melatih kedisiplinan dan kemandirian siswa melalui kegiatan kepanduan.', icon: <Award /> },
        { name: 'PMR', desc: 'Siswa dilatih untuk sigap dalam memberikan pertolongan pertama.', icon: <Heart /> },
        { name: 'Seni Tari', desc: 'Melestarikan budaya melalui tarian tradisional dan kreasi.', icon: <Star /> },
    ];

    return (
        <div className="landing-container">
            {/* Header / Navbar */}
            <header className="landing-navbar glass animate-fade-in">
                <div className="nav-logo">
                    <AppLogo size="sm" variant="navbar" />
                    <div>
                        <h1>Madrasah Aliyah</h1>
                        <span>Aisyiyah Medan</span>
                    </div>
                </div>
                <nav className="nav-menu">
                    <button onClick={() => scrollToSection('home')}>Beranda</button>
                    <button onClick={() => scrollToSection('profil')}>Profil Sekolah</button>
                    <button onClick={() => scrollToSection('berita')}>Berita & Prestasi</button>
                    <button onClick={() => scrollToSection('ekskul')}>Ekstrakurikuler</button>
                </nav>
                <div className="nav-actions">
                    <Link to="/" className="btn-secondary">Login</Link>
                    <button onClick={handlePendaftaranClick} className="btn-primary">Pendaftaran</button>
                </div>
            </header>

            {/* HERO SECTION */}
            <section id="home" className="hero-section main-hero">
                <div className="hero-content">
                    <span className="badge">Selamat Datang di Website Resmi</span>
                    <h1>MAS Aisyiyah Medan</h1>
                    <p>Membentuk generasi islami yang unggul dalam IPTEK dan berakhlakul karimah.</p>
                    <div className="hero-btns">
                        <button onClick={handlePendaftaranClick} className="btn-primary lg">Mulai Pendaftaran</button>
                    </div>
                </div>
                <div className="hero-image main-image glass">
                   <div className="hero-placeholder">
                        <AppLogo size="xl" className="hero-school-logo" />
                        <p>MAS Aisyiyah Medan</p>
                   </div>
                </div>
            </section>

            {/* PROFIL SECTION */}
            <section id="profil" className="landing-section">
                <div className="sambutan-container glass animate-fade-in">
                    <div className="sambutan-grid">
                        <div className="kepsek-photo glass">
                            <Users size={120} />
                            <span>Kepala Sekolah</span>
                        </div>
                        <div className="sambutan-text">
                            <h2>Kata Sambutan Kepala Sekolah</h2>
                            <p>"Assalamu'alaikum Warahmatullahi Wabarakatuh. Selamat datang di MAS Aisyiyah Medan. Kami berkomitmen untuk memberikan pendidikan terbaik bagi putra-putri Anda, menggabungkan kurikulum nasional dengan nilai-nilai keislaman yang kuat."</p>
                            <strong>- Dr. H. Budi Santoso</strong>
                        </div>
                    </div>
                </div>

                <div className="visi-misi-grid">
                    <div className="visi-box glass">
                        <h3>Visi</h3>
                        <p>"Menjadi lembaga pendidikan Islam yang unggul, kompetitif, dan berkarakter mulia."</p>
                    </div>
                    <div className="misi-box glass">
                        <h3>Misi</h3>
                        <ul>
                            <li>Menyelenggarakan pendidikan berbasis IT dan Islam.</li>
                            <li>Mengembangkan potensi bakat dan minat siswa.</li>
                            <li>Membangun lingkungan sekolah yang religius.</li>
                        </ul>
                    </div>
                </div>
            </section>

            {/* BERITA SECTION */}
            <section id="berita" className="landing-section">
                <div className="section-header-centered">
                    <h2>Berita & Prestasi</h2>
                    <div className="search-bar glass">
                        <Search size={20} />
                        <input 
                            type="text" 
                            placeholder="Cari berita atau prestasi..." 
                            value={searchQuery}
                            onChange={(e) => setSearchQuery(e.target.value)}
                        />
                    </div>
                </div>

                <div className="news-grid">
                    {newsData.filter(n => n.title.toLowerCase().includes(searchQuery.toLowerCase())).map((news) => (
                        <div key={news.id} className="news-card glass">
                            <div className="news-image">
                                {news.image}
                            </div>
                            <div className="news-body">
                                <span className="news-date">{news.date}</span>
                                <h4>{news.title}</h4>
                                <p>{news.excerpt}</p>
                                <button onClick={() => navigate(`/news/${news.id}`)} className="read-more">
                                    Baca Selengkapnya <ArrowRight size={16} />
                                </button>
                            </div>
                        </div>
                    ))}
                </div>
            </section>

            {/* EKSKUL SECTION */}
            <section id="ekskul" className="landing-section">
                <div className="section-header-centered">
                    <h2>Ekstrakurikuler</h2>
                    <p>Wadah kreativitas dan pengembangan diri siswa.</p>
                </div>
                <div className="ekskul-list">
                    {ekskulData.map((ekskul, index) => (
                        <div key={index} className="ekskul-item glass">
                            <div className="ekskul-img-box glass">
                                {ekskul.icon}
                            </div>
                            <div className="ekskul-info">
                                <h3>{ekskul.name}</h3>
                                <p>{ekskul.desc}</p>
                            </div>
                        </div>
                    ))}
                </div>
            </section>
        </div>
    );
};

// Helper components for icons not imported
const Heart = () => <Award className="text-red-500" />;

export default LandingPage;

