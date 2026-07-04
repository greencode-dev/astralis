import { Search } from 'lucide-react';

export default function SearchBar({ value, onChange, placeholder = 'Cerca...' }) {
    return (
        <div className="relative">
            <Search
                className="absolute left-3 top-1/2 -translate-y-1/2"
                size={18}
                style={{ color: '#7A7A9A' }}
            />
            <input
                type="text"
                value={value}
                onChange={e => onChange(e.target.value)}
                placeholder={placeholder}
                className="w-full pl-10 pr-4 py-2.5 rounded-lg text-sm outline-none transition-all duration-200"
                style={{
                    backgroundColor: '#111128',
                    color: '#F0F0FA',
                    border: '1px solid rgba(34, 211, 238, 0.15)',
                }}
                onFocus={e => e.target.style.borderColor = 'rgba(34, 211, 238, 0.5)'}
                onBlur={e => e.target.style.borderColor = 'rgba(34, 211, 238, 0.15)'}
            />
        </div>
    );
}