export default function InputLabel({
    value,
    className = '',
    children,
    ...props
}) {
    return (
        <label
            {...props}
            className={
                `block text-sm font-medium ` +
                className
            }
            style={{ color: '#B8B8D0' }}
        >
            {value ? value : children}
        </label>
    );
}
