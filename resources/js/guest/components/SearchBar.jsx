import { useState, memo } from 'react';
import { Search } from 'lucide-react';

export default memo(function SearchBar({ value, onChange, placeholder = 'Cerca...' }) {
    const [focused, setFocused] = useState(false);

    return (
        <div className="relative">
            <Search
                className="absolute left-3 top-1/2 -translate-y-1/2 text-admin-muted"
                size={18}
            />
            <input
                type="text"
                value={value}
                onChange={e => onChange(e.target.value)}
                placeholder={placeholder}
                className={`w-full pl-10 pr-4 py-2.5 rounded-lg text-sm outline-none transition-all duration-200 bg-admin-card text-admin-text border ${focused ? 'border-admin-primary/50' : 'border-admin-primary/15'}`}
                onFocus={() => setFocused(true)}
                onBlur={() => setFocused(false)}
            />
        </div>
    );
});
