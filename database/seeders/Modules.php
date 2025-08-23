<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;

class Modules extends Seeder
{
    public function run()
    {
        // ======= DASHBOARD =======
        Module::create([
            'name' => 'dashboard',
            'designation' => 'Dashboard',
            'color' => 'secondary',
            'icon' => 'bi bi-speedometer2',
            'lock' => true,
            'route' => 'dashboard',
        ]);

        // ======= MANAGEMENT =======
        $management = Module::create([
            'name' => 'management',
            'designation' => 'Gestions',
            'color' => 'secondary',
            'icon' => 'bi bi-kanban',
            'lock' => true,
            'hidden' => true,
            'link' => '#management',
        ]);

        Module::create([
            'name' => 'modules',
            'designation' => 'Modules',
            'color' => 'secondary',
            'icon' => 'bi bi-ui-checks-grid',
            'lock' => true,
            'hidden' => true,
            'route' => 'modules.index',
            'module_id' => $management->id,
        ]);
        Module::create([
            'name' => 'users',
            'designation' => 'Utilisateurs',
            'color' => 'secondary',
            'icon' => 'bi bi-people',
            'lock' => true,
            'hidden' => true,
            'route' => 'users.index',
            'module_id' => $management->id,
        ]);

        Module::create([
            'name' => 'access',
            'designation' => 'Permissions & Roles',
            'color' => 'success',
            'icon' => 'bi bi-shield-lock',
            'lock' => true,
            'hidden' => true,
            'route' => 'access.index',
            'module_id' => $management->id,
        ]);

        Module::create([
            'name' => 'tarifs',
            'designation' => 'Tarifs',
            'color' => 'primary',
            'icon' => 'bi bi-ui-checks',
            'lock' => true,
            'hidden' => true,
            'route' => 'tarifs.index',
            'module_id' => $management->id,
        ]);

        // ======= APP =======
        $app = Module::create([
            'name' => 'app',
            'designation' => 'App',
            'color' => 'info',
            'icon' => 'bi bi-grid',
            'link' => '#app',
            'hidden' => true,
        ]);

        Module::create([
            'name' => 'services',
            'designation' => 'Services',
            'color' => 'warning',
            'icon' => 'bi bi-briefcase',
            'lock' => true,
            'route' => 'services.index',
            'module_id' => $app->id,
        ]);

        Module::create([
            'name' => 'chats',
            'designation' => 'Chat',
            'color' => 'success',
            'icon' => 'bi bi-chat',
            'lock' => true,
            'route' => 'chats',
            'module_id' => $app->id,
        ]);

        Module::create([
            'name' => 'resumes',
            'designation' => 'Résumé (CV)',
            'color' => 'info',
            'icon' => 'bi bi-file-person',
            'lock' => true,
            'route' => 'resumes.index',
            'module_id' => $app->id,
        ]);

        Module::create([
            'name' => 'vcards',
            'designation' => 'VCard',
            'color' => 'warning',
            'icon' => 'bi bi-person-vcard',
            'lock' => true,
            'route' => 'vcards.index',
            'module_id' => $app->id,
        ]);

        Module::create([
            'name' => 'qrcodes',
            'designation' => 'Qrcodes',
            'color' => 'dark',
            'icon' => 'bi bi-qr-code',
            'lock' => true,
            'route' => 'qrcodes.index',
            'module_id' => $app->id,
        ]);
        Module::create([
            'name' => 'websites',
            'designation' => 'Site Web',
            'color' => 'dark',
            'icon' => 'bi bi-globe',
            'lock' => true,
            'route' => 'websites.index',
            'module_id' => $app->id,
        ]);

        Module::create([
            'name' => 'emails',
            'designation' => 'Email',
            'color' => 'success',
            'icon' => 'bi bi-envelope',
            'lock' => true,
            'route' => 'emails.index',
            'module_id' => $app->id,
        ]);

        // ======= COMMERCIALE =======
        $commerciale = Module::create([
            'name' => 'commerciale',
            'designation' => 'Gestion Commerciale',
            'color' => 'secondary',
            'icon' => 'bi bi-shop',
            'link' => '#commerciale',
            'hidden' => true,
        ]);

        $articles = Module::create([
            'name' => 'articles',
            'designation' => 'Gestion des Articles',
            'color' => 'warning',
            'icon' => 'bi bi-cart3',
            'lock' => true,
            'link' => '#articles',
            'module_id' => $commerciale->id,
        ]);

        Module::create([
            'name' => 'categories',
            'designation' => 'Catégories',
            'color' => 'warning',
            'icon' => 'bi bi-box',
            'lock' => true,
            'route' => 'categories.index',
            'module_id' => $articles->id,
        ]);

        Module::create([
            'name' => 'produits',
            'designation' => 'Produits',
            'color' => 'danger',
            'icon' => 'bi bi-boxes',
            'lock' => true,
            'route' => 'produits.index',
            'module_id' => $articles->id,
        ]);

        Module::create([
            'name' => 'clients',
            'designation' => 'Clients',
            'color' => 'secondary',
            'icon' => 'bi bi-person',
            'lock' => true,
            'route' => 'clients.index',
            'module_id' => $commerciale->id,
        ]);

        Module::create([
            'name' => 'factures',
            'designation' => 'Factures',
            'color' => 'success',
            'icon' => 'bi bi-receipt',
            'lock' => true,
            'route' => 'factures.index',
            'module_id' => $commerciale->id,
        ]);

        Module::create([
            'name' => 'devis',
            'designation' => 'Devis',
            'color' => 'secondary',
            'icon' => 'bi bi-file-earmark-text',
            'lock' => true,
            'route' => 'devis.index',
            'module_id' => $commerciale->id,
        ]);

        Module::create([
            'name' => 'contrats',
            'designation' => 'Contrats',
            'color' => 'secondary',
            'icon' => 'bi bi-file-earmark',
            'route' => 'contrats.index',
            'lock' => true,
            'module_id' => $commerciale->id,
        ]);

        Module::create([
            'name' => 'fournisseurs',
            'designation' => 'Fournisseurs',
            'color' => 'dark',
            'icon' => 'bi bi-person-check',
            'link' => '#!',
            'lock' => true,
            'module_id' => $commerciale->id,
        ]);

        // ======= COMPTABILITE =======
        $comptabilite = Module::create([
            'name' => 'comptabilite',
            'designation' => 'Comptablité',
            'color' => 'danger',
            'icon' => 'bi bi-bank',
            'link' => '#comptabilite',
            'hidden' => true,
        ]);

        Module::create([
            'name' => 'comptes',
            'designation' => 'Comptes',
            'color' => 'danger',
            'icon' => 'bi bi-person-circle',
            'link' => '#!',
            'lock' => true,
            'module_id' => $comptabilite->id,
        ]);

        Module::create([
            'name' => 'journal',
            'designation' => 'Journal',
            'color' => 'primary',
            'icon' => 'bi bi-journals',
            'lock' => true,
            'route' => 'journals.index',
            'module_id' => $comptabilite->id,
        ]);

        Module::create([
            'name' => 'caisse',
            'designation' => 'Caisses',
            'color' => 'success',
            'icon' => 'bi bi-cash-coin',
            'link' => '#!',
            'lock' => true,
            'module_id' => $comptabilite->id,
        ]);

        Module::create([
            'name' => 'paiements',
            'designation' => 'Paiements',
            'color' => 'success',
            'icon' => 'bi bi-cash-stack',
            'link' => '#!',
            'lock' => true,
            'module_id' => $comptabilite->id,
        ]);

        // ======= RH =======
        $rh = Module::create([
            'name' => 'rh',
            'designation' => 'Ressource Humaine',
            'color' => 'success',
            'icon' => 'bi bi-person-workspace',
            'link' => '#rh',
            'hidden' => true,
        ]);

        Module::create([
            'name' => 'postes',
            'designation' => 'Postes',
            'color' => 'primary',
            'icon' => 'bi bi-person-vcard-fill',
            'lock' => true,
            'statut' => 'new',
            'route' => 'postes.index',
            'module_id' => $rh->id,
        ]);

        Module::create([
            'name' => 'employes',
            'designation' => 'Employes',
            'color' => 'info',
            'icon' => 'bi bi-person-badge-fill',
            'lock' => true,
            'statut' => 'new',
            'route' => 'employes.index',
            'module_id' => $rh->id,
        ]);

        Module::create([
            'name' => 'pointages',
            'designation' => 'Pointages',
            'color' => 'warning',
            'icon' => 'bi bi-clock-fill',
            'lock' => true,
            'statut' => 'new',
            'route' => 'pointages.index',
            'module_id' => $rh->id,
        ]);

        // ======= DOCUMENTATIONS =======
        Module::create([
            'name' => 'documentations',
            'designation' => 'documentations',
            'color' => 'secondary',
            'icon' => 'bi bi-file-earmark-code-fill',
            'hidden' => true,
            'target' => '_blank',
            'route' => 'docs',
            'lock' => true,
        ]);
    }
}
