CREATE DATABASE IF NOT EXISTS evvemi_task;

use evvemi_task;
 
CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `sname` varchar(200) NOT NULL,
  `year` varchar(200) NOT NULL,
  `gpa` float(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

INSERT INTO `student` (`id`, `sid`, `sname`, `year`, `gpa`) VALUES
(1, 1, 'Vicky', 'sophomore', 3.5),
(2, 2, 'Saahil', 'graduate', 3.76),
(3, 3, 'Jenny', 'junior', 2.9),
(4, 4, 'George', 'senior', 3.2);

CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `cname` varchar(200) NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

INSERT INTO `course` (`id`, `sid`, `cname`) VALUES
(1, 1, 'Information Retrieval'),
(2, 2, 'Information Retrieval'),
(3, 1, 'Machine Learning'),
(4, 3, 'Analysis of Algorithms'),
(5, 4, 'Distributed Systems'),
(6, 1, 'Distributed Systems'),
(7, 2, 'Distributed Systems');

