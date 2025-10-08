<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Departement;
use App\Models\Employer;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des départements de démonstration
        $departements = [
            [
                'name' => 'Ressources Humaines',
                'description' => 'Gestion du personnel et des relations humaines',
                'budget_mensuel' => 50000,
                'status' => 'actif',
                'couleur' => '#3B82F6'
            ],
            [
                'name' => 'Informatique',
                'description' => 'Développement et maintenance informatique',
                'budget_mensuel' => 75000,
                'status' => 'actif',
                'couleur' => '#10B981'
            ],
            [
                'name' => 'Marketing',
                'description' => 'Stratégie marketing et communication',
                'budget_mensuel' => 60000,
                'status' => 'actif',
                'couleur' => '#F59E0B'
            ],
            [
                'name' => 'Comptabilité',
                'description' => 'Gestion financière et comptable',
                'budget_mensuel' => 45000,
                'status' => 'actif',
                'couleur' => '#EF4444'
            ],
            [
                'name' => 'Ventes',
                'description' => 'Équipe commerciale et ventes',
                'budget_mensuel' => 80000,
                'status' => 'actif',
                'couleur' => '#8B5CF6'
            ]
        ];

        foreach ($departements as $dept) {
            Departement::create($dept);
        }

        // Récupérer les départements créés
        $rh = Departement::where('name', 'Ressources Humaines')->first();
        $it = Departement::where('name', 'Informatique')->first();
        $marketing = Departement::where('name', 'Marketing')->first();
        $compta = Departement::where('name', 'Comptabilité')->first();
        $ventes = Departement::where('name', 'Ventes')->first();

        // Créer des employés de démonstration
        $employers = [
            [
                'nom' => 'Jean Dupont',
                'prenom' => 'Jean',
                'email' => 'jean.dupont@entreprise.com',
                'contact' => '0123456789',
                'telephone' => '0123456789',
                'adresse' => '123 Rue de la Paix, Paris',
                'date_naissance' => '1985-03-15',
                'date_embauche' => '2020-01-15',
                'poste' => 'Manager RH',
                'montant_journalier' => 150.00,
                'departement_id' => $rh->id
            ],
            [
                'nom' => 'Marie Martin',
                'prenom' => 'Marie',
                'email' => 'marie.martin@entreprise.com',
                'contact' => '0123456790',
                'telephone' => '0123456790',
                'adresse' => '456 Avenue des Champs, Lyon',
                'date_naissance' => '1990-07-22',
                'date_embauche' => '2021-03-10',
                'poste' => 'Développeuse Senior',
                'montant_journalier' => 180.00,
                'departement_id' => $it->id
            ],
            [
                'nom' => 'Pierre Durand',
                'prenom' => 'Pierre',
                'email' => 'pierre.durand@entreprise.com',
                'contact' => '0123456791',
                'telephone' => '0123456791',
                'adresse' => '789 Boulevard Central, Marseille',
                'date_naissance' => '1988-11-08',
                'date_embauche' => '2019-08-20',
                'poste' => 'Chef de Projet Marketing',
                'montant_journalier' => 160.00,
                'departement_id' => $marketing->id
            ],
            [
                'nom' => 'Sophie Bernard',
                'prenom' => 'Sophie',
                'email' => 'sophie.bernard@entreprise.com',
                'contact' => '0123456792',
                'telephone' => '0123456792',
                'adresse' => '321 Rue du Commerce, Toulouse',
                'date_naissance' => '1992-04-12',
                'date_embauche' => '2022-01-05',
                'poste' => 'Comptable',
                'montant_journalier' => 120.00,
                'departement_id' => $compta->id
            ],
            [
                'nom' => 'Lucas Moreau',
                'prenom' => 'Lucas',
                'email' => 'lucas.moreau@entreprise.com',
                'contact' => '0123456793',
                'telephone' => '0123456793',
                'adresse' => '654 Place de la République, Nantes',
                'date_naissance' => '1987-09-30',
                'date_embauche' => '2020-11-15',
                'poste' => 'Commercial Senior',
                'montant_journalier' => 140.00,
                'departement_id' => $ventes->id
            ],
            [
                'nom' => 'Emma Roux',
                'prenom' => 'Emma',
                'email' => 'emma.roux@entreprise.com',
                'contact' => '0123456794',
                'telephone' => '0123456794',
                'adresse' => '987 Rue de la Liberté, Bordeaux',
                'date_naissance' => '1995-01-18',
                'date_embauche' => '2023-02-28',
                'poste' => 'Développeuse Junior',
                'montant_journalier' => 110.00,
                'departement_id' => $it->id
            ],
            [
                'nom' => 'Thomas Leroy',
                'prenom' => 'Thomas',
                'email' => 'thomas.leroy@entreprise.com',
                'contact' => '0123456795',
                'telephone' => '0123456795',
                'adresse' => '147 Avenue Victor Hugo, Nice',
                'date_naissance' => '1989-06-25',
                'date_embauche' => '2021-09-12',
                'poste' => 'Responsable Ventes',
                'montant_journalier' => 170.00,
                'departement_id' => $ventes->id
            ],
            [
                'nom' => 'Julie Petit',
                'prenom' => 'Julie',
                'email' => 'julie.petit@entreprise.com',
                'contact' => '0123456796',
                'telephone' => '0123456796',
                'adresse' => '258 Rue de la Gare, Strasbourg',
                'date_naissance' => '1993-12-03',
                'date_embauche' => '2022-06-20',
                'poste' => 'Chargée de Communication',
                'montant_journalier' => 130.00,
                'departement_id' => $marketing->id
            ]
        ];

        foreach ($employers as $emp) {
            Employer::create($emp);
        }

        // Mettre à jour les responsables des départements
        $rh->update(['responsable_id' => Employer::where('nom', 'Jean Dupont')->first()->id]);
        $it->update(['responsable_id' => Employer::where('nom', 'Marie Martin')->first()->id]);
        $marketing->update(['responsable_id' => Employer::where('nom', 'Pierre Durand')->first()->id]);
        $compta->update(['responsable_id' => Employer::where('nom', 'Sophie Bernard')->first()->id]);
        $ventes->update(['responsable_id' => Employer::where('nom', 'Lucas Moreau')->first()->id]);
    }
}
