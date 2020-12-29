<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace ZeroGravity\Directory\Setup;

use Magento\Directory\Helper\Data;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * Directory data
     *
     * @var Data
     */
    private $directoryData;

    /**
     * Init
     *
     * @param Data $directoryData
     */
    public function __construct(Data $directoryData)
    {
        $this->directoryData = $directoryData;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {

        /**
         * Fill table directory/country_city
         * Fill table directory/country_region
         * Fill table directory/country_region_name for en_US locale
         */

        $dataRegion = [
            ['Bagherhat', ['Bagerhat Sadar', 'Chalna Ankorage', 'Chitalmari', 'Fakirhat', 'Kachua Upo', 'Mollahat', 'Morelganj', 'Rampal', 'Rayenda']],
            ['Bandarban', ['Alikadam', 'Bandarban Sadar', 'Naikhong', 'Roanchhari', 'Ruma', 'Thanchi']],
            ['Barguna', ['Amtali', 'Bamna', 'Barguna Sadar', 'Betagi', 'Patharghata']],
            ['Barishal', ['Agailzhara', 'Babuganj', 'Barajalia', 'Barishal Sadar', 'Gouranadi', 'Mahendiganj', 'Muladi', 'Sahebganj', 'Uzirpur']],
            ['Bhola', ['Bhola Sadar', 'Borhanuddin Upo', 'Charfashion', 'Doulatkhan', 'Hajirhat', 'Hatshoshiganj', 'Lalmohan Upo']],
            ['Bogra', ['Alamdighi', 'Bogra Sadar', 'Dhunat', 'Dupchachia', 'Gabtoli', 'Kahalu', 'Nandigram', 'Sariakandi', 'Sherpur', ' Shibganj']],
            ['Brahmanbaria', ['Akhaura', 'Banchharampur', 'Brahamanbaria Sadar', 'Kasba', 'Nabinagar', 'Nasirnagar', 'Sarail']],
            ['Chandpur', ['Chandpur Sadar', 'Faridganj', 'Hajiganj', 'Hayemchar', 'Kachua', 'Matlab North','Matlab South', 'Shahrasti']],
            ['Chapinawabganj', ['Bholahat', 'Chapinawabganj Sadar', 'Nachol', 'Rohanpur', 'Shibganj U.P.O']],
            ['Chittagong', ['Anawara', 'Boalkhali', 'Chittagong Sadar', 'East Joara', 'Fatikchhari', 'Hathazari', 'Jaldi', 'Lohagara', 'Mirsharai', 'Patia', 'Rangunia', 'Rouzan', 'Sandwip', 'Satkania', 'Sitakunda']],
            ['Chuadanga', ['Alamdanga', 'Chuadanga Sadar', 'Damurhuda', 'Doulatganj']],
            ['Comilla', ['Barura', 'Brahmanpara', 'Burichang', 'Chandina', 'Chouddagram', 'Comilla Sadar', 'Daudkandi', 'Davidhar', 'Homna']],
            ['Coxs Bazar', ['Chiringga', 'Coxs Bazar Sadar', 'Gorakghat', 'Kutubdia', 'Ramu', 'Teknaf', 'Ukhia']],
            ['Dhaka', ['Badda', 'Banani', 'Banani Cantonment', 'Banani Dohs', 'Bangabhaban', 'Baridhara', 'Baridhara Dohs', 'Basabo', 'Bashundhara R/A', 'Dhanmondi', 'Dilkusha', 'Eskaton', 'Elephant Road', 'Firmgate', 'Gendaria', 'Green Road', 'Gulistan', 'Gulshan 1', 'Gulshan 2', 'Hazaribagh', 'Jigatala', 'Kakrail', 'Kalabagan', 'Kallyanpur', 'Karwan Bazar', 'Kathalbagan', 'Khilgaon', 'Khilkhet', 'Lalmatia', 'Mirpur', 'Mirpur 1', 'Mirpur 10', 'Mirpur 11', 'Mirpur 12', 'Mirpur 14', 'Mirpur 2', 'Mirpur 6', 'Mirpur 7', 'Moghbazar', 'Mohakhali', 'Mohakhali Dohs', 'Mohammadpur', 'Motijheel', 'New Market', 'Niketon', 'Nikunja-1', 'Nikunja-2', 'Noya Paltan', 'Panthapath', 'Paribag', 'Posta', 'Purana Paltan', 'Rampura', 'Sangsad Bhaban', 'Shantinagar', 'Shaymoli', 'Shukrabad', 'Sobhanbag', 'Tejgaon', 'Uttara Sector-2-4-6-8', 'Uttara Sector 1-3-5-7-9-10-11-12-13-14', 'Wari']],
            ['Outskirts Of Dhaka', ['Savar', ' Tongi']],
            ['Dinajpur', ['Bangla Hili', 'Biral', 'Birampur', 'Birganj', 'Chrirbandar', 'Dinajpur Sadar', 'Khansama', 'Maharajganj', 'Nababganj']],
            ['Faridpur', ['Alfadanga', 'Bhanga', 'Boalmari', 'Charbhadrasan', 'Faridpur Sadar', 'Madukhali', 'Nagarkanda', 'Sadarpur', 'Shriangan']],
            ['Feni', ['Chhagalnaia', 'Dagonbhuia', 'Feni Sadar', 'Pashurampur', 'Sonagazi']],
            ['Gaibandha', ['Bonarpara', 'Gaibandha Sadar', 'Gobindaganj', 'Palashbari', 'Phulchhari', 'Saadullapur', 'Sundarganj']],
            ['Gazipur', ['Gazipur Sadar', 'Kaliakaar', 'Kaliganj', 'Kapashia', 'Monnunagar', 'Sreepur', 'Sripur']],
            ['Gopalganj', ['Gopalganj Sadar', 'Kashiani', 'Kotalipara', 'Maksudpur', 'Tungipara']],
            ['Hobiganj', ['Azmireeganj', 'Bahubal', 'Baniachang', 'Chunarughat', 'Hobiganj Sadar', 'Kalauk', 'Madhabpur', 'Nabiganj']],
            ['Jamalpur', ['Dewangonj', 'Islampur', 'Jamalpur', 'Malandah', 'Mathargonj', 'Shorishabari']],
            ['Jessore', ['Bagharpara', 'Chaugachha', 'Jessore Sadar', 'Jhikargachha', 'Keshabpur', 'Monirampur', 'Noapara', 'Sarsa']],
            ['Jhalokathi', ['Jhalokathi Sadar', 'Kathalia', 'Nalchhiti', 'Rajapur']],
            ['Jinaidaha', ['Harinakundu', 'Jinaidaha Sadar', 'Kotchandpur', 'Maheshpur', 'Naldanga', 'Shailakupa']],
            ['Joypurhat', ['Akkelpur', 'Joypurhat Sadar', 'Kalai', 'Khetlal', 'Panchbibi']],
            ['Khagrachari', ['Diginala', 'Khagrachari Sadar', 'Laxmichhari', 'Mahalchhari', 'Manikchhari', 'Matiranga', 'Panchhari', 'Ramghar Head Office']],
            ['Khulna', ['Alaipur', 'Batiaghat', 'Chalna Bazar', 'Digalia', 'Khulna Sadar', 'Madinabad', 'Paikgachha', 'Phultala', 'Sajiara', 'Terakhada']],
            ['Kishoreganj', ['Bajitpur', 'Bhairob', 'Hossenpur', 'Itna', 'Karimganj', 'Katiadi', 'Kishoreganj Sadar', 'Kuliarchar', 'Mithamoin']],
            ['Kurigram', ['Bhurungamari', 'Chilmari', 'Kurigram Sadar', 'Nageshwar', 'Rajarhat', 'Rajibpur', 'Roumari', 'Ulipur']],
            ['Kustia', ['Bheramara', 'Janipur', 'Kumarkhali', 'Kustia Sadar', 'Mirpur', 'Rafayetpur']],
            ['Lakshmipur', ['Char Alexgander', 'Lakshimpur Sadar', 'Ramganj', 'Raypur']],
            ['Lalmonirhat', ['Aditmari', 'Hatibandha', 'Lalmonirhat Sadar', 'Patgram', 'Tushbhandar']],
            ['Madaripur', ['Barhamganj', 'Kalkini', 'Madaripur Sadar', 'Rajoir']],
            ['Magura', ['Arpara', 'Magura Sadar', 'Mohammadpur', 'Shripur']],
            ['Manikganj', ['Doulatpur', 'Gheor', 'Lechhraganj', 'Manikganj Sadar', 'Saturia', 'Shibloya', 'Singari']],
            ['Meherpur', ['Gangni', 'Meherpur Sadar']],
            ['Moulvibazar', ['Baralekha', 'Kamalganj', 'Kulaura', 'Moulvibazar Sadar', 'Rajnagar', 'Srimangal']],
            ['Munshiganj', ['Gajaria', 'Lohajong', 'Munshiganj Sadar', 'Sirajdikhan', 'Srinagar', 'Tangibari']],
            ['Mymensingh', ['Bhaluka', 'Fulbaria', 'Gaforgaon', 'Gouripur', 'Haluaghat', 'Isshwargonj', 'Muktagachha', 'Mymensingh Sadar', 'Nandail', 'Phulpur', 'Trishal']],
            ['Naogaon', ['Ahsanganj', 'Badalgachhi', 'Dhamuirhat', 'Mahadebpur', 'Naogaon Sadar', 'Niamatpur', 'Nitpur', 'Patnitala', 'Prasadpur']],
            ['Narail', ['Kalia', 'Laxmipasha', 'Mohajan', 'Narail Sadar']],
            ['Narayanganj', ['Araihazar', 'Baidder Bazar', 'Bandar', 'Fatullah', 'Narayanganj Sadar', 'Rupganj', 'Siddirganj']],
            ['Narshingdi', ['Belabo', 'Monohordi', 'Narshingdi Sadar', 'Palash', 'Raypura', 'Shibpur']],
            ['Natore', ['Gopalpur Upo', 'Harua', 'Hatgurudaspur', 'Laxman', 'Natore Sadar', 'Singra']],
            ['Netrakona', ['Susung Durgapur', 'Atpara', 'Barhatta', 'Dharmapasha', 'Dhobaura', 'Kalmakanda', 'Kendua', 'Khaliajuri', 'Madan']],
            ['Nilphamari', ['Dimla', 'Domar', 'Jaldhaka', 'Kishoriganj', 'Nilphamari Sadar', 'Syedpur']],
            ['Noakhali', ['Basurhat', 'Begumganj', 'Chatkhil', 'Hatiya', 'Noakhali Sadar', 'Senbag']],
            ['Pabna', ['Banwarinagar', 'Bera', 'Bhangura', 'Chatmohar', 'Debottar', 'Ishwardi', 'Pabna Sadar', 'Sathia', 'Sujanagar']],
            ['Panchagarh', ['Boda', 'Chotto Dab', 'Dabiganj', 'Panchagra Sadar', 'Tetulia']],
            ['Patuakhali', ['Bauphal', 'Dashmina', 'Galachipa', 'Khepupara', 'Patuakhali Sadar', 'Subidkhali']],
            ['Pirojpur', ['Banaripara', 'Bhandaria', 'Kaukhali', 'Mathbaria', 'Nazirpur', 'Pirojpur Sadar', 'Swarupkathi']],
            ['Rajbari', ['Baliakandi', 'Pangsha', 'Rajbari Sadar']],
            ['Rajshahi', ['Bagha', 'Bhabaniganj', 'Charghat', 'Durgapur', 'Godagari', 'Khod Mohanpur', 'Lalitganj', 'Putia', 'Rajshahi Sadar', 'Tanor']],
            ['Rangamati', ['Barakal', 'Bilaichhari', 'Jarachhari', 'Kalampati', 'Kaptai', 'Longachh', 'Marishya', 'Naniachhar', 'Rajsthali']],
            ['Rangpur', ['Gangachara', 'Kaunia', 'Mithapukur', 'Pirgachha', 'Rangpur Sadar', 'Taraganj']],
            ['Satkhira', ['Ashashuni', 'Debbhata', 'Kalaroa', 'Kaliganj Upo', 'Nakipur', 'Satkhira Sadar', 'Taala']],
            ['Shariatpur', ['Bhedorganj', 'Damudhya', 'Gosairhat', 'Jajira', 'Naria', 'Shariatpur Sadar']],
            ['Sherpur', ['Bakshigonj', 'Jhinaigati', 'Nakla', 'Nalitabari', 'Sherpur Shadar', 'Shribardi']],
            ['Sirajganj', ['Baiddya Jam Toil', 'Belkuchi', 'Dhangora', 'Kazipur', 'Shahjadpur', 'Sirajganj Sadar', 'Tarash', 'Ullapara']],
            ['Sunamganj', ['Bishamsarpur', 'Chhatak', 'Dhirai Chandpur', 'Duara Bazar', 'Ghungiar', 'Jagnnathpur', 'Sachna', 'Sunamganj Sadar', 'Tahirpur']],
            ['Sylhet', ['Balaganj', 'Bianibazar', 'Bishwanath', 'Fenchuganj', 'Goainhat', 'Gopalganj', 'Jaintapur', 'Jakiganj', 'Kanaighat', 'Kompanyganj', 'Sylhet Sadar']],
            ['Tangail', ['Basail', 'Bhuapur', 'Delduar', 'Ghatail', 'Gopalpur', 'Kalihati', 'Kashkaolia', 'Madhupur', 'Mirzapur', 'Nagarpur', 'Shakhipur', 'Tangail Sadar']],
            ['Thakurgaon', ['Baliadangi', 'Jibanpur', 'Pirganj', 'Rani Sankail', 'Thakurgaon Sadar']]
        ];


        foreach ($dataRegion as $region) {
            $country_id="BD";
            $city=$region[0];
            $regions=$region[1];

            $bindC = ['country_id' => $country_id, 'code' => $city, 'name' => $city];
            $setup->getConnection()->insert($setup->getTable('directory_country_city'), $bindC);
            foreach ($regions as $row) {

                $bind = ['country_id' => $country_id, 'code' => $row, 'default_name' => $row,'city'=>$city];
                $setup->getConnection()->insert($setup->getTable('directory_country_region'), $bind);
                $regionId = $setup->getConnection()->lastInsertId($setup->getTable('directory_country_region'));

                $bind = ['locale' => 'en_US', 'region_id' => $regionId, 'name' => $row];
                $setup->getConnection()->insert($setup->getTable('directory_country_region_name'), $bind);
            }
        }

    }
}
