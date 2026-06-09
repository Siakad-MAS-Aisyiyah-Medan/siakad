import React, { useState, useEffect } from 'react';
import AdminPageShell from '@app/shared/components/AdminPageShell';
import { 
    Users, GraduationCap, ClipboardList, BookOpen, 
    Bell, Star, History, AlertCircle 
} from 'lucide-react';
import { fetchAdminDashboardStats } from '@app/shared/services/dashboard.service';

export default function AdminDashboard() {
    const [realStats, setRealStats] = useState({
        total_guru: 0,
        total_murid: 0,
        total_mapel: 0,
        total_kelas: 0,
    });
    const [auditLogs, setAuditLogs] = useState([]);
    const [isLoading, setIsLoading] = useState(true);

    useEffect(() => {
        const loadDashboardData = async () => {
            try {
                const data = await fetchAdminDashboardStats();
                if (data) {
                    setRealStats(data.stats);
                    setAuditLogs(data.audit_logs || []);
                }
            } catch (error) {
                console.error('Failed to fetch dashboard stats', error);
            } finally {
                setIsLoading(false);
            }
        };

        loadDashboardData();
    }, []);

    const stats = [
        { label: 'Total Guru', value: realStats.total_guru, icon: <Users />, color: 'blue' },
        { label: 'Total Murid', value: realStats.total_murid, icon: <GraduationCap />, color: 'green' },
        { label: 'Mata Pelajaran', value: realStats.total_mapel, icon: <ClipboardList />, color: 'purple' },
        { label: 'Total Kelas', value: realStats.total_kelas, icon: <BookOpen />, color: 'orange' },
    ];

    return (
        <AdminPageShell>
            <div className="admin-dashboard-wrapper animate-fade-in">
                {/* 1. STATISTIK ATAU INFO BOX */}
                <div className="stats-info-grid">
                    {stats.map((stat, index) => (
                        <div key={index} className={`stat-box glass border-${stat.color}`}>
                            <div className="stat-content">
                                <div className="stat-value">
                                    {isLoading ? (
                                        <div style={{ width: '30px', height: '30px', border: '3px solid #e2e8f0', borderTopColor: 'var(--color-primary)', borderRadius: '50%', animation: 'spin 1s linear infinite' }} />
                                    ) : (
                                        stat.value
                                    )}
                                </div>
                                <div className="stat-label">{stat.label}</div>
                            </div>
                            <div className={`stat-icon bg-${stat.color}`}>
                                {stat.icon}
                            </div>
                        </div>
                    ))}
                </div>


            </div>
        </AdminPageShell>
    );
}

