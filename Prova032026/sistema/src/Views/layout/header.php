<?php
$usuarioLogado = $_SESSION['usuario_nome'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo ?? 'VetCare — Clínica Veterinária') ?></title>
    <style>
        :root {
            color-scheme: light;
            --page: #f5f4ef;
            --surface: #fffefa;
            --line: #e5e4dc;
            --text: #35433b;
            --muted: #78847b;
            --accent: #557a67;
            --accent-soft: #e8efe9;
        }
        * { box-sizing: border-box; }
        body {
            min-height: 100vh;
            margin: 0;
            color: var(--text);
            background: var(--page);
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.55;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            padding: 15px clamp(18px, 5vw, 64px);
            background: var(--surface);
            border-bottom: 1px solid var(--line);
        }
        header h1 { margin: 0; color: var(--accent); font-size: 1.08rem; font-weight: 650; }
        nav { display: flex; align-items: center; flex-wrap: wrap; gap: 5px; }
        nav a:not(.btn) {
            padding: 7px 10px;
            color: #59675e;
            text-decoration: none;
            font-size: .88rem;
            font-weight: 600;
            border-radius: 7px;
            transition: background .15s ease, color .15s ease;
        }
        nav a:not(.btn):hover { color: #365846; background: var(--accent-soft); }
        .user-tag { padding: 5px 10px; color: #496754; background: #f0f4ef; border: 1px solid #dce6dd; border-radius: 7px; font-size: .82rem; }
        .container { width: min(1160px, calc(100% - 36px)); margin: 30px auto; padding: 0; }
        .card {
            overflow-x: auto;
            padding: clamp(20px, 3vw, 30px);
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(55, 65, 54, .045);
        }
        h2, h3 { color: #35483c; letter-spacing: -.015em; }
        h2 { margin-top: 0; }
        p { color: var(--muted); }
        .grid-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 14px; margin-top: 22px; }
        .stat-box {
            padding: 19px;
            text-align: left;
            background: #fbfaf6;
            border: 1px solid #e9e8df;
            border-radius: 10px;
        }
        .stat-box span { color: var(--muted); font-size: .74rem; letter-spacing: .06em; text-transform: uppercase; font-weight: 700; }
        .stat-box strong { display: block; margin: 7px 0 11px; color: var(--accent); font-size: 1.8rem; line-height: 1.2; }
        table { width: 100%; min-width: 620px; margin-top: 20px; border-collapse: collapse; font-size: .9rem; }
        th, td { padding: 12px 13px; text-align: left; border-bottom: 1px solid #ecebe4; }
        th { color: #68766d; background: #f7f7f2; font-size: .75rem; text-transform: uppercase; letter-spacing: .045em; }
        tbody tr:hover { background: #fafbf7; }
        tbody tr:last-child td { border-bottom: 0; }
        .btn {
            display: inline-block;
            padding: 8px 13px;
            color: #fff;
            background: var(--accent);
            border: 1px solid var(--accent);
            border-radius: 7px;
            text-decoration: none;
            font-size: .84rem;
            font-weight: 650;
            cursor: pointer;
            transition: background .15s ease;
        }
        .btn:hover { background: #456854; }
        .btn-success { color: #fff; background: #66866c; border-color: #66866c; }
        .btn-success:hover { background: #55765c; }
        .btn-danger { color: #fff; background: #a95f5b; border-color: #a95f5b; }
        .btn-danger:hover { background: #914f4c; }
        .form-group { margin-bottom: 17px; }
        label { display: block; margin-bottom: 6px; color: #56665b; font-size: .86rem; font-weight: 600; }
        input, select, textarea {
            width: 100%;
            padding: 10px 12px;
            color: var(--text);
            background: #fff;
            border: 1px solid #d9ddd5;
            border-radius: 7px;
            font: inherit;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        input::placeholder { color: #9aa39b; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #789984; box-shadow: 0 0 0 3px rgba(85, 122, 103, .12); }
        .alerta-erro { padding: 11px 13px; margin-bottom: 16px; color: #7c3838; background: #fbefec; border: 1px solid #efd5ce; border-radius: 8px; font-size: .88rem; }
        footer { color: #899188 !important; border-color: #e5e4dc !important; }
        a:focus-visible, button:focus-visible { outline: 3px solid rgba(85, 122, 103, .35); outline-offset: 2px; }
        @media (max-width: 720px) {
            header { align-items: flex-start; flex-direction: column; }
            nav { width: 100%; }
            .container { width: min(100% - 24px, 1160px); margin: 22px auto; }
            .card { border-radius: 14px; }
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { scroll-behavior: auto !important; transition-duration: .01ms !important; }
        }
    </style>
</head>
<body>
<header>
    <h1>Kaiovet — Gestão Veterinária</h1>
    <nav>
        <?php if ($usuarioLogado): ?>
            <a href="/">Painel</a>
            <a href="/tutores">Tutores</a>
            <a href="/pets">Pets</a>
            <a href="/agendamentos">Agendamentos</a>
            <span class="user-tag">👤 <?= htmlspecialchars($usuarioLogado) ?></span>
            <form action="/logout" method="POST" style="display:inline;margin:0;">
                <button type="submit" class="btn btn-danger" style="padding:5px 10px;font-size:0.8rem;">Sair</button>
            </form>
        <?php else: ?>
            <a href="/login" class="btn">Entrar</a>
        <?php endif; ?>
    </nav>
</header>
<div class="container">
