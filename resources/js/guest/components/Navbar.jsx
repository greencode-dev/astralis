import { useState } from 'react';
import { Link, useLocation } from 'react-router-dom';
import { Menu, X } from 'lucide-react';

const navLinks = [
    { path: "/", label: "Home" },
    { path: "/corpi-celesti", label: "Corpi Celesti" },
];

export default function Navbar() {
    const location = useLocation();
    const [open, setOpen] = useState(false);

    return (
        <nav
            className="border-b bg-admin-card border-admin-primary/10"
            aria-label="Navigazione principale"
        >
            <div className="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div className="flex items-center justify-between h-16">
                    <Link to="/" className="flex items-center gap-3">
                        <img src="/favicon.svg" alt="Astralis" className="w-10 h-10" />
                        <span className="text-xl font-bold font-orbitron text-admin-primary">
                            Astralis
                        </span>
                    </Link>

                    <button
                        className="md:hidden p-2 rounded-lg text-admin-dim hover:text-admin-primary hover:bg-admin-primary/10 transition-colors"
                        onClick={() => setOpen(!open)}
                        aria-expanded={open}
                        aria-controls="mobile-nav"
                        aria-label={open ? 'Chiudi menu' : 'Apri menu'}
                    >
                        {open ? <X size={22} /> : <Menu size={22} />}
                    </button>

                    <div className="hidden md:flex items-center gap-1">
                        {navLinks.map((link) => {
                            const isActive = location.pathname === link.path;
                            return (
                                <Link
                                    key={link.path}
                                    to={link.path}
                                    className={`px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-admin-primary/8 hover:text-admin-primary ${isActive ? "bg-admin-primary/15 text-admin-primary" : "text-admin-dim"}`}
                                    aria-current={isActive ? "page" : undefined}
                                >
                                    {link.label}
                                </Link>
                            );
                        })}
                    </div>
                </div>

                {open && (
                    <div id="mobile-nav" className="md:hidden pb-4 space-y-1">
                        {navLinks.map((link) => {
                            const isActive = location.pathname === link.path;
                            return (
                                <Link
                                    key={link.path}
                                    to={link.path}
                                    onClick={() => setOpen(false)}
                                    className={`block px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-admin-primary/8 hover:text-admin-primary ${isActive ? "bg-admin-primary/15 text-admin-primary" : "text-admin-dim"}`}
                                    aria-current={isActive ? "page" : undefined}
                                >
                                    {link.label}
                                </Link>
                            );
                        })}
                    </div>
                )}
            </div>
        </nav>
    );
}
