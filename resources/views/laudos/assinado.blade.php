<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laudo Assinado - OSLaudos</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            max-width: 600px;
            background: white;
            padding: 3rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background-color: #10b981;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 3rem;
            color: white;
        }

        h1 {
            color: #2563eb;
            margin-bottom: 1rem;
        }

        p {
            color: #6b7280;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">✓</div>
        <h1>Laudo Assinado com Sucesso!</h1>
        <p>Este laudo já foi assinado digitalmente.</p>
        <p><strong>Data da Assinatura:</strong> {{ $laudo->data_assinatura_cliente ? $laudo->data_assinatura_cliente->format('d/m/Y H:i') : '-' }}</p>
        <p><strong>Método:</strong> {{ $laudo->metodo_assinatura === 'biometria' ? 'Biometria' : 'Assinatura Digital' }}</p>
    </div>
</body>
</html>

