import { Link, useLocation } from 'react-router-dom';

const navLinks = [
    { path: '/', label: 'Home' },
    { path: '/corpi-celesti', label: 'Corpi Celesti' },
];

export default function Navbar() {
    const location = useLocation();

    return (
        <nav className="bg-admin-card border-b border-admin-primary/10" aria-label="Navigazione principale">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex items-center justify-between h-16">
                    <Link to="/" className="flex items-center gap-3">
                        <span className="text-2xl">🚀</span>
                        <span className="text-xl font-bold text-admin-primary">Astralis</span>
                    </Link>

                    <div className="flex items-center gap-1">
                        {navLinks.map(link => {
                            const isActive = location.pathname === link.path;
                            return (
                                <Link
                                    key={link.path}
                                    to={link.path}
                                    className={`px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-admin-primary/8 hover:text-admin-primary ${isActive ? 'bg-admin-primary/15 text-admin-primary' : 'text-admin-dim'}`}
                                    aria-current={isActive ? 'page' : undefined}
                                >
                                    {link.label}
                                </Link>
                            );
                        })}
                    </div>
                </div>
            </div>
        </nav>
    );
}
