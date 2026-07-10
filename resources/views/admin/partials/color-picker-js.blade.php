@push('scripts')
<script>
    document.getElementById('colore').addEventListener('input', function() {
        document.getElementById('colore_hex').value = this.value;
    });
    document.getElementById('colore_hex').addEventListener('input', function() {
        document.getElementById('colore').value = this.value;
    });
</script>
@endpush
