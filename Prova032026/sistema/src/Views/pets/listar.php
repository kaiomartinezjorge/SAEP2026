<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2><?= htmlspecialchars($titulo) ?></h2>
        <a href="/pets/novo" class="btn btn-success">+ Cadastrar Pet</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome do Pet</th>
                <th>Espécie</th>
                <th>Raça</th>
                <th>Nascimento</th>
                <th>Tutor Responsável</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($pets)): ?>
                <tr><td colspan="6" style="text-align:center; color:#94a3b8;">Nenhum pet cadastrado no momento.</td></tr>
            <?php else: ?>
                <?php foreach ($pets as $p): ?>
                    <tr>
                        <td>#<?= (int)$p['id'] ?></td>
                        <td><strong><?= htmlspecialchars($p['nome']) ?></strong></td>
                        <td><?= htmlspecialchars($p['especie']) ?></td>
                        <td><?= htmlspecialchars($p['raca']) ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y', strtotime($p['data_nascimento']))) ?></td>
                        <td><?= htmlspecialchars($p['tutor_nome']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>