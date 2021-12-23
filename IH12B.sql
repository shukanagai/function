-- 1
SELECT id AS "学生ID" , name AS "氏名" , grade AS "学年"
FROM m_student 
WHERE grade = "1"
ORDER BY ASC
;

-- 2
SELECT id AS "学生ID" , name AS "名前" , grade AS "学年"
FROM m_student
WHERE name LIKE "Naka%" AND grade IN(3 , 4)
ORDER BY ASC
;


-- 3
SELECT id AS "学生ID" , name AS "氏名" , address AS "都道府県" , grade AS "学年"
FROM m_student
WHERE address LIKE "%oosakafu%" AND birthday LIKE "1996%"
ORDER BY grade DESC
;


-- 4
SELECT bloodtype AS "血液型" , COUNT(bloodtype) AS "人数"
FROM m_student
GROUP BY bloodtype
ORDER BY bloodtype ASC
;


-- 5
SELECT grade AS "学年" , gender AS "性別" , bloodtype AS "血液型" , COUNT(*) AS "人数"
FROM m_student
GROUP BY grade , gender , bloodtype
ORDER BY grade ASC , gender DESC  , bloodtype ASC
;


-- 6
SELECT m.bloodtype AS "血液型" , t.subject_id AS "科目記号" , AVG(t.point) AS "平均点数"
FROM m_student m INNER JOIN t_point t
ON m.id = t.student_id
WHERE m.gender LIKE "%F%"
GROUP BY m.bloodtype , t.subject_id
HAVING AVG(t.point) >= 40
ORDER BY AVG(t.point) DESC
;


-- 7
SELECT m.id AS "学生ID" , m.name AS "氏名"
FROM m_student m INNER JOIN t_point t
ON m.id = t.student_id
GROUP BY m.id
HAVING COUNT(m.id) <3
ORDER BY m.id ASC
;


-- 8
SELECT
FROM m_student m INNER JOIN t_point t
ON m.id = t.student_id
INNER JOIN m_subject
ON m