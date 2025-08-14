<?php

namespace App\Controllers;

use Klein\Request;
use Klein\Response;
use App\Core\View;
use App\Repositories\AgencyRepository;

/** CRUD Agences (avec CSRF + protection suppression si utilisée) */
class AdminAgencyController
{
    public function index(): string
    {
        $agencies = (new AgencyRepository())->all();
        return View::render('admin/agencies/index', [
            'title' => 'Agences',
            'agencies' => $agencies,
        ]);
    }

    public function createForm(): string
    {
        $_SESSION['csrf'] = $_SESSION['csrf'] ?? bin2hex(random_bytes(16));
        return View::render('admin/agencies/create', [
            'title' => 'Créer une agence',
            'csrf'  => $_SESSION['csrf'],
        ]);
    }

    public function store(): void
    {
        $this->assertCsrf();
        $name = trim((string)($_POST['name'] ?? ''));
        $city = trim((string)($_POST['city'] ?? ''));
        if ($name === '' || $city === '') {
            $this->flash('Veuillez renseigner nom et ville', 'danger');
            header('Location: /admin/agencies/create');
            exit;
        }
        (new AgencyRepository())->create($name, $city);
        $this->flash('Agence créée', 'success');
        header('Location: /admin/agencies');
        exit;
    }

    public function editForm(Request $request, Response $response): string
    {
        $id = (int) $request->param('id'); // ou $request->id
        $repo = new AgencyRepository();
        $agency = $repo->find($id);
        if (!$agency) {
            header('Location: /admin/agencies');
            exit;
        }

        $_SESSION['csrf'] = $_SESSION['csrf'] ?? bin2hex(random_bytes(16));
        return View::render('admin/agencies/edit', [
            'title'  => 'Modifier une agence',
            'csrf'   => $_SESSION['csrf'],
            'agency' => $agency,
        ]);
    }

    public function update(Request $request, Response $response): void
    {
        $this->assertCsrf();
        $id   = (int) $request->param('id'); // récupéré depuis l’URL
        $name = trim((string)($_POST['name'] ?? ''));
        $city = trim((string)($_POST['city'] ?? ''));

        if ($name === '' || $city === '') {
            $this->flash('Veuillez renseigner nom et ville', 'danger');
            header('Location: /admin/agencies/' . $id . '/edit');
            exit;
        }

        (new AgencyRepository())->update($id, $name, $city);
        $this->flash('Agence modifiée', 'success');
        header('Location: /admin/agencies');
        exit;
    }

    public function delete(Request $request, Response $response): void
    {
        $this->assertCsrf();
        $id = (int) $request->param('id');

        $repo = new AgencyRepository();
        if ($repo->tripsCount($id) > 0) {
            $this->flash('Suppression impossible : agence utilisée par des trajets', 'warning');
        } else {
            $repo->delete($id);
            $this->flash('Agence supprimée', 'success');
        }
        header('Location: /admin/agencies');
        exit;
    }

    private function assertCsrf(): void
    {
        $csrf = $_POST['csrf'] ?? '';
        if (!isset($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $csrf)) {
            $this->flash('Session expirée (CSRF).', 'danger');
            header('Location: /admin/agencies');
            exit;
        }
    }

    private function flash(string $msg, string $type = 'info'): void
    {
        $_SESSION['flash'] = ['msg' => $msg, 'type' => $type];
    }
}
