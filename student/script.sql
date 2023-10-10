

-- Use the database
USE bright_boost;

-- Table for student information
CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    -- Add other student information fields as needed
    UNIQUE (username),
    UNIQUE (email)
);

-- Table for tutors and their expertise
CREATE TABLE tutors (
    tutor_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    expertise_subject VARCHAR(100) NOT NULL,
    -- Add other tutor information fields as needed
);

-- Table for timetable
CREATE TABLE timetable (
    session_id INT AUTO_INCREMENT PRIMARY KEY,
    session_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    tutor_id INT NOT NULL,
    subject VARCHAR(100) NOT NULL,
    -- Add other session details as needed
    FOREIGN KEY (tutor_id) REFERENCES tutors(tutor_id)
);

-- Table for session queue
CREATE TABLE session_queue (
    queue_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    session_id INT NOT NULL,
    timestamp DATETIME NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (session_id) REFERENCES timetable(session_id)
);

-- Table for student questions
CREATE TABLE questions (
    question_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    question_text TEXT NOT NULL,
    timestamp DATETIME NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- Table for student statistics
CREATE TABLE statistics (
    statistic_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    session_id INT NOT NULL,
    questions_asked INT NOT NULL,
    attendance_status ENUM('Present', 'Absent') NOT NULL,
    -- Add other statistic details as needed
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (session_id) REFERENCES timetable(session_id)
);

-- Table for learning materials
CREATE TABLE learning_materials (
    material_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    file_path VARCHAR(255) NOT NULL,
    -- Add other material details as needed
);
