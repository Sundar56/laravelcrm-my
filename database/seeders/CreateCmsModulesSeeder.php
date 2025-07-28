<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;

class CreateCmsModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $module_type = 3;
        $module = Module::insert([
            [
                'name'       => 'Aktive ordrer',
                'order'      => '21',
                'slug'       => 'ordre_oversigt_aktive',
                'main_module' => 'ordre_oversigt',
                'sub_module' => 'aktive',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Afsluttede ordrer',
                'order'      => '22',
                'slug'       => 'ordre_oversigt_afsluttede',
                'main_module' => 'ordre_oversigt',
                'sub_module' => 'afsluttede',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Slettede ordrer',
                'order'      => '23',
                'slug'       => 'ordre_oversigt_slettede',
                'main_module' => 'ordre_oversigt',
                'sub_module' => 'slettede',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'søg',
                'order'      => '24',
                'slug'       => 'søg',
                'main_module' => 'søg',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Ikke-gennemførte ordrer',
                'order'      => '25',
                'slug'       => 'ikke_gennemfoerte',
                'main_module' => 'ikke_gennemfoerte',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Udskriv pakkelabel',
                'order'      => '26',
                'slug'       => 'udskrivCustomPakkelabel',
                'main_module' => 'udskrivCustomPakkelabel',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Vis komponentliste',
                'order'      => '27',
                'slug'       => 'komponentliste',
                'main_module' => 'komponentliste',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Online',
                'order'      => '28',
                'slug'       => 'online',
                'main_module' => 'online',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Masterpassword',
                'order'      => '29',
                'slug'       => 'masterpassword',
                'main_module' => 'masterpassword',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Kontantrabat',
                'order'      => '30',
                'slug'       => 'kontantrabat',
                'main_module' => 'kontantrabat',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Vis lagerantal',
                'order'      => '31',
                'slug'       => 'show_in_stock_count',
                'main_module' => 'show_in_stock_count',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Vis priser uden login',
                'order'      => '32',
                'slug'       => 'show_prices_without_login',
                'main_module' => 'show_prices_without_login',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Producent Blackliste',
                'order'      => '33',
                'slug'       => 'producent_blacklist',
                'main_module' => 'producent_blacklist',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Events',
                'order'      => '34',
                'slug'       => 'events',
                'main_module' => 'events',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Nyheder',
                'order'      => '35',
                'slug'       => 'news',
                'main_module' => 'news',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Forside',
                'order'      => '36',
                'slug'       => 'rediger_side_forside',
                'main_module' => 'rediger_side',
                'sub_module' => 'forside',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Produkter',
                'order'      => '37',
                'slug'       => 'rediger_side_produkter',
                'main_module' => 'rediger_side',
                'sub_module' => 'produkter',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Dokumenter',
                'order'      => '38',
                'slug'       => 'min-konto-dokumenter',
                'main_module' => 'min-konto-dokumenter ',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Markedsføringsmateriale',
                'order'      => '39',
                'slug'       => 'min-konto-markedsfoeringsmateriale',
                'main_module' => 'min-konto-markedsfoeringsmateriale ',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Trådløst netværk',
                'order'      => '40',
                'slug'       => 'rediger_side_wireless-network',
                'main_module' => 'rediger_side',
                'sub_module' => 'wireless-network',
                'status'     =>  '1',
                'module_type'     =>   $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            [
                'name'       => 'Radio link',
                'order'      => '41',
                'slug'       => 'rediger_side_radio-link',
                'main_module' => 'rediger_side',
                'sub_module' => 'radio-link',
                'status'     =>  '1',
                'module_type'     =>   $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'M2M network',
                'order'      => '42',
                'slug'       => 'rediger_side_ethernet-network',
                'main_module' => 'rediger_side',
                'sub_module' => 'ethernet-network',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Infrastruktur',
                'order'      => '43',
                'slug'       => 'rediger_side_network-security',
                'main_module' => 'rediger_side',
                'sub_module' => 'network-security',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Webinar',
                'order'      => '44',
                'slug'       => 'rediger_side_uddannelse_1',
                'main_module' => 'rediger_side',
                'sub_module' => 'uddannelse_1',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Certificering',
                'order'      => '45',
                'slug'       => 'rediger_side_uddannelse_2',
                'main_module' => 'rediger_side',
                'sub_module' => 'uddannelse_2',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Edit Pages References',
                'order'      => '46',
                'slug'       => 'rediger_side_references',
                'main_module' => 'rediger_side',
                'sub_module' => 'references',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Profile',
                'order'      => '47',
                'slug'       => 'rediger_side_profile',
                'main_module' => 'rediger_side',
                'sub_module' => 'profile',
                'status'     =>  '1',
                'module_type'     =>   $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Kontakt',
                'order'      => '48',
                'slug'       => 'rediger_side_contact_edit_team_page',
                'main_module' => 'rediger_side',
                'sub_module' => 'contact',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Forhandler',
                'order'      => '49',
                'slug'       => 'rediger_side_forhandler',
                'main_module' => 'rediger_side',
                'sub_module' => 'forhandler',
                'status'     =>  '1',
                'module_type'     =>   $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Service',
                'order'      => '50',
                'slug'       => 'rediger_side_service',
                'main_module' => 'rediger_side',
                'sub_module' => 'service',
                'status'     =>  '1',
                'module_type'     =>   $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'RMA',
                'order'      => '51',
                'slug'       => 'rediger_side_rma',
                'main_module' => 'rediger_side',
                'sub_module' => 'rma',
                'status'     =>  '1',
                'module_type'     =>   $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            [
                'name'       => 'Betingelser',
                'order'      => '52',
                'slug'       => 'rediger_side_betingelser',
                'main_module' => 'rediger_side',
                'sub_module' => 'betingelser',
                'status'     =>  '1',
                'module_type'     =>   $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Producentmap',
                'order'      => '53',
                'slug'       => 'rediger_side_producentmap',
                'main_module' => 'rediger_side',
                'sub_module' => 'producentmap',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Frameld nyhedsmail',
                'order'      => '54',
                'slug'       => 'rediger_side_unsubscribe-newsletter',
                'main_module' => 'rediger_side',
                'sub_module' => 'unsubscribe-newsletter',
                'status'     =>  '1',
                'module_type'     => $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Oversættelser',
                'order'      => '55',
                'slug'       => 'translations',
                'main_module' => 'translations',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Kat. Rækkefølge',
                'order'      => '56',
                'slug'       => 'mini_praesentation',
                'main_module' => 'mini_praesentation',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>   $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Tilbehør og video',
                'order'      => '57',
                'slug'       => 'tilbehoer',
                'main_module' => 'tilbehoer',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Gruppe1 billeder',
                'order'      => '58',
                'slug'       => 'gruppe_billeder',
                'main_module' => 'gruppe_billeder',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Gruppe2 billeder',
                'order'      => '59',
                'slug'       => 'gruppe2_billeder',
                'main_module' => 'gruppe2_billeder',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Tilbud',
                'order'      => '60',
                'slug'       => 'tilbud',
                'main_module' => 'tilbud',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Visning af varer',
                'order'      => '61',
                'slug'       => 'visningafvarer',
                'main_module' => 'visningafvarer',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Visning af kat. på forsiden',
                'order'      => '62',
                'slug'       => 'visningafkategorierpaaforsiden',
                'main_module' => 'visningafkategorierpaaforsiden',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Visning af underkat.',
                'order'      => '63',
                'slug'       => 'visningafkategori2kategorier',
                'main_module' => 'visningafkategori2kategorier',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Varekort',
                'order'      => '64',
                'slug'       => 'varekort',
                'main_module' => 'varekort',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'kvitteringstyper',
                'order'      => '65',
                'slug'       => 'kvitteringstyper',
                'main_module' => 'kvitteringstyper',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Søgeoptimering',
                'order'      => '66',
                'slug'       => 'meta',
                'main_module' => 'meta',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Layout Indstillinger',
                'order'      => '67',
                'slug'       => 'layout_indstillinger',
                'main_module' => 'layout_indstillinger',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Social media',
                'order'      => '68',
                'slug'       => 'social_media',
                'main_module' => 'social_media',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Fragtpriser',
                'order'      => '69',
                'slug'       => 'postpriser',
                'main_module' => 'postpriser',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Kreditkortgebyr',
                'order'      => '70',
                'slug'       => 'kreditkortgebyr',
                'main_module' => 'kreditkortgebyr',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Leveringstid',
                'order'      => '71',
                'slug'       => 'leveringstid',
                'main_module' => 'leveringstid',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'References',
                'order'      => '72',
                'slug'       => 'referencer',
                'main_module' => 'referencer',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Forside video/billede',
                'order'      => '73',
                'slug'       => 'frontpage_video_picture',
                'main_module' => 'frontpage_video_picture',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     => $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Ekstern kredit',
                'order'      => '74',
                'slug'       => 'external_credit',
                'main_module' => 'external_credit',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Sprog/lande',
                'order'      => '75',
                'slug'       => 'languages',
                'main_module' => 'languages',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Diverse Tekst',
                'order'      => '76',
                'slug'       => 'rediger_smaatekst',
                'main_module' => 'rediger_smaatekst',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Afsendte e-mails',
                'order'      => '77',
                'slug'       => 'emails',
                'main_module' => 'emails',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'E-mail skabeloner',
                'order'      => '78',
                'slug'       => 'emailskabeloner',
                'main_module' => 'emailskabeloner',
                'sub_module' => '',
                'status'     =>  '1',
                'module_type'     =>  $module_type,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],


        ]);

        $this->command->info('Modules created successfully.');
    }
}
// php artisan db:seed --class=CreateCmsModulesSeeder 