export function formatScientific(v) {
    if (v === null || v === undefined || v === '') return '—';
    const num = parseFloat(v);
    if (isNaN(num)) return '—';
    if (num === 0) return '0';
    const exp = Math.floor(Math.log10(Math.abs(num)));
    const mant = num / Math.pow(10, exp);
    return `${mant.toFixed(2)} × 10^${exp}`;
}

export function formatNumber(v) {
    if (v === null || v === undefined || v === '') return '—';
    const num = parseFloat(v);
    if (isNaN(num)) return '—';
    if (num === 0) return '0';
    if (num >= 1e15) return (num / 1e15).toFixed(1) + ' Bil mln km';
    if (num >= 1e12) return (num / 1e12).toFixed(1) + ' Bln km';
    if (num >= 1e9) return (num / 1e9).toFixed(1) + ' Mld km';
    if (num >= 1e6) return (num / 1e6).toFixed(1) + ' Mln km';
    if (num >= 1e3) return (num / 1e3).toFixed(1) + ' mila km';
    return num.toLocaleString('it-IT');
}

export function formatDistance(km) {
    if (km === null || km === undefined || km === '') return '—';
    const num = parseFloat(km);
    if (isNaN(num)) return '—';
    if (num === 0) return '0 km';
    if (num >= 1_000_000_000) return (num / 1_000_000_000).toFixed(1) + ' Mld km';
    if (num >= 1_000_000) return (num / 1_000_000).toFixed(1) + ' Mln km';
    if (num >= 1_000) return (num / 1_000).toFixed(1) + ' Mila km';
    return num.toLocaleString('it-IT') + ' km';
}
