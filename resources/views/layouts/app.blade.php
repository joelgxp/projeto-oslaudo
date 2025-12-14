<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#1e40af">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="OSLaudos">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <title>@yield('title', 'OSLaudos') - Sistema de Gestão</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #1e40af;
            --primary-dark: #1e3a8a;
            --primary-light: #3b82f6;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-bg: #0f172a;
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --bg-light: #f8fafc;
            --white: #ffffff;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg-light);
            color: var(--text-primary);
            line-height: 1.5;
            font-size: 13px;
        }

        /* Layout Principal */
        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar - Estilo Profissional Jurídico */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            transition: transform 0.3s ease;
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 1.25rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(0, 0, 0, 0.15);
            position: relative;
        }

        .sidebar-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        }

        .sidebar-header h1 {
            font-size: 1.375rem;
            font-weight: 700;
            color: white;
            margin: 0;
            letter-spacing: -0.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .sidebar-header p {
            font-size: 0.6875rem;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 500;
        }

        .sidebar-nav {
            padding: 1rem 0;
            flex: 1;
        }

        .nav-section {
            margin-bottom: 1.5rem;
        }

        .nav-section:first-child {
            margin-top: 0.5rem;
        }

        .nav-section-title {
            padding: 0.625rem 1.5rem 0.5rem;
            font-size: 0.6875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: rgba(255, 255, 255, 0.35);
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.25rem;
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 4px solid transparent;
            font-weight: 500;
            font-size: 0.8125rem;
            position: relative;
            margin: 0.125rem 0.625rem;
            border-radius: 0.5rem;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--primary-light);
            transform: scaleY(0);
            transition: transform 0.25s ease;
            border-radius: 0 2px 2px 0;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
            padding-left: 1.75rem;
        }

        .nav-link:hover::before {
            transform: scaleY(1);
        }

        .nav-link.active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.2) 0%, rgba(59, 130, 246, 0.1) 100%);
            color: white;
            border-left-color: var(--primary-light);
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.15);
        }

        .nav-link.active::before {
            transform: scaleY(1);
        }

        .nav-link svg {
            width: 18px;
            height: 18px;
            margin-right: 0.75rem;
            opacity: 0.7;
            transition: opacity 0.25s ease;
            flex-shrink: 0;
        }

        .nav-link:hover svg,
        .nav-link.active svg {
            opacity: 1;
            transform: scale(1.05);
        }

        .sidebar-footer {
            padding: 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .sidebar-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        }

        .user-info {
            display: flex;
            align-items: center;
            padding: 0.875rem;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 0.5rem;
            margin-bottom: 0.875rem;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.25s ease;
        }

        .user-info:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.12);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8125rem;
            margin-right: 0.75rem;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
            border: 2px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        .user-details {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-size: 0.8125rem;
            font-weight: 600;
            color: white;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 0.125rem;
        }

        .user-role {
            font-size: 0.6875rem;
            color: rgba(255, 255, 255, 0.55);
            text-transform: capitalize;
            font-weight: 500;
        }

        /* Conteúdo Principal */
        .main-content {
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-content.with-sidebar {
            margin-left: 280px;
        }

        /* Header - Estilo baseado no print */
        .topbar {
            background: #f5f5f5;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid #e0e0e0;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .header-icons {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            cursor: pointer;
            transition: color 0.2s ease;
            border: none;
            background: none;
            padding: 0;
        }

        .header-icon:hover {
            color: #374151;
        }

        .header-icon svg {
            width: 20px;
            height: 20px;
            stroke-width: 1.5;
        }

        .header-icon-small {
            width: 28px;
            height: 28px;
        }

        .header-icon-small svg {
            width: 18px;
            height: 18px;
        }

        /* Dropdown de Configurações */
        .settings-dropdown {
            position: relative;
        }

        .settings-dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            left: 50%;
            transform: translateX(-50%) translateY(-10px);
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            min-width: 200px;
            padding: 0.5rem 0;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
            z-index: 1000;
            border: 1px solid #e5e7eb;
        }

        .settings-dropdown-menu::before {
            content: '';
            position: absolute;
            top: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 8px solid white;
        }

        .settings-dropdown-menu::after {
            content: '';
            position: absolute;
            top: -9px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 9px solid transparent;
            border-right: 9px solid transparent;
            border-bottom: 9px solid #e5e7eb;
            z-index: -1;
        }

        .settings-dropdown.open .settings-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
        }

        .settings-dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.625rem 0.875rem;
            color: #374151;
            text-decoration: none;
            font-size: 0.8125rem;
            transition: background-color 0.2s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .settings-dropdown-item:hover {
            background-color: #f3f4f6;
        }

        .settings-dropdown-item svg {
            width: 16px;
            height: 16px;
            color: #6b7280;
            flex-shrink: 0;
        }

        /* Dropdown de Perfil */
        .profile-dropdown {
            position: relative;
        }

        .profile-dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            transform: translateY(-10px);
            background: white;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            min-width: 180px;
            padding: 0.375rem 0;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
            z-index: 1000;
            border: 1px solid #e5e7eb;
        }

        .profile-dropdown-menu::before {
            content: '';
            position: absolute;
            top: -8px;
            left: 8px;
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 8px solid white;
        }

        .profile-dropdown-menu::after {
            content: '';
            position: absolute;
            top: -9px;
            left: 8px;
            width: 0;
            height: 0;
            border-left: 9px solid transparent;
            border-right: 9px solid transparent;
            border-bottom: 9px solid #e5e7eb;
            z-index: -1;
        }

        .profile-dropdown.open .profile-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .profile-dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.625rem 0.875rem;
            color: #374151;
            text-decoration: none;
            font-size: 0.8125rem;
            transition: background-color 0.2s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .profile-dropdown-item:hover {
            background-color: #f3f4f6;
        }

        .profile-dropdown-item svg {
            width: 16px;
            height: 16px;
            color: #6b7280;
            flex-shrink: 0;
        }

        .profile-dropdown-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 0.25rem 0;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-greeting-section {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .greeting-text {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .greeting-line1 {
            font-size: 0.8125rem;
            font-weight: 700;
            color: #374151;
            line-height: 1.2;
        }

        .greeting-line2 {
            font-size: 0.8125rem;
            font-weight: 400;
            color: #9ca3af;
            line-height: 1.2;
        }

        .user-icon-wrapper {
            position: relative;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-icon-circle {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .user-icon-circle::after {
            content: '';
            position: absolute;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 2px solid #fb923c;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .user-icon-circle svg {
            width: 16px;
            height: 16px;
            color: #6b7280;
            stroke-width: 1.5;
            z-index: 1;
            position: relative;
        }

        /* Container do Conteúdo */
        .content-wrapper {
            padding: 1.5rem;
            flex: 1;
        }

        /* Cards - Estilo Profissional */
        .card {
            background: var(--white);
            border-radius: 0.625rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
        }

        .card-header {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .card-subtitle {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-top: 0.5rem;
        }

        /* Botões - Estilo Profissional */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            font-size: 0.8125rem;
            font-weight: 500;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            gap: 0.5rem;
            font-family: inherit;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
        }

        .btn-secondary {
            background: var(--secondary-color);
            color: white;
        }

        .btn-secondary:hover {
            background: #475569;
        }

        .btn-danger {
            background: var(--danger-color);
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-success {
            background: var(--success-color);
            color: white;
        }

        .btn-success:hover {
            background: #059669;
        }

        /* Formulários */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.375rem;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 0.625rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 0.8125rem;
            transition: all 0.2s ease;
            font-family: inherit;
            background: var(--white);
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-checkbox {
            margin-right: 0.5rem;
        }

        /* Tabelas */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: var(--bg-light);
        }

        th {
            padding: 0.75rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.8125rem;
            color: var(--text-primary);
            border-bottom: 2px solid var(--border-color);
        }

        td {
            padding: 0.75rem;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.8125rem;
        }

        tbody tr:hover {
            background: var(--bg-light);
        }

        /* Alertas */
        .alert {
            padding: 0.875rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.25rem;
            border-left: 4px solid;
            font-size: 0.8125rem;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-color: var(--success-color);
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-color: var(--danger-color);
        }

        .alert-info {
            background: #dbeafe;
            color: #1e40af;
            border-color: var(--primary-color);
        }

        .alert-warning {
            background: #fef3c7;
            color: #92400e;
            border-color: var(--warning-color);
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 9999px;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-secondary {
            background: #e2e8f0;
            color: #475569;
        }

        /* Menu Mobile Toggle */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text-primary);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
        }

        /* Logout Button */
        .btn-logout {
            background: rgba(239, 68, 68, 0.12);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.25);
            width: 100%;
            font-weight: 500;
            transition: all 0.25s ease;
        }

        .btn-logout:hover {
            background: rgba(239, 68, 68, 0.2);
            color: white;
            border-color: rgba(239, 68, 68, 0.4);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }

        /* Responsivo */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
                box-shadow: 4px 0 20px rgba(0, 0, 0, 0.3);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content.with-sidebar {
                margin-left: 0;
            }

            .content-wrapper {
                padding: 1rem;
            }

            .topbar {
                padding: 0.75rem 1rem;
                flex-wrap: wrap;
            }

            .topbar-left {
                width: 100%;
                margin-bottom: 0.5rem;
            }

            .topbar-right {
                width: 100%;
                justify-content: space-between;
            }

            .menu-toggle {
                display: block;
                background: var(--primary-color);
                color: white;
                border: none;
                padding: 0.5rem 0.75rem;
                border-radius: 0.375rem;
                cursor: pointer;
                font-size: 1.25rem;
            }

            .card {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .stat-box {
                padding: 1rem;
            }

            .stat-box-value {
                font-size: 1.75rem;
            }

            table {
                font-size: 0.8125rem;
            }

            th, td {
                padding: 0.5rem;
            }

            .btn {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
                min-height: 44px; /* Tamanho mínimo para touch */
            }

            .form-input, .form-select, .form-textarea {
                font-size: 16px; /* Previne zoom no iOS */
                padding: 0.75rem;
                min-height: 44px;
            }

            .nav-link {
                padding: 1rem 1.25rem;
                font-size: 0.875rem;
            }

            .user-greeting-section {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .greeting-text {
                align-items: flex-start;
            }
        }

        /* Mobile muito pequeno */
        @media (max-width: 480px) {
            .content-wrapper {
                padding: 0.75rem;
            }

            .card {
                padding: 0.75rem;
                border-radius: 0.5rem;
            }

            h1 {
                font-size: 1.5rem !important;
            }

            .stat-box-value {
                font-size: 1.5rem;
            }

            .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }

            .topbar {
                padding: 0.5rem;
            }
        }

        /* Scrollbar Customizado */
        .sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.15);
            border-radius: 4px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 4px;
            border: 2px solid transparent;
            background-clip: padding-box;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.25);
            background-clip: padding-box;
        }

        /* Cards de Estatísticas */
        .stat-card {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            padding: 1.5rem;
            border-radius: 0.75rem;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stat-card h3 {
            font-size: 0.875rem;
            opacity: 0.9;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .stat-card p {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        @auth
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h1>OSLaudos</h1>
                <p>Sistema de Gestão</p>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Principal</div>
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>
                </div>

                @auth
                    @if(auth()->user()->isTechnician())
                        {{-- Menu Simplificado para Técnico --}}
                        <div class="nav-section">
                            <div class="nav-section-title">Meus Serviços</div>
                            <a href="{{ route('servicos.index') }}" class="nav-link {{ request()->routeIs('servicos.*') ? 'active' : '' }}">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <span>📋 Meus Serviços</span>
                            </a>
                        </div>
                        <div class="nav-section">
                            <div class="nav-section-title">Conta</div>
                            <a href="{{ route('perfil.show') }}" class="nav-link {{ request()->routeIs('perfil.*') ? 'active' : '' }}">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>👤 Meu Perfil</span>
                            </a>
                        </div>
                    @elseif(auth()->user()->isAdmin())
                        {{-- Menu Completo para Admin --}}
                        <div class="nav-section">
                            <div class="nav-section-title">Gestão de Dados</div>
                            <a href="{{ route('clientes.index') }}" class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span>Clientes</span>
                            </a>
                            <a href="{{ route('servicos.index') }}" class="nav-link {{ request()->routeIs('servicos.*') ? 'active' : '' }}">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <span>Ordens de Serviço</span>
                            </a>
                        </div>
                        <div class="nav-section">
                            <div class="nav-section-title">Configurações</div>
                            <a href="{{ route('laudo-templates.index') }}" class="nav-link {{ request()->routeIs('laudo-templates.*') ? 'active' : '' }}">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span>Templates de Laudos</span>
                            </a>
                            <a href="{{ route('relatorios.index') }}" class="nav-link {{ request()->routeIs('relatorios.*') ? 'active' : '' }}">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <span>Relatórios</span>
                            </a>
                        </div>
                    @endif
                @endauth
            </nav>

            @auth
                <div class="sidebar-footer">
                    <div class="user-info">
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="user-details">
                            <div class="user-name">{{ auth()->user()->name }}</div>
                            <div class="user-role">
                                @if(auth()->user()->isAdmin())
                                    Administrador
                                @elseif(auth()->user()->isTechnician())
                                    Técnico
                                @endif
                            </div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-logout">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Sair do Sistema</span>
                        </button>
                    </form>
                </div>
            @endauth
        </aside>
        @endauth

        <!-- Conteúdo Principal -->
        <main class="main-content @auth with-sidebar @endauth">
            <!-- Header -->
            @auth
            <div class="topbar">
                <button class="menu-toggle" onclick="toggleSidebar()" aria-label="Menu">
                    ☰
                </button>
                <div class="topbar-left">
                    <!-- Três ícones de ações rápidas -->
                    <div class="header-icons">
                        <div class="profile-dropdown" id="profileDropdown">
                            <button class="header-icon header-icon-small" onclick="toggleProfileDropdown(event)" aria-label="Perfil" type="button">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </button>
                            <div class="profile-dropdown-menu">
                                <a href="{{ route('perfil.show') }}" class="profile-dropdown-item">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Meu Perfil
                                </a>
                                <div class="profile-dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="profile-dropdown-item">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Sair do Sistema
                                    </button>
                                </form>
                            </div>
                        </div>
                        <button class="header-icon header-icon-small" aria-label="Relógio">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"></circle>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" stroke-width="1.5"></path>
                            </svg>
                        </button>
                        <div class="settings-dropdown" id="settingsDropdown">
                            <button class="header-icon" onclick="toggleSettingsDropdown(event)" aria-label="Configurações">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </button>
                            <div class="settings-dropdown-menu">
                                <a href="{{ route('configuracoes.sistema') }}" class="settings-dropdown-item">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Sistema
                                </a>
                                <a href="{{ route('configuracoes.usuarios') }}" class="settings-dropdown-item">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    Usuários
                                </a>
                                <a href="{{ route('configuracoes.emitente') }}" class="settings-dropdown-item">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Emitente
                                </a>
                                <a href="{{ route('configuracoes.permissoes') }}" class="settings-dropdown-item">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                    Permissões
                                </a>
                                <a href="{{ route('configuracoes.auditoria') }}" class="settings-dropdown-item">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                    Auditoria
                                </a>
                                <a href="{{ route('configuracoes.emails') }}" class="settings-dropdown-item">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    Emails
                                </a>
                                <a href="{{ route('configuracoes.backup') }}" class="settings-dropdown-item">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    Backup
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="topbar-right">
                    @auth
                    <!-- Saudação e ícone de usuário -->
                    <div class="user-greeting-section">
                        <div class="greeting-text">
                            <span class="greeting-line1">
                                @php
                                    $hora = (int)date('H');
                                    if ($hora >= 5 && $hora < 12) {
                                        $saudacao = 'Bom dia';
                                    } elseif ($hora >= 12 && $hora < 18) {
                                        $saudacao = 'Boa tarde';
                                    } else {
                                        $saudacao = 'Boa noite';
                                    }
                                @endphp
                                {{ $saudacao }},
                            </span>
                            <span class="greeting-line2">
                                @if(auth()->user()->isAdmin())
                                    Administrador
                                @elseif(auth()->user()->isTechnician())
                                    Técnico
                                @endif
                            </span>
                        </div>
                        <div class="user-icon-wrapper">
                            <div class="user-icon-circle">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>
            @endauth

            <!-- Container do Conteúdo -->
            <div class="content-wrapper">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error">
                        <ul style="margin: 0; padding-left: 1.5rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }

        function toggleSettingsDropdown(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('settingsDropdown');
            const profileDropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('open');
            if (profileDropdown) {
                profileDropdown.classList.remove('open');
            }
        }

        function toggleProfileDropdown(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('profileDropdown');
            const settingsDropdown = document.getElementById('settingsDropdown');
            dropdown.classList.toggle('open');
            if (settingsDropdown) {
                settingsDropdown.classList.remove('open');
            }
        }

        // Fechar sidebar ao clicar fora (mobile)
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.querySelector('.menu-toggle');
            const settingsDropdown = document.getElementById('settingsDropdown');
            
            // Fechar sidebar mobile
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                    sidebar.classList.remove('open');
                }
            }

            // Fechar dropdowns
            const profileDropdown = document.getElementById('profileDropdown');
            if (settingsDropdown && !settingsDropdown.contains(event.target)) {
                settingsDropdown.classList.remove('open');
            }
            if (profileDropdown && !profileDropdown.contains(event.target)) {
                profileDropdown.classList.remove('open');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
