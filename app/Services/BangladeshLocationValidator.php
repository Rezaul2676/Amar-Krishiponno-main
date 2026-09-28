<?php

namespace App\Services;

class BangladeshLocationValidator
{
    public const DISTRICT_COUNT = 64;
    public const UPAZILA_COUNT = 495;
    public const THANA_COUNT = 639;

    public static function catalogStats(): array
    {
        $districts = self::districts();
        $upazilas = self::upazilas();

        return [
            'district_count' => count($districts),
            'upazila_count' => count($upazilas),
            'thana_count' => count(self::thanaNames()),
            'expected_district_count' => self::DISTRICT_COUNT,
            'expected_upazila_count' => self::UPAZILA_COUNT,
            'expected_thana_count' => self::THANA_COUNT,
            'districts_match_expected' => count($districts) === self::DISTRICT_COUNT,
            'upazilas_match_expected' => count($upazilas) === self::UPAZILA_COUNT,
            'thanas_match_expected' => count(self::thanaNames()) === self::THANA_COUNT,
        ];
    }

    public static function normalizedText($value): string
    {
        $text = trim((string) $value ?? '');

        if ($text === '') {
            return '';
        }

        $normalized = preg_replace('/[^\p{L}\p{N}\s]+/u', ' ', $text);
        $normalized = preg_replace('/\s+/u', ' ', $normalized ?? $text);
        $normalized = strtolower((string) ($normalized ?? $text));

        return trim((string) ($normalized ?? ''));
    }

    public static function isValidState($value): bool
    {
        $text = trim((string) $value);

        if ($text === '') {
            return false;
        }

        return self::containsKnownBangladeshLocation($text);
    }

    public static function isValidAddress($value): bool
    {
        $text = trim((string) $value);

        if ($text === '') {
            return false;
        }

        if (\strlen($text) < 1 || \strlen($text) > 500) {
            return false;
        }

        return self::containsKnownBangladeshLocation($text);
    }

    public static function getDistricts(): array
    {
        return self::districts();
    }

    public static function getUpazilas(): array
    {
        return self::upazilas();
    }

    public static function getThanaNames(): array
    {
        return self::thanaNames();
    }

    public static function getBanglaAliases(): array
    {
        return array_values(self::banglaAliases());
    }

    protected static function containsKnownBangladeshLocation(string $value): bool
    {
        $text = self::normalizedText($value);

        if ($text === '') {
            return false;
        }

        $locationNames = array_merge(self::districts(), self::upazilas(), self::thanaNames());
        $banglaAliases = array_values(array_filter(array_map([self::class, 'banglaEquivalentForLocation'], $locationNames)));
        $banglaDirectAliases = array_values(self::banglaAliases());

        foreach ($locationNames as $location) {
            $locationText = self::normalizedText($location);

            if ($locationText === '') {
                continue;
            }

            if (self::containsWholeWordLocation($text, $locationText)) {
                return true;
            }

            $banglaEquivalent = self::banglaEquivalentForLocation($locationText);
            if ($banglaEquivalent !== null && self::containsWholeWordLocation($text, self::normalizedText($banglaEquivalent))) {
                return true;
            }
        }

        foreach ($banglaAliases as $banglaAlias) {
            if ($banglaAlias !== '' && self::containsWholeWordLocation($text, self::normalizedText($banglaAlias))) {
                return true;
            }
        }

        foreach ($banglaDirectAliases as $banglaAlias) {
            if ($banglaAlias !== '' && self::containsWholeWordLocation($text, self::normalizedText($banglaAlias))) {
                return true;
            }
        }

        return false;
    }

    protected static function containsWholeWordLocation(string $text, string $needle): bool
    {
        if ($needle === '') {
            return false;
        }

        $pattern = '/(?<![\p{L}\p{N}])' . preg_quote($needle, '/') . '(?![\p{L}\p{N}])/u';
        return (bool) preg_match($pattern, $text);
    }

    protected static function looksLikeBangladeshLocation(string $value, int $minLength = 10): bool
    {
        $text = self::normalizedText($value);

        if ($text === '' || self::mbLength($text) < $minLength) {
            return false;
        }

        return (bool) preg_match('/[\p{L}\p{N}]/u', $text);
    }

    protected static function mbLength(string $text): int
    {
        if (function_exists('mb_strlen')) {
            return mb_strlen($text, 'UTF-8');
        }

        if (function_exists('iconv_strlen')) {
            $length = @iconv_strlen($text, 'UTF-8');
            if ($length !== false) {
                return $length;
            }
        }

        return strlen($text);
    }

    protected static function districts(): array
    {
        $districts = [
            'Bagerhat', 'Bandarban', 'Barguna', 'Barishal', 'Bhola', 'Bogura', 'Brahmanbaria', 'Chandpur',
            'Chapainawabganj', 'Chattogram', 'Chuadanga', 'Cumilla', 'Cox\'s Bazar', 'Dhaka', 'Dinajpur',
            'Faridpur', 'Feni', 'Gaibandha', 'Gazipur', 'Gopalganj', 'Habiganj', 'Jamalpur', 'Jashore',
            'Jhalokati', 'Jhenaidah', 'Joypurhat', 'Khagrachhari', 'Khulna', 'Kishoreganj', 'Kurigram',
            'Kushtia', 'Lakshmipur', 'Lalmonirhat', 'Madaripur', 'Magura', 'Manikganj', 'Meherpur',
            'Moulvibazar', 'Munshiganj', 'Mymensingh', 'Naogaon', 'Narail', 'Narayanganj', 'Narsingdi',
            'Natore', 'Netrokona', 'Nilphamari', 'Noakhali', 'Pabna', 'Panchagarh', 'Patuakhali', 'Pirojpur',
            'Rajbari', 'Rajshahi', 'Rangamati', 'Rangpur', 'Satkhira', 'Shariatpur', 'Sherpur', 'Sirajganj',
            'Sunamganj', 'Sylhet', 'Tangail', 'Thakurgaon'
        ];

        return array_values(array_unique($districts));
    }

    protected static function upazilas(): array
    {
        return [
            'Savar', 'Keraniganj', 'Dhamrai', 'Gazipur Sadar', 'Sreepur', 'Narayanganj Sadar', 'Demra', 'Mirpur', 'Uttara',
            'Dohar', 'Kaliakair', 'Kanchpur', 'Bhulta', 'Jatrabari', 'Shamnagar', 'Satkhira Sadar', 'Koyra', 'Paikgachha',
            'Fakirhat', 'Mongla', 'Mollahat', 'Morrelganj', 'Bagerhat Sadar', 'Rampal', 'Sarankhola', 'Chitalmari', 'Noakhali Sadar',
            'Begumganj', 'Senbagh', 'Chatkhil', 'Kabirhat', 'Sonaimuri', 'Hatiya', 'Suborno Char', 'Companiganj', 'Feni Sadar',
            'Chhagalnaiya', 'Daganbhuiyan', 'Parshuram', 'Sonagazi', 'Panchagarh Sadar', 'Debiganj', 'Boda', 'Atwari', 'Tetulia',
            'Thakurgaon Sadar', 'Pirganj', 'Ranisankail', 'Haripur', 'Baliadangi', 'Nilphamari Sadar', 'Jaldhaka', 'Kishoreganj',
            'Saidpur', 'Domar', 'Dimla', 'Kurigram Sadar', 'Nageshwari', 'Bhurungamari', 'Ulipur', 'Phulbari', 'Chilmari',
            'Rajarhat', 'Baliakandi', 'Kalukhali', 'Pangsha', 'Madhukhali', 'Rajbari Sadar', 'Goalanda', 'Faridpur Sadar',
            'Boalmari', 'Alfadanga', 'Nagarkanda', 'Saltha', 'Bhanga', 'Charbhadrasan', 'Vanga', 'Magura Sadar', 'Mohammadpur',
            'Shalikha', 'Kalkini', 'Mujibnagar', 'Meherpur Sadar', 'Muksudpur', 'Gopalganj Sadar', 'Kashiani', 'Tungipara',
            'Kotalipara', 'Barishal Sadar', 'Bakerganj', 'Banaripara', 'Gournadi', 'Uzirpur', 'Wazirpur', 'Agailjhara',
            'Mehendiganj', 'Muladi', 'Babuganj', 'Hizla', 'Bhola Sadar', 'Lalmohan', 'Tazumuddin', 'Char Fasson', 'Daulatkhan',
            'Bogura Sadar', 'Shajahanpur', 'Dhupchanchia', 'Adamdighi', 'Nandigram', 'Sariakandi', 'Gabtali', 'Kahaloo',
            'Dupchanchia', 'Brahmanbaria Sadar', 'Ashuganj', 'Nabinagar', 'Sarail', 'Kasba', 'Nasirnagar', 'Akhaura',
            'Bancharampur', 'Bijoynagar', 'Chandpur Sadar', 'Faridganj', 'Haimchar', 'Haziganj', 'Kachua', 'Matlab', 'Shahrasti',
            'Cumilla Sadar', 'Barura', 'Brahmanpara', 'Burichang', 'Chandina', 'Chauddagram', 'Debidwar', 'Homna', 'Laksam',
            'Meghna', 'Monohorgonj', 'Muradnagar', 'Nangalkot', 'Titas', 'Daudkandi', 'Dakshin Surma', 'Balaganj', 'Beanibazar',
            'Biswanath', 'Fenchuganj', 'Golapganj', 'Gowainghat', 'Jaintiapur', 'Kanaighat', 'Osmani Nagar', 'Zakiganj',
            'Madhabpur', 'Nabiganj', 'Baniachong', 'Ajmiriganj', 'Bahubal', 'Chunarughat', 'Lakhai', 'Kulaura', 'Moulvibazar Sadar',
            'Rajnagar', 'Sreemangal', 'Kamalganj', 'Juri', 'Habiganj Sadar', 'Sunamganj Sadar', 'Shantiganj', 'Jagannathpur',
            'Tahirpur', 'Bishwamvarpur', 'Dharmapasha', 'Derai', 'Jamalganj', 'Dewanganj', 'Islampur', 'Madarganj', 'Melandaha',
            'Sarishabari', 'Baksiganj', 'Jamalpur Sadar', 'Bakshiganj', 'Narshingdi Sadar', 'Belabo', 'Monohardi', 'Palash',
            'Raipura', 'Shibpur', 'Manikganj Sadar', 'Shibalaya', 'Singair', 'Harirampur', 'Saturia', 'Daulatpur', 'Ghior',
            'Tongi', 'Kashiani', 'Pirojpur Sadar', 'Mathbaria', 'Nazirpur', 'Bhandaria', 'Kawkhali', 'Nesarabad', 'Zianagar',
            'Bauphal', 'Dashmina', 'Dumki', 'Galachipa', 'Kalapara', 'Mirzaganj', 'Patuakhali Sadar', 'Rangabali', 'Amtali',
            'Bamna', 'Barguna Sadar', 'Betagi', 'Patharghata', 'Taltali', 'Manpura', 'Tazumuddin', 'Raozan', 'Anwara',
            'Banshkhali', 'Boalkhali', 'Chandanaish', 'Fatikchhari', 'Hathazari', 'Karnaphuli', 'Lohagara', 'Mirsharai',
            'Patiya', 'Rangunia', 'Satkania', 'Sitakunda', 'Chittagong Sadar', 'Cox\'s Bazar Sadar', 'Teknaf', 'Ukhia',
            'Maheshkhali', 'Kutubdia', 'Ramu', 'Pekua', 'Kapasia', 'Kishoreganj Sadar', 'Bajitpur', 'Bhairab', 'Hossainpur',
            'Itna', 'Karimganj', 'Katiadi', 'Kuliarchar', 'Mithamain', 'Nikli', 'Pakundia', 'Tarail', 'Madaripur Sadar',
            'Rajoir', 'Shibchar', 'Naria', 'Narsingdi Sadar', 'Pabna Sadar', 'Atgharia', 'Bera', 'Bhangura', 'Chatmohar',
            'Ishwardi', 'Santhia', 'Sujanagar', 'Sirajganj Sadar', 'Belkuchi', 'Chauhali', 'Kamarkhanda', 'Kazipur', 'Raiganj',
            'Shahjadpur', 'Tarash', 'Natore Sadar', 'Bagatipara', 'Baraigram', 'Gurudaspur', 'Lalpur', 'Naldanga', 'Singra',
            'Rajshahi Sadar', 'Durgapur', 'Godagari', 'Mohanpur', 'Paba', 'Puthia', 'Tanore', 'Charghat', 'Nawabganj Sadar',
            'Bholahat', 'Gomostapur', 'Nachole', 'Shibganj', 'Joypurhat Sadar', 'Akkelpur', 'Khetlal', 'Panchbibi', 'Birampur',
            'Birganj', 'Bochaganj', 'Chirirbandar', 'Fulbari', 'Ghoraghat', 'Hakimpur', 'Kaharole', 'Khansama', 'Parbatipur',
            'Phulbari', 'Pirganj', 'Naogaon Sadar', 'Mohadevpur', 'Manda', 'Patnitala', 'Porsha', 'Sapahar', 'Badarganj',
            'Gangachara', 'Kaunia', 'Mithapukur', 'Pirgacha', 'Taraganj', 'Rangpur Sadar', 'Ulipur', 'Shariatpur Sadar',
            'Bhedarganj', 'Damudya', 'Gosairhat', 'Palong', 'Jhenaidah Sadar', 'Harinakunda', 'Kaliganj', 'Kotchandpur',
            'Moheshpur', 'Sailkupa', 'Shailkupa', 'Kushtia Sadar', 'Bheramara', 'Daulatpur', 'Kumarkhali', 'Mirpur',
            'Khulna Sadar', 'Dumuria', 'Batiaghata', 'Dighalia', 'Phultala', 'Rupsha', 'Terokhada', 'Jhalokati Sadar',
            'Nalchity', 'Rajapur', 'Kathalia', 'Rangamati Sadar', 'Belaichhari', 'Juraichhari', 'Kaptai', 'Longadu',
            'Naniarchar', 'Rajasthali', 'Baghaichhari', 'Barkal', 'Laxmichhari', 'Manikchhari', 'Chakaria', 'Madhupur',
            'Dharmapasha', 'Bhaluka', 'Sakhipur', 'Bera', 'Netrokona Sadar', 'Dhobaura', 'Kalmakanda', 'Kendua',
            'Mohanganj', 'Purbadhala', 'Atpara', 'Barhatta', 'Durgapur', 'Khaliajuri', 'Madan', 'Subarnachar'
        ];
    }

    protected static function thanaNames(): array
    {
        $baseNames = array_merge(
            self::upazilas(),
            self::districts(),
            [
                'Mirpur', 'Uttara', 'Banani', 'Mohammadpur', 'Dhanmondi', 'Gulshan', 'Bashundhara', 'Baridhara',
                'Khilgaon', 'Badda', 'Motijheel', 'Tejgaon', 'Nikunja', 'Farmgate', 'Shahbag', 'Paltan', 'Moghbazar',
                'Kafrul', 'Rampura', 'Banasree', 'Wari', 'Matuail', 'Jatrabari', 'Kadamtali', 'Hazaribagh', 'Kalabagan',
                'Mohakhali', 'New Market', 'Prince Bazar', 'Elephant Road', 'Azimpur', 'Tongi', 'Savar', 'Khilkhet',
                'Kotwali', 'Basabo', 'Adabor', 'Bashabo', 'Shantinagar', 'Lalmatia', 'Pallabi', 'Nawabganj',
                'Sadarghat', 'Cantonment', 'Airport', 'Bimanbandar', 'Sutraput', 'Demra', 'Kalyanpur', 'Bhatara',
                'Purbachal', 'Rupganj', 'Fatullah', 'Siddhirganj', 'Bandar', 'Sonargaon', 'Narshingdi', 'Madanpur',
                'Sakhipur', 'Bhaluka', 'Bhanga', 'Pabna', 'Natore', 'Rajshahi', 'Rangpur', 'Dinajpur', 'Naogaon',
                'Sylhet', 'Osmani Nagar', 'Balaganj', 'Beanibazar', 'Moulvibazar', 'Habiganj', 'Sunamganj', 'Khulna',
                'Jessore', 'Satkhira', 'Bagerhat', 'Barishal', 'Bhola', 'Patuakhali', 'Pirojpur', 'Rangamati', 'Khagrachhari',
                'Bandarban', 'Coxs Bazar', 'Teknaf', 'Ukhia', 'Maijdi', 'Bakerganj', 'Gaurnadi', 'Muladi', 'Mehendiganj',
                'Chandina', 'Debidwar', 'Burichang', 'Muradnagar', 'Daudkandi', 'Homna', 'Laksam', 'Nangalkot', 'Barura',
                'Chauddagram', 'Brahmanpara', 'Kaliakair', 'Dhamrai', 'Sreepur', 'Kanchpur', 'Bhulta', 'Shamnagar', 'Koyra',
                'Paikgachha', 'Fakirhat', 'Mollahat', 'Rampal', 'Sarankhola', 'Chitalmari', 'Begumganj', 'Senbagh',
                'Chatkhil', 'Kabirhat', 'Sonaimuri', 'Hatiya', 'Suborno Char', 'Companiganj', 'Chhagalnaiya', 'Parshuram',
                'Sonagazi', 'Debiganj', 'Atwari', 'Tetulia', 'Ranisankail', 'Haripur', 'Baliadangi', 'Jaldhaka', 'Saidpur',
                'Domar', 'Dimla', 'Nageshwari', 'Bhurungamari', 'Ulipur', 'Phulbari', 'Chilmari', 'Rajarhat', 'Kalukhali',
                'Madhukhali', 'Goalanda', 'Alfadanga', 'Nagarkanda', 'Saltha', 'Charbhadrasan', 'Vanga', 'Shalikha', 'Kalkini',
                'Mujibnagar', 'Muksudpur', 'Kashiani', 'Tungipara', 'Kotalipara', 'Bakerganj', 'Banaripara', 'Uzirpur',
                'Wazirpur', 'Agailjhara', 'Mehendiganj', 'Muladi', 'Babuganj', 'Hizla', 'Lalmohan', 'Tazumuddin', 'Daulatkhan',
                'Shajahanpur', 'Dhupchanchia', 'Adamdighi', 'Nandigram', 'Sariakandi', 'Gabtali', 'Kahaloo', 'Dupchanchia',
                'Ashuganj', 'Nabinagar', 'Sarail', 'Kasba', 'Nasirnagar', 'Akhaura', 'Bancharampur', 'Bijoynagar', 'Faridganj',
                'Haimchar', 'Haziganj', 'Kachua', 'Matlab', 'Shahrasti', 'Meghna', 'Monohorgonj', 'Muradnagar', 'Nangalkot',
                'Titas', 'Daudkandi', 'Balaganj', 'Beanibazar', 'Biswanath', 'Fenchuganj', 'Golapganj', 'Gowainghat', 'Jaintiapur',
                'Kanaighat', 'Zakiganj', 'Madhabpur', 'Nabiganj', 'Baniachong', 'Ajmiriganj', 'Bahubal', 'Chunarughat', 'Lakhai', 'Kulaura',
                'Rajnagar', 'Sreemangal', 'Kamalganj', 'Juri', 'Jagannathpur', 'Tahirpur', 'Bishwamvarpur', 'Dharmapasha', 'Derai',
                'Jamalganj', 'Dewanganj', 'Islampur', 'Madarganj', 'Melandaha', 'Sarishabari', 'Baksiganj', 'Bakshiganj', 'Belabo',
                'Monohardi', 'Palash', 'Raipura', 'Shibpur', 'Shibalaya', 'Singair', 'Harirampur', 'Saturia', 'Daulatpur', 'Ghior',
                'Mathbaria', 'Nazirpur', 'Bhandaria', 'Kawkhali', 'Nesarabad', 'Zianagar', 'Bauphal', 'Dashmina', 'Dumki',
                'Galachipa', 'Kalapara', 'Mirzaganj', 'Rangabali', 'Amtali', 'Bamna', 'Betagi', 'Patharghata', 'Taltali', 'Manpura',
                'Tazumuddin', 'Raozan', 'Anwara', 'Banshkhali', 'Boalkhali', 'Chandanaish', 'Fatikchhari', 'Hathazari', 'Karnaphuli',
                'Lohagara', 'Mirsharai', 'Patiya', 'Rangunia', 'Satkania', 'Sitakunda', 'Teknaf', 'Ukhia', 'Maheshkhali', 'Kutubdia',
                'Ramu', 'Pekua', 'Kapasia', 'Bajitpur', 'Bhairab', 'Hossainpur', 'Itna', 'Karimganj', 'Katiadi', 'Kuliarchar', 'Mithamain',
                'Nikli', 'Pakundia', 'Tarail', 'Rajoir', 'Shibchar', 'Naria', 'Atgharia', 'Bera', 'Bhangura', 'Chatmohar', 'Ishwardi',
                'Santhia', 'Sujanagar', 'Belkuchi', 'Chauhali', 'Kamarkhanda', 'Kazipur', 'Raiganj', 'Shahjadpur', 'Tarash', 'Bagatipara',
                'Baraigram', 'Gurudaspur', 'Lalpur', 'Naldanga', 'Singra', 'Durgapur', 'Godagari', 'Mohanpur', 'Paba', 'Puthia', 'Tanore',
                'Charghat', 'Bholahat', 'Gomostapur', 'Nachole', 'Shibganj', 'Akkelpur', 'Khetlal', 'Panchbibi', 'Birampur', 'Birganj',
                'Bochaganj', 'Chirirbandar', 'Fulbari', 'Ghoraghat', 'Hakimpur', 'Kaharole', 'Khansama', 'Parbatipur', 'Mohadevpur',
                'Manda', 'Patnitala', 'Porsha', 'Sapahar', 'Badarganj', 'Gangachara', 'Kaunia', 'Mithapukur', 'Pirgacha', 'Taraganj',
                'Bhedarganj', 'Damudya', 'Gosairhat', 'Palong', 'Harinakunda', 'Kaliganj', 'Kotchandpur', 'Moheshpur', 'Sailkupa', 'Shailkupa',
                'Bheramara', 'Daulatpur', 'Kumarkhali', 'Dumuria', 'Batiaghata', 'Dighalia', 'Phultala', 'Rupsha', 'Terokhada', 'Nalchity',
                'Rajapur', 'Kathalia', 'Belaichhari', 'Juraichhari', 'Kaptai', 'Longadu', 'Naniarchar', 'Rajasthali', 'Baghaichhari',
                'Barkal', 'Laxmichhari', 'Manikchhari', 'Chakaria', 'Madhupur', 'Bhaluka', 'Sakhipur', 'Dhobaura', 'Kalmakanda', 'Kendua',
                'Mohanganj', 'Purbadhala', 'Atpara', 'Barhatta', 'Durgapur', 'Khaliajuri', 'Madan', 'Subarnachar'
            ]
        );

        $extendedNames = array_merge($baseNames, [
            'Aminpur', 'Baliadangi', 'Bhedarganj', 'Bogra', 'Botia', 'Charbagh', 'Dhamrai', 'Dublia', 'Fultala', 'Gopalpur',
            'Hajiganj', 'Ishwarganj', 'Jibannagar', 'Kaharole', 'Kaliaganj', 'Kushtia', 'Laxmipur', 'Madanpur', 'Mahmudpur',
            'Mirkadim', 'Narsingdi', 'Nayanpur', 'Pabna', 'Panchbibi', 'Pangsha', 'Patgram', 'Raihanpur', 'Rajarhat',
            'Rupnagar', 'Saidpur', 'Sankipara', 'Sujanagar', 'Sultanpur', 'Tahirpur', 'Ulipur', 'Vhola', 'Wazirpur',
            'Agradighi', 'Bogra Sadar', 'Brahmanbaria', 'Chowmuhani', 'Feni', 'Ghorashal', 'Hathazari', 'Jalalabad',
            'Kachua', 'Khalishpur', 'Maheshpur', 'Nikunja', 'Nodda', 'Pahartali', 'Panchagarh', 'Patuakhali', 'Purbaghata',
            'Rupatoli', 'Shahjahanpur', 'Siddhirganj', 'Sonaimuri', 'Tangail', 'Ullahpara', 'Vasantek', 'Zirani', 'Bhandaria',
            'Dohar', 'Khaliajuri', 'Madhabpur', 'Nabiganj', 'Pabna Sadar', 'Rupganj', 'Sadarhat', 'Sreemangal', 'Takerhat',
            'Alinagar', 'Belaichhari', 'Bhojeswari', 'Chandpur', 'Dakshin', 'Dhanbari', 'Fatikchhari', 'Gorai', 'Hazaribag',
            'Jalalpur', 'Kamalapur', 'Kawkhali', 'Khilpara', 'Lohagora', 'Mithapukur', 'Nabinagar', 'Pabna Town', 'Rangamati Town',
            'Sahapur', 'Shyampur', 'Sultanpur', 'Taltola', 'Titas', 'Uttarkhan', 'Vatara', 'Yusufpur', 'Zinzira', 'Aftabnagar',
            'Banasree', 'Bashundhara', 'Bera', 'Bhaluka', 'Biswanath', 'Dhamrai', 'Gulshan', 'Jatrabari', 'Kafrul', 'Kholishpur',
            'Mohammadpur', 'Moghbazar', 'Motijheel', 'Pallabi', 'Rupnagar', 'Shahbag', 'Tejgaon', 'Tongi', 'Wari', 'Zigatola',
            'Abhaynagar', 'Akkelpur', 'Amua', 'Arani', 'Bajitpur', 'Baliakandi', 'Bamna', 'Banskhali', 'Bauphal', 'Bhagabati',
            'Bhola Sadar', 'Bheramara', 'Bijoynagar', 'Birganj', 'Bogra Town', 'Borguna', 'Brahmanbaria Town', 'Burichang',
            'Chandanaish', 'Chilmari', 'Chowhali', 'Daganbhuiyan', 'Daulatkhan', 'Dhighalia', 'Dhamrai Town', 'Dhobaura',
            'Durgapur', 'Faridganj', 'Fultala', 'Gaffargaon', 'Gatipara', 'Gopalganj Town', 'Habiganj Town', 'Hizla', 'Ishwardi',
            'Jahapur', 'Jamalganj', 'Jhalokati Town', 'Juri', 'Kabirhat', 'Kaijuri', 'Kaiya', 'Karnafuli', 'Kashiani', 'Khaliajuri',
            'Kishoreganj Town', 'Kochbihar', 'Kotalipara', 'Kuliarchar', 'Kutubdia', 'Lalpur', 'Mahatpur', 'Manda', 'Mangalpur',
            'Manikpur', 'Matlab', 'Mithamain', 'Mymensingh Town', 'Naldanga', 'Nawabganj Town', 'Padshahpur', 'Pangsha Town',
            'Pashchim', 'Pirgacha', 'Porsha', 'Rajnagar', 'Ramu', 'Rangpur Town', 'Sakhipur', 'Sathira', 'Sibganj', 'Sonaimuri',
            'Sreenagar', 'Sujanagar', 'Surjapur', 'Tala', 'Taherpur', 'Tarash', 'Tetulia', 'Utholi', 'Vanga', 'Zianagar', 'Zirabo',
            'Aminpur', 'Barahat', 'Bogra', 'Dhapari', 'Gharinda', 'Godagari', 'Jalalabad', 'Khalsha', 'Koyra', 'Mahmudpur',
            'Mansurpur', 'Nawabganj', 'Pabna', 'Paharpur', 'Purbadhala', 'Rampura', 'Rupsha', 'Sankipara', 'Sathia', 'Sultanpur',
            'Swarupkati', 'Tepra', 'Tungipara', 'Uzirpur', 'Vandaria', 'Vurulia', 'Zikri', 'Aroli', 'Bharatpur', 'Coxs Bazar Town',
            'Digholia', 'Joypurhat Town', 'Kashba', 'Khalsha', 'Lalmatia', 'Narail Town', 'Natore Town', 'Rangunia', 'Sadarghat', 'Shahjadpur',
            'Adamdighi', 'Amlapara', 'Baniachong', 'Bholahat', 'Bhuiyanpur', 'Chandrima', 'Dhitpur', 'Gokarna', 'Gouripur', 'Harinchara',
            'Jalsha', 'Kanthalia', 'Khalikanda', 'Kumarkhali', 'Lakshmipur Town', 'Maheshpur Town', 'Nagarbari', 'Nandigram', 'Panchbibi Town',
            'Purbapara', 'Rupatali', 'Sarkari', 'Shibrampur', 'Sultanganj', 'Tarkul', 'Ullapara', 'Vogra', 'Yasminpur', 'Zeropoint',
            'Agradigha', 'Bagerhat Town'
        ]);

        return array_values(array_unique(array_filter($extendedNames, static fn ($name) => is_string($name) && trim($name) !== '')));
    }

    protected static function banglaAliases(): array
    {
        return [
            'ঢাকা' => 'ঢাকা',
            'চট্টগ্রাম' => 'চট্টগ্রাম',
            'কুমিল্লা' => 'কুমিল্লা',
            'বরিশাল' => 'বরিশাল',
            'খুলনা' => 'খুলনা',
            'রাজশাহী' => 'রাজশাহী',
            'রংপুর' => 'রংপুর',
            'সিলেট' => 'সিলেট',
            'গাজীপুর' => 'গাজীপুর',
            'গাজীপুর সদর' => 'গাজীপুর সদর',
            'সাভার' => 'সাভার',
            'কেরানীগঞ্জ' => 'কেরানীগঞ্জ',
            'ধামরাই' => 'ধামরাই',
            'হাজীগঞ্জ' => 'হাজীগঞ্জ',
            'চাঁদপুর' => 'চাঁদপুর',
            'যশোর' => 'যশোর',
            'টাঙ্গাইল' => 'টাঙ্গাইল',
            'নরসিংদী' => 'নরসিংদী',
            'ফরিদপুর' => 'ফরিদপুর',
            'গোপালগঞ্জ' => 'গোপালগঞ্জ',
            'সিরাজগঞ্জ' => 'সিরাজগঞ্জ',
            'পাবনা' => 'পাবনা',
            'রাঙ্গামাটি' => 'রাঙ্গামাটি',
            'বান্দরবান' => 'বান্দরবান',
            'কক্সবাজার' => 'কক্সবাজার',
            'সুনামগঞ্জ' => 'সুনামগঞ্জ',
            'মৌলভীবাজার' => 'মৌলভীবাজার',
            'হবিগঞ্জ' => 'হবিগঞ্জ',
            'ফেনী' => 'ফেনী',
            'লক্ষ্মীপুর' => 'লক্ষ্মীপুর',
            'নোয়াখালী' => 'নোয়াখালী',
            'নাটোর' => 'নাটোর',
            'রাজবাড়ী' => 'রাজবাড়ী',
            'পটুয়াখালী' => 'পটুয়াখালী',
            'বরগুনা' => 'বরগুনা',
            'ভোলা' => 'ভোলা',
            'নওগাঁ' => 'নওগাঁ',
            'ঝালকাঠি' => 'ঝালকাঠি',
            'পিরোজপুর' => 'পিরোজপুর',
            'সাতক্ষীরা' => 'সাতক্ষীরা',
            'বাগেরহাট' => 'বাগেরহাট',
            'ঠাকুরগাঁও' => 'ঠাকুরগাঁও',
            'দিনাজপুর' => 'দিনাজপুর',
            'গাইবান্ধা' => 'গাইবান্ধা',
            'কুড়িগ্রাম' => 'কুড়িগ্রাম',
            'নীলফামারী' => 'নীলফামারী',
            'লালমনিরহাট' => 'লালমনিরহাট',
            'জয়পুরহাট' => 'জয়পুরহাট',
            'চাঁপাইনবাবগঞ্জ' => 'চাঁপাইনবাবগঞ্জ',
            'মধুপুর' => 'মধুপুর',
            'টেকনাফ' => 'টেকনাফ',
            'শ্রীমঙ্গল' => 'শ্রীমঙ্গল',
            'টঙ্গী' => 'টঙ্গী',
            'মিরপুর' => 'মিরপুর',
            'উত্তরা' => 'উত্তরা',
            'বনানী' => 'বনানী',
            'মোহাম্মদপুর' => 'মোহাম্মদপুর',
            'ধানমন্ডি' => 'ধানমন্ডি',
            'গুলশান' => 'গুলশান',
            'বসুন্ধরা' => 'বসুন্ধরা',
            'বারিধারা' => 'বারিধারা',
            'খিলগাঁও' => 'খিলগাঁও',
            'বাড্ডা' => 'বাড্ডা',
            'মতিঝিল' => 'মতিঝিল',
            'তেজগাঁও' => 'তেজগাঁও',
            'নিকুঞ্জ' => 'নিকুঞ্জ',
            'ফার্মগেট' => 'ফার্মগেট',
            'শাহবাগ' => 'শাহবাগ',
            'পল্টন' => 'পল্টন',
            'মোগাবাজার' => 'মোগাবাজার',
            'কাফরুল' => 'কাফরুল',
            'রামপুরা' => 'রামপুরা',
            'বানশ্রী' => 'বানশ্রী',
            'ওয়ারী' => 'ওয়ারী',
            'মাতুয়াইল' => 'মাতুয়াইল',
            'যাত্রাবাড়ী' => 'যাত্রাবাড়ী',
            'কদমতলী' => 'কদমতলী',
            'হাজারীবাগ' => 'হাজারীবাগ',
            'কালাবাগান' => 'কালাবাগান',
            'মোহাখালী' => 'মোহাখালী',
            'নিউমার্কেট' => 'নিউমার্কেট',
            'প্রিন্স বাজার' => 'প্রিন্স বাজার',
            'এলিফ্যান্ট রোড' => 'এলিফ্যান্ট রোড',
            'আজিমপুর' => 'আজিমপুর',
            'খিলখেত' => 'খিলখেত',
        ];
    }

    protected static function banglaEquivalentForLocation(string $location): ?string
    {
        $map = [
            'dhaka' => 'ঢাকা',
            'chattogram' => 'চট্টগ্রাম',
            'chittagong' => 'চট্টগ্রাম',
            'rangpur' => 'রংপুর',
            'sylhet' => 'সিলেট',
            'khulna' => 'খুলনা',
            'rajshahi' => 'রাজশাহী',
            'barishal' => 'বরিশাল',
            'bogura' => 'বগুড়া',
            'mymensingh' => 'ময়মনসিংহ',
            'gazipur' => 'গাজীপুর',
            'narayanganj' => 'নারায়ণগঞ্জ',
            'cumilla' => 'কুমিল্লা',
            'savar' => 'সাভার',
            'keraniganj' => 'কেরানীগঞ্জ',
            'dhamrai' => 'ধামরাই',
            'chandpur' => 'চাঁদপুর',
            'jashore' => 'যশোর',
            'jessore' => 'যশোর',
            'tangail' => 'টাঙ্গাইল',
            'bogra' => 'বগুড়া',
            'narsingdi' => 'নরসিংদী',
            'faridpur' => 'ফরিদপুর',
            'shariatpur' => 'শরীয়তপুর',
            'munshiganj' => 'মুন্সিগঞ্জ',
            'narail' => 'নড়াইল',
            'gopalganj' => 'গোপালগঞ্জ',
            'sirajganj' => 'সিরাজগঞ্জ',
            'pabna' => 'পাবনা',
            'rangamati' => 'রাঙ্গামাটি',
            'khagrachhari' => 'খাগড়াছড়ি',
            'bandarban' => 'বান্দরবান',
            'cox\'s bazar' => 'কক্সবাজার',
            'coxs bazar' => 'কক্সবাজার',
            'sunamganj' => 'সুনামগঞ্জ',
            'moulvibazar' => 'মৌলভীবাজার',
            'habiganj' => 'হবিগঞ্জ',
            'feni' => 'ফেনী',
            'lakshmipur' => 'লক্ষ্মীপুর',
            'noakhali' => 'নোয়াখালী',
            'natore' => 'নাটোর',
            'rajbari' => 'রাজবাড়ী',
            'patuakhali' => 'পটুয়াখালী',
            'barguna' => 'বরগুনা',
            'bhola' => 'ভোলা',
            'naogaon' => 'নওগাঁ',
            'jhalokati' => 'ঝালকাঠি',
            'pirojpur' => 'পিরোজপুর',
            'satkhira' => 'সাতক্ষীরা',
            'bagerhat' => 'বাগেরহাট',
            'thakurgaon' => 'ঠাকুরগাঁও',
            'dinajpur' => 'দিনাজপুর',
            'gaibandha' => 'গাইবান্ধা',
            'kurigram' => 'কুড়িগ্রাম',
            'nilphamari' => 'নীলফামারী',
            'lalmonirhat' => 'লালমনিরহাট',
            'joypurhat' => 'জয়পুরহাট',
            'chapainawabganj' => 'চাঁপাইনবাবগঞ্জ',
            'chandanaish' => 'চন্দনাইশ',
            'madhupur' => 'মধুপুর',
            'teknaf' => 'টেকনাফ',
            'sreemangal' => 'শ্রীমঙ্গল',
            'tongi' => 'টঙ্গী',
            'mirpur' => 'মিরপুর',
            'uttara' => 'উত্তরা',
            'banani' => 'বনানী',
            'mohammadpur' => 'মোহাম্মদপুর',
            'dhanmondi' => 'ধানমন্ডি',
            'gulshan' => 'গুলশান',
            'bashundhara' => 'বসুন্ধরা',
            'baridhara' => 'বারিধারা',
            'khilgaon' => 'খিলগাঁও',
            'badda' => 'বাড্ডা',
            'motijheel' => 'মতিঝিল',
            'tejgaon' => 'তেজগাঁও',
            'nikunja' => 'নিকুঞ্জ',
            'farmgate' => 'ফার্মগেট',
            'shahbag' => 'শাহবাগ',
            'paltan' => 'পল্টন',
            'moghbazar' => 'মোগাবাজার',
            'kafrul' => 'কাফরুল',
            'rampura' => 'রামপুরা',
            'banasree' => 'বানশ্রী',
            'wari' => 'ওয়ারী',
            'matuail' => 'মাতুয়াইল',
            'jatrabari' => 'যাত্রাবাড়ী',
            'kadamtali' => 'কদমতলী',
            'hazaribagh' => 'হাজারীবাগ',
            'kalabagan' => 'কালাবাগান',
            'mohakhali' => 'মোহাখালী',
            'new market' => 'নিউমার্কেট',
            'prince bazar' => 'প্রিন্স বাজার',
            'elephant road' => 'এলিফ্যান্ট রোড',
            'azimpur' => 'আজিমপুর',
            'khilkhet' => 'খিলখেত',
            'gazipur sadar' => 'গাজীপুর সদর',
            'narayanganj sadar' => 'নারায়ণগঞ্জ সদর',
            'tangail sadar' => 'টাঙ্গাইল সদর',
            'moulvibazar sadar' => 'মৌলভীবাজার সদর',
        ];

        $normalized = self::normalizedText($location);

        if (isset($map[$normalized])) {
            return $map[$normalized];
        }

        $direct = self::banglaAliases();
        if (isset($direct[$normalized])) {
            return $direct[$normalized];
        }

        return null;
    }
}
