CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Dummy data for tabell `posts`
INSERT INTO `posts` (`id`, `title`, `content`, `user_id`, `created_date`) VALUES
(68, '1st Post', 'This is my first post', 1, '2023-05-06 23:50:43'),
(69, '2nd Post', 'This is my second post', 1, '2023-05-06 23:51:19'),
(70, '3rd Post', 'This is my third post', 1, '2023-05-06 23:51:51');

-- Indexes for table `posts`
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

-- AUTO_INCREMENT for table `posts`
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
COMMIT;
