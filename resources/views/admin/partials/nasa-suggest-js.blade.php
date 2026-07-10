@push('scripts')
<script>
document.getElementById('cercaNasaBtn')?.addEventListener('click', function() {
    var nomeIt = document.getElementById('nome_it').value.trim();
    var resultEl = document.getElementById('suggestResult');
    if (!nomeIt) {
        resultEl.textContent = 'Inserisci un nome in italiano.';
        resultEl.style.color = '#EF4444';
        return;
    }

    resultEl.textContent = 'Cerco su NASA...';
    resultEl.style.color = '#6B7280';

    fetch('{{ route("admin.corpi-celesti.suggest-nome") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ nome_it: nomeIt })
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.success) {
            document.getElementById('nome').value = data.nome;
            resultEl.textContent = 'Suggerito: ' + data.nome;
            resultEl.style.color = '#22C55E';
        } else {
            resultEl.textContent = data.message;
            resultEl.style.color = '#EF4444';
        }
    })
    .catch(function() {
        resultEl.textContent = 'Errore di connessione.';
        resultEl.style.color = '#EF4444';
    });
});
</script>
@endpush
