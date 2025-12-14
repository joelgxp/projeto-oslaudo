@extends('layouts.app')

@section('content')
<style>
    @media (max-width: 768px) {
        .execucao-header {
            margin-bottom: 1.5rem;
        }

        .execucao-header h1 {
            font-size: 1.5rem !important;
        }

        .checklist-mobile {
            padding: 1rem !important;
        }

        .checklist-item {
            padding: 0.75rem 0;
            font-size: 0.875rem;
        }

        .checklist-item input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-right: 0.75rem;
        }

        .signature-container {
            margin-bottom: 1rem;
        }

        #signatureCanvas {
            height: 180px !important;
            touch-action: none;
        }

        .btn-mobile-full {
            width: 100%;
            margin-bottom: 0.75rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .fotos-grid {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)) !important;
            gap: 0.75rem !important;
        }
    }
</style>

<div class="card">
    <div class="execucao-header" style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700;">Executar Serviço</h1>
        <p style="color: #6b7280; margin-top: 0.5rem;">Cliente: <strong>{{ $servico->cliente->nome }}</strong> - {{ $servico->tipo_servico }}</p>
    </div>

    <form method="POST" action="{{ route('servicos.salvar-execucao', $servico) }}" enctype="multipart/form-data" id="execucaoForm">
        @csrf

        <div class="form-group">
            <label class="form-label">Checklist de Execução</label>
            <div class="checklist-mobile" style="background: #f9fafb; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                <div style="display: grid; gap: 1rem;">
                    <label class="checklist-item" style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer; padding: 0.75rem; background: white; border-radius: 0.375rem; transition: background 0.2s;">
                        <input type="checkbox" name="checklist_preenchido[]" value="equipamentos_verificados" style="width: 24px; height: 24px; cursor: pointer;" {{ (old('checklist_preenchido') && in_array('equipamentos_verificados', old('checklist_preenchido'))) || ($servico->execucao && in_array('equipamentos_verificados', $servico->execucao->checklist_preenchido ?? [])) ? 'checked' : '' }}>
                        <span style="flex: 1; user-select: none;">Equipamentos verificados e funcionando</span>
                    </label>
                    <label class="checklist-item" style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer; padding: 0.75rem; background: white; border-radius: 0.375rem; transition: background 0.2s;">
                        <input type="checkbox" name="checklist_preenchido[]" value="area_inspecionada" style="width: 24px; height: 24px; cursor: pointer;" {{ (old('checklist_preenchido') && in_array('area_inspecionada', old('checklist_preenchido'))) || ($servico->execucao && in_array('area_inspecionada', $servico->execucao->checklist_preenchido ?? [])) ? 'checked' : '' }}>
                        <span style="flex: 1; user-select: none;">Área completamente inspecionada</span>
                    </label>
                    <label class="checklist-item" style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer; padding: 0.75rem; background: white; border-radius: 0.375rem; transition: background 0.2s;">
                        <input type="checkbox" name="checklist_preenchido[]" value="produtos_aplicados" style="width: 24px; height: 24px; cursor: pointer;" {{ (old('checklist_preenchido') && in_array('produtos_aplicados', old('checklist_preenchido'))) || ($servico->execucao && in_array('produtos_aplicados', $servico->execucao->checklist_preenchido ?? [])) ? 'checked' : '' }}>
                        <span style="flex: 1; user-select: none;">Produtos aplicados conforme especificado</span>
                    </label>
                    <label class="checklist-item" style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer; padding: 0.75rem; background: white; border-radius: 0.375rem; transition: background 0.2s;">
                        <input type="checkbox" name="checklist_preenchido[]" value="cliente_orientado" style="width: 24px; height: 24px; cursor: pointer;" {{ (old('checklist_preenchido') && in_array('cliente_orientado', old('checklist_preenchido'))) || ($servico->execucao && in_array('cliente_orientado', $servico->execucao->checklist_preenchido ?? [])) ? 'checked' : '' }}>
                        <span style="flex: 1; user-select: none;">Cliente orientado sobre cuidados necessários</span>
                    </label>
                    <label class="checklist-item" style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer; padding: 0.75rem; background: white; border-radius: 0.375rem; transition: background 0.2s;">
                        <input type="checkbox" name="checklist_preenchido[]" value="local_limpo" style="width: 24px; height: 24px; cursor: pointer;" {{ (old('checklist_preenchido') && in_array('local_limpo', old('checklist_preenchido'))) || ($servico->execucao && in_array('local_limpo', $servico->execucao->checklist_preenchido ?? [])) ? 'checked' : '' }}>
                        <span style="flex: 1; user-select: none;">Local deixado limpo e organizado</span>
                    </label>
                </div>
            </div>
        </div>

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
                    <div class="fotos-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem;">
                        @foreach($servico->execucao->fotos as $foto)
                            <img src="{{ asset('storage/' . $foto) }}" alt="Foto" style="width: 100%; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="form-group">
            <label class="form-label">Assinatura do Técnico</label>
            <div class="signature-container" style="border: 2px solid #d1d5db; border-radius: 0.5rem; background-color: white; margin-bottom: 1rem; position: relative;">
                <canvas id="signatureCanvas" width="600" height="200" style="width: 100%; height: 200px; cursor: crosshair; border-radius: 0.5rem; touch-action: none;"></canvas>
            </div>
            <input type="hidden" name="assinatura_tecnico" id="assinatura_tecnico" value="{{ old('assinatura_tecnico', $servico->execucao->assinatura_tecnico ?? '') }}">
            <button type="button" onclick="clearSignature()" class="btn btn-secondary btn-mobile-full" style="margin-bottom: 1rem;">Limpar Assinatura</button>
            @error('assinatura_tecnico')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap;">
            <button type="submit" class="btn btn-primary btn-mobile-full" onclick="saveSignature()" style="flex: 1; min-width: 200px;">Salvar Execução</button>
            <a href="{{ route('servicos.show', $servico) }}" class="btn btn-secondary btn-mobile-full" style="flex: 1; min-width: 200px;">Cancelar</a>
        </div>
    </form>
</div>

<script>
    const canvas = document.getElementById('signatureCanvas');
    const ctx = canvas.getContext('2d');
    let isDrawing = false;
    let lastX = 0;
    let lastY = 0;
    let hasDrawing = false; // Flag para verificar se há desenho no canvas

    // Ajustar tamanho do canvas para mobile (preservando o desenho)
    function resizeCanvas() {
        const rect = canvas.getBoundingClientRect();
        const dpr = window.devicePixelRatio || 1;
        
        // Salvar o conteúdo atual do canvas se houver desenho
        let savedImageData = null;
        if (hasDrawing && canvas.width > 0 && canvas.height > 0) {
            savedImageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        }
        
        // Calcular novas dimensões
        const newWidth = rect.width * dpr;
        const newHeight = rect.height * dpr;
        
        // Redimensionar canvas
        canvas.width = newWidth;
        canvas.height = newHeight;
        ctx.scale(dpr, dpr);
        canvas.style.width = rect.width + 'px';
        canvas.style.height = rect.height + 'px';
        
        // Restaurar o desenho se existia
        if (savedImageData) {
            // Criar um canvas temporário para redimensionar a imagem
            const tempCanvas = document.createElement('canvas');
            const tempCtx = tempCanvas.getContext('2d');
            tempCanvas.width = savedImageData.width;
            tempCanvas.height = savedImageData.height;
            tempCtx.putImageData(savedImageData, 0, 0);
            
            // Desenhar a imagem redimensionada no canvas principal
            ctx.drawImage(tempCanvas, 0, 0, rect.width, rect.height);
        }
    }
    
    // Inicializar canvas apenas uma vez (sem preservar desenho na primeira vez)
    function initCanvas() {
        const rect = canvas.getBoundingClientRect();
        const dpr = window.devicePixelRatio || 1;
        canvas.width = rect.width * dpr;
        canvas.height = rect.height * dpr;
        ctx.scale(dpr, dpr);
        canvas.style.width = rect.width + 'px';
        canvas.style.height = rect.height + 'px';
    }
    
    initCanvas();
    
    // Carregar assinatura existente se houver (ao editar execução)
    const existingSignature = document.getElementById('assinatura_tecnico').value;
    if (existingSignature && existingSignature.trim() !== '') {
        const img = new Image();
        img.onload = function() {
            const rect = canvas.getBoundingClientRect();
            const dpr = window.devicePixelRatio || 1;
            ctx.drawImage(img, 0, 0, rect.width, rect.height);
            hasDrawing = true;
        };
        img.onerror = function() {
            console.warn('Erro ao carregar assinatura existente');
        };
        img.src = existingSignature;
    }
    
    // Usar debounce para evitar múltiplos redimensionamentos rápidos
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(resizeCanvas, 100);
    });

    // Mouse events
    canvas.addEventListener('mousedown', (e) => {
        e.preventDefault();
        const rect = canvas.getBoundingClientRect();
        lastX = e.clientX - rect.left;
        lastY = e.clientY - rect.top;
        startDrawing({ clientX: lastX, clientY: lastY });
    });

    canvas.addEventListener('mousemove', (e) => {
        e.preventDefault();
        if (isDrawing) {
            const rect = canvas.getBoundingClientRect();
            draw({ clientX: e.clientX - rect.left, clientY: e.clientY - rect.top });
        }
    });

    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);

    // Touch events para mobile (melhorado)
    canvas.addEventListener('touchstart', (e) => {
        e.preventDefault();
        const touch = e.touches[0];
        const rect = canvas.getBoundingClientRect();
        lastX = touch.clientX - rect.left;
        lastY = touch.clientY - rect.top;
        startDrawing({ clientX: lastX, clientY: lastY });
    }, { passive: false });

    canvas.addEventListener('touchmove', (e) => {
        e.preventDefault();
        if (isDrawing) {
            const touch = e.touches[0];
            const rect = canvas.getBoundingClientRect();
            draw({ clientX: touch.clientX - rect.left, clientY: touch.clientY - rect.top });
        }
    }, { passive: false });

    canvas.addEventListener('touchend', (e) => {
        e.preventDefault();
        stopDrawing();
    }, { passive: false });

    function startDrawing(e) {
        isDrawing = true;
        hasDrawing = true; // Marcar que há desenho no canvas
        ctx.beginPath();
        ctx.moveTo(e.clientX, e.clientY);
        lastX = e.clientX;
        lastY = e.clientY;
    }

    function draw(e) {
        if (!isDrawing) return;
        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(e.clientX, e.clientY);
        ctx.strokeStyle = '#000';
        ctx.lineWidth = 3; // Mais grosso para mobile
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.stroke();
        lastX = e.clientX;
        lastY = e.clientY;
    }

    function stopDrawing() {
        if (isDrawing) {
            ctx.closePath();
        }
        isDrawing = false;
    }

    function clearSignature() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        hasDrawing = false; // Resetar flag ao limpar
        document.getElementById('assinatura_tecnico').value = '';
    }

    function saveSignature() {
        const dataURL = canvas.toDataURL('image/png');
        document.getElementById('assinatura_tecnico').value = dataURL;
    }

    // Salvar assinatura antes de submeter o formulário
    document.getElementById('execucaoForm').addEventListener('submit', function(e) {
        saveSignature();
    });
</script>
@endsection

