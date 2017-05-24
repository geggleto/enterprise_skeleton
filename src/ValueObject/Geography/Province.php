<?php
/**
 * Created by PhpStorm.
 * User: bradleyhanebury
 * Date: 15-10-08
 * Time: 10:54 AM
 */

namespace Infrastructure\ValueObject\Geography;


use Infrastructure\ValueObject\Util\Util;
use Infrastructure\ValueObject\ValueObject;

//todo remove and use province code only
class Province implements ValueObject
{
    private $id;

    protected $provinceCode;

    public static $codes = [
        1 => 'ON',
        2 => 'AB',
        3 => 'NY',
        4 => 'MI',
        5 => 'PE',
        6 => 'NF',
        7 => 'NS',
        8 => 'NB',
        9 => 'QC',
        10 => 'MB',
        11 => 'SK',
        12 => 'BC',
        13 => 'YT',
        14 => 'NT',
        15 => 'NU',
        16 => 'AL',
        17 => 'AK',
        18 => 'AZ',
        19 => 'AR',
        20 => 'CA',
        21 => 'CO',
        22 => 'CT',
        23 => 'DE',
        24 => 'FL',
        25 => 'GA',
        26 => 'HI',
        27 => 'ID',
        28 => 'IL',
        29 => 'IN',
        30 => 'IA',
        31 => 'KS',
        32 => 'KY',
        33 => 'LA',
        34 => 'ME',
        35 => 'MD',
        36 => 'MA',
        37 => 'MI',
        38 => 'MN',
        39 => 'MS',
        40 => 'MO',
        41 => 'MT',
        42 => 'NE',
        43 => 'NV',
        44 => 'NH',
        45 => 'NJ',
        46 => 'NM',
        47 => 'NY',
        48 => 'NC',
        49 => 'ND',
        50 => 'OH',
        51 => 'OK',
        52 => 'OR',
        53 => 'PA',
        54 => 'RI',
        55 => 'SC',
        56 => 'SD',
        57 => 'TN',
        58 => 'TX',
        59 => 'UT',
        60 => 'VT',
        61 => 'VA',
        62 => 'WA',
        63 => 'WV',
        64 => 'WI',
        65 => 'WY',
    ];

    public static $names = [
        1 => 'Ontario',
        2 => 'Alberta',
        3 => 'New York',
        4 => 'Michigan',
        5 => 'Prince Edward Island',
        6 => 'Newfoundland',
        7 => 'Nova Scotia',
        8 => 'New Brunswick',
        9 => 'Quebec',
        10 => 'Manitoba',
        11 => 'Saskatchewan',
        12 => 'British Columbia',
        13 => 'Yukon',
        14 => 'Northwest Territories',
        15 => 'Nunavut',
        16 => 'Alabama',
        17 => 'Alaska',
        18 => 'Arizona',
        19 => 'Arkansas',
        20 => 'California',
        21 => 'Colorado',
        22 => 'Connecticut',
        23 => 'Delaware',
        24 => 'Florida',
        25 => 'Georgia',
        26 => 'Hawaii',
        27 => 'Idaho',
        28 => 'Illinois',
        29 => 'Indiana',
        30 => 'Iowa',
        31 => 'Kansas',
        32 => 'Kentucky',
        33 => 'Louisiana',
        34 => 'Maine',
        35 => 'Maryland',
        36 => 'Massachusetts',
        37 => 'Michigan',
        38 => 'Minnesota',
        39 => 'Mississippi',
        40 => 'Missouri',
        41 => 'Montana',
        42 => 'Nebraska',
        43 => 'Nevada',
        44 => 'New Hampshire',
        45 => 'New Jersey',
        46 => 'New Mexico',
        47 => 'New York',
        48 => 'North Carolina',
        49 => 'North Dakota',
        50 => 'Ohio',
        51 => 'Oklahoma',
        52 => 'Oregon',
        53 => 'Pennsylvania',
        54 => 'Rhode Island',
        55 => 'South Carolina',
        56 => 'South Dakota',
        57 => 'Tennessee',
        58 => 'Texas',
        59 => 'Utah',
        60 => 'Vermont',
        61 => 'Virginia',
        62 => 'Washington',
        63 => 'West Virginia',
        64 => 'Wisconsin',
        65 => 'Wyoming'
    ];


    /**
     * @param int $id
     *
     * @throws \Exception
     */
    public function __construct($id)
    {
        if (array_key_exists($id, self::$names) === false)
        {
            throw new \Exception("Invalid province id of " . $id);
        }

        $this->id = $id;
    }

    /**
     * @param string $provinceCode
     *
     * @return Province
     * @throws \Exception
     */
    public static function fromProvinceCode($provinceCode)
    {
        foreach (self::$names as $id => $code)
        {
            if ($code == $provinceCode)
            {
                return new Province($id);
            }
        }

        throw new \Exception("Invalid Province Code of " . $provinceCode);
    }

    /**
     * @param string $codeOrName
     *
     * @return Province
     * @throws \Exception
     */
    public static function fromProvinceCodeOrName($codeOrName)
    {
        foreach (self::$codes as $id => $code)
        {
            if (strtolower($code) == strtolower($codeOrName))
            {
                return new Province($id);
            }
        }

        foreach (self::$names as $id => $name)
        {
            if (strtolower($name) == strtolower($codeOrName))
            {
                return new Province($id);
            }
        }

        throw new \Exception("Invalid Province of " . $codeOrName);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::$names[$this->getId()];
    }

    /**
     * @param ValueObject|Province $object
     *
     * @return bool
     */
    public function equals(ValueObject $object)
    {
        if (Util::classEquals($this, $object) === false)
        {
            return false;
        }

        if ($object->getId() === $this->getId())
        {
            return true;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}