DELIMITER $$

USE `newvista_db`$$

DROP PROCEDURE IF EXISTS `st_payment_history`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `st_payment_history`(IN frmdt DATE,IN todt DATE,IN classid INT,
    IN section INT,IN studentid INT,IN schoolid INT,IN acd_sesid INT)
BEGIN
   
	DELETE FROM temp_table_payment;
  IF studentid != 0 
  THEN
  INSERT INTO temp_table_payment(payment_master_id,classname,studentname,section,roll,payment_date,memono,amount) 
    
    SELECT 
	payment_master.payment_id,
	class_master.classname,
	student_master.name,
	section_master.section,
	academic_details.rollno,
	#payment_master.payment_date,
	DATE_FORMAT(payment_master.payment_date, '%d-%m-%Y'),
	payment_master.memono,
	payment_master.total_amount
	FROM payment_master
	INNER JOIN student_master
	ON student_master.student_id=payment_master.student_id
	INNER JOIN academic_details
	ON academic_details.student_id=payment_master.student_id
	INNER JOIN class_master
	ON class_master.id=academic_details.class_id
	INNER JOIN section_master
	ON section_master.id=academic_details.section_id
	WHERE payment_master.student_id=studentid;
ELSE IF classid != 0 AND section != 0
     THEN
  INSERT INTO temp_table_payment(payment_master_id,classname,studentname,section,roll,payment_date,memono,amount) 
    
    SELECT 
	payment_master.payment_id,
	class_master.classname,
	student_master.name,
	section_master.section,
	academic_details.rollno,
	#payment_master.payment_date,
	DATE_FORMAT(payment_master.payment_date, '%d-%m-%Y'),
	payment_master.memono,
	payment_master.total_amount
	FROM payment_master
	INNER JOIN student_master
	ON student_master.student_id=payment_master.student_id
	INNER JOIN academic_details
	ON academic_details.student_id=payment_master.student_id
	INNER JOIN class_master
	ON class_master.id=academic_details.class_id
	INNER JOIN section_master
	ON section_master.id=academic_details.section_id
	WHERE academic_details.class_id = classid
	AND academic_details.section_id = section;
ELSE IF classid != 0
     THEN
  INSERT INTO temp_table_payment(payment_master_id,classname,studentname,section,roll,payment_date,memono,amount) 
    
    SELECT 
	payment_master.payment_id,
	class_master.classname,
	student_master.name,
	section_master.section,
	academic_details.rollno,
	#payment_master.payment_date,
	DATE_FORMAT(payment_master.payment_date, '%d-%m-%Y'),
	payment_master.memono,
	payment_master.total_amount
	FROM payment_master
	INNER JOIN student_master
	ON student_master.student_id=payment_master.student_id
	INNER JOIN academic_details
	ON academic_details.student_id=payment_master.student_id
	INNER JOIN class_master
	ON class_master.id=academic_details.class_id
	INNER JOIN section_master
	ON section_master.id=academic_details.section_id
	WHERE academic_details.class_id = classid
	;
	
	
ELSE
	
	INSERT INTO temp_table_payment(payment_master_id,classname,studentname,section,roll,payment_date,memono,amount) 
    
        SELECT 
	payment_master.payment_id,
	class_master.classname,
	student_master.name,
	section_master.section,
	academic_details.rollno,
	#payment_master.payment_date,
	DATE_FORMAT(payment_master.payment_date, '%d-%m-%Y'),
	payment_master.memono,
	payment_master.total_amount
	FROM payment_master
	INNER JOIN student_master
	ON student_master.student_id=payment_master.student_id
	INNER JOIN academic_details
	ON academic_details.student_id=payment_master.student_id
	INNER JOIN class_master
	ON class_master.id=academic_details.class_id
	INNER JOIN section_master
	ON section_master.id=academic_details.section_id
	WHERE payment_master.payment_date BETWEEN frmdt AND todt;
	
	
    
        END IF;
        END IF;
        END IF;
    
  
    END$$

DELIMITER ;