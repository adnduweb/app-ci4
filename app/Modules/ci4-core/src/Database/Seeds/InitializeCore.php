<?php

namespace Adnduweb\Ci4Core\Database\Seeds;
 
use CodeIgniter\Database\Seeder;
use Faker\Factory;

use Adnduweb\Ci4Core\Models\LanguageModel;
use Adnduweb\Ci4Core\Models\CurrencyModel;
use Adnduweb\Ci4Core\Models\CountryModel;
use Adnduweb\Ci4Core\Models\TabModel;
use Adnduweb\Ci4Admin\Entities\User;
use Adnduweb\Ci4Admin\Models\UserModel;
use Adnduweb\Ci4Core\Models\CompanyModel;
use Adnduweb\Ci4Core\Models\SettingModel;
use Adnduweb\Ci4Core\Models\AuditModel;
use Adnduweb\Ci4Core\Models\ModuleModel;

class InitializeCore extends Seeder
{

    protected $uuid1;
    protected $uuid2;
    protected $uuid3;

    public function run()
    {
        //helper('common');

        cache()->clean();

        $this->createLanguages();

        //$this->createCurrency();

        $this->createCrountry();

        $uuid_company = $this->createCompany();
        //$uuid_company= '';

        $this->createUsers($uuid_company);

        $this->createModules();
    }

    public function createLanguages()
    {
        // Define default project langue
        $rows = [
            [
                'name'       => 'Français (French)',
                'active'      => 1,
                'iso_code'      => 'fr',
                'language_code'    => 'fr',
                'locale'    =>  'fr_FR',
                'date_format_lite'  => 'd/m/y',
                'date_format_full'  => 'd/m/y',
            ],
            [
                'name'       => 'Anglais',
                'active'      => 1,
                'iso_code'      => 'en',
                'language_code'    => 'en',
                'locale'    =>  'en_EN',
                'date_format_lite'  => 'y/m/d',
                'date_format_full'  => 'y/m/d',
            ]

        ];

        // Check for and create project langues
        $languages = new languageModel();
        foreach ($rows as $row) {
            $langue = $languages->where('name', $row['name'])->first();

            if (empty($langue)) {
                // No langue - add the row
                $languages->insert($row);
            }
        }
    }

    public function createCurrency()
    {
        // Define default project currency
        $rows = [
            [
                'name'       => 'Euro',
                'iso_code'      => 'EUR',
                'symbol'      => '€',
                'numeric_iso_code'    => 978,
                'precision'    =>  '2',
                'conversion_rate'  => '1.000000',
                'active'  => 1,
            ],
            [
                'name'       => 'Pound',
                'iso_code'      => 'GBP',
                'symbol'      => '£',
                'numeric_iso_code'    => 826,
                'precision'    =>  '2',
                'conversion_rate'  => '0.897195',
                'active'  => 1,
            ]

        ];

        // Check for and create project currency
        $devise = new CurrencyModel();
        foreach ($rows as $row) {
            $deviseRow = $devise->where('name', $row['name'])->first();

            if (empty($deviseRow)) {
                // No currency - add the row
                //print_r($devise);
                $devise->insert($row);
            }
        }
    }

    public function createCrountry()
    {
        // Define default project country
        $languages = new languageModel();
        $langues = $languages->get()->getResult();
        $i = 0;
        foreach ($langues as $langue) {
            foreach ($this->getCountry() as $key => $v) {
                $rows[$i]['id_lang'] = $langue->id;
                $rows[$i]['code_iso'] = $key;
                $rows[$i]['name'] = $v[$langue->iso_code];
                $i++;
            }
        }
        //print_r($rows); exit;

        // Check for and create project country
        $country = new CountryModel();
        foreach ($rows as $row) {
            $countryRow = $country->where('name', $row['name'])->first();

            if (empty($countryRow)) {
                // No langue - add the row
                $country->insert($row);
            }
        }
    }

    public function createUsers($uuid_company)
    {
        $this->uuid1  = service('uuid')->uuid4();
        $this->uuid2  = service('uuid')->uuid4();
        $rowsGroups = [
            [
                'id'                => 1,
                'name'              => 'super adminstrateur',
                'description'       => 'accès à tout',
                'login_destination' => 'dashboard',
                'is_hide'           => 1,
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ],
            [
                'id'                => 2,
                'name'              => 'adminstrateur',
                'description'       => 'Idéal pour les propriétaires d\'entreprise et les administrateurs d\'entreprise',
                'login_destination' => 'users',
                'is_hide'           => 0,
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ],
            [
                'id'                => 3,
                'name'              => 'analyst',
                'description'       => 'Idéal pour les personnes qui ont besoin d\'un accès complet aux données d\'analyse, mais n\'ont pas besoin de mettre à jour les paramètres de l\'entreprise',
                'login_destination' => 'dashboard',
                'is_hide'           => 0,
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ],
            [
                'id'                => 4,
                'name'              => 'demo',
                'description'       => 'Idéal pour les personnes qui ont besoin de prévisualiser les données de contenu, mais n\'ont pas besoin de faire de mises à jour',
                'login_destination' => 'dashboard',
                'is_hide'           => 0,
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ],
        ];

        // on insrére les groupes par défault
        $db = \Config\Database::connect();
        foreach ($rowsGroups as $row) {
            $tabRow =  $db->table('auth_groups')->where('name', $row['name'])->get()->getRow();
            if (empty($tabRow)) {
                // No langue - add the row
                $db->table('auth_groups')->insert($row);
            }
        }

        $rowsUsersSA = [
            'email'        => 'admin@admin.com',
            'username'     => 'Fabrice Loru',
            'lastname'     => 'Super',
            'firstname'    => 'Hero',
            'fonction'     => 'developer',
            'password'     => '123456',
            'active'       => 1,
            'lang'         => 'fr',
            'created_at'   => date('Y-m-d H:i:s'),
            'company_id'   => 1,
            'uuid'         => $this->uuid1->toString(),
            'is_principal' => 0
        ];
        $rowsUsersA = [
            'email'        => 'admin2@admin.com',
            'username'     => 'JohnC Doe',
            'lastname'     => 'Doe2',
            'firstname'    => 'John2',
            'fonction'     => 'marketing',
            'password'     => '123456',
            'active'       => 1,
            'lang'         => 'fr',
            'created_at'   => date('Y-m-d H:i:s'),
            'company_id'   => 1,
            'uuid'         => $this->uuid2->toString(),
            'is_principal' => 1
        ];

        // print_r($rowsUsersSA); exit;
        // On insére le user par défault
        $users = new UserModel(); 

        $userSA = new User($rowsUsersSA);
        // print_r($userSA); 
        // print_r($users->save($userSA)); exit;
        $users->save($userSA);

        $userA = new User($rowsUsersA);
        $users->save($userA);

        $rowsGroupsUsers = [
            [
                'group_id'          => 1,
                'user_id'           => 1,
            ],
            // [
            //     'group_id'          => 2,
            //     'user_id'           => 1,
            // ],
            [
                'group_id'          => 2,
                'user_id'           => 2,
            ],
        ];
        // On insére le role par default au user
        foreach ($rowsGroupsUsers as $row) {
            $tabRow =  $db->table('auth_groups_users')->where(['group_id' => $row['group_id'], 'user_id' => $row['user_id']])->get()->getRow();
            if (empty($tabRow)) {
                // No langue - add the row
                $db->table('auth_groups_users')->insert($row);
            }
        }



        // On créer les réglages par défault de l'application.

        $settings = [
            [
                'class'      => 'App.theme_bo',
                'value'     => 'metronic',
                'context'   => 'name',
            ],
            [
                'class'      => 'App.language_bo',
                'value'     => 'fr',
                'context'   => 'change',
            ]



        ];
        foreach ($settings as $row) {
            service('settings')->set($row['class'], $row['value'], $row['context']);
        }

        // Et les permissions
        $rowsPermissionsUsers = [
            [
                'name'              => 'system.index',
                'description'       => "Voir l'onglet système",
                'is_natif'          => '1',
            ],
            [
                'name'              => 'modules.index',
                'description'       => "Voir l'onglet modules",
                'is_natif'          => '1',
            ],
            [
                'name'              => 'public.index',
                'description'       => "Voir l'onglet public",
                'is_natif'          => '1',
            ],
            [
                'name'              => 'users.index',
                'description'       => 'Voir les utilisateurs',
                'is_natif'          => '1',
            ],
            [
                'name'              => 'users.create',
                'description'       => 'Créer des utilisateurs',
                'is_natif'          => '1',
            ],
            [
                'name'              => 'users.edit',
                'description'       => 'Modifier les utilisateurs',
                'is_natif'          => '1',
            ],
            [
                'name'              => 'users.delete',
                'description'       => 'Supprimer des utilisateurs',
                'is_natif'          => '1',
            ],
            [
                'name'              => 'users.manageGroup',
                'description'       => 'L\'utilisateur peut changer de groupe',
                'is_natif'          => '1',
            ],
            [
                'name'              => 'users.editOnly',
                'description'       => 'Modifier seulement son compte',
                'is_natif'          => '1',
            ],
            [
                'name'              => 'groups.index',
                'description'       => 'Voir les groupes',
                'is_natif'          => '1',
            ],
            [
                'name'              => 'groups.create',
                'description'       => 'Créer des groupes',
                'is_natif'          => '1',
            ],
            [
                'name'              => 'groups.edit',
                'description'       => 'Modifier les groupes',
                'is_natif'          => '1',
            ],
            [
                'name'              => 'groups.delete',
                'description'       => 'Supprimer des groupes',
                'is_natif'          => '1',
            ],
            [
                'name'              => 'permissions.index',
                'description'       => 'Voir les permissions',
                'is_natif'          => '1',
            ],
            [
                'name'              => 'permissions.create',
                'description'       => 'Créer des permissions',
                'is_natif'          => '1',
            ],
            [
                'name'              => 'permissions.edit',
                'description'       => 'Modifier les permissions',
                'is_natif'          => '1',
            ],
            [
                'name'              => 'permissions.delete',
                'description'       => 'Supprimer des permissions',
                'is_natif'          => '1',
            ],
            [
                'name'              => 'routes.index',
                'description'       => 'Voir/editer les routes',
                'is_natif'          => '1',
            ],
            [
                'name'              => 'informations.index',
                'description'       => 'Voir les informations',
                'is_natif'          => '1',
            ],
            [
                'name'              => 'settings.index',
                'description'       => 'Voir les réglages',
                'is_natif'          => '1',
            ],
            [
                'name'              => 'settings.edit',
                'description'       => 'Modifier les réglages',
                'is_natif'          => '1',
            ],
            [
                'name'              => 'translates.index',
                'description'       => 'Voir les traductions',
                'is_natif'          => '1',
            ],
            [
                'name'              => 'logs.index',
                'description'       => 'Voir les logs',
                'is_natif'          => '1',
            ],
            [
                'name'              => 'modules.index',
                'description'       => 'Voir les modules',
                'is_natif'          => '1',
            ],
        ];
        // On insére le role par default au user
        foreach ($rowsPermissionsUsers as $row) {
            $tabRow =  $db->table('auth_permissions')->where(['name' => $row['name']])->get()->getRow();
            if (empty($tabRow)) {
                // No langue - add the row
                $db->table('auth_permissions')->insert($row);
            }
        }


        // on insrére les persmissions par groupes par défault
        $rowsGroupsPermissions = [

            [
                'group_id'      => 2,
                'permission_id' => 1,
            ],
            [
                'group_id'      => 2,
                'permission_id' => 2,
            ],
            [
                'group_id'      => 2,
                'permission_id' => 3,
            ],
            [
                'group_id'      => 2,
                'permission_id' => 4,
            ]


        ];
        // On insére le role par default au user
        foreach ($rowsGroupsPermissions as $row) {
            $tabRow =  $db->table('auth_groups_permissions')->where(['group_id' => $row['group_id'], 'permission_id' => $row['permission_id']])->get()->getRow();
            if (empty($tabRow)) {
                // No langue - add the row
                $db->table('auth_groups_permissions')->insert($row);
            }
        }
    }

    public function createCompany()
    {

        // use the factory to create a Faker\Generator instance
        $faker = Factory::create();

        $this->uuid3  = service('uuid')->uuid4();
        $db = \Config\Database::connect();

        // Define default project Company Type
        $rowsCompanyType = [
            [
                'id'       => 1,
                'nom_court'             => 'SARL',
                'nom_long'              => 'Société à responsabilité limitée',
                'created_at'            => date('Y-m-d H:i:s'),
                'updated_at'            => date('Y-m-d H:i:s'),
            ],
            [
                'id'       => 2,
                'nom_court'             => 'EURL',
                'nom_long'              => 'Entreprise unipersonnelle à responsabilité limitée',
                'created_at'            => date('Y-m-d H:i:s'),
                'updated_at'            => date('Y-m-d H:i:s'),
            ],
            [
                'id'       => 3,
                'nom_court'             => 'SELARL',
                'nom_long'              => "Société d'exercice libéral à responsabilité limitée",
                'created_at'            => date('Y-m-d H:i:s'),
                'updated_at'            => date('Y-m-d H:i:s'),
            ],
            [
                'id'       => 4,
                'nom_court'             => 'SA',
                'nom_long'              => 'Société anonyme',
                'created_at'            => date('Y-m-d H:i:s'),
                'updated_at'            => date('Y-m-d H:i:s'),
            ],
            [
                'id'       => 5,
                'nom_court'             => 'SAS',
                'nom_long'              => 'Société par actions simplifiée',
                'created_at'            => date('Y-m-d H:i:s'),
                'updated_at'            => date('Y-m-d H:i:s'),
            ],
            [
                'id'       => 6,
                'nom_court'             => 'SASU',
                'nom_long'              => 'Société par actions simplifiée unipersonnelle',
                'created_at'            => date('Y-m-d H:i:s'),
                'updated_at'            => date('Y-m-d H:i:s'),
            ],
            [
                'id'       => 7,
                'nom_court'             => 'SNC',
                'nom_long'              => 'Société en nom collectif',
                'created_at'            => date('Y-m-d H:i:s'),
                'updated_at'            => date('Y-m-d H:i:s'),
            ],
            [
                'id'       => 8,
                'nom_court'             => 'SCP',
                'nom_long'              => 'Société civile professionnelle',
                'created_at'            => date('Y-m-d H:i:s'),
                'updated_at'            => date('Y-m-d H:i:s'),
            ],
            [
                'id'         => 9,
                'nom_court'  => 'ME',
                'nom_long'   => 'Micro entreprise',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

        ];

        // Check for and create project company Type
        foreach ($rowsCompanyType as $row) {
            $companyRow = $db->table('companies_type')->where('nom_court', $row['nom_court'])->get()->getRow();

            if (empty($companyRow)) {
                // No company type - add the row
                $db->table('companies_type')->insert($row);
            }
        }

        $rowsCompany = [
            [
                'id'               => 1,
                'uuid_company'     => $this->uuid3->toString(),
                'company_type_id'  => 1,
                'country_id'       => 74,
                'raison_social'    => 'Company Name',
                'email'            => 'contact@exemple.fr',
                'adresse'          => '3, street Eminem',
                'adresse2'         => '',
                'ville'            => 'Houston',
                'code_postal'      => '2456 67',
                'phone'            => '+33684521245',
                'phone_mobile'     => '+33684521245',
                'fax'              => '+33684521245',
                'siret'            => '78979907890',
                'ape'              => 'z4567',
                'tva'              => 1,
                'is_ttc'           => 0,
                'bio'              => $faker->text(),
                'logo'             => '',
                'active'           => 1
            ]
        ];

        // Check for and create project company
        $company = new CompanyModel();
        foreach ($rowsCompany as $row) {
            $companyRow = $company->where('raison_social', $row['raison_social'])->first();
            if (empty($companyRow)) {
                // No company - add the row
                $company->insert($row);
            }
        }

        $rowsCompanyLangs = [
            [
                'company_id'         => 1,
                'id_lang'  => 1,
                'bio'   => 'Je suis une bio'
            ],
        ];

        // Check for and create project company Type
        foreach ($rowsCompanyLangs as $row) {
            $companyRow = $db->table('companies_langs')->where('company_id', $row['company_id'])->get()->getRow();

            if (empty($companyRow)) {
                // No company type - add the row
                $db->table('companies_langs')->insert($row);
            }
        }
        return $this->uuid3->toString();
    }

    public function getCountry()
    {
        $countryList = array(
            'AD' => array('en' => 'Andorra', 'fr' => 'Andorre'),
            'AE' => array('en' => 'United Arab Emirates', 'fr' => 'Émirats arabes unis'),
            'AF' => array('en' => 'Afghanistan', 'fr' => 'Afghanistan'),
            'AG' => array('en' => 'Antigua and Barbuda', 'fr' => 'Antigua-et-Barbuda'),
            'AI' => array('en' => 'Anguilla', 'fr' => 'Anguilla'),
            'AL' => array('en' => 'Albania', 'fr' => 'Albanie'),
            'AM' => array('en' => 'Armenia', 'fr' => 'Arménie'),
            'AN' => array('en' => 'Netherlands Antilles', 'fr' => 'Antilles néerlandaises'),
            'AO' => array('en' => 'Angola', 'fr' => 'Angola'),
            'AQ' => array('en' => 'Antarctica', 'fr' => 'Antarctique'),
            'AR' => array('en' => 'Argentina', 'fr' => 'Argentine'),
            'AS' => array('en' => 'American Samoa', 'fr' => 'Samoa américaines'),
            'AT' => array('en' => 'Austria', 'fr' => 'Autriche'),
            'AU' => array('en' => 'Australia', 'fr' => 'Australie'),
            'AW' => array('en' => 'Aruba', 'fr' => 'Aruba'),
            'AX' => array('en' => 'Åland Islands', 'fr' => 'Îles Åland'),
            'AZ' => array('en' => 'Azerbaijan', 'fr' => 'Azerbaïdjan'),
            'BA' => array('en' => 'Bosnia and Herzegovina', 'fr' => 'Bosnie-Herzégovine'),
            'BB' => array('en' => 'Barbados', 'fr' => 'Barbade'),
            'BD' => array('en' => 'Bangladesh', 'fr' => 'Bangladesh'),
            'BE' => array('en' => 'Belgium', 'fr' => 'Belgique'),
            'BF' => array('en' => 'Burkina Faso', 'fr' => 'Burkina Faso'),
            'BG' => array('en' => 'Bulgaria', 'fr' => 'Bulgarie'),
            'BH' => array('en' => 'Bahrain', 'fr' => 'Bahreïn'),
            'BI' => array('en' => 'Burundi', 'fr' => 'Burundi'),
            'BJ' => array('en' => 'Benin', 'fr' => 'Bénin'),
            'BL' => array('en' => 'Saint Barthélemy', 'fr' => 'Saint-Barthélémy'),
            'BM' => array('en' => 'Bermuda', 'fr' => 'Bermudes'),
            'BN' => array('en' => 'Brunei', 'fr' => 'Brunéi Darussalam'),
            'BO' => array('en' => 'Bolivia', 'fr' => 'Bolivie'),
            'BR' => array('en' => 'Brazil', 'fr' => 'Brésil'),
            'BS' => array('en' => 'Bahamas', 'fr' => 'Bahamas'),
            'BT' => array('en' => 'Bhutan', 'fr' => 'Bhoutan'),
            'BV' => array('en' => 'Bouvet Island', 'fr' => 'Île Bouvet'),
            'BW' => array('en' => 'Botswana', 'fr' => 'Botswana'),
            'BY' => array('en' => 'Belarus', 'fr' => 'Bélarus'),
            'BZ' => array('en' => 'Belize', 'fr' => 'Belize'),
            'CA' => array('en' => 'Canada', 'fr' => 'Canada'),
            'CC' => array('en' => 'Cocos [Keeling] Islands', 'fr' => 'Îles Cocos - Keeling'),
            'CD' => array('en' => 'Congo - Kinshasa', 'fr' => 'République démocratique du Congo'),
            'CF' => array('en' => 'Central African Republic', 'fr' => 'République centrafricaine'),
            'CG' => array('en' => 'Congo - Brazzaville', 'fr' => 'Congo'),
            'CH' => array('en' => 'Switzerland', 'fr' => 'Suisse'),
            'CI' => array('en' => 'Côte d’Ivoire', 'fr' => 'Côte d’Ivoire'),
            'CK' => array('en' => 'Cook Islands', 'fr' => 'Îles Cook'),
            'CL' => array('en' => 'Chile', 'fr' => 'Chili'),
            'CM' => array('en' => 'Cameroon', 'fr' => 'Cameroun'),
            'CN' => array('en' => 'China', 'fr' => 'Chine'),
            'CO' => array('en' => 'Colombia', 'fr' => 'Colombie'),
            'CR' => array('en' => 'Costa Rica', 'fr' => 'Costa Rica'),
            'CU' => array('en' => 'Cuba', 'fr' => 'Cuba'),
            'CV' => array('en' => 'Cape Verde', 'fr' => 'Cap-Vert'),
            'CX' => array('en' => 'Christmas Island', 'fr' => 'Île Christmas'),
            'CY' => array('en' => 'Cyprus', 'fr' => 'Chypre'),
            'CZ' => array('en' => 'Czech Republic', 'fr' => 'République tchèque'),
            'DE' => array('en' => 'Germany', 'fr' => 'Allemagne'),
            'DJ' => array('en' => 'Djibouti', 'fr' => 'Djibouti'),
            'DK' => array('en' => 'Denmark', 'fr' => 'Danemark'),
            'DM' => array('en' => 'Dominica', 'fr' => 'Dominique'),
            'DO' => array('en' => 'Dominican Republic', 'fr' => 'République dominicaine'),
            'DZ' => array('en' => 'Algeria', 'fr' => 'Algérie'),
            'EC' => array('en' => 'Ecuador', 'fr' => 'Équateur'),
            'EE' => array('en' => 'Estonia', 'fr' => 'Estonie'),
            'EG' => array('en' => 'Egypt', 'fr' => 'Égypte'),
            'EH' => array('en' => 'Western Sahara', 'fr' => 'Sahara occidental'),
            'ER' => array('en' => 'Eritrea', 'fr' => 'Érythrée'),
            'ES' => array('en' => 'Spain', 'fr' => 'Espagne'),
            'ET' => array('en' => 'Ethiopia', 'fr' => 'Éthiopie'),
            'FI' => array('en' => 'Finland', 'fr' => 'Finlande'),
            'FJ' => array('en' => 'Fiji', 'fr' => 'Fidji'),
            'FK' => array('en' => 'Falkland Islands', 'fr' => 'Îles Malouines'),
            'FM' => array('en' => 'Micronesia', 'fr' => 'États fédérés de Micronésie'),
            'FO' => array('en' => 'Faroe Islands', 'fr' => 'Îles Féroé'),
            'FR' => array('en' => 'France', 'fr' => 'France'),
            'GA' => array('en' => 'Gabon', 'fr' => 'Gabon'),
            'GB' => array('en' => 'United Kingdom', 'fr' => 'Royaume-Uni'),
            'GD' => array('en' => 'Grenada', 'fr' => 'Grenade'),
            'GE' => array('en' => 'Georgia', 'fr' => 'Géorgie'),
            'GF' => array('en' => 'French Guiana', 'fr' => 'Guyane française'),
            'GG' => array('en' => 'Guernsey', 'fr' => 'Guernesey'),
            'GH' => array('en' => 'Ghana', 'fr' => 'Ghana'),
            'GI' => array('en' => 'Gibraltar', 'fr' => 'Gibraltar'),
            'GL' => array('en' => 'Greenland', 'fr' => 'Groenland'),
            'GM' => array('en' => 'Gambia', 'fr' => 'Gambie'),
            'GN' => array('en' => 'Guinea', 'fr' => 'Guinée'),
            'GP' => array('en' => 'Guadeloupe', 'fr' => 'Guadeloupe'),
            'GQ' => array('en' => 'Equatorial Guinea', 'fr' => 'Guinée équatoriale'),
            'GR' => array('en' => 'Greece', 'fr' => 'Grèce'),
            'GS' => array('en' => 'South Georgia and the South Sandwich Islands', 'fr' => 'Géorgie du Sud et les îles Sandwich du Sud'),
            'GT' => array('en' => 'Guatemala', 'fr' => 'Guatemala'),
            'GU' => array('en' => 'Guam', 'fr' => 'Guam'),
            'GW' => array('en' => 'Guinea-Bissau', 'fr' => 'Guinée-Bissau'),
            'GY' => array('en' => 'Guyana', 'fr' => 'Guyana'),
            'HK' => array('en' => 'Hong Kong SAR China', 'fr' => 'R.A.S. chinoise de Hong Kong'),
            'HM' => array('en' => 'Heard Island and McDonald Islands', 'fr' => 'Îles Heard et MacDonald'),
            'HN' => array('en' => 'Honduras', 'fr' => 'Honduras'),
            'HR' => array('en' => 'Croatia', 'fr' => 'Croatie'),
            'HT' => array('en' => 'Haiti', 'fr' => 'Haïti'),
            'HU' => array('en' => 'Hungary', 'fr' => 'Hongrie'),
            'ID' => array('en' => 'Indonesia', 'fr' => 'Indonésie'),
            'IE' => array('en' => 'Ireland', 'fr' => 'Irlande'),
            'IL' => array('en' => 'Israel', 'fr' => 'Israël'),
            'IM' => array('en' => 'Isle of Man', 'fr' => 'Île de Man'),
            'IN' => array('en' => 'India', 'fr' => 'Inde'),
            'IO' => array('en' => 'British Indian Ocean Territory', 'fr' => 'Territoire britannique de l\'océan Indien'),
            'IQ' => array('en' => 'Iraq', 'fr' => 'Irak'),
            'IR' => array('en' => 'Iran', 'fr' => 'Iran'),
            'IS' => array('en' => 'Iceland', 'fr' => 'Islande'),
            'IT' => array('en' => 'Italy', 'fr' => 'Italie'),
            'JE' => array('en' => 'Jersey', 'fr' => 'Jersey'),
            'JM' => array('en' => 'Jamaica', 'fr' => 'Jamaïque'),
            'JO' => array('en' => 'Jordan', 'fr' => 'Jordanie'),
            'JP' => array('en' => 'Japan', 'fr' => 'Japon'),
            'KE' => array('en' => 'Kenya', 'fr' => 'Kenya'),
            'KG' => array('en' => 'Kyrgyzstan', 'fr' => 'Kirghizistan'),
            'KH' => array('en' => 'Cambodia', 'fr' => 'Cambodge'),
            'KI' => array('en' => 'Kiribati', 'fr' => 'Kiribati'),
            'KM' => array('en' => 'Comoros', 'fr' => 'Comores'),
            'KN' => array('en' => 'Saint Kitts and Nevis', 'fr' => 'Saint-Kitts-et-Nevis'),
            'KP' => array('en' => 'North Korea', 'fr' => 'Corée du Nord'),
            'KR' => array('en' => 'South Korea', 'fr' => 'Corée du Sud'),
            'KW' => array('en' => 'Kuwait', 'fr' => 'Koweït'),
            'KY' => array('en' => 'Cayman Islands', 'fr' => 'Îles Caïmans'),
            'KZ' => array('en' => 'Kazakhstan', 'fr' => 'Kazakhstan'),
            'LA' => array('en' => 'Laos', 'fr' => 'Laos'),
            'LB' => array('en' => 'Lebanon', 'fr' => 'Liban'),
            'LC' => array('en' => 'Saint Lucia', 'fr' => 'Sainte-Lucie'),
            'LI' => array('en' => 'Liechtenstein', 'fr' => 'Liechtenstein'),
            'LK' => array('en' => 'Sri Lanka', 'fr' => 'Sri Lanka'),
            'LR' => array('en' => 'Liberia', 'fr' => 'Libéria'),
            'LS' => array('en' => 'Lesotho', 'fr' => 'Lesotho'),
            'LT' => array('en' => 'Lithuania', 'fr' => 'Lituanie'),
            'LU' => array('en' => 'Luxembourg', 'fr' => 'Luxembourg'),
            'LV' => array('en' => 'Latvia', 'fr' => 'Lettonie'),
            'LY' => array('en' => 'Libya', 'fr' => 'Libye'),
            'MA' => array('en' => 'Morocco', 'fr' => 'Maroc'),
            'MC' => array('en' => 'Monaco', 'fr' => 'Monaco'),
            'MD' => array('en' => 'Moldova', 'fr' => 'Moldavie'),
            'ME' => array('en' => 'Montenegro', 'fr' => 'Monténégro'),
            'MF' => array('en' => 'Saint Martin', 'fr' => 'Saint-Martin'),
            'MG' => array('en' => 'Madagascar', 'fr' => 'Madagascar'),
            'MH' => array('en' => 'Marshall Islands', 'fr' => 'Îles Marshall'),
            'MK' => array('en' => 'Macedonia', 'fr' => 'Macédoine'),
            'ML' => array('en' => 'Mali', 'fr' => 'Mali'),
            'MM' => array('en' => 'Myanmar [Burma]', 'fr' => 'Myanmar'),
            'MN' => array('en' => 'Mongolia', 'fr' => 'Mongolie'),
            'MO' => array('en' => 'Macau SAR China', 'fr' => 'R.A.S. chinoise de Macao'),
            'MP' => array('en' => 'Northern Mariana Islands', 'fr' => 'Îles Mariannes du Nord'),
            'MQ' => array('en' => 'Martinique', 'fr' => 'Martinique'),
            'MR' => array('en' => 'Mauritania', 'fr' => 'Mauritanie'),
            'MS' => array('en' => 'Montserrat', 'fr' => 'Montserrat'),
            'MT' => array('en' => 'Malta', 'fr' => 'Malte'),
            'MU' => array('en' => 'Mauritius', 'fr' => 'Maurice'),
            'MV' => array('en' => 'Maldives', 'fr' => 'Maldives'),
            'MW' => array('en' => 'Malawi', 'fr' => 'Malawi'),
            'MX' => array('en' => 'Mexico', 'fr' => 'Mexique'),
            'MY' => array('en' => 'Malaysia', 'fr' => 'Malaisie'),
            'MZ' => array('en' => 'Mozambique', 'fr' => 'Mozambique'),
            'NA' => array('en' => 'Namibia', 'fr' => 'Namibie'),
            'NC' => array('en' => 'New Caledonia', 'fr' => 'Nouvelle-Calédonie'),
            'NE' => array('en' => 'Niger', 'fr' => 'Niger'),
            'NF' => array('en' => 'Norfolk Island', 'fr' => 'Île Norfolk'),
            'NG' => array('en' => 'Nigeria', 'fr' => 'Nigéria'),
            'NI' => array('en' => 'Nicaragua', 'fr' => 'Nicaragua'),
            'NL' => array('en' => 'Netherlands', 'fr' => 'Pays-Bas'),
            'NO' => array('en' => 'Norway', 'fr' => 'Norvège'),
            'NP' => array('en' => 'Nepal', 'fr' => 'Népal'),
            'NR' => array('en' => 'Nauru', 'fr' => 'Nauru'),
            'NU' => array('en' => 'Niue', 'fr' => 'Niue'),
            'NZ' => array('en' => 'New Zealand', 'fr' => 'Nouvelle-Zélande'),
            'OM' => array('en' => 'Oman', 'fr' => 'Oman'),
            'PA' => array('en' => 'Panama', 'fr' => 'Panama'),
            'PE' => array('en' => 'Peru', 'fr' => 'Pérou'),
            'PF' => array('en' => 'French Polynesia', 'fr' => 'Polynésie française'),
            'PG' => array('en' => 'Papua New Guinea', 'fr' => 'Papouasie-Nouvelle-Guinée'),
            'PH' => array('en' => 'Philippines', 'fr' => 'Philippines'),
            'PK' => array('en' => 'Pakistan', 'fr' => 'Pakistan'),
            'PL' => array('en' => 'Poland', 'fr' => 'Pologne'),
            'PM' => array('en' => 'Saint Pierre and Miquelon', 'fr' => 'Saint-Pierre-et-Miquelon'),
            'PN' => array('en' => 'Pitcairn Islands', 'fr' => 'Pitcairn'),
            'PR' => array('en' => 'Puerto Rico', 'fr' => 'Porto Rico'),
            'PS' => array('en' => 'Palestinian Territories', 'fr' => 'Territoire palestinien'),
            'PT' => array('en' => 'Portugal', 'fr' => 'Portugal'),
            'PW' => array('en' => 'Palau', 'fr' => 'Palaos'),
            'PY' => array('en' => 'Paraguay', 'fr' => 'Paraguay'),
            'QA' => array('en' => 'Qatar', 'fr' => 'Qatar'),
            'RE' => array('en' => 'Réunion', 'fr' => 'Réunion'),
            'RO' => array('en' => 'Romania', 'fr' => 'Roumanie'),
            'RS' => array('en' => 'Serbia', 'fr' => 'Serbie'),
            'RU' => array('en' => 'Russia', 'fr' => 'Russie'),
            'RW' => array('en' => 'Rwanda', 'fr' => 'Rwanda'),
            'SA' => array('en' => 'Saudi Arabia', 'fr' => 'Arabie saoudite'),
            'SB' => array('en' => 'Solomon Islands', 'fr' => 'Îles Salomon'),
            'SC' => array('en' => 'Seychelles', 'fr' => 'Seychelles'),
            'SD' => array('en' => 'Sudan', 'fr' => 'Soudan'),
            'SE' => array('en' => 'Sweden', 'fr' => 'Suède'),
            'SG' => array('en' => 'Singapore', 'fr' => 'Singapour'),
            'SH' => array('en' => 'Saint Helena', 'fr' => 'Sainte-Hélène'),
            'SI' => array('en' => 'Slovenia', 'fr' => 'Slovénie'),
            'SJ' => array('en' => 'Svalbard and Jan Mayen', 'fr' => 'Svalbard et Île Jan Mayen'),
            'SK' => array('en' => 'Slovakia', 'fr' => 'Slovaquie'),
            'SL' => array('en' => 'Sierra Leone', 'fr' => 'Sierra Leone'),
            'SM' => array('en' => 'San Marino', 'fr' => 'Saint-Marin'),
            'SN' => array('en' => 'Senegal', 'fr' => 'Sénégal'),
            'SO' => array('en' => 'Somalia', 'fr' => 'Somalie'),
            'SR' => array('en' => 'Suriname', 'fr' => 'Suriname'),
            'ST' => array('en' => 'São Tomé and Príncipe', 'fr' => 'Sao Tomé-et-Principe'),
            'SV' => array('en' => 'El Salvador', 'fr' => 'El Salvador'),
            'SY' => array('en' => 'Syria', 'fr' => 'Syrie'),
            'SZ' => array('en' => 'Swaziland', 'fr' => 'Swaziland'),
            'TC' => array('en' => 'Turks and Caicos Islands', 'fr' => 'Îles Turks et Caïques'),
            'TD' => array('en' => 'Chad', 'fr' => 'Tchad'),
            'TF' => array('en' => 'French Southern Territories', 'fr' => 'Terres australes françaises'),
            'TG' => array('en' => 'Togo', 'fr' => 'Togo'),
            'TH' => array('en' => 'Thailand', 'fr' => 'Thaïlande'),
            'TJ' => array('en' => 'Tajikistan', 'fr' => 'Tadjikistan'),
            'TK' => array('en' => 'Tokelau', 'fr' => 'Tokelau'),
            'TL' => array('en' => 'Timor-Leste', 'fr' => 'Timor oriental'),
            'TM' => array('en' => 'Turkmenistan', 'fr' => 'Turkménistan'),
            'TN' => array('en' => 'Tunisia', 'fr' => 'Tunisie'),
            'TO' => array('en' => 'Tonga', 'fr' => 'Tonga'),
            'TR' => array('en' => 'Turkey', 'fr' => 'Turquie'),
            'TT' => array('en' => 'Trinidad and Tobago', 'fr' => 'Trinité-et-Tobago'),
            'TV' => array('en' => 'Tuvalu', 'fr' => 'Tuvalu'),
            'TW' => array('en' => 'Taiwan', 'fr' => 'Taïwan'),
            'TZ' => array('en' => 'Tanzania', 'fr' => 'Tanzanie'),
            'UA' => array('en' => 'Ukraine', 'fr' => 'Ukraine'),
            'UG' => array('en' => 'Uganda', 'fr' => 'Ouganda'),
            'UM' => array('en' => 'U.S. Minor Outlying Islands', 'fr' => 'Îles Mineures Éloignées des États-Unis'),
            'US' => array('en' => 'United States', 'fr' => 'États-Unis'),
            'UY' => array('en' => 'Uruguay', 'fr' => 'Uruguay'),
            'UZ' => array('en' => 'Uzbekistan', 'fr' => 'Ouzbékistan'),
            'VA' => array('en' => 'Vatican City', 'fr' => 'État de la Cité du Vatican'),
            'VC' => array('en' => 'Saint Vincent and the Grenadines', 'fr' => 'Saint-Vincent-et-les Grenadines'),
            'VE' => array('en' => 'Venezuela', 'fr' => 'Venezuela'),
            'VG' => array('en' => 'British Virgin Islands', 'fr' => 'Îles Vierges britanniques'),
            'VI' => array('en' => 'U.S. Virgin Islands', 'fr' => 'Îles Vierges des États-Unis'),
            'VN' => array('en' => 'Vietnam', 'fr' => 'Viêt Nam'),
            'VU' => array('en' => 'Vanuatu', 'fr' => 'Vanuatu'),
            'WF' => array('en' => 'Wallis and Futuna', 'fr' => 'Wallis-et-Futuna'),
            'WS' => array('en' => 'Samoa', 'fr' => 'Samoa'),
            'YE' => array('en' => 'Yemen', 'fr' => 'Yémen'),
            'YT' => array('en' => 'Mayotte', 'fr' => 'Mayotte'),
            'ZA' => array('en' => 'South Africa', 'fr' => 'Afrique du Sud'),
            'ZM' => array('en' => 'Zambia', 'fr' => 'Zambie'),
            'ZW' => array('en' => 'Zimbabwe', 'fr' => 'Zimbabwe')
        );
        return $countryList;
    }


    public function createModules()
    {

        $db = \Config\Database::connect();

        // Define default project Company Type
        $rowsType = [
            [
                'id'           => 1,
                'name'         => 'ci4 core',
                'handle'       => 'ci4-core',
                'class'        => 'Adnduweb\Ci4Core',
                'is_natif'     => 1,
                'is_installed' => 1,
                'active'       => 1,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'id'           => 2,
                'name'         => 'ci4 admin',
                'handle'       => 'ci4-admin',
                'class'         => 'Adnduweb\Ci4Admin',
                'is_natif'     => 1,
                'is_installed' => 1,
                'active'       => 1,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'id'           => 3,
                'name'         => 'ci4 medias',
                'handle'       => 'ci4-medias',
                'class'         => 'Adnduweb\Ci4Medias',
                'is_natif'     => 1,
                'is_installed' => 1,
                'active'       => 1,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],

        ];

        // Check for and create project company Type
        foreach ($rowsType as $row) {
            $moduleRow = $db->table('modules')->where('handle', $row['handle'])->get()->getRow();

            if (empty($moduleRow)) {
                // No company type - add the row
                $db->table('modules')->insert($row);
            }
        }

    }

}
