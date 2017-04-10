CREATE TABLE class
(
	class_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    course_id INT(11),
    class_code VARCHAR(40),
    sem_id INT(11),
    own_id INT(11)
);

CREATE TABLE course
(
	course_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    sch_id INT(11),
    course_code VARCHAR(40),
    course_name VARCHAR(255)
);

CREATE TABLE semester
(
	sem_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    sch_id INT(11),
    sem_code VARCHAR(40),
    sem_name VARCHAR(255),
    sem_start DATETIME,
    sem_week INT(6)
);

CREATE TABLE school
(
	sch_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    sch_code VARCHAR(40),
    sch_name VARCHAR(255),
    sch_region VARCHAR(255)
);

CREATE TABLE thread
(
	t_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    class_id INT(11),
    lect_id INT(11)
);

CREATE TABLE message
(
	m_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    t_id INT(11),
    m_type VARCHAR(3),
    u_id INT(11),
    u_show TINYINT,
    m_time DATETIME,
    m_lastmod DATETIME,
    m_head TEXT,
    m_body TEXT
);

CREATE TABLE label
(
	l_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    m_id INT(11),
    label VARCHAR(255),
    l_type TINYINT,
    l_score FLOAT
);

CREATE TABLE vote
(
	v_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    m_id INT(11),
    u_id INT(11),
    v_time DATETIME,
    vote TINYINT
);

CREATE TABLE hand
(
	h_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    m_id INT(11),
    u_id INT(11),
    h_time DATETIME,
    hand TINYINT
);

CREATE TABLE poll_opt
(
	opt_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    m_id INT(11),
    opt_txt TEXT
);

CREATE TABLE poll_vote
(
	p_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    u_id INT(11),
    u_show TINYINT,
    p_time DATETIME,
    opt_id INT(11)
);

CREATE TABLE lecture
(
	lect_id INT(11) AUTO_INCREMENT PRIMARY KEY,
	lect_ref VARCHAR(11), 
    class_id INT(11),
    lect_name VARCHAR(255),
    lect_start DATETIME,
    lect_end DATETIME,
    set_anonymous TINYINT DEFAULT 0, 
    set_discussion TINYINT DEFAULT 0, 
    own_id INT(11)
);

CREATE TABLE user_log
(
	log_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    u_id INT(11),
    u_name VARCHAR(40),
    u_nick VARCHAR(40),
    class_id INT(11),   /* should be lect_id */
    signin_time DATETIME,
    signout_time DATETIME
);

CREATE TABLE user
(
	u_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    u_name VARCHAR(40),
    u_nick VARCHAR(255),
    u_type INT(3),
    u_pass VARCHAR(40),
    sch_id INT(11)
);

CREATE TABLE class_user
(
	id INT(11) AUTO_INCREMENT PRIMARY KEY,
    class_id INT(11),
    u_id INT(11),
    role INT(3)
);

CREATE TABLE rake_stop_ver
(
	ver_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    ver_date DATETIME
);

CREATE TABLE rake_stop_words
(
	stop_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    ver_id INT(11),
    word VARCHAR(255)
);