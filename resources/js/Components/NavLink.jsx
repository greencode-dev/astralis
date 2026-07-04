import { Link } from '@inertiajs/react';

export default function NavLink({
    active = false,
    className = '',
    children,
    ...props
}) {
    return (
        <Link
            {...props}
            className={
                'inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none ' +
                (active
                    ? 'border-[#22D3EE] text-[#F0F0FA] focus:border-[#1BB8D1]'
                    : 'border-transparent text-[#B8B8D0] hover:border-[#242450] hover:text-[#F0F0FA] focus:border-[#242450] focus:text-[#F0F0FA]') +
                className
            }
        >
            {children}
        </Link>
    );
}
