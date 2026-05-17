import { Navigate, Route } from 'react-router-dom';
import LandingPage from '@app/menus/profil-sekolah/pages/landing-page';
import NewsDetail from '@app/menus/profil-sekolah/pages/news-detail';
import { ppdbPublicRoutes } from '@app/menus/ppdb/routes';

export const publicRoutes = (
  <>
    <Route path="/" element={<Navigate to="/home" replace />} />
    <Route path="/home" element={<LandingPage />} />
    <Route path="/profil-sekolah" element={<LandingPage />} />
    <Route path="/berita-prestasi/:id" element={<NewsDetail />} />
    <Route path="/news/:id" element={<NewsDetail />} />
    {ppdbPublicRoutes}
  </>
);
