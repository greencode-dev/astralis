@push('scripts')
<script>
    (function() {
        var colorEl = document.getElementById('colore');
        var hexEl = document.getElementById('colore_hex');
        if (!colorEl || !hexEl) return;
        colorEl.addEventListener('input', function() {
            hexEl.value = this.value;
        });
        hexEl.addEventListener('input', function() {
            colorEl.value = this.value;
        });
        var form = colorEl.closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                colorEl.value = hexEl.value;
            });
        }
    })();
</script>
@endpush
