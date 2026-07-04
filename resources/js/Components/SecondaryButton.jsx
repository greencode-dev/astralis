export default function SecondaryButton({
    type = 'button',
    className = '',
    disabled,
    children,
    ...props
}) {
    return (
        <button
            {...props}
            type={type}
            className={
                `inline-flex items-center rounded-lg px-4 py-2 text-xs font-semibold uppercase tracking-widest transition-all duration-200 ${
                    disabled && 'opacity-25'
                } ` + className
            }
            style={{
                backgroundColor: '#111128',
                border: '1px solid rgba(34, 211, 238, 0.2)',
                color: '#B8B8D0',
            }}
            onMouseEnter={e => { if (!disabled) { e.target.style.borderColor = 'rgba(34, 211, 238, 0.4)'; e.target.style.color = '#22D3EE'; }}}
            onMouseLeave={e => { if (!disabled) { e.target.style.borderColor = 'rgba(34, 211, 238, 0.2)'; e.target.style.color = '#B8B8D0'; }}}
            disabled={disabled}
        >
            {children}
        </button>
    );
}
