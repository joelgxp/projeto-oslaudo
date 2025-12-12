<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assinar Laudo - OSLaudos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
            padding: 2rem;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #2563eb;
            margin-bottom: 1rem;
        }

        .info {
            background-color: #f9fafb;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
        }

        .info p {
            margin-bottom: 0.5rem;
        }

        .signature-section {
            margin-top: 2rem;
        }

        .signature-canvas {
            border: 2px solid #d1d5db;
            border-radius: 0.5rem;
            background-color: white;
            width: 100%;
            height: 200px;
            cursor: crosshair;
            margin-bottom: 1rem;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            margin-right: 0.5rem;
        }

        .btn-primary {
            background-color: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
        }

        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Assinar Laudo</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <div class="info">
            <p><strong>Cliente:</strong> {{ $laudo->cliente->nome }}</p>
            <p><strong>Serviço:</strong> {{ $laudo->servico->tipo_servico }}</p>
            <p><strong>Data do Serviço:</strong> {{ $laudo->servico->data_execucao ? $laudo->servico->data_execucao->format('d/m/Y') : '-' }}</p>
        </div>

        <div class="signature-section">
            <h2 style="margin-bottom: 1rem;">Assinatura Digital</h2>
            <p style="margin-bottom: 1rem; color: #6b7280;">Por favor, assine abaixo usando o mouse ou o dedo (em dispositivos touch):</p>
            
            <canvas id="signatureCanvas" class="signature-canvas"></canvas>
            <input type="hidden" name="assinatura" id="assinatura">
            
            <div style="margin-bottom: 1rem;">
                <button type="button" onclick="clearSignature()" class="btn btn-secondary">Limpar</button>
            </div>

            <form method="POST" action="{{ route('assinatura.canvas', $laudo->link_assinatura_unico) }}" id="formAssinatura">
                @csrf
                <input type="hidden" name="assinatura" id="assinaturaInput">
                <button type="submit" class="btn btn-primary" onclick="saveSignature(event)">Assinar Laudo</button>
            </form>
        </div>
    </div>

    <script>
        const canvas = document.getElementById('signatureCanvas');
        const ctx = canvas.getContext('2d');
        let isDrawing = false;

        // Ajustar tamanho do canvas
        function resizeCanvas() {
            const rect = canvas.getBoundingClientRect();
            canvas.width = rect.width;
            canvas.height = rect.height;
        }
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

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
            ctx.beginPath();
            ctx.moveTo(e.clientX, e.clientY);
        }

        function draw(e) {
            if (!isDrawing) return;
            ctx.lineTo(e.clientX, e.clientY);
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
            document.getElementById('assinaturaInput').value = '';
        }

        function saveSignature(e) {
            e.preventDefault();
            const dataURL = canvas.toDataURL('image/png');
            if (dataURL === canvas.toDataURL()) {
                alert('Por favor, assine o documento antes de enviar.');
                return false;
            }
            document.getElementById('assinaturaInput').value = dataURL;
            document.getElementById('formAssinatura').submit();
        }
    </script>
</body>
</html>

