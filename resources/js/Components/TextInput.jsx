import { forwardRef, useEffect, useImperativeHandle, useRef } from 'react';

export default forwardRef(function TextInput(
    { type = 'text', className = '', isFocused = false, ...props },
    ref,
) {
    const localRef = useRef(null);

    useImperativeHandle(ref, () => ({
        focus: () => localRef.current?.focus(),
    }));

    useEffect(() => {
        if (isFocused) {
            localRef.current?.focus();
        }
    }, [isFocused]);

    return (
        <input
            {...props}
            type={type}
            className={
                'rounded-lg border px-3 py-2 text-sm shadow-sm outline-none transition-all duration-200 ' +
                className
            }
            style={{
                backgroundColor: '#0A0A1A',
                borderColor: '#242450',
                color: '#F0F0FA',
            }}
            onFocus={e => { e.target.style.borderColor = '#22D3EE'; e.target.style.boxShadow = '0 0 0 2px rgba(34, 211, 238, 0.15)'; }}
            onBlur={e => { e.target.style.borderColor = '#242450'; e.target.style.boxShadow = 'none'; }}
            ref={localRef}
        />
    );
});
