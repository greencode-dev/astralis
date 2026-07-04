import { Link, useLocation } from 'react-router-dom';

const navLinks = [
    { path: '/', label: 'Home' },
    { path: '/corpi-celesti', label: 'Corpi Celesti' },
];

export default function Navbar() {
    const location = useLocation();

    return (
        <nav style={{ backgroundColor: '#111128', borderBottom: '1px solid rgba(34, 211, 238, 0.1)' }}>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex items-center justify-between h-16">
                    <Link to="/" className="flex items-center gap-3">
                        <span className="text-2xl">🚀</span>
                        <span className="text-xl font-bold" style={{ color: '#22D3EE' }}>Astralis</span>
                    </Link>

                    <div className="flex items-center gap-1">
                        {navLinks.map(link => {
                            const isActive = location.pathname === link.path;
                            return (
                                <Link
                                    key={link.path}
                                    to={link.path}
                                    className="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200"
                                    style={{
                                        backgroundColor: isActive ? 'rgba(34, 211, 238, 0.15)' : 'transparent',
                                        color: isActive ? '#22D3EE' : '#B8B8D0',
                                    }}
                                    onMouseEnter={e => {
                                        if (!isActive) {
                                            e.target.style.backgroundColor = 'rgba(34, 211, 238, 0.08)';
                                            e.target.style.color = '#22D3EE';
                                        }
                                    }}
                                    onMouseLeave={e => {
                                        if (!isActive) {
                                            e.target.style.backgroundColor = 'transparent';
                                            e.target.style.color = '#B8B8D0';
                                        }
                                    }}
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