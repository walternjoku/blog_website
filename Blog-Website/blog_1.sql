-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2024 at 11:33 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `author_id` int(11) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `author_email` varchar(256) NOT NULL,
  `author_password` varchar(255) NOT NULL,
  `author_bio` longtext NOT NULL,
  `author_role` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`author_id`, `author_name`, `author_email`, `author_password`, `author_bio`, `author_role`) VALUES
(3, 'York', 'york@gmail.com', '$2y$10$14ky3BlvI4dLIyd5N5cMzejRVFCAHJGk7GbQ0jUhZpfpowT4EFr7y', 'Enter Bio', 'admin'),
(4, 'Mike', 'mike@gmail.com', '$2y$10$vLnpTS4lLLmYKu8ANI/EVeVQ.7sibupaRx3g5ms/NPajIW6TBcq.K', '                                                        hey', 'author');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(20) NOT NULL,
  `category_name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Sports'),
(2, 'Technology'),
(3, 'Science');

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `page_id` int(11) NOT NULL,
  `page_title` varchar(256) NOT NULL,
  `page_content` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`page_id`, `page_title`, `page_content`) VALUES
(3, 'About', 'Updated....Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(5, 'Contact Us', '<table>\r\n<tr>\r\n<td>Name:</td>\r\n<td>John</td>');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(20) NOT NULL,
  `post_title` varchar(256) NOT NULL,
  `post_content` longtext NOT NULL,
  `post_category` int(20) NOT NULL,
  `post_author` int(20) NOT NULL,
  `post_date` varchar(256) NOT NULL,
  `post_keywords` varchar(256) NOT NULL,
  `post_image` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `post_title`, `post_content`, `post_category`, `post_author`, `post_date`, `post_keywords`, `post_image`) VALUES
(3, 'Time', 'Tempus fugit...Time flies', 1, 4, '2024-07-12 00:27:05', '', 'uploads/66905c391db913.32944958.jpg'),
(4, 'Yoga', 'Classic sports yoga performed by a lady in track-suit', 1, 4, '2024-07-12 09:58:51', '', 'uploads/6690e23bd10320.44007294.jpg'),
(5, 'Team Success', 'A forest is made up by a collection of trees. Team success is vital. We build together.', 2, 4, '2024-07-12 10:00:23', 'Team work', 'uploads/6690e297207180.93572467.jpg'),
(6, 'Para-Olympic', 'Impossible is nothing for the determined', 1, 4, '2024-07-12 10:02:37', '', 'uploads/6690e31d378071.36500261.jpg'),
(7, 'Human DNA', ' Chromosomes are unique. Humans have a total of 46, 23 of X and 23 of Y', 2, 4, '2024-07-12 10:04:10', 'DNA', 'uploads/6690e37addeb23.32290504.jpg'),
(8, 'Binary', 'Computers compute in 0s and 1s', 2, 3, '2024-07-16 16:46:55', '', 'uploads/669687df4daa13.81146828.jpg'),
(9, 'Work Cafe', 'In the quiet corner of a bustling café, a writer sits with a laptop open, fingers dancing across the keyboard. The aroma of freshly brewed coffee mingles with the soft hum of conversation, creating a perfect backdrop for creativity. The steam rises gently from the cup, a testament to the warmth and comfort that fuels the mind. With each sip, inspiration flows, and the words on the screen come to life.\r\n\r\nThis setting is an ode to the perfect blend of technology and tradition, where ideas are born and nurtured one cup at a time.', 2, 3, '2024-08-01 12:04:30', '', 'uploads/66ab5daeb166c2.94033597.jpg'),
(10, 'Rocket Launch', 'The crowd gathered at the edge of the launch site, eyes fixed on the towering rocket that stood against the backdrop of a clear blue sky. The air was thick with anticipation as the countdown commenced, each number echoing through the excitement-filled atmosphere.\r\n\r\n&quot;Ten... nine... eight...&quot;\r\n\r\nThe engines roared to life, a powerful rumble that vibrated through the ground and into the hearts of every onlooker. Flames and smoke billowed out as the rocket prepared for its journey.\r\n\r\n&quot;Seven... six... five...&quot;\r\n\r\nFamilies, friends, and space enthusiasts held their breath, cameras ready to capture the historic moment. The energy was electric, a shared dream about to take flight.\r\n\r\n&quot;Four... three... two...&quot;\r\n\r\nA final check, a heartbeat of silence.\r\n\r\n&quot;One... lift-off!&quot;\r\n\r\nWith a burst of fire and sound, the rocket surged upward, defying gravity. The cheers of the crowd merged with the roar of the engines, a symphony of human achievement and ambition. As the rocket soared higher, leaving a trail of white in the sky, every soul present felt a part of something larger—a collective step into the unknown, a leap towards the stars.\r\n\r\n', 2, 3, '2024-08-01 12:09:06', '', 'uploads/66ab5ec2b60d44.62288482.jpg'),
(11, 'Kayaking', 'The morning sun peeked over the horizon, casting a golden glow on the tranquil lake. A lone kayaker dipped their paddle into the glassy water, sending gentle ripples across the surface. The kayak glided silently, a sleek vessel moving with the rhythm of the paddler&#039;s strokes.\r\n\r\nSurrounded by the symphony of nature, the kayaker felt a profound sense of peace. Birds chirped melodiously from the trees lining the shore, and the scent of pine mingled with the fresh, crisp air. Each paddle stroke brought the kayaker deeper into a world untouched by the rush of everyday life.\r\n\r\nAs the kayak rounded a bend, the scene opened up to reveal a hidden cove, its waters so clear that the pebbles on the bottom sparkled like jewels. The kayaker paused, taking in the serene beauty, the only sounds being the gentle lapping of water against the kayak and the distant call of an eagle soaring high above.\r\n\r\nWith renewed energy, the kayaker continued their journey, weaving through narrow channels and navigating around clusters of water lilies. The thrill of exploration mingled with the meditative cadence of paddling, creating a perfect balance of adventure and tranquility.\r\n\r\nTime seemed to stand still on the water, the world reduced to the simple joy of movement and nature&#039;s embrace. As the sun climbed higher, casting dancing reflections on the water, the kayaker felt a deep connection to the environment and a sense of freedom that only the open water could provide.', 1, 3, '2024-08-01 12:11:55', '', 'uploads/66ab5f6b348e31.56528207.jpg'),
(12, 'Boxing', 'The gym was alive with the rhythmic sound of gloves hitting heavy bags and the sharp calls of trainers. In the center of the ring, a boxer stood poised, muscles taut and eyes focused, awaiting the start of the next round. The air was thick with the scent of sweat and determination, a testament to the hard work and grit that defined this sacred space.\r\n\r\nThe bell rang, and the boxer sprang into action, moving with a fluid grace honed by countless hours of training. Each jab, hook, and uppercut was a carefully calculated move, a blend of power and precision. The boxer&#039;s body was a symphony of motion, each muscle working in harmony to deliver blows and evade counterattacks.\r\n\r\nOpposite him, his sparring partner danced with equal intensity, their movements a mirror image, each seeking an opening, a moment of vulnerability. The sound of gloves connecting with pads and the occasional grunt of exertion filled the gym, a reminder of the fierce physical and mental battle unfolding in the ring.\r\n\r\nThe boxer&#039;s mind was a whirlwind of strategy and instinct. He recalled the advice of his coach: &quot;Keep your guard up, stay light on your feet, and watch for the telltale signs of an incoming punch.&quot; He breathed in deeply, feeling the rush of adrenaline, the world outside the ropes fading away until only the fight remained.\r\n\r\nRound after round, the boxers pushed each other to their limits, testing not just their physical endurance but their willpower and resilience. Every punch thrown was an assertion of strength, every dodge a display of agility and foresight.\r\n\r\nAs the final bell rang, signaling the end of the sparring session, the boxer lowered his gloves, chest heaving with exertion. He reached out to his opponent, a gesture of respect and camaraderie. They had pushed each other to be better, stronger, more disciplined.\r\n\r\nIn the quiet moments after the fight, as the boxer unlaced his gloves and wiped the sweat from his brow, he reflected on the journey. Boxing was more than a sport; it was a way of life, a test of character, and a path to self-discovery. Each punch, each round, was a step closer to mastering not just the art of boxing, but the art of inner strength and perseverance.', 1, 3, '2024-08-01 12:14:17', '', 'uploads/66ab5ff9a861f1.99430174.jpg'),
(13, 'Bike Race', 'The sun was just beginning to rise, casting a golden glow over the starting line where cyclists from around the world gathered, their colorful jerseys a vibrant mosaic against the morning sky. The air was filled with a palpable sense of anticipation and adrenaline as final checks were made—tires inflated to perfection, helmets secured, and water bottles filled.\r\n\r\nThe race marshal raised the flag, and a hush fell over the crowd. In that split second before the start, every rider took a deep breath, minds focused on the miles ahead. The flag dropped, and the silence erupted into a symphony of whirring wheels and the rhythmic cadence of pedals.\r\n\r\nThe cyclists surged forward as one, a tightly knit peloton slicing through the cool morning air. The pace was blistering from the start, each rider jockeying for position, finding the perfect balance between aggression and conservation. The sound of gears shifting and the occasional shout of communication filled the air as they navigated the first stretch.\r\n\r\nAs the race progressed, the terrain shifted from flat, open roads to challenging hills and winding descents. The peloton began to stretch out, with the strongest climbers pushing to the front, their legs pumping with relentless power. Every muscle burned, but the thrill of the competition and the beauty of the scenery propelled them onward.\r\n\r\nSpectators lined the route, cheering with enthusiasm, their energy providing a much-needed boost to the riders. Children waved flags, and families held up signs of encouragement, each cheer a reminder of the support and passion that surrounded the sport.\r\n\r\nAt the halfway mark, the race took on a new intensity. Breakaways formed, small groups of riders daring to challenge the pack and carve out a lead. Among them, a determined cyclist pushed harder, his eyes set on the horizon, where the finish line awaited. He remembered the hours of training, the early mornings and late nights spent honing his skills, and the sacrifices made along the way.\r\n\r\nThe final stretch was a test of endurance and strategy. The leading pack, now a select few, approached the finish line with everything they had left. The roar of the crowd grew louder, a wall of sound that urged them to give that final burst of speed. In those last, excruciating moments, it was heart and willpower that made the difference.\r\n\r\nWith a final, powerful push, the cyclist crossed the finish line, chest heaving and legs trembling. The race was over, but the sense of accomplishment and the thrill of competition lingered. He raised his arms in triumph, a smile breaking through the exhaustion, knowing that he had given his all.\r\n\r\nAs he slowed to a stop and the reality of his achievement sank in, the cyclist was surrounded by fellow competitors and well-wishers. In that moment, he felt a profound connection to everyone who had been part of the race—riders, spectators, and supporters alike. It was more than just a race; it was a celebration of human spirit, determination, and the joy of pushing beyond limits.\r\n', 1, 3, '2024-08-01 12:18:00', '', 'uploads/66ab60d8e131a1.11513353.jpg'),
(14, 'Intel-Core-i9', 'The Intel Core i9 processor stands at the pinnacle of consumer computing power, designed to cater to enthusiasts, gamers, and professionals who demand unparalleled performance. With its advanced architecture and cutting-edge technology, the Core i9 is engineered to handle the most demanding tasks with ease.\r\n\r\nFeaturing multiple cores and threads, the Core i9 excels in multitasking and parallel processing. Whether you&#039;re rendering high-resolution videos, running complex simulations, or engaging in intensive gaming, this processor delivers exceptional speed and efficiency. The higher core count and thread support ensure that the Core i9 can manage multiple applications simultaneously without a hitch, making it ideal for tasks that require substantial computational power.\r\n\r\nThe Core i9 is built on Intel&#039;s latest microarchitecture, offering improved performance per watt and enhanced thermal management. This means not only faster processing but also better energy efficiency and thermal control, which contributes to a more stable and quieter computing experience.\r\n\r\nWith support for the latest DDR5 memory and PCIe 5.0 technology, the Core i9 enhances overall system responsiveness and future-proofs your setup against emerging technologies. The combination of high clock speeds and innovative thermal designs ensures that the processor can sustain peak performance even under heavy workloads.\r\n\r\nIn gaming, the Core i9’s high clock speeds and multiple cores translate to smooth, lag-free gameplay and rapid response times, providing a competitive edge. For content creators and professionals, its robust processing capabilities accelerate rendering times and streamline complex workflows.\r\n\r\nIn summary, the Intel Core i9 represents the zenith of Intel&#039;s consumer processor offerings. It is a powerhouse that delivers top-tier performance, cutting-edge features, and robust reliability for those who seek the best in computing technology.', 1, 3, '2024-08-01 12:20:13', '', 'uploads/66ab615dd76ca2.25916079.jpeg'),
(15, 'Bitcoin', 'Bitcoin is a pioneering digital currency that has fundamentally transformed the landscape of finance and technology since its inception. Created in 2009 by an anonymous individual or group known as Satoshi Nakamoto, Bitcoin introduced the concept of decentralized digital money, operating on a technology called blockchain.\r\n\r\nAt its core, Bitcoin is a decentralized peer-to-peer network that allows users to exchange value directly without the need for intermediaries like banks. This is made possible through blockchain technology, a public ledger that records all Bitcoin transactions transparently and securely. Each transaction is verified by a network of nodes, ensuring that the system remains tamper-proof and resistant to fraud.\r\n\r\nOne of Bitcoin’s most notable features is its limited supply. The total number of bitcoins is capped at 21 million, a design choice meant to mimic the scarcity of precious metals like gold and to prevent inflation. This fixed supply is achieved through a process known as &quot;mining,&quot; where powerful computers solve complex mathematical problems to validate transactions and add them to the blockchain. Miners are rewarded with newly created bitcoins and transaction fees.\r\n\r\nBitcoin’s decentralized nature provides several advantages, including resistance to censorship and the potential for financial inclusion. Users can transact with anyone in the world without relying on traditional banking systems, which is particularly valuable in regions with limited access to financial services.\r\n\r\nDespite its revolutionary potential, Bitcoin is not without challenges. Its volatility can lead to significant price fluctuations, making it a speculative asset. Additionally, concerns about its environmental impact due to the energy-intensive mining process and its use in illicit activities have sparked debate.\r\n\r\nOver the years, Bitcoin has gained widespread acceptance as both a store of value and a medium of exchange. It has inspired a broad ecosystem of cryptocurrencies and blockchain applications, influencing everything from finance to supply chain management.\r\n\r\nIn summary, Bitcoin stands as a groundbreaking innovation in digital finance, offering a decentralized, secure, and scarce form of money. Its impact extends beyond its monetary value, shaping the future of technology and finance in profound ways.\r\n', 2, 3, '2024-08-01 12:21:55', '', 'uploads/66ab61c380aea4.51916276.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_name` varchar(256) NOT NULL,
  `setting_value` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_name`, `setting_value`) VALUES
('home_light_nav_bar_desc', 'Welcome to Best Online Blogging Website'),
('home_light_nav_bar_title', 'My Full Stack Website');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`author_id`),
  ADD UNIQUE KEY `author_email` (`author_email`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
