@push('scripts')
<script>
document.getElementById('cercaNasaBtn')?.addEventListener('click', function() {
    var nomeIt = document.getElementById('nome').value.trim();
    var nomeEn = document.getElementById('nome_en').value.trim();
    var resultEl = document.getElementById('suggestResult');
    if (!nomeIt && !nomeEn) {
        resultEl.textContent = 'Inserisci un nome in italiano o inglese.';
        resultEl.style.color = 'var(--color-admin-error)';
        return;
    }

    resultEl.textContent = 'Cerco su NASA...';
    resultEl.style.color = 'var(--color-admin-neutral)';

    fetch('{{ route("admin.corpi-celesti.suggest-nome") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ nome: nomeIt, nome_en: nomeEn })
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.success) {
            document.getElementById('nome_en').value = data.nome_en;
            resultEl.textContent = 'Suggerito: ' + data.nome_en;
            resultEl.style.color = 'var(--color-admin-success)';
        } else if (data.needs_manual) {
            resultEl.innerHTML = '';
            resultEl.style.color = 'var(--color-admin-neutral)';
            var wrapper = document.createElement('div');
            wrapper.style.display = 'flex';
            wrapper.style.alignItems = 'center';
            wrapper.style.gap = '0.5rem';
            wrapper.style.marginTop = '0.25rem';
            var input = document.createElement('input');
            input.type = 'text';
            input.placeholder = 'Nome inglese su NASA (es. Orion Nebula)';
            input.className = 'admin-input';
            input.style.flex = '1';
            input.id = 'manualNasaInput';
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = 'Usa';
            btn.className = 'admin-btn-primary';
            btn.addEventListener('click', function() {
                var val = input.value.trim();
                if (val) {
                    document.getElementById('nome_en').value = val;
                    resultEl.textContent = 'Impostato: ' + val;
                    resultEl.style.color = 'var(--color-admin-success)';
                }
            });
            wrapper.appendChild(input);
            wrapper.appendChild(btn);
            resultEl.appendChild(wrapper);
            input.focus();
        } else {
            resultEl.textContent = data.message;
            resultEl.style.color = 'var(--color-admin-error)';
        }
    })
    .catch(function() {
        resultEl.textContent = 'Errore di connessione.';
        resultEl.style.color = 'var(--color-admin-error)';
    });
});
</script>
@endpush
