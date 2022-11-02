-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 15, 2020 at 01:17 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dwozny2_mountains`
--

-- --------------------------------------------------------

--
-- Table structure for table `dyl_mountains`
--

CREATE TABLE `dyl_mountains` (
  `title` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL,
  `province` varchar(20) NOT NULL,
  `mtn_image` varchar(100) NOT NULL,
  `vertical_relief` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `first_summit` varchar(50) NOT NULL,
  `is_volcano` tinyint(1) NOT NULL,
  `access` varchar(15) NOT NULL,
  `google_img` varchar(75) NOT NULL,
  `mtn_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dyl_mountains`
--

INSERT INTO `dyl_mountains` (`title`, `description`, `province`, `mtn_image`, `vertical_relief`, `height`, `first_summit`, `is_volcano`, `access`, `google_img`, `mtn_id`) VALUES
('Mt Garbaldi ', 'A large strato volcanoe located close to vancouver. Garbaldi lake sits at its foot, with cold clear blue waters', 'bc', 'garbaldi-thumb.jpg', 1450, 2678, 'by me', 1, 'hike', 'garbaldii-g.JPG', 2),
('Mount Robson', ' talllest mountian in the canadian rockiers. The vertical relief of this mountain makes it massive in person. A famous hiking trail wraps around to the back with a beautiful view of a lake and glaciers.', 'bc', 'robson-thumb.jpg', 3100, 3953, 'July 31, 1913 by William W. Foster', 0, 'vehicle', 'mt-robson-g.JPG', 3),
('Cascade Mountain', 'the famous mountain that looms over Banf townsite', 'ab', 'cascade-thumb.jpg', 1510, 2998, '	1887 by Tom Wilson', 0, 'vehicle', 'cascade-g.JPG', 5),
('Mount Rundle', 'Another famous mountain of Banff National Park. Located towards the south of the Banff townsite. A large forest covers the mountains backside.', 'ab', 'rundle-thumb.jpg', 1600, 2948, '1888 by J.J. McArthur', 0, 'vehicle', 'rundle-g.JPG', 7),
('mount Thor', 'located in Auyuittuq National Park, on Baffin Island, Nunavut, Canada. This old mountain\'s claim to fame is its sheer vertical face, which is the one of the highest vertical drops in the world !', 'nuv', 'thor-thumb.jpg', 1450, 1675, 'Morton and Spitzer, 1965', 0, 'helicopter', 'thor-g.JPG', 8),
('Mount Meager', 'This mountain is actual a massif, a group of peaks. It is also a volcano. This volcano also created the largest eruption in Canada 10,000 years ago.', 'bc', 'Meager-thumb.jpg', 2200, 2680, 'unknown', 1, 'hike', 'Meager-g.JPG', 9),
('Mount Logan', 'Mount Logan is the highest mountain in Canada. The exact height of mount logan was not known until 1992 ! Ice caps that lay on mount logan can reach 300 meters.', 'yk', 'logan-thumb.jpg', 4500, 5250, '1925 by A.H. MacCarthy e', 0, 'helicopter', 'logan-g.JPG', 22),
('Mount Assiniboine', 'Mount Assiniboine is the highest peak in the continental ranges of the Canadian Rockies. This mountain is often compared to the Matterhorn of the alps because of its triangular horn shape.', 'ab', 'Assiniboine-thumb.jpg', 2086, 3676, '1901 by James Outram', 0, 'hike', 'Assiniboine-g.JPG', 23),
('Mount Goodsir', 'Located in Yoho national park, Mount Goodsir is one of the most imposing mountains in the Canadian Rockies. It consists of  two mountain peaks. ', 'bc', 'goodsir-thumb.jpg', 3567, 1887, '1903 Charles E. Fay and Herschel C. Parker', 0, 'hike', 'goodsir-g.JPG', 24),
('Mount Temple', 'The most prominent peak in Banff National park. This mountain can be hiked up, but not easily. The hike is a treacherous scramble.', 'ab', 'Temple-thumb.jpg', 1544, 3456, '1894 by Walter Wilcox', 0, 'hike', 'temple-g.JPG', 25),
('Lotus Flower Tower', 'This remote mountains sheer rock wall is a popular climbing destination for pros', 'nw', 'lotus-thumb.jpg', 1100, 2570, 'uly 16, 1960, William J. Buckingham and party', 0, 'helicopter', 'lotus-g.JPG', 26),
('Pyramid Mountain', 'Pyramid Mountain is a subglacial mound located on the Murtle Plateau in Wells Gray Provincial Park.Pyramid Mountain erupted about 12,000 years ago.', 'bc', 'Pyramid-thumb.jpg', 227, 1094, 'unknown', 1, 'hike', 'pyramid-g.JPG', 27),
('Stawamus Chief', 'A granite dome mountain that sits very close to Squamish BC. Beware the traffic on this mountain! It can get quite busy in the summer.', 'bc', 'chief-thumb.jpg', 417, 702, 'Prehistoric', 0, 'vehicle', 'chief-g.JPG', 28),
('Mount Raoul Blanchard', 'The highest peak in Quebec, this mountain is named after the famous geographer Raoul Blanchard.', 'qc', 'Raoul-thumb.jpg', 600, 1166, 'Prehistoric', 0, 'hike', 'raoul-g.JPG', 29),
('North Twin Peak', 'A sister peak of south twin peak, this mountain intense mountain. The north face drops nearly 1,500 meters! that\\\'s 1.5X higher than El Capitan in Yosemite national park', 'ab', 'twin-thumb.jpg', 1500, 3731, '1923 by W.S. Ladd, J. Monroe Thorington', 0, 'helicopter', 'twin-g.JPG', 30);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dyl_mountains`
--
ALTER TABLE `dyl_mountains`
  ADD PRIMARY KEY (`mtn_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dyl_mountains`
--
ALTER TABLE `dyl_mountains`
  MODIFY `mtn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
