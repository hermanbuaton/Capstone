CREATE TABLE class (
	class_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    course_id INT(11),
    class_code VARCHAR(40),
    sem_id INT(11)
);

CREATE TABLE course (
	course_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    sch_id INT(11),
    course_code VARCHAR(40),
    course_name VARCHAR(255)
);

CREATE TABLE semester (
	sem_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    sch_id INT(11),
    sem_code VARCHAR(40),
    sem_name VARCHAR(255),
    sem_start DATETIME,
    sem_week INT(6)
);

CREATE TABLE school (
	sch_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    sch_code VARCHAR(40),
    sch_name VARCHAR(255),
    sch_region VARCHAR(255)
);

CREATE TABLE thread (
	t_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    class_id INT(11),
    lect_id INT(11)
);

CREATE TABLE message (
	m_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    t_id INT(11),
    m_type VARCHAR(3),
    u_id INT(11),
    u_show TINYINT,
    m_time DATETIME,
    m_head TEXT,
    m_body TEXT
);

CREATE TABLE vote (
	v_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    m_id INT(11),
    u_id INT(11),
    v_time DATETIME,
    vote TINYINT
);

CREATE TABLE poll_opt (
	opt_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    m_id INT(11),
    opt_txt TEXT
);

CREATE TABLE poll_vote (
	p_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    u_id INT(11),
    u_show TINYINT,
    p_time DATETIME,
    opt_id INT(11)
);

CREATE TABLE lecture (
	lect_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    class_id INT(11),
    lect_owner INT(11),
    lect_name INT(11),
    lect_start DATETIME,
    lect_end DATETIME
);

CREATE TABLE user_log (
	log_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    u_id INT(11),
    u_name VARCHAR(40),
    u_nick VARCHAR(40),
    class_id INT(11),
    signin_time DATETIME,
    signout_time DATETIME
);

CREATE TABLE user (
	u_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    u_name VARCHAR(40),
    u_nick VARCHAR(40),
    u_type INT(3),
    u_pass VARCHAR(40),
    sch_id INT(11)
);

CREATE TABLE class_user (
	id INT(11) AUTO_INCREMENT PRIMARY KEY,
    class_id INT(11),
    u_id INT(11),
    role INT(3)
);