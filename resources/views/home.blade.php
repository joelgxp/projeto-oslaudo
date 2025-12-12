<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - OSLaudo</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            max-width: 600px;
            width: 100%;
            text-align: center;
        }
        h1 {
            color: #667eea;
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        .subtitle {
            color: #666;
            font-size: 1.2em;
            margin-bottom: 30px;
        }
        .status-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 15px 0;
            text-align: left;
        }
        .status-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .status-item:last-child {
            border-bottom: none;
        }
        .status-label {
            font-weight: 600;
            color: #333;
        }
        .status-value {
            color: #667eea;
            font-weight: 500;
        }
        .success-badge {
            display: inline-block;
            background: #10b981;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9em;
            margin-top: 20px;
        }
        .links {
            margin-top: 30px;
            display: flex;
            gap: 15px;
            justify-content: center;
        }
        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-primary {
            background: #667eea;
            color: white;
        }
        .btn-primary:hover {
            background: #5568d3;
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: #e0e0e0;
            color: #333;
        }
        .btn-secondary:hover {
            background: #d0d0d0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 OSLaudo</h1>
        <p class="subtitle">Página de Teste - Deploy Funcionando!</p>
        
        <div class="status-card">
            <div class="status-item">
                <span class="status-label">Status do Sistema:</span>
                <span class="status-value">✅ Online</span>
            </div>
            <div class="status-item">
                <span class="status-label">Ambiente:</span>
                <span class="status-value">{{ config('app.env') }}</span>
            </div>
            <div class="status-item">
                <span class="status-label">Versão PHP:</span>
                <span class="status-value">{{ PHP_VERSION }}</span>
            </div>
            <div class="status-item">
                <span class="status-label">Framework:</span>
                <span class="status-value">Laravel {{ app()->version() }}</span>
            </div>
            <div class="status-item">
                <span class="status-label">Data/Hora:</span>
                <span class="status-value">{{ now()->format('d/m/Y H:i:s') }}</span>
            </div>
        </div>

        <span class="success-badge">✅ Deploy Automático Funcionando!</span>

        <div class="links">
            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
            <a href="{{ route('register') }}" class="btn btn-secondary">Registrar</a>
        </div>
    </div>
</body>
</html>

