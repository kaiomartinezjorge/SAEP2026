<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Agendamento;
use App\Models\Pet;
use App\Models\Tutor;

/**
 * Controla listagem, cadastro e alteracao de datas de agendamentos.
 */
final class AgendamentoController extends Controller {
    public function listar(): void {
        $this->renderizar('agendamentos/listar', [
            'titulo'       => 'Agendamentos Cadastrados',
            'agendamentos' => Agendamento::listarOrdenadoPorAno()
        ]);
    }

    public function formulario(): void {
        $this->renderizar('agendamentos/criar', [
            'titulo'    => 'Novo Agendamento',
            'tutores'   => Tutor::listar(),
            'pets'      => Pet::listarTodos(),
            'csrfToken' => $this->obterCsrfToken()
        ]);
    }

    public function salvar(): void {
        if (!$this->validarCsrfToken($_POST['csrf_token'] ?? null)) {
            $this->redirecionar('/agendamentos/novo');
        }

        $tutorId = (int)($_POST['tutor_id'] ?? 0);
        $petId = (int)($_POST['pet_id'] ?? 0);
        $usuarioId = (int)($_SESSION['usuario_id'] ?? 0);
        $data = trim((string)($_POST['data_agendamento'] ?? ''));
        $hora = trim((string)($_POST['hora_agendamento'] ?? ''));
        $servico = trim((string)($_POST['servico'] ?? ''));

        if ($tutorId < 1 || $petId < 1 || $usuarioId < 1 || $data === '' || $hora === '' || $servico === '') {
            $this->renderizar('agendamentos/criar', [
                'titulo'    => 'Novo Agendamento',
                'tutores'   => Tutor::listar(),
                'pets'      => Pet::listarTodos(),
                'csrfToken' => $this->obterCsrfToken(),
                'erro'      => 'Preencha todos os campos para salvar o agendamento.'
            ]);
            return;
        }

        Agendamento::salvar($tutorId, $petId, $usuarioId, $data, $hora, $servico);
        $this->redirecionar('/agendamentos');
    }

    public function formularioEditarData(): void {
        $id = (int)($_GET['id'] ?? 0);
        $agendamento = $id > 0 ? Agendamento::buscarPorId($id) : null;
        if (!$agendamento) {
            $this->redirecionar('/agendamentos');
        }

        $this->renderizar('agendamentos/editar-data', [
            'titulo'      => 'Alterar Data do Agendamento',
            'agendamento' => $agendamento,
            'csrfToken'   => $this->obterCsrfToken()
        ]);
    }

    public function atualizarData(): void {
        if (!$this->validarCsrfToken($_POST['csrf_token'] ?? null)) {
            $this->redirecionar('/agendamentos');
        }

        $id = (int)($_POST['id'] ?? 0);
        $data = trim((string)($_POST['data_agendamento'] ?? ''));
        $hora = trim((string)($_POST['hora_agendamento'] ?? ''));
        if ($id > 0 && $data !== '') {
            Agendamento::atualizarData($id, $data, $hora !== '' ? $hora : null);
        }
        $this->redirecionar('/agendamentos');
    }
}
