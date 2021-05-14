-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 14, 2021 at 10:15 PM
-- Server version: 5.7.34
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mon10003_mh`
--

-- --------------------------------------------------------

--
-- Table structure for table `ACCOMMODATION`
--

CREATE TABLE `ACCOMMODATION` (
  `ACCOMMODATION_ID` varchar(64) NOT NULL,
  `ROOM_NAME` varchar(100) NOT NULL,
  `ACCOUNT_ID` varchar(70) NOT NULL,
  `ROOM_DESC` text NOT NULL,
  `RULES` varchar(500) NOT NULL,
  `PRICE` int(10) NOT NULL,
  `MAX_OF_PEOPLE` int(3) NOT NULL,
  `NO_OF_ROOM` int(2) NOT NULL,
  `NO_OF_BED` decimal(2,1) NOT NULL,
  `NO_OF_BATHROOM` int(2) NOT NULL,
  `DISTRICT` varchar(100) NOT NULL,
  `LOCATION` text NOT NULL,
  `ROOM_LIVESTYLE` varchar(25) NOT NULL,
  `AMENITIES` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ACCOMMODATION`
--

INSERT INTO `ACCOMMODATION` (`ACCOMMODATION_ID`, `ROOM_NAME`, `ACCOUNT_ID`, `ROOM_DESC`, `RULES`, `PRICE`, `MAX_OF_PEOPLE`, `NO_OF_ROOM`, `NO_OF_BED`, `NO_OF_BATHROOM`, `DISTRICT`, `LOCATION`, `ROOM_LIVESTYLE`, `AMENITIES`) VALUES
('023bf1ba7ce5256415c5c7646814e63245db2345ecdf4dda17788bfcc6c79f30', 'Tsim Sha Tsui Coliving apt for female\r\n', 'mh54897924b143356464f3518faad7db622acb64b879dd84fbed0ccd2ddbefe041', 'Female only capsule in our coliving space for rental. No deposit required. It locates next to Tsim Sha Tsui station on Nathan Road. Simple cooking is allowed in our kitchen, you can find necessary equipment there. Locker is provided which is fit for 28\" suitcase. You can also put your extra luggage at the luggage area. Each capsule has power socket inside. 5 star bed linen are using!', 'After 15:00-Before 14:00,no_party,no_pets,no_smoking,no_children', 180, 11, 1, 9.0, 4, 'Yau Tsim Mong District', 'Block S4, Kowloon Park, Tsim Sha Tsui', 'Private', 'air_conditioner,wifi,hair_dryer,tv,kitchen'),
('03cd773d7a9b92fcddf8b0872c15809eb54792d4e581ff69881e196c2e8a0b04', 'Large Private Room + Balcony near TKO MTR & HKUST', 'fb5531723913512228', 'DESCRIPTION: Upper-class residential complex in Hong Kong facing the South China Sea and the new French International School campus:\r\n- Bedroom with balcony\r\n- 4-minute walk to AIRPORT bus stop\r\n- 5-minute walk to Tseung Kwan O MTR Station\r\n- near HKUST\r\n- 2-minute walk to four supermarkets / shopping malls\r\n\r\nThe space\r\nA private bedroom from which the sea is visible in a modern high-end residential complex next to a shopping mall and a 5-minute walk from Tseung Kwan O metro station.\r\n\r\nQuiet neighborhood where you can enjoy the view of Hong Kong.', 'After 14:00-Before 12:00,no_pets,no_party,no_smoking', 289, 2, 1, 1.0, 1, 'Sai Kung District', '9 Tong Yin St, Tseung Kwan O', 'Private', 'air_conditioner,shower,wifi,hair_dryer,tv,kitchen'),
('097b41b0d0e078fd9a1a53cd510e50be4461aa8e62604a9907c80f505d5ebb8d', 'Tang Xiaoshuwowo home, fresh and comfortable apartment, warm and small home in a different place', 'mh910338c0f7e5e245c8bf37c03c0f63e89d9264ad8fbf85bb6c2ff175b78ec81a', 'This is a Loft apartment, Nordic wooden house style, skylights with star-gazing, double toilets, and extra large beds to give you the most relaxing rest.\r\nLocated in Dameisha Outlets Town, downstairs is the Outlets, the name of the community is Eighty Steps Haiyu, 500 meters from the seaside of Dameisha, 1 kilometers to the East OCT, to Vanke International Conference Center and Meisha The academy is only one hundred meters away.\r\nThe bus stop is downstairs, shopping is very convenient, convenience supermarket, Starbucks, Burger King, Nai Xue are all downstairs, downstairs.', 'After 10:00-Before 12:00,no_party,no_pets', 630, 2, 1, 1.0, 1, 'Sai Kung District', '3 Hing Tin St, Lam Tin', 'Private', 'air_conditioner,shower,wifi,hair_dryer,kitchen'),
('0b4cee502c116390b1f4fbe29202229e598d65bb920167c22824d6549e8425d3', '6 Queen Size Beds with 2 private bathrooms', 'mhab38e51167dc43b96c6f2ea98abb3796473be13fe91a1e1e', 'Launched in Dec. 2014, we are centrally located in a soulful Chinese neighbourhood and just a stone’s throw to the city’s hustling bustling attractions, as well as its renowned mountain & coastal charms.\r\n\r\nThe space\r\nOur Deluxe Queen Pods, are extremely spacious, Have their own keycard safes and privacy blinds, their own personal chill-out lounge area and 2 private showers!', 'After 15:00-Before 11:00,no_party,no_pets,no_smoking', 1500, 12, 1, 6.0, 2, 'Kowloon City District', '83 Sa Po Rd, Kowloon City', 'Private', 'air_conditioner,wifi,tv,kitchen,hair_dryer'),
('0ca4fbfe6d1f61adec7123e31fb2b04d4f4c375b63fc7fd8d93ebca337a6d97c', 'Spacious Whole Houseboat - Near Soho East', 'mh2a97d14039bb530dd428a15a3b5f91cb17460bda3f0c4db8705d910ee7b7760b', 'Located near the waterfront of Soho East, experience a unique stay in a spacious houseboat, with 4 bedrooms, 3 floors and over 2000 square feet of space.', 'After 10:00-Before 12:00,no_party,no_pets', 2700, 7, 4, 5.0, 2, 'Eastern District', 'Oi Lai St, Aldrich Bay', 'Deluxe', 'wifi,air_conditioner,hair_dryer,tv,kitchen'),
('14552799b779c8714f979d4d43dc1d8b54e4c0d0d1825a9b59920e9cc02e8a38', 'Big Bedroom Near HKUST, Kwun Tong & TKO Subway', 'mh52024933702095f623d238b0b551ddfcf2bd26334259e778448e68e20f1ca37a', 'A short 5 minutes\' walk from Tseung Kwan O MTR Station. Bedroom with balcony in a high-class residential complex surrounded by supermarkets and four shopping malls. Located beside a seaside park with a cycling area. A few minutes\' bus ride away from Sai Kung\'s nature.', 'After 13:00-Before 12:00,no_pets,no_party,no_smoking', 308, 2, 1, 1.0, 1, 'Sai Kung District', 'Tong Tak St, Tseung Kwan O', 'Simple', 'wifi,air_conditioner,hair_dryer,tv,table,,hair_dryer'),
('180609c260aa78307f85c429838cec6a034b4611fab7d9e6f418b5181d8d8011', 'BEST LOCATION! One Min Walk to New Town Plaza / MTR!', 'go114931508039548220186', 'Hi all, I have a well-designed studio room available in the heart of the city - Causeway Bay. There is a Queen-Sized bed, a study desk, two big wardrobes and your own PRIVATE BATHROOM in the studio apartment.', 'After 14:00-Before 11:00,no_party,no_pets,no_smoking', 468, 3, 1, 1.0, 1, 'Sha Tin District', '24 Tin Sam St, Tai Wai', 'Modern', 'air_conditioner,wifi,hair_dryer,tv,kitchen'),
('20db901d95b3919aab6ebcf5aa1510f808d3d82573cc3ce067a1a965632bfaac', 'Modern 2BR Flat in Heart of City. 1 min to MTR.', 'mhb49a2bbab7055432dcb7c094377b7653156cbd8361105fa13b851bad44c6c751', 'Newly refurbished, this lovely modern 2-bed flat is perfect for family holidays, friends vacays, and business trips alike. Sleeps up to 6 with 2 super comfy queen beds and a cosy sofabed. A proper dining area and fully equipped kitchen. Nestled in the heart of THE coolest neighbourhood of HK - Sheung Wan - with delicious local diners and award-winning coffee houses at your doorstep. 1 min walk to MTR, 3 min to Central & Soho, 10 min to the peak hike trail, 20 min cab ride to the beach!', 'After 14:00-Before 10:00,no_party,no_pets,no_smoking', 990, 6, 2, 2.0, 1, 'Central and Western District', '228-238 queen road Entreprise building 4F Central', 'Modern', 'air_conditioner,wifi,hair_dryer,tv,kitchen'),
('242f39d146c57b1231c6e579541b3051d522aca448c330c652798c681fd6b10e', 'Treetops - South Lantau', 'go114931508039548220186', 'Treetops - South Lantau is an idyllic retreat. Nestled in foothills of Sunset Peak yet less than five mins walk from the secluded Shan Shek Wan beach and close to the famous Cheung Sha beach and Pui O beaches.\r\n\r\nOur flat is located at the edge of a small quiet village with mountain and sea views. Hiking is on your doorstep as are tranquil streams swimmable rock pools.\r\n\r\nThis is the place to experience some peace and reconnect with nature.\r\n', 'After 14:00-Before 12:00,no_smoking,no_party', 2020, 4, 2, 2.2, 1, 'Islands District', 'S Lantau Rd, Lantau Island', 'Nature', 'wifi,air_conditioner,tv,table,kitchen,shampoo,towels,hair_dryer'),
('391294b4222494c8698a4efb0cd8a5f16ea76aa56df20cf47756834cd1ec6c29', 'Interior Design/Warm Classic Designer Homestay', 'go114687849892449315351', '-MTR subway E exit (3 minutes walk)\r\n-3 minutes by subway (Exit E)\r\n-There is Netflix! Youtube TV!\r\n-Highly Adjustable / Extendable TV frame, allows the screen to extend closer to the bed (Enjoy movie from your bed)\r\n-Adjustable/extended TV position (sleep in bed to enjoy) -On top of CWB Fashion Street / Food Street (Good food at your door steps. Literally)\r\n-Located in Causeway Bay Fashion Street/Food Street (the best food is downstairs) -Quiet Street in a busy area\r\n-Alarm clock to keep quiet -Minimalism -Minimalism', 'After 15:00-Before 11:00,no_party,no_pets,no_smoking', 468, 3, 1, 2.0, 1, 'Wan Chai District', 'Unit A, 13th Floor, Sun Tang Building, 6 Cleveland Street, Causeway Bay, Hong Kong', 'Simple', 'air_conditioner,wifi,tv,kitchen'),
('3a9a78015878c145393fc4c3c38e37994796d152ab9721a247cd730ab34bf727', 'BUDGET STUDIO FOR2', 'go115526276323034108584', '**PLEASE READ IMPORTANT NOTES AND DESCRIPTION BEFORE YOU BOOK!\r\n\r\nThe building is 24/7 secured by the guards while enjoying the 24HOURS SELF CHECK IN service! Our studio is perfect for solo travellers, couples or business travellers.\r\n\r\nTHREE METRO STATIONS AROUND -- Austin (3 minutes walk), Jordan(8-10 minutes walk) or Kowloon (8-10minutes walk).', 'After 14:00-Before 12:00,no_pets,no_party,no_smoking', 261, 2, 1, 1.0, 1, 'Yau Tsim Mong District', 'Shop C, 27 Battery Street, Yau Ma Tei', 'Simple', 'wifi,air_conditioner,tv,table,kitchen'),
('3c275a182c78ac39f4dc8c0af5367e359b1559a31199cfb81310841c2fb3f956', 'Treetops - South Lantau ', 'mhca7ab8385b620720bba923fb434ae70529a93698a5d065b8ea2197e2480ffc90', 'Treetops - South Lantau is an idyllic retreat. Nestled in foothills of Sunset Peak yet less than five mins walk from the secluded Shan Shek Wan beach and close to the famous Cheung Sha beach and Pui O beaches.', 'After 13:00-Before 12:00,no_smoking,no_party,no_children', 1800, 3, 2, 2.0, 1, ' Islands District', '17 San Shek Wan, Lantau Island', 'Treetops', 'microwave,wifi,air_conditioner,shampoo,towels,table'),
('3c8feed5ae88089a7f2c2c01b604c39cd3a3703b0f64e413c05fb7766efd9cef', '1100sq Large 3BR Mongkok Shopping Tourist Centre', 'mh877229e629e803a6143b0a527868f422bca9881208943a2c41bd10e94df1d6a5', 'A newly furnished 3 bedroom apartment 2min walk to the Mongkok MTR Station and Langham Place Shopping Mall. Large 100 inch projector screen to watch your favourite Netflix after a long day of shopping and sightseeing.\r\n\r\nThe space\r\nA lovely spacious 3 bedroom apartment in the heart of Mongkok. Directly upstairs from Mongkok MTR station with access to all that Hong Kong has on offer.\r\n\r\nNewly designed and beautifully decorated with all modern furnishings. The spacious apartment is comfortable for 6-8 guests. Welcome to my apartment, located in the heart of Hong Kong shopping, food and culture centre.', 'After 15:00-Before 12:00,no_party,no_pets,no_smoking', 808, 10, 3, 3.0, 2, 'Yau Tsim Mong District', 'T.O.P. This Is Our Place, 700 Nathan Rd', 'Modern', 'air_conditioner,wifi,hair_dryer,tv,kitchen'),
('3de201c3a66364f39caf58ca5427365909c31a60a65ade3146601ac91bd45326', 'Stylish studio with a private terrace', 'mhca7ab8385b620720bba923fb434ae70529a93698a5d065b8ea2197e2480ffc90', 'A cute, homely studio perfect for a weekend escape from the city! Lamma is the gateway destination full of greenery, nature and peace.\r\n\r\n- 10-12 minutes to pier (up the hill) PLEASE NOTE IT IS UP A HILL!\r\n- 6 minutes walk down to the beach, 10 minutes up\r\n- Hiking trails all around\r\n- Perfect for solo travellers/couples, always welcome to invite friends for a BBQ\r\n- 6-10 minutes to the main village, full of shops, delis, market stalls, restaurants, cafes and seafood restaurants', 'After 15:00-Before 11:00,no_party,no_smoking', 900, 2, 1, 1.0, 1, 'Islands District', 'Lamma Island', 'Nature', 'air_conditioner,shampoo,hair_dryer,tv'),
('4175b62c00ed3d9928b046234487702fb0ef32de1356f039224788810e39a2b8', 'Modern Stylish Apt', 'mhab38e51167dc43b96c6f2ea98abb3796473be13fe91a1e1ed085fcb8ea4c6f47', 'New renovated apartment in Prince Edward.\r\nJust 3 mins walk from Prince Edward MTR station Exit D.\r\n3 double beds in my apartment, it’s suit for family trip.\r\nThis building is secured with 24 hr security guard and a locked street gate at all time.\r\nIt has elevator from street level to apartment.', 'After 14:00-Before 12:00,no_children,no_smoking,no_party', 400, 6, 2, 3.0, 2, 'Yau Tsim Mong District', '180-182 Lai Chi Kok Road, Prince Edward', 'Modern Stylish', 'wifi,air_conditioner,tv,table,kitchen'),
('42ecffb50faf9bcc74a9cea575811e2cfe330cce20a0127384a6fb3a129284d4', 'Highheaven house', 'mhc5bec4951e9f5b91ad095e264b2a47ddb5803c64777ccaba246fe04c07831e31', 'sunset hits the back wall\r\ntasteful wooden furniture\r\nunit passageway windows open to an inner square\r\nthis features a natural flow from back to front\r\nthe neighbourhood hosts emerging designers and artists\r\nwashing dries quickly on hanging system\r\nrhinoceros man carved into the wall\r\ncurved windowsill akin to a mudbrick house\r\nfully furnished with hot water system\r\nWi-Fi ready to go\r\nnew windows and A/C\r\ncomfortable and chilled out\r\nif the unit tickles your fancy\r\nlong term rental available', 'After 14:00-Before 12:00,no_party,no_smoking', 1280, 4, 1, 2.0, 1, 'Tsuen Wan District', '18 Shibei Street', 'Nordic Style', 'air_conditioner,wifi,shampoo,hair_dryer,tv,kitchen'),
('4eccdcd33fed19b2b60fe54780bbadb89d1c8308932165c76e746c64428f343c', 'Tin Shui Wai Private Room, New Reno *1B', 'fb106080884912293', 'Newly renovated private rooms with shared bathrooms in Tin Shui Wai. Location is quiet and convenient, lots of eateries nearby. There is no MTR station nearby however lots of bus stops in and around the area.', 'After 15:00-Before 11:00,no_pets,no_smoking', 288, 1, 1, 1.0, 1, 'North District', '8 Tin Shui Rd, Tin Shui Wai', 'Modern', 'wifi,air_conditioner,tv,kitchen,shower'),
('55192ad0623a407e6805d7cde364f95e92dc6f3b2c4813ec84e76723abf48838', 'Japanese style cottage with swing and wooden horse in Taoyuan', 'mh2a97d14039bb530dd428a15a3b5f91cb17460bda3f0c4db8705d910ee7b7760b', 'If your rental purpose is for shooting (no matter if it is a photo, a print, a video, etc.), please inform the number of people, the number of equipment, the estimated start time and end time in advance. We need to charge a shooting fee for shooting, please be aware, in order to avoid unpleasantness please communicate with us in advance ^-^', 'After 14:00-Before 12:00,no_party,no_pets', 481, 3, 1, 1.0, 1, 'Sha Tin District', '18 Tung Lo Wan Hill Rd, Tai Wai', 'Simple', 'air_conditioner,shampoo,hair_dryer,tv'),
('6c5f2a6c5a42e787f711133282c7ff2a72a68d87e8705c21658101e6b361e3d0', 'Private room at Tseung Kwan O', 'mhb6c16b03a1ccce960cf1e20a68f6ac3c2a63d63f052ba9e641e68d259cc99e83', 'Well furnished apartment just above TKO MTR station. Close to Sai Kung and HKUST.', 'After 14:00-Before 12:00,no_pets,no_party,no_smoking', 500, 1, 1, 1.0, 1, 'Sai Kung District', '31-29 Tong Yin St, Tseung Kwan O', 'Private', 'wifi,air_conditioner,tv,hair_dryer'),
('6f435f094c1101ebe516c1b78c80b17759a27496e09f06c9bdd6d14c64ff6222', 'BL-1 Min TST MTR perfect for family & group', 'mhb6c16b03a1ccce960cf1e20a68f6ac3c2a63d63f052ba9e641e68d259cc99e83', 'This modern and spacious apartment is located in the heart of Kowloon, Conveniently located in all types of transportation (1 minute walk to MTR, Airport bus, City bus, Taxi), Local and international restaurants are just around the corner (Local Cantonese food, Japanese, Thai, Indonesian, Turkish, Indian, Street food etc.) Supermarkets and Shopping\'s malls (both imitation and original high end luxury brands).\r\n\r\nThe apartment is fully furnish and newly renovated, vibrant, hygienic and comfortable.', 'After 15:00-Before 12:00,no_party,no_pets,no_smoking', 2250, 10, 3, 5.0, 2, 'Yau Tsim Mong District', '12/F, Sands Building, 17 Hankow Rd, Tsim Sha Tsui', 'Simple', 'air_conditioner,wifi,tv,kitchen'),
('7305819e2758dc6c2612730782e1effe93475f2f735a1f9a968fd7dc03c6911a', 'Spacious 1000sf 1br with big terrace', 'mhc9060a31d89fa1a0cb2e04a72745f4659ac3be8ea1aaf5038c8eb72cf099d167', 'A stylish loft apartment in Sheung Wan.( used to be my photography studio )Fully furnished, equipped and rare spacious flat in Hong Kong! Very convenient~ central location: 3 minutes walk to Sai Ying Pun MTR station To Central /SoHo/Lan Kwai Fong/ Po Hing Fong only a walking distance.', 'After 13:00-Before 10:00,no_smoking,no_party', 1288, 6, 1, 3.0, 1, 'Central and Western District', '70 Des Voeux Rd W, Sheung Wan, Hong Kong', 'Studio', 'wifi,air_conditioner,tv,radiator,kitchen,shower'),
('7441b13702fbd38179cd85efbbfa7ed22b512ed6b8837f1e083788be98952ed5', 'Floor-to-ceiling glass windows, with panoramic mountain views, king-size bed room/couple/family', 'mh910338c0f7e5e245c8bf37c03c0f63e89d9264ad8fbf85bb6c2ff175b78ec81a', '[Room Features] 270-degree panoramic mountain view room, large floor-to-ceiling glass windows directly facing the Qiniang Mountain, the second highest mountain in Shenzhen, the room is equipped with a stylish bathtub, open bathing, and enjoy the harmony of nature\r\n\r\n[Room Facilities] The room is equipped with Hitachi air-conditioning, Marriott Intercontinental and other five-star hotel Serta mattresses of the same type, GABO all-smart electric toilet, GABO bathtub, leisure tea, advanced custom toiletries, custom linen slippers, free WIFI, etc. facility', 'After 14:00-Before 12:00,no_party,no_pets,no_smoking', 1527, 2, 1, 1.0, 1, 'Yuen Long District', '8 Fuk Shun St, Yuen Long', 'Private', 'air_conditioner,wifi,hair_dryer,tv,kitchen'),
('76afde47d7af650623393af6ebbc0bbe5ad1ba43695688c128667de645f12fb5', 'Upscale five-star hotel-style apartment by the sea, downstairs, magnificent night view of Victoria', 'mh949ac26c182bc6dcdda73ce70a8301c548d2ef7acf2f771a77cef61ffb49a07c', 'Really going downstairs is the sea view, the magnificent Victoria Harbour scenery, allowing you to live in the bustling city every day, strolling along the beach and watching the night view of Victoria Harbour’s seaside life', 'After 14:00-Before 12:00,no_party,no_pets,no_smoking', 905, 4, 2, 3.0, 1, 'Yau Tsim Mong District', '8 Oi King St, Hung Hom Bay', 'Deluxe', 'wifi,air_conditioner,kitchen'),
('7a2250d62d11cf93f014134274cb6ad5d94a93a71a531105b17c226cc8de9ec7', 'COZY 2PPL stay TST ICC ELEMENT Airport express', 'mh85101c6889e8a9171a426ea7657a4daa803574f5ceda34444256b365e4fb1ea3', 'Our studio is perfect for solo travellers, couples or business travellers as the location is the best in town.\r\n\r\nOur home is surrounded by THREE METRO STATIONS -- Austin station (3 minutes walk), Jordan station (8-10minutes walk) or Kowloon station (8minutes walk). Tsim Sha Tsui, Yau Ma Tei, Mong Kok are only ONE to TWO METRO STOPS AWAY.', 'After 15:00-Before 11:00,no_party,no_pets,no_smoking', 347, 2, 1, 1.5, 1, 'Yau Tsim Mong District', '8 Man Yuen St, Jordan', 'Simple', 'air_conditioner,shower,wifi,hair_dryer,tv,kitchen'),
('8039c81ed0d4d0982229f03b863e5b29a1dc8c318b68e1bcc0a04a6e5018b89c', 'SOHO\'s urban fashion designer apartment', 'go106082222172576588429', 'My warm, sunny, relaxing apartment is located in the heart of SoHo, just below the\'red\' point on the Hong Kong map! My apartment is chic, urban, stylish, fully equipped and spacious. It is located in the lower section of Yilijin Street, which is also the most sought-after location in Hong Kong. The apartment has a long window, you can admire the street life below.', 'After 14:00-Before 12:00,no_party,no_smoking', 580, 3, 1, 2.0, 1, 'Central and Western District', '16a Staunton Street, Central', 'Urban', 'air_conditioner,wifi,shampoo,hair_dryer,tv, Washing_machine'),
('8368b6c997efe8bee25f09b4ed56d483119aafba7a4ef57e6e6d001651f80c8d', 'Mui Wo-Renovated Apartment ', 'mh7aa7e7303037e16459d17721ffd4a9e2eddec1965e09e3aaf61f4e0b885c0d52', 'A fully renovated modern flat located in the heart of a traditional Lantau village. This pet friendly property is available on a private basis, giving you the privacy you require to sit back, rest & recharge. Located on the first floor of a detached house with French windows and a comfortable private outdoor balcony space fitted with outdoor seating.', 'After 14:00-Before 12:00,no_pets,no_party', 780, 6, 2, 3.0, 2, ' Islands District', 'Luk Tei Tong Tsuen Path, Mui Wo', 'Continental Style', 'wifi,air_conditioner,tv,kitchen,microwave'),
('8d9a660a1e7cb79cd42cec132fe43000c9f7099687994bb6bf90fa4c43b04f84', '3BR with lift Max12ppl Perfectforfamily 2mins-MTR', 'mh7aa7e7303037e16459d17721ffd4a9e2eddec1965e09e3aaf61f4e0b885c0d52', 'Welcome to HongKong!\r\nThe building is surrounded by hundreds of restaurants including local style Cha Chan Tangs where you can enjoy delicious HK food!\r\nOther than numerous restaurants, there are also supermarket, 24 hr convenient shops, bakeries,currency exchange, shopping mall etc anything you can imagine!', 'After 13:00-Before 12:00,no_party,no_pets,no_smoking,no_children', 1584, 10, 3, 7.0, 2, 'Tai Po District', '17 Silver Pond Road, Ting Kok', 'Simple', 'air_conditioner,wifi,shampoo,hair_dryer,tv,kitchen'),
('8ede9f0bbab935e3b96357f10429191afcea7a5c37646f02353f55e94369a73b', 'Luxury Kwun Tong Two Double Bed Room In Hongkong', 'fb5531723913512228', 'i have this beautiful twin bed room available for one night at Kwun Tong, 31st Dec in Kwun Tong Centre, as I have to cancel my trip.\r\nAs soon as you choose to book, I will contact the hotel to change the name and arrange your stay. As you will pay via Airbnb, no payment is being made at the property. If needed, I\'ll forward you the booking and payment confirmation.', 'After 14:00-Before 12:00,no_party,no_pets,no_smoking', 2125, 2, 1, 2.0, 1, 'Kwun Tong District', '8 Yuet Wah St, Kwun Tong', 'Deluxe', 'wifi,air_conditioner,hair_dryer,tv,kitchen'),
('90952956fca689d1718e2d296fbd0126ee533f43a2d4ffd333faa4693f8706c5', 'Wanchai DBL', 'mh949ac26c182bc6dcdda73ce70a8301c548d2ef7acf2f771a77cef61ffb49a07c', 'We will reject any guest have been to the buildings with confirmed cases of COVID-19 in the past 14 days.\r\n\r\nDue to the Covid-19, our book lounge is closed and roof top garden is partial opened until further notice.', 'After 14:00-Before 12:00,no_smoking,no_party', 400, 3, 1, 1.0, 1, 'Wan Chai District', 'Wan 313～323 Jaffe Road, Wan Chai', 'Wood-based', 'wifi,air_conditioner,tv,parking,table,Washing_machine'),
('91441043af1738e8b7358b2c7ec3408c7a9dd06d7931c8a460812322ddbbf72f', 'NEW 20sec to MTR Max12ppl Perfect for group', 'mh5af754c58dd1020e7f55189bf09d6deb7f4b5add67073c40a324ee54ea933f52', 'Welcome to HongKong! The building is surrounded by hundreds of restaurants including local style Cha Chan Tangs where you can enjoy delicious HK food! Other than numerous restaurants, there are also supermarket, 24 hr convenient shops, bakeries,currency exchange, shopping mall etc anything you can imagine!', 'After 12:00-Before 12:00,no_party,no_pets,no_smoking', 1600, 11, 3, 7.0, 2, 'Kowloon, Sham Shui Po', '399 Castle Peak Rd, Cheung Sha Wan', 'Private', 'wifi,air_conditioner,tv,kitchen'),
('9264298f1a2414213ee835ea66afc94806ff3fb18e07cc57e19299a385a5cec2', '2BR family home', 'go114687849892449315351', 'A spacious 6 person family home away from the hustle and bustle of Hong Kong. The apartment is located in the heart of Discovery Bay (DB), an expat location in Hong Kong with lots of greenery, a private beach and beautiful hiking routes.', 'After 14:00-Before 12:00,no_smoking,no_pets', 745, 4, 2, 2.0, 2, ' Islands District', 'Kwun Ha House, Block 3, Ming Tsui Terrace, Ming Tsui Drive, Discovery Bay', 'Comfortable', 'wifi,air_conditioner,bathtub,shampoo,washing_machine,tv'),
('97fa693fc601f10a6ddee041ec7cef84f13994eb328d051b0a6e9e14db78ce43', 'Classy & modern APT', 'mh877229e629e803a6143b0a527868f422bca9881208943a2c41bd10e94df1d6a5', 'My place is close to public transport (Tsim Sha Tshui MTR station, Jordan MTR station, Hung Hom MTR station) and the city center. You can take a shuttle to airport express (shutle station at 1 min). You’ll love my place because of the ambiance, the light, and the comfy bed. My place is good for couples, solo adventurers, business travelers. It is in the Korean district of Hong Kong with great restaurants you\'ll love :) !', 'After 13:00-Before 11:00,no_smoking,no_party,no_pets', 516, 5, 2, 2.0, 1, 'Yau Tsim Mong District', 'No.1 Knutsford Terrace, Tsim Sha Tsui', 'Simple', 'air_conditioner,wifi,hair_dryer,tv'),
('98988be72f73750f36e135fb679d18a1aa2f44770915cea3d1b0bffbfd623ed7', 'Interior Designer Studio', 'mh89867c7ca620b209b2827d23a2684141293371e837384ad8492dc7bea3364979', 'Interior Designer Studio in northpoint', 'After 12:00-Before 11:00,no_smoking,no_party', 705, 3, 1, 1.0, 1, 'Eastern District', 'G/F, 21-23 Kam Hong St, North Point', 'Studio', 'wifi,hair_dryer,tv,air_conditioner,kitchen'),
('9b7444e18d327ef32f520c6368cede7d73e70b5f109f740a07d45dfb2d569d36', 'Relaxing place and good transportation!', 'mhc5bec4951e9f5b91ad095e264b2a47ddb5803c64777ccaba246fe04c07831e31', 'We love to host different nationalities people and our place is very popular! We hosted to share culture, food and local HONG Kong life to you', 'After 12:00-Before 12:00,no_party,no_pets,no_smoking,no_children', 380, 2, 1, 1.0, 1, 'Tai Po District', '98 Boulevard Du Lac, Ting Kok', 'Private', 'air_conditioner,wifi,shampoo,hair_dryer,tv,kitchen'),
('a3732095006eccd09c84c2d0b48d61a914ecc7ccc36b1311d1c34ed7e71cde36', 'Independent 2 room house.. Near West Rail Station.. 5mins MTR.. free wifi..', 'mh89867c7ca620b209b2827d23a2684141293371e837384ad8492dc7bea3364979', 'Located in the New Territories, New Territories, Hong Kong, China, it is equipped with Wi-Fi, a kitchen, and a computer desk. In addition, the homestay is also equipped with air-conditioning. It provides washing machines, hangers, hair dryers and other household equipment, allowing you to enjoy a comfortable life.', 'After 15:00-Before 12:00,no_party,no_pets,no_smoking', 1388, 6, 2, 3.0, 1, 'Tsuen Wan District', '51 Wing Shun St, Tsuen Wan', 'Simple', 'air_conditioner,wifi,tv,kitchen'),
('a42842ce9348b47bffcac6aa06a9143efdb74c92dd0d3ac2e5f1675e8e8bda8b', 'Nordic space', 'mh5af754c58dd1020e7f55189bf09d6deb7f4b5add67073c40a324ee54ea933f52', 'There are three main subway stations near my home: Austin Station (3 minutes on foot), Jordan Station (8-10 minutes on foot), and Kowloon Station (8 minutes on foot). Central, Tsim Sha Tsui, Yau Ma Tei, and Mong Kok are only one or two subway stations away. The Kowloon Station is also the location of the Airport Express, which can take you directly to the airport in just 24 minutes. (There is a train every ten minutes, and the running time is from 6 am to 1 pm) A 15-minute walk from home can reach the most prosperous Yau Tsim Mong district in Hong Kong without the hassle of traffic.', 'After 14:00-Before 12:00,no_party,no_smoking', 1088, 3, 1, 1.0, 1, 'Yau Tsim Mong District', '1 Austin Rd W, West Kowloon', 'Nordic Style', 'wifi,air_conditioner,hair_dryer,tv,table'),
('a7248ce5b18f4f8e633447e9ff869e5ec577cbc81904912cc013379a45309960', 'The Beach Room', 'go115526276323034108584', 'If you feel like a staycation with sea views and your own beach, the Beach Room is designed for just that. Situated in a private garden space next to the main house, with access to the beach, open plan room with double bed, fully stocked kitchen and ensuite bathroom. Added amenties will make your stay comfortable and you are guaranteed wonderful sea views and a peaceful environment during your stay. Conveniently located near to bustling Sai Kung Town, its an ideal getaway from the city. We have put a lot of time and thought into making this area as comfortable and user-friendly as possible. The open plan kitchen allows for you to make your meals and there is a large gas BBQ available outside in your space. We live next door in the main house but we will try to give you as much privacy as possible and answer messages if you have any questions or issues Please note we share the connecting patio and garden space to your room. You will have your own area for sitting out To access the beach room, you must walk through the village to our main house and then through the garden to your room. We have added additional security lighting at night, but we advise you bring torches.', 'After 14:00-Before 12:00,no_party,no_pets,no_smoking', 1614, 4, 2, 1.1, 1, 'Sai Kung District', '210 Tai Mong Tsai Road, Sai Kung, New Territories, Hong Kong', 'Tiny house', 'air_conditioner,shower,wifi,hair_dryer,toilet_paper'),
('b3190569ce2cf5beb845553d1091fb31a4155fb6677d4a9e2cadcd34be5a9ca7', 'T1A-Best location 1BR Apt in HK - Shops & Sights', 'mh52024933702095f623d238b0b551ddfcf2bd26334259e778448e68e20f1ca37a', 'Welcome to my apartment, 1BR newly renovated and furnished. Located in the heart of Hong Kong\'s shopping, food and culture center. 1 minute walk to TST MTR station, airport transfer and all major transport.', 'After 13:00-Before 12:00,no_party,no_pets,no_smoking', 1020, 4, 1, 2.0, 1, 'Yau Tsim Mong District', 'Lee Kar Building, Carnarvon Rd, No. 4, Tsim Sha Tsui', 'Modern', 'wifi,air_conditioner,,hair_dryer,tv,kitchen'),
('b8eca860c6df0665a5966fc699135267b0dd9b1df3c1a6253ba593a6205c5928', 'Hotel provides take-away continental breakfast', 'go115526276323034108584', 'Located within the transportation hub of Kowloon, Rambler Oasis Hotel is a 20-minute train ride from Disneyland Resort and a 20-minute taxi ride from Hong Kong International Airport. Maritime Square Shopping Center is a 7-minute shuttle bus ride away. Tsing Yi MTR Station and Kwai Fong MTR Station are a 7-minute mini bus ride away.', 'After 14:00-Before 12:00,no_pets', 604, 4, 1, 1.0, 1, 'Kwai Tsing District', '1 Tsing Yi Rd, Tsing Yi', 'Deluxe', 'air_conditioner,wifi,tv'),
('bc55f829409e163d1919599b890476edccc2e824e29f571ea7f9f4b72e26de01', 'SeaSide Hong Kong', 'mh5d50f9c7d029d6837d01ae9607847225c039e9cf384f81ebea235b44380b4e37', 'Try the amazing experience in Hong Kong. You will feel like in vacation.\r\nAmazing view.\r\nNext to the beach.\r\n40 min by bus to Central/ Causeway Bay, Quarry bay.\r\n\r\nThe space\r\n2 double room flat.\r\nYou are alone in the flat.\r\nHowever, ONLY ONE ROOM AVAILABLE FOR YOU out of the 2.\r\n\r\nGuest access\r\nAll the flat except my room', 'After 12:00-Before 12:00,no_party,no_pets,no_smoking', 1511, 4, 1, 1.0, 1, 'Southern District', '1 Stanley Link Rd, Stanley', 'Simple', 'air_conditioner,wifi,tv,kitchen'),
('ccab967adca5391646bcc835c983b51ad7043cd3116a9b1fe7133cc64f1234dc', 'Art director home 3br WC/ CWB', 'go105561102062899685756', 'Best Location in HK! Indie restaurants and world-class shopping malls are comfortably located nearby this apartment, while the nearby MTR station will conveniently transport you to your favorite destinations.', 'After 11:00-Before 10:00,no_pets,no_party,no_smoking', 1167, 4, 1, 1.0, 1, 'Central and Western District', '12～18 Morrison Hill Rd, Wan Chai', 'Nature', 'wifi,air_conditioner,hair_dryer,tv,table'),
('ccf78faa0def746d304fdb266d51cfeb4da4bded2b85ca2751305eb35dd57627', '50% off: Amazing Stylish & Chic 780 sqft Suite #2', 'go118071272540373812870', 'We are proud to provide the well traveled you a chic home-away-from-home in the midst of buzzing Tuen Mun. This is originally designed by Philippe Starck and while we had a makeover to cater to our travelers\' needs, we remain respectful to its rich history. We have a vision to create an unique experience through design, and allow you to be immersed in the Tuen Mun local culture.', 'After 14:00-Before 12:00,no_party,no_pets,no_smoking', 1600, 3, 1, 1.0, 1, 'Tuen Mun District', '1 Tuen Lee St, Tuen Mun', 'Private', 'wifi,air_conditioner,tv,radiator,kitchen,shower'),
('d85a0475e41595f57df4b74704e518d354639d22d19334a7dc51670fcdd24a70', '99 Bonham - Deluxe Suite', 'mh5d50f9c7d029d6837d01ae9607847225c039e9cf384f81ebea235b44380b4e37', 'Located in Hong Kong’s dynamic Sheung Wan District, 99 Bonham provides exceptional access to prestigious business, shopping, dining and entertainment destinations.\r\n99 Bonham is just a 3-minute walk from MTR Sheung Wan Station, while Central is a 20-minute walk away. Both Lan Kwai Fong and SoHo are 15 minutes\' walk away. It takes an hour to reach Hong Kong International Airport from the property by taking Airport Express.', 'After 11:00-Before 10:00,no_pets,no_party,no_smoking\r\n', 1430, 2, 1, 1.0, 1, 'Central and Western District', '379-375 Queen\'s Road Central', 'Deluxe', 'wifi,air_conditioner,hair_dryer,tv,gym,shampoo'),
('e7d1a504ac9704249a5dd5a729742703302403034234775687ca0f389095a161', 'Preferred for travel and residence MTR licenced guesthouse', 'go105561102062899685756', 'Many restaurant and local food nearby\r\nWe have big sign facing the street, very easy to access\r\nPrivate washroom\r\nClean and tidy\r\nFree wifi\r\nReasonable price', 'After 13:00-Before 10:00,no_party,no_pets,no_smoking', 698, 2, 1, 1.0, 1, 'Wong Tai Sin District', '8 Muk Lun St, Chuk Un', 'Modern', 'wifi,air_conditioner,hair_dryer,kitchen,tv'),
('ea0d408172994f1ff05693eb653a6c617dd6de020b565edcfb69a7d7416b3cb4', 'YHA Mei Ho House Youth Hostel', 'mhc9060a31d89fa1a0cb2e04a72745f4659ac3be8ea1aaf5038c8eb72cf099d167', 'Sham Shui Po Exit B2 (8mins walk) Sham Shui Po Station Exit B2 (8mins walk) / Shek Kip Mei Exit A (9mins walk) Shek Kip Mei Exit A (9mins walk) Shek Kip Mei Station Exit A (9mins walk) Double Bed x 1 (1.8mx 2m) ) / Single Bed x 2 (0.9mx 2m) 25 Square feet Non smoking room Private bathroom in room 1 double bed (1.8mx2m) / 2 single beds (0.9mx2m) • Room area 25 square meters • Non smoking Smoking room • Separate toilet', 'After 16:00-Before 10:00,no_smoking', 250, 2, 1, 2.0, 1, 'Sham Shui Po District', '41, 70 Berwick St, Shek Kip Mei', 'Simple', 'air_conditioner,wifi,tv,kitchen'),
('f24bea89c4f4efeb6e3632e966226d0eaf42f0ee796d36643110e142967e5221', 'Long-term rental super discount cheap and cozy', 'go106082222172576588429', 'The location of Nancyhouse B&B is excellent, two minutes away from Yuen Long Longping MTR Station, close to Yuen Long Main Road, Yuen Long Shopping Mall, it is very convenient for eating and shopping. The B&B is located on the second floor with independent stairs. The whole unit is independent of the residents of other units. The rooms are bright, spacious and quiet. 3D TV, air conditioning, refrigerator, water heater, free Wi-Fi, etc.\r\n\r\nThe space\r\nNancyhouse B&B is located in Daqiao Village. It is very quiet on weekdays. It takes only two to three minutes to Long Ping MRT Station. It is close to the bus station. There are tea restaurants, markets, parks, etc. nearby. It is close to Yuen Long Main Road and is very convenient for shopping.', 'After 14:00-Before 13:00,no_party,no_pets,no_smoking', 380, 2, 1, 1.0, 1, 'Yuen Long District', '31 Yau San St, Yuen Long', 'Simple', 'air_conditioner,wifi,tv,kitchen'),
('f464fbf2abebe3aa072b39716159bcf3d4d3203be3be8404afb52e3562c80fa2', 'Middle floor of Village House', 'fb106080884912293', 'Modern, newly renovated, 650 Sq Foot middle floor, consisting of an open plan living room/kitchen, balcony, double bedroom and ensuite bathroom. Fibre Optic Wifi. Smart TV. Airconditioning with dehumidier and heating functions. Double glazed. Note: 1st floor shares door and open plan staircase with owners on top floor.', 'After 11:00-Before 10:00,no_smoking,no_party,no_pets', 880, 2, 1, 1.0, 1, ' Islands District', '6 Ngan Kwong Wan Rd, Mui Wo', 'Simple', 'air_conditioner,wifi,washing_machine,tv,parking,balcony'),
('f9e4af2e3c2ca80fbbce89b0f8c6a4b649750ac57cefd55d7fa1a41ab58d18a2', '2BR Main City Apartment', 'mhb49a2bbab7055432dcb7c094377b7653156cbd8361105fa13b851bad44c6c751', 'Located directly adjacent to Yau Ma Tei A1 MTR, my place is very convenient with access to Lady St, Sneaker St and Temple St in Mongkok within several mins of walking. Being located in a building refurbished nearly two years and at high level, it is very quiet and an elevator is available to access this level.', 'After 14:00-Before 12:00,no_children', 525, 6, 2, 4.0, 1, 'Yau Tsim Mong District', '351 Shanghai St, Yau Ma Tei', 'Simple', 'tv,wifi,air_conditioner,shampoo,towels');

-- --------------------------------------------------------

--
-- Table structure for table `ACCOUNT`
--

CREATE TABLE `ACCOUNT` (
  `USER_ID` int(10) NOT NULL,
  `TYPE` varchar(2) NOT NULL,
  `SURNAME` varchar(15) NOT NULL,
  `GIVEN_NAME` varchar(15) NOT NULL,
  `EMAIL` varchar(80) NOT NULL,
  `PASSWORD` varchar(100) DEFAULT NULL,
  `IMG_URL` varchar(200) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `MOBILE` int(16) DEFAULT NULL,
  `ACCOUNT_ID` varchar(100) NOT NULL,
  `SEX` varchar(10) DEFAULT NULL,
  `STATUS` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ACCOUNT`
--

INSERT INTO `ACCOUNT` (`USER_ID`, `TYPE`, `SURNAME`, `GIVEN_NAME`, `EMAIL`, `PASSWORD`, `IMG_URL`, `DOB`, `MOBILE`, `ACCOUNT_ID`, `SEX`, `STATUS`) VALUES
(1, 'mh', ' Chan ', 'Tai Man', 'mantaichan021@gmail.com', '95423394ae3e3038b45ddaa4db3c1641538e8a8720ac3e5ee10c5ce368ca6a6f', NULL, '1998-10-16', 93848572, 'mhb49a2bbab7055432dcb7c094377b7653156cbd8361105fa13b851bad44c6c751', 'M', 0),
(2, 'go', 'Wong', 'Jackson', 'jacksomaaaa@gmail.com', NULL, 'https://lh3.googleusercontent.com/a/AATXAJwl0hwpdPzDRXhmQkaSbIQwsOBAcm-l5JvMTOCQ=s96-c', NULL, 12312312, 'go114687849892449315351', 'M', 1),
(4, 'mh', 'Chan', 'Ho Man', 'markchan123@gmail.com', '13004d8331d779808a2336d46b3553d1594229e2bb696a8e9e14554d82a648da', NULL, '1995-06-23', 64987542, 'mhca7ab8385b620720bba923fb434ae70529a93698a5d065b8ea2197e2480ffc90', 'M', 0),
(6, 'mh', 'Cheung', 'Man Tat', 'tattatcheung12@gmail.com', '501fe884fdbbb0bceafff5f4fd2f3423cd32d435e96a0a85e56cdf067a632894', 'https://monistic-hotel.com/images/users/mhc9060a31d89fa1a0cb2e04a72745f4659ac3be8ea1aaf5038c8eb72cf099d167.jpg', '1998-06-25', 64978421, 'mhc9060a31d89fa1a0cb2e04a72745f4659ac3be8ea1aaf5038c8eb72cf099d167', 'M', 1),
(7, 'mh', 'Lee', 'Ming Hin', 'hinlee97@gmail.com', '1a84db779b94dd0df4f75e078a7e805178d0c8dfa8e8f069fb3e4ab204c5d166', NULL, '1997-07-14', 61484572, 'mh877229e629e803a6143b0a527868f422bca9881208943a2c41bd10e94df1d6a5', 'M', 0),
(8, 'mh', 'Cheung', 'Man Tai', 'mantai93@gmail.com', '6428b4a6b521d0b26825f8ca2f285a7c7449d8ef24c9e58531a5b77f853256f4', NULL, '1993-10-21', 26487512, 'mh89867c7ca620b209b2827d23a2684141293371e837384ad8492dc7bea3364979', 'M', 0),
(9, 'mh', 'Wong', 'Ming Tak', 'peterwong0717@gmail.com', '0ef198f02d13c7364ebc9b7d548fd125e1678affd651c21ba25f23532acfc5b5', NULL, '2001-07-17', 64978421, 'mhc5bec4951e9f5b91ad095e264b2a47ddb5803c64777ccaba246fe04c07831e31', 'F', 0),
(10, 'go', 'Man', 'James', 'jamesmanhoyin@gmail.com', NULL, 'https://lh6.googleusercontent.com/-vVYziRoJFvQ/AAAAAAAAAAI/AAAAAAAAAAA/AMZuucm0PEwUiMBppIC3qxcoe35oPTJ54A/s96-c/photo.jpg', '1994-12-02', 62391164, 'go115526276323034108584', 'M', 1),
(11, 'go', 'PRCO', 'PRCO', 'prco204hk@gmail.com', NULL, 'https://lh3.googleusercontent.com/-pKcxs6o0haE/AAAAAAAAAAI/AAAAAAAAAAA/AMZuucnWv6l3fUeXEJ4zQWDcRj2iRyIeqA/s96-c/photo.jpg', '1970-01-08', 94837423, 'go114931508039548220186', 'M', 1),
(12, 'go', 'ABS', 'ABS', 'prco204hk04@gmail.com', NULL, 'https://lh5.googleusercontent.com/-b0t6ZY50dPw/AAAAAAAAAAI/AAAAAAAAAAA/AMZuucnBNKqoAnU_fEb5nEvJkySsDAX9lQ/s96-c/photo.jpg', '1970-01-01', 62391164, 'go118071272540373812870', 'M', 1),
(13, 'go', 'MAN', 'HO YIN', '20154953@learner.hkuspace.hku.hk', NULL, 'https://lh3.googleusercontent.com/-pvji1ncK2b8/AAAAAAAAAAI/AAAAAAAAAAA/AMZuuckl-F7A7E1cgmJXAksi-MXFpmOPxA/s96-c/photo.jpg', NULL, NULL, 'go106082222172576588429', NULL, 1),
(14, 'fb', 'Prco', 'Prco', 'prco204hk04@gmail.com', NULL, 'http://graph.facebook.com/106080884912293/picture?type=large', NULL, NULL, 'fb106080884912293', NULL, 1),
(16, 'fb', 'Men', 'James', 'jamesmanhoyin@hotmail.com', NULL, 'http://graph.facebook.com/5531723913512228/picture?type=large', NULL, NULL, 'fb5531723913512228', NULL, 1),
(18, 'mh', 'Hung', 'Ka Ho', 'kaho_0913@gmail.com', 'f2a360d82ccc9e2861faf5b78afffed4b9207878451376930c27e547698ca61a', NULL, '1998-12-01', 97851242, 'mh5d50f9c7d029d6837d01ae9607847225c039e9cf384f81ebea235b44380b4e37', 'M', 1),
(19, 'mh', 'Wong', 'Wing Shan', 'shanwong93@gmail.com', '5c9bac88327c459cd32d0bc9b0bb68eae8324a6345e0195767e395df48512500', NULL, '1993-05-08', 62485512, 'mh949ac26c182bc6dcdda73ce70a8301c548d2ef7acf2f771a77cef61ffb49a07c', 'F', 1),
(20, 'mh', 'Kong', 'Man Yee', 'manyee85@gmail.com', '134690299ca93cd8993eee6da5bfb923a555cae3c064a7e42f1b16822c13a10a', NULL, '1985-02-15', 57845142, 'mhb6c16b03a1ccce960cf1e20a68f6ac3c2a63d63f052ba9e641e68d259cc99e83', 'F', 0),
(21, 'mh', 'Kwan', 'Kit Chi', 'Kennykwan213@gmail.com', 'ccb75f77be32492c2bc6c7d7c6d336df527b24e7cf78591d580ea3eb1af8590b', NULL, '1997-02-13', 94782142, 'mh5af754c58dd1020e7f55189bf09d6deb7f4b5add67073c40a324ee54ea933f52', 'M', 1),
(22, 'mh', 'Kwok', 'Wing Ki', 'wkk315@gmail.com', '05df97cd3f960904c7d9d4b01af8ee8bc5513bf711384838117e2a7338278957', NULL, '1992-02-25', 68754214, 'mh7aa7e7303037e16459d17721ffd4a9e2eddec1965e09e3aaf61f4e0b885c0d52', 'F', 0),
(23, 'mh', 'Pang', 'Ka Chun', 'kachun1998@gmail.com', 'c62e994b7ea6967ee2b2b451a4a399e216bca6f205e85c79bff4ead8f24bf750', NULL, '1998-12-18', 64887512, 'mh52024933702095f623d238b0b551ddfcf2bd26334259e778448e68e20f1ca37a', 'M', 1),
(24, 'mh', 'Wong', 'Wai Fung', 'Kelvinwong96@gmail.com', '5b5f2fcef55b816a75d72784a7528c51e5d0027f0d4dc7c5543142c72ce61b7b', NULL, '1996-02-26', 57842142, 'mh54897924b143356464f3518faad7db622acb64b879dd84fbed0ccd2ddbefe041', 'M', 1),
(25, 'mh', 'Chan', 'Tsz Ho', 'tomchan8496@gmail.com', '208292ac20b41e04bdd4720093462b58da94eb351c4665fdab0ba4641b6933eb', NULL, '1986-04-08', 94751426, 'mh910338c0f7e5e245c8bf37c03c0f63e89d9264ad8fbf85bb6c2ff175b78ec81a', 'M', 0),
(26, 'mh', 'Lee', 'Wing Yan', 'susanlee93@gmail.com', 'b0d58fe9da6559538a60bfed68c180a1451af81b008082b92643fa31339b67dc', NULL, '1993-05-08', 97855241, 'mh2a97d14039bb530dd428a15a3b5f91cb17460bda3f0c4db8705d910ee7b7760b', 'F', 1),
(27, 'mh', 'Tse', 'Wing Tung', 'twt082@gmail.com', 'b8302a53d5779b673a1173566f68af7b986ea014a3e7544780b1a23cf8237b30', NULL, '1998-08-02', 64875512, 'mh85101c6889e8a9171a426ea7657a4daa803574f5ceda34444256b365e4fb1ea3', 'F', 1),
(28, 'mh', 'Wong', 'Ka Man', 'Yammywong693@gmail.com', '9cb36d8163e145d63258baeee4f524bc07a0c9a26b3b9e08a64db25e81a4c2b9', NULL, '1994-11-21', 64785172, 'mha27c2ea6aacc909a3a6e146b31b07fd5cc2e119816b97e2a2cd4428451d742e1', 'F', 1),
(29, 'mh', 'Choi', 'Wing Ki', 'kikiwing94@gmail.com', '0db8c649414a11c4ad37983c4c40c651e5fa7445fcd4561f5a4067c5a866023f', NULL, '1994-02-16', 67845142, 'mh5e35d2923b800bc7d43f82142321811bf07a425e43589717b72e175474209622', 'M', 0),
(48, 'mh', 'Man', 'James', 'jamesmanhoyin@gmail.com', '501fe884fdbbb0bceafff5f4fd2f3423cd32d435e96a0a85e56cdf067a632894', NULL, '1994-01-20', 98989596, 'mh20bd79bb6a04acec2a19b9650bc68e2b99dc95cc277fe2ebd958e5cd3e560fd8', 'M', 1),
(49, 'mh', 'Chong', 'Kevin', 'kevincck96@gmail.com', '633e6d095024faf1caf5621378867eefa5c78a55d9e01dc64aca7721a7f1e8af', NULL, '1998-01-14', 64778542, 'mh4971ccafdaa3440f2c8ecc01bf0e619851468abd3022834d587909c6d6de9069', 'M', 1),
(50, 'mh', 'Test', 'Test', 'sipifem376@troikos.com', 'cf00d4904dbc6b5215dcf15fd449262efcb191b6e592d954f8b5d6729dedfd69', NULL, '1988-01-14', 90000000, 'mh51e052cf23f1ff7cea5633a540f3219cde576144c3ab1c134226afe17bf751d9', 'M', 1);

-- --------------------------------------------------------

--
-- Table structure for table `COMMENT`
--

CREATE TABLE `COMMENT` (
  `COMMENT_ID` varchar(64) NOT NULL,
  `ACCOUNT_ID` varchar(100) NOT NULL,
  `CM_CONTENT` varchar(1000) NOT NULL,
  `RATING` int(1) NOT NULL,
  `HISTORY_ID` varchar(64) NOT NULL,
  `ACCOMMODATION_ID` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `COMMENT`
--

INSERT INTO `COMMENT` (`COMMENT_ID`, `ACCOUNT_ID`, `CM_CONTENT`, `RATING`, `HISTORY_ID`, `ACCOMMODATION_ID`) VALUES
('1', 'go118071272540373812870', 'Nice place close to nature. We enjoyed a great stay there and will certainly return in the future.', 4, '1', 'a7248ce5b18f4f8e633447e9ff869e5ec577cbc81904912cc013379a45309960'),
('14', 'go114931508039548220186', 'The apartment is clean and tidy. Parker responses very quick on my enquiries. It was a pleasant stay ', 4, '2', '97fa693fc601f10a6ddee041ec7cef84f13994eb328d051b0a6e9e14db78ce43'),
('15', 'go114687849892449315351', 'Parker’s place is ideally situated minutes from MTR station and many restaurants nearby. The place is clean and beautiful.', 4, '5', '9264298f1a2414213ee835ea66afc94806ff3fb18e07cc57e19299a385a5cec2'),
('16', 'go115526276323034108584', 'Everything was great and exactly the same as the photos shown. But the hot water cannot last for long, even we have pre-heated the storage water heater for 15 minute.', 2, '6', '7305819e2758dc6c2612730782e1effe93475f2f735a1f9a968fd7dc03c6911a'),
('17', 'go114687849892449315351', 'Recommend!!! It is a very nice experience. The place is clean and comfortable. Many convenience stores and restaurants are near the building. The host is helpful.', 5, '18', '3a9a78015878c145393fc4c3c38e37994796d152ab9721a247cd730ab34bf727'),
('18', 'mhca7ab8385b620720bba923fb434ae70529a93698a5d065b8ea2197e2480ffc90', 'Good to try some local food near the apartment', 5, '20', 'f464fbf2abebe3aa072b39716159bcf3d4d3203be3be8404afb52e3562c80fa2'),
('19', 'mh877229e629e803a6143b0a527868f422bca9881208943a2c41bd10e94df1d6a5', 'The toilet is small. Not very quiet. ', 2, '21', '03cd773d7a9b92fcddf8b0872c15809eb54792d4e581ff69881e196c2e8a0b04'),
('20', 'mhc5bec4951e9f5b91ad095e264b2a47ddb5803c64777ccaba246fe04c07831e31', 'The host is very considerate, communicated effectively and efficiently. The place is sparkly clean and cozy for a small warm gathering.', 5, '22', 'd85a0475e41595f57df4b74704e518d354639d22d19334a7dc51670fcdd24a70'),
('21', 'go114931508039548220186', 'The unit was tidy and everything we needed was there. Location was a bit hard to find but the area has access to nearby stores.', 3, '23', '6c5f2a6c5a42e787f711133282c7ff2a72a68d87e8705c21658101e6b361e3d0'),
('22', 'go106082222172576588429', 'Excellent service with quick response! Good location and well equipped', 5, '29', '8368b6c997efe8bee25f09b4ed56d483119aafba7a4ef57e6e6d001651f80c8d'),
('23', 'go105561102062899685756', 'Everything is same as described but only the toilet light wasn’t working and cannot be fixed during the time of my stay', 2, '30', 'a7248ce5b18f4f8e633447e9ff869e5ec577cbc81904912cc013379a45309960'),
('24', 'mhab38e51167dc43b96c6f2ea98abb3796473be13fe91a1e1ed085fcb8ea4c6f47', 'The place is spacious and looks almost exactly like what you see in the pictures provided! However, the overall cleanliness was not satisfactory (e.g. the floor was a bit dirty, the sofa was old and had stains)', 3, '31', 'f9e4af2e3c2ca80fbbce89b0f8c6a4b649750ac57cefd55d7fa1a41ab58d18a2'),
('25', 'mh5af754c58dd1020e7f55189bf09d6deb7f4b5add67073c40a324ee54ea933f52', 'It’s very clean and tidy, and the terrace was just perfect especially at night when it’s so quiet outside and you can have a great conversation with friends', 4, '33', '97fa693fc601f10a6ddee041ec7cef84f13994eb328d051b0a6e9e14db78ce43'),
('26', 'mhca7ab8385b620720bba923fb434ae70529a93698a5d065b8ea2197e2480ffc90', 'Nice place to stay!! Good location and cleanliness', 5, '34', 'f9e4af2e3c2ca80fbbce89b0f8c6a4b649750ac57cefd55d7fa1a41ab58d18a2'),
('27', 'mh877229e629e803a6143b0a527868f422bca9881208943a2c41bd10e94df1d6a5', 'Nice apartment and great location. But, we saw a lot of ants.', 4, '35', '3c275a182c78ac39f4dc8c0af5367e359b1559a31199cfb81310841c2fb3f956'),
('28', 'mhc5bec4951e9f5b91ad095e264b2a47ddb5803c64777ccaba246fe04c07831e31', 'Love your smart TV, really had a great time with frds at your place, thanks!\r\nKwan Wai', 4, '36', '97fa693fc601f10a6ddee041ec7cef84f13994eb328d051b0a6e9e14db78ce43'),
('29', 'go114931508039548220186', 'Great location and super responsive. Decent and well-equipped place for 3-4 to stay.', 4, '37', '42ecffb50faf9bcc74a9cea575811e2cfe330cce20a0127384a6fb3a129284d4'),
('30', 'go105561102062899685756', 'It’s an overall good experience with accurate location in TST city center. The place is neat. Just a remark that it would be a bit empty/ quiet walking on the way to the apartment at night. ', 4, '49', '8039c81ed0d4d0982229f03b863e5b29a1dc8c318b68e1bcc0a04a6e5018b89c'),
('31', 'mhab38e51167dc43b96c6f2ea98abb3796473be13fe91a1e1ed085fcb8ea4c6f47', 'Great location and good size for family of four. The apartment has everything you need and a great view.', 5, '50', 'ccab967adca5391646bcc835c983b51ad7043cd3116a9b1fe7133cc64f1234dc'),
('32', 'mh949ac26c182bc6dcdda73ce70a8301c548d2ef7acf2f771a77cef61ffb49a07c', 'Host peaceful. Good place.', 4, '51', '4175b62c00ed3d9928b046234487702fb0ef32de1356f039224788810e39a2b8'),
('33', 'mh5af754c58dd1020e7f55189bf09d6deb7f4b5add67073c40a324ee54ea933f52', 'Nice room with detailed instruction in locating', 4, '52', '90952956fca689d1718e2d296fbd0126ee533f43a2d4ffd333faa4693f8706c5'),
('4fba3974776b6c3dc7c2ffdab35886bfbb3ad559a483f7525e148b7002b9e06c', 'go114931508039548220186', 'test', 4, '38', '242f39d146c57b1231c6e579541b3051d522aca448c330c652798c681fd6b10e'),
('bf5612b30fd6dbb7347f54ebff3c9449011198dacdd50b6761a84d4a8660d1fe', 'go114931508039548220186', 'very nice place', 4, '08be7ff5e8b1596a8b4c9caaff77fb342ae5a5a731359c45dd021e8c90cfc605', '9264298f1a2414213ee835ea66afc94806ff3fb18e07cc57e19299a385a5cec2');

-- --------------------------------------------------------

--
-- Table structure for table `DISTRICT`
--

CREATE TABLE `DISTRICT` (
  `DISTRICT_ID` varchar(3) NOT NULL,
  `DISTRICT_NAME` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `DISTRICT`
--

INSERT INTO `DISTRICT` (`DISTRICT_ID`, `DISTRICT_NAME`) VALUES
('D01', 'Hong Kong, Central and Western'),
('D02', 'Hong Kong, Eastern'),
('D03', 'Hong Kong, Southern'),
('D04', 'Hong Kong, Wan Chai'),
('D05', 'Kowloon, Kowloon City'),
('D06', 'Kowloon, Kwun Tong'),
('D07', 'Kowloon, Sham Shui Po'),
('D08', 'Kowloon, Wong Tai Sin'),
('D09', 'Kowloon, Yau Tsim Mong'),
('D10', 'New Territories, Islands'),
('D11', 'New Territories, Kwai Tsing'),
('D12', 'New Territories, North'),
('D13', 'New Territories, Sai Kung'),
('D14', 'New Territories, Sha Tin'),
('D15', 'New Territories, Tai Po'),
('D16', 'New Territories, Tsuen Wan'),
('D17', 'New Territories, Tuen Mun'),
('D18', 'New Territories, Yuen Long');

-- --------------------------------------------------------

--
-- Table structure for table `HISTORY`
--

CREATE TABLE `HISTORY` (
  `HISTORY_ID` varchar(64) NOT NULL,
  `CHECK_IN` date NOT NULL,
  `CHECK_OUT` date NOT NULL,
  `NO_OF_PEOPLE` int(3) NOT NULL,
  `ACCOMMODATION_ID` varchar(64) NOT NULL,
  `ACCOUNT_ID` varchar(100) NOT NULL,
  `BOOKING_DATE` date NOT NULL,
  `EVALUATION` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `HISTORY`
--

INSERT INTO `HISTORY` (`HISTORY_ID`, `CHECK_IN`, `CHECK_OUT`, `NO_OF_PEOPLE`, `ACCOMMODATION_ID`, `ACCOUNT_ID`, `BOOKING_DATE`, `EVALUATION`) VALUES
('03970da0ac226ff59a2b9bb0891466fc0245b19472e546f3e240df89c9460ade', '2021-05-21', '2021-05-22', 1, 'a7248ce5b18f4f8e633447e9ff869e5ec577cbc81904912cc013379a45309960', 'go114931508039548220186', '2021-05-13', 'N'),
('1', '2021-05-09', '2021-05-10', 2, 'a7248ce5b18f4f8e633447e9ff869e5ec577cbc81904912cc013379a45309960', 'go118071272540373812870', '2021-04-30', 'Y'),
('17', '2021-05-06', '2021-05-07', 1, '98988be72f73750f36e135fb679d18a1aa2f44770915cea3d1b0bffbfd623ed7', 'fb106080884912293', '2021-05-04', 'N'),
('18', '2021-05-04', '2021-05-05', 3, '3a9a78015878c145393fc4c3c38e37994796d152ab9721a247cd730ab34bf727', 'go114687849892449315351', '2021-05-01', 'Y'),
('19', '2021-05-10', '2021-05-12', 2, 'ef13a88c4760ed31bd593305446434a077915471e389ec648c74800ea53940cc', 'mhb49a2bbab7055432dcb7c094377b7653156cbd8361105fa13b851bad44c6c751', '2021-05-08', 'N'),
('2', '2021-05-03', '2021-05-04', 2, '97fa693fc601f10a6ddee041ec7cef84f13994eb328d051b0a6e9e14db78ce43', 'go114931508039548220186', '2021-05-01', 'Y'),
('20', '2021-04-20', '2021-04-21', 1, 'f464fbf2abebe3aa072b39716159bcf3d4d3203be3be8404afb52e3562c80fa2', 'mhca7ab8385b620720bba923fb434ae70529a93698a5d065b8ea2197e2480ffc90', '2021-04-16', 'Y'),
('21', '2021-05-01', '2021-05-04', 3, '03cd773d7a9b92fcddf8b0872c15809eb54792d4e581ff69881e196c2e8a0b04', 'mh877229e629e803a6143b0a527868f422bca9881208943a2c41bd10e94df1d6a5', '2021-04-28', 'Y'),
('22', '2021-05-04', '2021-05-05', 2, 'd85a0475e41595f57df4b74704e518d354639d22d19334a7dc51670fcdd24a70', 'mhc5bec4951e9f5b91ad095e264b2a47ddb5803c64777ccaba246fe04c07831e31', '2021-05-01', 'Y'),
('23', '2021-04-19', '2021-04-21', 2, '6c5f2a6c5a42e787f711133282c7ff2a72a68d87e8705c21658101e6b361e3d0', 'go114931508039548220186', '2021-04-17', 'Y'),
('286a2f7bfcd31c378746435721c3423d47d43b6cfef60b0435f350617e4c7a87', '2021-05-17', '2021-05-19', 3, '8039c81ed0d4d0982229f03b863e5b29a1dc8c318b68e1bcc0a04a6e5018b89c', 'go118071272540373812870', '2021-05-13', 'N'),
('29', '2021-04-29', '2021-04-30', 1, '8368b6c997efe8bee25f09b4ed56d483119aafba7a4ef57e6e6d001651f80c8d', 'go106082222172576588429', '2021-04-25', 'Y'),
('30', '2021-05-01', '2021-05-02', 2, 'a7248ce5b18f4f8e633447e9ff869e5ec577cbc81904912cc013379a45309960', 'go105561102062899685756', '2021-04-29', 'Y'),
('31', '2021-05-04', '2021-05-06', 3, 'f9e4af2e3c2ca80fbbce89b0f8c6a4b649750ac57cefd55d7fa1a41ab58d18a2', 'mhab38e51167dc43b96c6f2ea98abb3796473be13fe91a1e1ed085fcb8ea4c6f47', '2021-05-02', 'Y'),
('32', '2021-05-11', '2021-05-14', 2, '3c275a182c78ac39f4dc8c0af5367e359b1559a31199cfb81310841c2fb3f956', 'mh949ac26c182bc6dcdda73ce70a8301c548d2ef7acf2f771a77cef61ffb49a07c', '2021-05-07', 'N'),
('33', '2021-05-02', '2021-05-03', 2, '97fa693fc601f10a6ddee041ec7cef84f13994eb328d051b0a6e9e14db78ce43', 'mh5af754c58dd1020e7f55189bf09d6deb7f4b5add67073c40a324ee54ea933f52', '2021-04-26', 'Y'),
('34', '2021-05-03', '2021-05-04', 2, 'f9e4af2e3c2ca80fbbce89b0f8c6a4b649750ac57cefd55d7fa1a41ab58d18a2', 'mhca7ab8385b620720bba923fb434ae70529a93698a5d065b8ea2197e2480ffc90', '2021-04-29', 'Y'),
('35', '2021-04-12', '2021-04-14', 3, '3c275a182c78ac39f4dc8c0af5367e359b1559a31199cfb81310841c2fb3f956', 'mh877229e629e803a6143b0a527868f422bca9881208943a2c41bd10e94df1d6a5', '2021-04-10', 'Y'),
('36', '2021-04-26', '2021-04-27', 2, '97fa693fc601f10a6ddee041ec7cef84f13994eb328d051b0a6e9e14db78ce43', 'mhc5bec4951e9f5b91ad095e264b2a47ddb5803c64777ccaba246fe04c07831e31', '2021-04-21', 'Y'),
('37', '2021-04-27', '2021-04-28', 3, '42ecffb50faf9bcc74a9cea575811e2cfe330cce20a0127384a6fb3a129284d4', 'go114931508039548220186', '2021-04-21', 'Y'),
('49', '2021-04-28', '2021-04-30', 3, '8039c81ed0d4d0982229f03b863e5b29a1dc8c318b68e1bcc0a04a6e5018b89c', 'go105561102062899685756', '2021-04-25', 'Y'),
('5', '2021-04-27', '2021-04-29', 3, '9264298f1a2414213ee835ea66afc94806ff3fb18e07cc57e19299a385a5cec2', 'go115526276323034108584', '2021-04-22', 'Y'),
('50', '2021-04-19', '2021-04-21', 2, 'ccab967adca5391646bcc835c983b51ad7043cd3116a9b1fe7133cc64f1234dc', 'mhab38e51167dc43b96c6f2ea98abb3796473be13fe91a1e1ed085fcb8ea4c6f47', '2021-04-16', 'Y'),
('51', '2021-05-03', '2021-05-04', 2, '4175b62c00ed3d9928b046234487702fb0ef32de1356f039224788810e39a2b8', 'mh949ac26c182bc6dcdda73ce70a8301c548d2ef7acf2f771a77cef61ffb49a07c', '2021-05-01', 'Y'),
('52', '2021-04-28', '2021-04-29', 1, '90952956fca689d1718e2d296fbd0126ee533f43a2d4ffd333faa4693f8706c5', 'mh5af754c58dd1020e7f55189bf09d6deb7f4b5add67073c40a324ee54ea933f52', '2021-04-25', 'Y'),
('53', '2021-05-16', '2021-05-18', 2, 'a42842ce9348b47bffcac6aa06a9143efdb74c92dd0d3ac2e5f1675e8e8bda8b', 'mh52024933702095f623d238b0b551ddfcf2bd26334259e778448e68e20f1ca37a', '2021-05-13', 'N'),
('6', '2021-04-20', '2021-04-21', 2, '7305819e2758dc6c2612730782e1effe93475f2f735a1f9a968fd7dc03c6911a', 'go115526276323034108584', '2021-04-17', 'Y'),
('64', '2021-05-19', '2021-05-20', 1, 'ef13a88c4760ed31bd593305446434a077915471e389ec648c74800ea53940cc', 'go114931508039548220186', '2021-05-10', 'N'),
('889745f1bec954a89946e61c42e440a64a92a27a08145f247cd5a782086b36ae', '2021-05-12', '2021-05-13', 1, '180609c260aa78307f85c429838cec6a034b4611fab7d9e6f418b5181d8d8011', 'go114931508039548220186', '2021-05-12', 'N'),
('9c461912c73b1e5f734ac1c224df8d819143960d55a2bb84f3e37fca03e28935', '2021-05-19', '2021-05-20', 1, 'a7248ce5b18f4f8e633447e9ff869e5ec577cbc81904912cc013379a45309960', 'go114931508039548220186', '2021-05-12', 'N'),
('d70dc0187e511531d37ee13a3861479835609b8227365cb29b79184994c59e19', '2021-05-13', '2021-05-14', 1, 'a7248ce5b18f4f8e633447e9ff869e5ec577cbc81904912cc013379a45309960', 'go114931508039548220186', '2021-05-12', 'N'),
('ec0cf6731f21cd8f37b9caf8558b8c9d34f4986374234bb52702914d0164d6c1', '2021-05-19', '2021-05-20', 1, '03cd773d7a9b92fcddf8b0872c15809eb54792d4e581ff69881e196c2e8a0b04', 'mhc9060a31d89fa1a0cb2e04a72745f4659ac3be8ea1aaf5038c8eb72cf099d167', '2021-05-11', 'N'),
('fd71823ddf9bab8db45161c7c5dd7722341610d25fd1596a86193d81401c2f07', '2021-05-17', '2021-05-18', 1, 'a7248ce5b18f4f8e633447e9ff869e5ec577cbc81904912cc013379a45309960', 'go114931508039548220186', '2021-05-13', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `LOCATION`
--

CREATE TABLE `LOCATION` (
  `LOCATION_ID` varchar(4) NOT NULL,
  `LOCATION_NAME` varchar(30) NOT NULL,
  `DISTRICT_ID` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LOCATION`
--

INSERT INTO `LOCATION` (`LOCATION_ID`, `LOCATION_NAME`, `DISTRICT_ID`) VALUES
('L001', 'Kennedy Town', 'D01'),
('L002', 'Shek Tong Tsui', 'D01'),
('L003', 'Sai Ying Pun', 'D01'),
('L004', 'Sheung Wan', 'D01'),
('L005', 'Central', 'D01'),
('L006', 'Admiralty', 'D01'),
('L007', 'Mid-levels', 'D01'),
('L008', 'Peak', 'D01'),
('L009', 'Tin Hau', 'D02'),
('L010', 'Braemar Hill', 'D02'),
('L011', 'North Point', 'D02'),
('L012', 'Quarry Bay', 'D02'),
('L013', 'Sai Wan Ho', 'D02'),
('L014', 'Shau Kei Wan', 'D02'),
('L015', 'Chai Wan', 'D02'),
('L016', ' Siu Sai Wan', 'D02'),
('L017', 'Pok Fu Lam', 'D03'),
('L018', 'Aberdeen', 'D03'),
('L019', 'Ap Lei Chau', 'D03'),
('L020', 'Wong Chuk Hang', 'D03'),
('L021', 'Shouson Hill', 'D03'),
('L022', 'Repulse Bay', 'D03'),
('L023', 'Chung Hom Kok', 'D03'),
('L024', 'Stanley', 'D03'),
('L025', 'Tai Tam', 'D03'),
('L026', 'Shek O', 'D03'),
('L027', 'Wan Chai', 'D04'),
('L028', 'Causeway Bay', 'D04'),
('L029', 'Happy Valley', 'D04'),
('L030', 'Tai Hang', 'D04'),
('L031', 'So Kon Po', 'D04'),
('L032', 'Jardine\'s Lookout', 'D04'),
('L033', 'Hung Hom', 'D05'),
('L034', 'To Kwa Wan', 'D05'),
('L035', 'Ma Tau Kok', 'D05'),
('L036', 'Ma Tau Wai', 'D05'),
('L037', 'Kai Tak', 'D05'),
('L038', 'Kowloon City', 'D05'),
('L039', 'Ho Man Tin', 'D05'),
('L040', 'Kowloon Tong', 'D05'),
('L041', 'Beacon Hill', 'D05'),
('L042', 'Ping Shek', 'D06'),
('L043', 'Kowloon Bay', 'D06'),
('L044', 'Ngau Tau Kok', 'D06'),
('L045', 'Jordan Valley', 'D06'),
('L046', 'Kwun Tong', 'D06'),
('L047', 'Sau Mau Ping', 'D06'),
('L048', 'Lam Tin', 'D06'),
('L049', 'Yau Tong', 'D06'),
('L050', 'Lei Yue Mun', 'D06'),
('L051', 'Mei Foo', 'D07'),
('L052', 'Lai Chi Kok', 'D07'),
('L053', 'Cheung Sha Wan', 'D07'),
('L054', 'Sham Shui Po', 'D07'),
('L055', 'Shek Kip Mei', 'D07'),
('L056', 'Yau Yat Tsuen', 'D07'),
('L057', 'Tai Wo Ping', 'D07'),
('L058', 'Stonecutters Island', 'D07'),
('L059', 'San Po Kong', 'D08'),
('L060', 'Wong Tai Sin', 'D08'),
('L061', 'Tung Tau', 'D08'),
('L062', 'Wang Tau Hom', 'D08'),
('L063', 'Lok Fu', 'D08'),
('L064', 'Diamond Hill', 'D08'),
('L065', 'Tsz Wan Shan', 'D08'),
('L066', 'Ngau Chi Wan', 'D08'),
('L067', 'Tsim Sha Tsui', 'D09'),
('L068', 'Yau Ma Tei', 'D09'),
('L069', 'West Kowloon Reclamation', 'D09'),
('L070', 'King\'s Park', 'D09'),
('L071', 'Mong Kok', 'D09'),
('L072', 'Tai Kok Tsui', 'D09'),
('L073', 'Cheung Chau', 'D10'),
('L074', 'Peng Chau', 'D10'),
('L075', 'Lantau Island', 'D10'),
('L076', 'Tung Chung', 'D10'),
('L077', 'Lamma Island', 'D10'),
('L078', 'Kwai Chung', 'D11'),
('L079', 'Tsing Yi', 'D11'),
('L080', 'Fanling', 'D12'),
('L081', 'Luen Wo Hui', 'D12'),
('L082', 'Sheung Shui', 'D12'),
('L083', 'Shek Wu Hui', 'D12'),
('L084', 'Sha Tau Kok', 'D12'),
('L085', 'Luk Keng', 'D12'),
('L086', 'Wu Kau Tang', 'D12'),
('L087', 'Clear Water Bay', 'D13'),
('L088', 'Sai Kung', 'D13'),
('L089', 'Tai Mong Tsai', 'D13'),
('L090', 'Tseung Kwan O', 'D13'),
('L091', 'Hang Hau', 'D13'),
('L092', 'Tiu Keng Leng', 'D13'),
('L093', 'Ma Yau Tong', 'D13'),
('L094', 'Tai Wai', 'D14'),
('L095', 'Sha Tin', 'D14'),
('L096', 'Fo Tan', 'D14'),
('L097', 'Ma Liu Shui', 'D14'),
('L098', 'Wu Kai Sha', 'D14'),
('L099', 'Ma On Shan', 'D14'),
('L100', 'Tai Po Market', 'D15'),
('L101', 'Tai Po', 'D15'),
('L102', 'Tai Po Kau', 'D15'),
('L103', 'Tai Mei Tuk', 'D15'),
('L104', 'Shuen Wan', 'D15'),
('L105', 'Cheung Muk Tau', 'D15'),
('L106', 'Kei Ling Ha', 'D15'),
('L107', 'Tsuen Wan', 'D16'),
('L108', 'Lei Muk Shue', 'D16'),
('L109', 'Ting Kau', 'D16'),
('L110', 'Sham Tseng', 'D16'),
('L111', 'Tsing Lung Tau', 'D16'),
('L112', 'Ma Wan', 'D16'),
('L113', 'Sunny Bay', 'D16'),
('L114', 'Tai Lam Chung', 'D17'),
('L115', 'So Kwun Wat', 'D17'),
('L116', 'Tuen Mun', 'D17'),
('L117', 'Lam Tei', 'D17'),
('L118', 'Hung Shui Kiu', 'D18'),
('L119', 'Ha Tsuen', 'D18'),
('L120', 'Lau Fau Shan', 'D18'),
('L121', 'Tin Shui Wai', 'D18'),
('L122', 'Yuen Long', 'D18'),
('L123', 'San Tin', 'D18'),
('L124', 'Lok Ma Chau', 'D18'),
('L125', 'Kam Tin', 'D18'),
('L126', 'Shek Kong', 'D18'),
('L127', 'Pat Heung', 'D18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ACCOMMODATION`
--
ALTER TABLE `ACCOMMODATION`
  ADD PRIMARY KEY (`ACCOMMODATION_ID`);

--
-- Indexes for table `ACCOUNT`
--
ALTER TABLE `ACCOUNT`
  ADD PRIMARY KEY (`USER_ID`);

--
-- Indexes for table `COMMENT`
--
ALTER TABLE `COMMENT`
  ADD PRIMARY KEY (`COMMENT_ID`);

--
-- Indexes for table `DISTRICT`
--
ALTER TABLE `DISTRICT`
  ADD PRIMARY KEY (`DISTRICT_ID`);

--
-- Indexes for table `HISTORY`
--
ALTER TABLE `HISTORY`
  ADD PRIMARY KEY (`HISTORY_ID`);

--
-- Indexes for table `LOCATION`
--
ALTER TABLE `LOCATION`
  ADD PRIMARY KEY (`LOCATION_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ACCOUNT`
--
ALTER TABLE `ACCOUNT`
  MODIFY `USER_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
