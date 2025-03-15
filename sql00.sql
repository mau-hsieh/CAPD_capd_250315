CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE responses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL, -- 對應的使用者ID
    session_id INT NOT NULL, -- 對應答題的場次ID
    question_number INT NOT NULL, -- 問題的編號
    is_correct BOOLEAN NOT NULL, -- 作答是否正確 (1 表示正確, 0 表示錯誤)
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- 建立 questions 資料表，存儲問題和正確答案
CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_text TEXT NOT NULL, -- 問題的題目
    correct_answer TEXT -- 問題的正確答案
);

-- 建立 test_score 資料表，存儲使用者的答題記錄
CREATE TABLE test_score (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL, -- 對應的使用者ID
    session_id INT NOT NULL, -- 對應答題的場次ID
    question_id INT NOT NULL, -- 對應的問題ID (來自 questions 表)
    user_answer TEXT  , -- 使用者的答案
    is_correct BOOLEAN NOT NULL, -- 作答是否正確 (1 表示正確, 0 表示錯誤)
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (question_id) REFERENCES questions(id)
);

-- 建立 questions 資料表，存儲問題和正確答案
CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_text TEXT NOT NULL, -- 問題的題目
    correct_answer TEXT -- 問題的正確答案
);

-- 建立 test_score 資料表，存儲使用者的答題記錄
CREATE TABLE test_score (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL, -- 對應的使用者ID
    session_id INT NOT NULL, -- 對應答題的場次ID
    question_id INT NOT NULL, -- 對應的問題ID (來自 questions 表)
    user_answer TEXT  , -- 使用者的答案
    is_correct BOOLEAN NOT NULL, -- 作答是否正確 (1 表示正確, 0 表示錯誤)
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (question_id) REFERENCES questions(id)
);

-- 建立 questions 資料表，存儲問題和正確答案
CREATE TABLE question01 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_text TEXT NOT NULL, -- 問題的題目
    correct_answer TEXT -- 問題的正確答案
);

-- 建立 test_score 資料表，存儲使用者的答題記錄
CREATE TABLE score01 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL, -- 對應的使用者ID
    session_id INT NOT NULL, -- 對應答題的場次ID
    question_id INT NOT NULL, -- 對應的問題ID (來自 questions 表)
    user_answer TEXT  , -- 使用者的答案
    is_correct BOOLEAN NOT NULL, -- 作答是否正確 (1 表示正確, 0 表示錯誤)
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (question_id) REFERENCES questions(id)
);