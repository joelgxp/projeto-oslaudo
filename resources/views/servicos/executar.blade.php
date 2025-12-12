@extends('layouts.app')

@section('content')
<div class="card">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700;">Executar Serviço</h1>
        <p style="color: #6b7280; margin-top: 0.5rem;">Cliente: <strong>{{ $servico->cliente->nome }}</strong> - {{ $servico->tipo_servico }}</p>
    </div>

    <form method="POST" action="{{ route('servicos.salvar-execucao', $servico) }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label class="form-label">Problemas Encontrados</label>
            <textarea name="problemas_encontrados" class="form-input" rows="4" placeholder="Descreva os problemas encontrados durante a execução do serviço...">{{ old('problemas_encontrados', $servico->execucao->problemas_encontrados ?? '') }}</textarea>
            @error('problemas_encontrados')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Recomendações</label>
            <textarea name="recomendacoes" class="form-input" rows="4" placeholder="Recomendações para o cliente...">{{ old('recomendacoes', $servico->execucao->recomendacoes ?? '') }}</textarea>
            @error('recomendacoes')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Fotos (múltiplas)</label>
            <input type="file" name="fotos[]" class="form-input" multiple accept="image/*">
            @error('fotos')
                <div class="error-message">{{ $message }}</div>
            @enderror
            @if($servico->execucao && $servico->execucao->fotos)
                <div style="margin-top: 1rem;">
                    <p style="margin-bottom: 0.5rem;"><strong>Fotos já enviadas:</strong></p>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem;">
                        @foreach($servico->execucao->fotos as $foto)
                            <img src="{{ asset('storage/' . $foto) }}" alt="Foto" style="width: 100%; border-radius: 0.5rem;">
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="form-group">
            <label class="form-label">Assinatura do Técnico</label>
            <div style="border: 2px solid #d1d5db; border-radius: 0.5rem; background-color: white; margin-bottom: 1rem;">
                <canvas id="signatureCanvas" width="600" height="200" style="width: 100%; height: 200px; cursor: crosshair; border-radius: 0.5rem;"></canvas>
            </div>
            <input type="hidden" name="assinatura_tecnico" id="assinatura_tecnico">
            <button type="button" onclick="clearSignature()" class="btn btn-secondary" style="margin-bottom: 1rem;">Limpar Assinatura</button>
            @error('assinatura_tecnico')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary" onclick="saveSignature()">Salvar Execução</button>
            <a href="{{ route('servicos.show', $servico) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<script>
    const canvas = document.getElementById('signatureCanvas');
    const ctx = canvas.getContext('2d');
    let isDrawing = false;

    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);

    // Touch events para mobile
    canvas.addEventListener('touchstart', (e) => {
        e.preventDefault();
        const touch = e.touches[0];
        const rect = canvas.getBoundingClientRect();
        startDrawing({
            clientX: touch.clientX - rect.left,
            clientY: touch.clientY - rect.top
        });
    });

    canvas.addEventListener('touchmove', (e) => {
        e.preventDefault();
        const touch = e.touches[0];
        const rect = canvas.getBoundingClientRect();
        draw({
            clientX: touch.clientX - rect.left,
            clientY: touch.clientY - rect.top
        });
    });

    canvas.addEventListener('touchend', stopDrawing);

    function startDrawing(e) {
        isDrawing = true;
        const rect = canvas.getBoundingClientRect();
        ctx.beginPath();
        ctx.moveTo(e.clientX - rect.left, e.clientY - rect.top);
    }

    function draw(e) {
        if (!isDrawing) return;
        const rect = canvas.getBoundingClientRect();
        ctx.lineTo(e.clientX - rect.left, e.clientY - rect.top);
        ctx.strokeStyle = '#000';
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.stroke();
    }

    function stopDrawing() {
        isDrawing = false;
    }

    function clearSignature() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        document.getElementById('assinatura_tecnico').value = '';
    }

    function saveSignature() {
        const dataURL = canvas.toDataURL('image/png');
        document.getElementById('assinatura_tecnico').value = dataURL;
    }
</script>
@endsection

