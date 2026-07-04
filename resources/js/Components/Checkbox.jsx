export default function Checkbox({ className = '', ...props }) {
    return (
        <input
            {...props}
            type="checkbox"
            className={
                'rounded border-[#242450] bg-[#0A0A1A] text-[#22D3EE] shadow-sm focus:ring-[#22D3EE] ' +
                className
            }
        />
    );
}
