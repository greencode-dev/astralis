export default function PrimaryButton({
    className = '',
    disabled,
    children,
    ...props
}) {
    return (
        <button
            {...props}
            className={
                `inline-flex items-center rounded-lg px-4 py-2 text-xs font-semibold uppercase tracking-widest transition-all duration-200 ${
                    disabled && 'opacity-40 cursor-not-allowed'
                } ` + className
            }
            style={{
                backgroundColor: '#22D3EE',
                color: '#0A0A1A',
            }}
            onMouseEnter={e => { if (!disabled) e.target.style.backgroundColor = '#1BB8D1'; }}
            onMouseLeave={e => { if (!disabled) e.target.style.backgroundColor = '#22D3EE'; }}
            disabled={disabled}
        >
            {children}
        </button>
    );
}
