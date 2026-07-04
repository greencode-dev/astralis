import { Link } from '@inertiajs/react';

export default function ResponsiveNavLink({
    active = false,
    className = '',
    children,
    ...props
}) {
    return (
        <Link
            {...props}
            className={`flex w-full items-start border-l-4 py-2 pe-4 ps-3 ${
                active
                    ? 'border-[#22D3EE] bg-[#1A1A3E] text-[#22D3EE] focus:border-[#1BB8D1] focus:bg-[#1A1A3E] focus:text-[#1BB8D1]'
                    : 'border-transparent text-[#B8B8D0] hover:border-[#242450] hover:bg-[#1A1A3E] hover:text-[#F0F0FA] focus:border-[#242450] focus:bg-[#1A1A3E] focus:text-[#F0F0FA]'
            } text-base font-medium transition duration-150 ease-in-out focus:outline-none ${className}`}
        >
            {children}
        </Link>
    );
}
