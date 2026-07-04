export default function ApplicationLogo(props) {
    return (
        <span
            {...props}
            className={'font-bold tracking-tight ' + (props.className || '')}
            style={{ color: '#22D3EE' }}
        >
            Astralis
        </span>
    );
}
