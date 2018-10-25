<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CountryFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    private $countries = [
        'AF' => 'Afghanistan',
        'ZA' => 'Afrique Du Sud',
        'AX' => 'Åland, Îles',
        'AL' => 'Albanie',
        'DZ' => 'Algérie',
        'DE' => 'Allemagne',
        'AD' => 'Andorre',
        'AO' => 'Angola',
        'AI' => 'Anguilla',
        'AQ' => 'Antarctique',
        'AG' => 'Antigua-Et-Barbuda',
        'SA' => 'Arabie Saoudite',
        'AR' => 'Argentine',
        'AM' => 'Arménie',
        'AW' => 'Aruba',
        'AU' => 'Australie',
        'AT' => 'Autriche',
        'AZ' => 'Azerbaïdjan',
        'BS' => 'Bahamas',
        'BH' => 'Bahreïn',
        'BD' => 'Bangladesh',
        'BB' => 'Barbade',
        'BY' => 'Bélarus',
        'BE' => 'Belgique',
        'BZ' => 'Belize',
        'BJ' => 'Bénin',
        'BM' => 'Bermudes',
        'BT' => 'Bhoutan',
        'BO' => 'Bolivie, L\'état Plurinational De',
        'BQ' => 'Bonaire, Saint-Eustache Et Saba',
        'BA' => 'Bosnie-Herzégovine',
        'BW' => 'Botswana',
        'BV' => 'Bouvet, Île',
        'BR' => 'Brésil',
        'BN' => 'Brunei Darussalam',
        'BG' => 'Bulgarie',
        'BF' => 'Burkina Faso',
        'BI' => 'Burundi',
        'KY' => 'Caïmans, Îles',
        'KH' => 'Cambodge',
        'CM' => 'Cameroun',
        'CA' => 'Canada',
        'CV' => 'Cap-Vert',
        'CF' => 'Centrafricaine, République',
        'CL' => 'Chili',
        'CN' => 'Chine',
        'CX' => 'Christmas, Île',
        'CY' => 'Chypre',
        'CC' => 'Cocos (Keeling), Îles',
        'CO' => 'Colombie',
        'KM' => 'Comores',
        'CG' => 'Congo',
        'CD' => 'Congo, La République Démocratique Du',
        'CK' => 'Cook, Îles',
        'KR' => 'Corée, République De',
        'KP' => 'Corée, République Populaire Démocratique De',
        'CR' => 'Costa Rica',
        'CI' => 'Côte D\'ivoire',
        'HR' => 'Croatie',
        'CU' => 'Cuba',
        'CW' => 'Curaçao',
        'DK' => 'Danemark',
        'DJ' => 'Djibouti',
        'DO' => 'Dominicaine, République',
        'DM' => 'Dominique',
        'EG' => 'Égypte',
        'SV' => 'El Salvador',
        'AE' => 'Émirats Arabes Unis',
        'EC' => 'Équateur',
        'ER' => 'Érythrée',
        'ES' => 'Espagne',
        'EE' => 'Estonie',
        'US' => 'États-Unis',
        'ET' => 'Éthiopie',
        'FK' => 'Falkland, Îles (Malvinas)',
        'FO' => 'Féroé, Îles',
        'FJ' => 'Fidji',
        'FI' => 'Finlande',
        'FR' => 'France',
        'GA' => 'Gabon',
        'GM' => 'Gambie',
        'GE' => 'Géorgie',
        'GS' => 'Géorgie Du Sud-Et-Les Îles Sandwich Du Sud',
        'GH' => 'Ghana',
        'GI' => 'Gibraltar',
        'GR' => 'Grèce',
        'GD' => 'Grenade',
        'GL' => 'Groenland',
        'GP' => 'Guadeloupe',
        'GU' => 'Guam',
        'GT' => 'Guatemala',
        'GG' => 'Guernesey',
        'GN' => 'Guinée',
        'GW' => 'Guinée-Bissau',
        'GQ' => 'Guinée Équatoriale',
        'GY' => 'Guyana',
        'GF' => 'Guyane Française',
        'HT' => 'Haïti',
        'HM' => 'Heard-Et-Îles Macdonald, Île',
        'HN' => 'Honduras',
        'HK' => 'Hong Kong',
        'HU' => 'Hongrie',
        'IM' => 'Île De Man',
        'UM' => 'Îles Mineures Éloignées Des États-Unis',
        'VG' => 'Îles Vierges Britanniques',
        'VI' => 'Îles Vierges Des États-Unis',
        'IN' => 'Inde',
        'ID' => 'Indonésie',
        'IR' => 'Iran, République Islamique D\'',
        'IQ' => 'Iraq',
        'IE' => 'Irlande',
        'IS' => 'Islande',
        'IL' => 'Israël',
        'IT' => 'Italie',
        'JM' => 'Jamaïque',
        'JP' => 'Japon',
        'JE' => 'Jersey',
        'JO' => 'Jordanie',
        'KZ' => 'Kazakhstan',
        'KE' => 'Kenya',
        'KG' => 'Kirghizistan',
        'KI' => 'Kiribati',
        'KW' => 'Koweït',
        'LA' => 'Lao, République Démocratique Populaire',
        'LS' => 'Lesotho',
        'LV' => 'Lettonie',
        'LB' => 'Liban',
        'LR' => 'Libéria',
        'LY' => 'Libye',
        'LI' => 'Liechtenstein',
        'LT' => 'Lituanie',
        'LU' => 'Luxembourg',
        'MO' => 'Macao',
        'MK' => 'Macédoine, L\'ex-République Yougoslave De',
        'MG' => 'Madagascar',
        'MY' => 'Malaisie',
        'MW' => 'Malawi',
        'MV' => 'Maldives',
        'ML' => 'Mali',
        'MT' => 'Malte',
        'MP' => 'Mariannes Du Nord, Îles',
        'MA' => 'Maroc',
        'MH' => 'Marshall, Îles',
        'MQ' => 'Martinique',
        'MU' => 'Maurice',
        'MR' => 'Mauritanie',
        'YT' => 'Mayotte',
        'MX' => 'Mexique',
        'FM' => 'Micronésie, États Fédérés De',
        'MD' => 'Moldova, République De',
        'MC' => 'Monaco',
        'MN' => 'Mongolie',
        'ME' => 'Monténégro',
        'MS' => 'Montserrat',
        'MZ' => 'Mozambique',
        'MM' => 'Myanmar',
        'NA' => 'Namibie',
        'NR' => 'Nauru',
        'NP' => 'Népal',
        'NI' => 'Nicaragua',
        'NE' => 'Niger',
        'NG' => 'Nigéria',
        'NU' => 'Niué',
        'NF' => 'Norfolk, Île',
        'NO' => 'Norvège',
        'NC' => 'Nouvelle-Calédonie',
        'NZ' => 'Nouvelle-Zélande',
        'IO' => 'Océan Indien, Territoire Britannique De L\'',
        'OM' => 'Oman',
        'UG' => 'Ouganda',
        'UZ' => 'Ouzbékistan',
        'PK' => 'Pakistan',
        'PW' => 'Palaos',
        'PS' => 'Palestinien Occupé, Territoire',
        'PA' => 'Panama',
        'PG' => 'Papouasie-Nouvelle-Guinée',
        'PY' => 'Paraguay',
        'NL' => 'Pays-Bas',
        'PE' => 'Pérou',
        'PH' => 'Philippines',
        'PN' => 'Pitcairn',
        'PL' => 'Pologne',
        'PF' => 'Polynésie Française',
        'PR' => 'Porto Rico',
        'PT' => 'Portugal',
        'QA' => 'Qatar',
        'RE' => 'Réunion',
        'RO' => 'Roumanie',
        'GB' => 'Royaume-Uni',
        'RU' => 'Russie, Fédération De',
        'RW' => 'Rwanda',
        'EH' => 'Sahara Occidental',
        'BL' => 'Saint-Barthélemy',
        'SH' => 'Sainte-Hélène, Ascension Et Tristan Da Cunha',
        'LC' => 'Sainte-Lucie',
        'KN' => 'Saint-Kitts-Et-Nevis',
        'SM' => 'Saint-Marin',
        'MF' => 'Saint-Martin(Partie Française)',
        'SX' => 'Saint-Martin (Partie Néerlandaise)',
        'PM' => 'Saint-Pierre-Et-Miquelon',
        'VA' => 'Saint-Siège (État De La Cité Du Vatican)',
        'VC' => 'Saint-Vincent-Et-Les Grenadines',
        'SB' => 'Salomon, Îles',
        'WS' => 'Samoa',
        'AS' => 'Samoa Américaines',
        'ST' => 'Sao Tomé-Et-Principe',
        'SN' => 'Sénégal',
        'RS' => 'Serbie',
        'SC' => 'Seychelles',
        'SL' => 'Sierra Leone',
        'SG' => 'Singapour',
        'SK' => 'Slovaquie',
        'SI' => 'Slovénie',
        'SO' => 'Somalie',
        'SD' => 'Soudan',
        'SS' => 'Soudan Du Sud',
        'LK' => 'Sri Lanka',
        'SE' => 'Suède',
        'CH' => 'Suisse',
        'SR' => 'Suriname',
        'SJ' => 'Svalbard Et Île Jan Mayen',
        'SZ' => 'Swaziland',
        'SY' => 'Syrienne, République Arabe',
        'TJ' => 'Tadjikistan',
        'TW' => 'Taïwan, Province De Chine',
        'TZ' => 'Tanzanie, République-Unie De',
        'TD' => 'Tchad',
        'CZ' => 'Tchèque, République',
        'TF' => 'Terres Australes Françaises',
        'TH' => 'Thaïlande',
        'TL' => 'Timor-Leste',
        'TG' => 'Togo',
        'TK' => 'Tokelau',
        'TO' => 'Tonga',
        'TT' => 'Trinité-Et-Tobago',
        'TN' => 'Tunisie',
        'TM' => 'Turkménistan',
        'TC' => 'Turks-Et-Caïcos, Îles',
        'TR' => 'Turquie',
        'TV' => 'Tuvalu',
        'UA' => 'Ukraine',
        'UY' => 'Uruguay',
        'VU' => 'Vanuatu',
        'VE' => 'Venezuela, République Bolivarienne Du',
        'VN' => 'Viet Nam',
        'WF' => 'Wallis Et Futuna',
        'YE' => 'Yémen',
        'ZM' => 'Zambie',
        'ZW' => 'Zimbabwe',
    ];


    public function load(ObjectManager $manager)
    {

        $i = 0;

        foreach ($this->countries as $key => $value) {
            $country = new Country();
            $country->setCountryCode($key);
            $country->setName($value);

            $manager->persist($country);

            $i++;

            if ($i % 50) {
                $manager->flush();
            }
        }

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }
}