drop function geConsultStatus;
DELIMITER ;;
CREATE DEFINER=`root`@`%` FUNCTION `geConsultStatus`(_id int) RETURNS int
BEGIN
declare value INT default 0;
select  (case when id is null then 0 else 1 end) as status_consult into value from doctor_consult where patient_id=_id ;
RETURN value;
END ;;
DELIMITER ;

drop function geRehabDataStatus; 
DELIMITER ;;
CREATE DEFINER=`root`@`%` FUNCTION `geRehabDataStatus`(_id int,_branch_id int) RETURNS int
BEGIN
declare value INT default 0;
select  (case when id is null then 0 else 1 end) as status_rehab into value from com_1_dep_16 where patient_id=_id AND branch_id=_branch_id ;
RETURN value;
END ;;
DELIMITER ;

drop function getAgeGender;
DELIMITER ;;
CREATE DEFINER=`root`@`%` FUNCTION `getAgeGender`(_id int) RETURNS varchar(255) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
BEGIN
declare value varchar(255);
select group_concat(TIMESTAMPDIFF(YEAR, birth_date, CURDATE()),' / ',case when gender =1 then 'Male' else 'Female' end) into value from com_2_patient where id = _id;

RETURN value;
END ;;
DELIMITER ;

drop function getAgeGenderOfCom1Patient;
DELIMITER ;;
CREATE DEFINER=`root`@`%` FUNCTION `getAgeGenderOfCom1Patient`(_id int) RETURNS varchar(255) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
BEGIN
declare value varchar(255);
select group_concat(TIMESTAMPDIFF(YEAR, birth_date, CURDATE()),' / ',case when gender =1 then 'Male' else 'Female' end) into value from com_1_patient where id = _id;

RETURN value;
END ;;
DELIMITER ;

drop function getBedRate;
DELIMITER ;;
CREATE DEFINER=`root`@`%` FUNCTION `getBedRate`(_date date,_patient_id int) RETURNS text CHARSET utf8mb4 COLLATE utf8mb4_general_ci
BEGIN
declare bid int default 0;
declare rateInfo text default null;
select bed_id into bid from com_1_bed_history where (date(inTime) = _date or date(inTime) < _date) and patient_id=_patient_id order by id desc limit 1;
if bid =0 then
select bed_id into bid from com_1_bed_history where (date(inTime) = _date or date(inTime) > _date) and patient_id=_patient_id order by id asc limit 1;
end if;

select (select group_concat(rate,"|",service_id,"|",service_description) from service_master where service_id=b.bed_type)  into rateInfo
from com_1_bed b where b.id=bid;
return rateInfo;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`%` FUNCTION `getConsultDate`(_id int) RETURNS datetime
BEGIN
declare value datetime;
select transaction_date into value from doctor_consult where patient_id=_id order by id asc limit 1 ;
RETURN value;
END ;;
DELIMITER ;

drop function getLabParaValues;
DELIMITER ;;
CREATE DEFINER=`root`@`%` FUNCTION `getLabParaValues`(_patient_id int(11)) RETURNS text CHARSET utf8mb4
BEGIN
declare lab_details text;
select group_concat(lt.para_name,'||',(select 
(case when esd.result REGEXP '^[0-9]+\\.?[0-9]*$' > 0 then 
case when (cast(esd.result as double ) >= cast(lt.min_range as double) and 
cast(esd.result as double ) <= cast(lt.max_range as double)) then 0 else 1 end else -1 end )
 from excel_structure_data esd where esd.patient_id collate 
utf8mb4_general_ci=_patient_id AND
 esd.ParameterId collate 
utf8mb4_general_ci =lt.para_id group by lt.para_id order by esd.id desc),'||',
 (select esd.result from excel_structure_data esd where esd.patient_id collate 
utf8mb4_general_ci =_patient_id AND esd.ParameterId collate 
utf8mb4_general_ci =lt.para_id group by lt.para_id order by esd.id desc) SEPARATOR '@@')
 into lab_details from labparameter_table lt;
RETURN lab_details;
END ;;
DELIMITER ;

drop function getPatientMedicine;
DELIMITER ;;
CREATE DEFINER=`root`@`%` FUNCTION `getPatientMedicine`(_medicine_table varchar(255),_branch_id int,_patient_id int) RETURNS text CHARSET utf8mb4 COLLATE utf8mb4_general_ci
BEGIN
declare medicine_details text;
select 
group_concat( pm.name,pm.total_iteration,
(case when curdate() between date(pm.start_date) and date(pm.end_date) then 1 else 0 end),
(case when datediff(pm.end_date,pm.start_date) =0 then 1 else datediff(pm.end_date,pm.start_date) end),
(select mm.name from medicine_master mm where mm.id=pm.name)) into medicine_details
 from _medicine_table pm
 where pm.p_id=_patient_id and branch_id=_branch_id and status=1  order by id desc;
RETURN medicine_details;
END ;;
DELIMITER ;

drop function getReferance;
DELIMITER ;;
CREATE DEFINER=`root`@`%` FUNCTION `getReferance`(_referance text) RETURNS text CHARSET utf8mb4 COLLATE utf8mb4_general_ci
BEGIN
declare referance text;
select concat(SUBSTRING(_referance, 1, 25),'...') into referance;
RETURN referance;
END ;;
DELIMITER ;

drop function getRoomName;
DELIMITER ;;
CREATE DEFINER=`root`@`%` FUNCTION `getRoomName`( room_id int) RETURNS varchar(255) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
BEGIN
declare roomName varchar(255) default '';
select group_concat(hb.room_no,'-',hb.ward_no) into roomName from com_1_room hb where hb.id=room_id;
RETURN roomName;
END ;;
DELIMITER ;

drop function getUnits;
DELIMITER ;;
CREATE DEFINER=`root`@`%` FUNCTION `getUnits`(_unit text) RETURNS text CHARSET utf8mb4 COLLATE utf8mb4_general_ci
BEGIN
declare unit text;
select group_concat(name) into unit from lab_unit_master um where find_in_set(um.id,_unit);
RETURN unit;
END ;;
DELIMITER ;

drop function strSplit;
DELIMITER ;;
CREATE DEFINER=`root`@`%` FUNCTION `strSplit`(x VARCHAR(65000), delim VARCHAR(12), pos INTEGER) RETURNS varchar(255) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
BEGIN
  DECLARE output VARCHAR(255) default null;
  SET output = REPLACE(SUBSTRING(SUBSTRING_INDEX(x, delim, pos)
                 , LENGTH(SUBSTRING_INDEX(x, delim, pos - 1)) + 1)
                 , delim
                 , '');
  RETURN output;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `getAllDate`(in _pId int)
BEGIN

DECLARE i INTEGER;

DROP TEMPORARY TABLE IF EXISTS `unionTable`;
CREATE TEMPORARY TABLE `unionTable` (
`splitted_column` varchar(45) NOT NULL
) ;
call getDateRange(_pId,@dateString);

  SET i = 1;
  REPEAT
    INSERT INTO unionTable (splitted_column)
      SELECT strSplit(@dateString, ',', i) IS NOT NULL;
    SET i = i + 1;
    UNTIL ROW_COUNT() = 0
  END REPEAT;

END ;;
DELIMITER ;

drop function getDateRange;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `getDateRange`(in _pID int,out _outPut text)
BEGIN
DECLARE str  text default "";
DECLARE _startDate  VARCHAR(255);
DECLARE _endDate  VARCHAR(255);

DECLARE _startDateCopy  VARCHAR(255);

select admission_date,discharge_date into _startDate,_endDate from com_1_patient where id = _pID;

set _startDateCopy = _startDate;

if _endDate is null then 
set _endDate = now();
end if;

	loop_label:  LOOP
		
        IF date(_startDate) >=date(_endDate) THEN 
			SET  str = CONCAT(str,',',_startDate);		
            if hour(_endDate) > 12 then
				SET _startDate = date_add(_startDate,interval 1 day);
                SET  str = CONCAT(str,',',_startDate);		
            end if;
            
            if hour(_endDate) = 12 and minute(_endDate) > 0 then
				SET _startDate = date_add(_startDate,interval 1 day);
                SET  str = CONCAT(str,',',_startDate);		
            end if;
			LEAVE  loop_label;
		END  IF;
        
        if hour(_startDate) < 12 and _startDateCopy = _startDate then
			SET  str = CONCAT(str,_startDate);			            
            set _startDate = date_format(_startDate,'%Y-%m-%d 12:00:00');
			SET _startDate = date_add(_startDate,interval 1 day);
			ITERATE  loop_label;	
		end if;       
        
        if hour(_startDate) > 12 and _startDateCopy = _startDate then			
            set _startDate = date_format(_startDate,'%Y-%m-%d 12:00:00');            
			SET _startDate = date_add(_startDate,interval 1 day);
            SET  str = CONCAT(str,_startDate);		 
            SET _startDate = date_add(_startDate,interval 1 day);
			ITERATE  loop_label;	
		end if;       			      
        
        if hour(_startDate) = 12 and minute(_startDate) >= 0 and _startDateCopy = _startDate then			
            set _startDate = date_format(_startDate,'%Y-%m-%d 12:00:00');            
			SET _startDate = date_add(_startDate,interval 1 day);
            SET  str = CONCAT(str,_startDate);		 
            SET _startDate = date_add(_startDate,interval 1 day);
			ITERATE  loop_label;	
		end if;  
        
		SET  str = CONCAT(str,',',_startDate);		
        SET _startDate = date_add(_startDate,interval 1 day);
        ITERATE  loop_label;
	END LOOP;
-- SELECT str as dateRange;
set _outPut = str;
END ;;
DELIMITER ;

drop function getdateTableDateRange;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `getdateTableDateRange`(in _pID int)
BEGIN
DECLARE str  text default "";
DECLARE _startDate  VARCHAR(255);
DECLARE _endDate  VARCHAR(255);

DECLARE _startDateCopy  VARCHAR(255);

select admission_date,discharge_date into _startDate,_endDate from com_1_patient where id = _pID;

set _startDateCopy = _startDate;

if _endDate is null then 
set _endDate = now();
end if;

DROP TEMPORARY TABLE IF EXISTS dateTable;
CREATE TEMPORARY TABLE dateTable (
`date` varchar(45) NOT NULL,
`bedType` varchar(45) null,
`type` varchar(255) null,
`bed_final_type` varchar(255) null
) ;

	loop_label:  LOOP
		
        IF date(_startDate) >=date(_endDate) THEN 
			SET  str = CONCAT(str,',',date_format(_startDate,'%Y-%m-%d 12:00:00'));
            insert into dateTable (date,type) value (date_format(_startDate,'%Y-%m-%d 12:00:00'),'A');
            if hour(_endDate) > 12 and date(_startDate) = date(_endDate) then				
				 SET _startDate = date_add(_startDate,interval 1 day);
                 SET  str = CONCAT(str,',',_startDate);		
                insert into dateTable (date,type) value (date_format(_startDate,'%Y-%m-%d 12:00:00'),'A');
           end if;
            
            if hour(_endDate) = 12 and minute(_endDate) > 0 and date(_startDate) = date(_endDate) then				
			     SET _startDate = date_add(_startDate,interval 1 day);
                 SET  str = CONCAT(str,',',_startDate);		
                 insert into dateTable (date,type) value (date_format(_startDate,'%Y-%m-%d 12:00:00'),'A');
            end if;
			LEAVE  loop_label;
		END  IF;
        
        if hour(_startDate) < 12 and _startDateCopy = _startDate then
			SET  str = CONCAT(str,_startDate);		
			insert into dateTable (date,type) value (date_format(_startDate,'%Y-%m-%d 12:00:00'),'A');
            set _startDate = date_format(_startDate,'%Y-%m-%d 12:00:00');
			SET _startDate = date_add(_startDate,interval 1 day);
           
			ITERATE  loop_label;	
		end if;       
        
        if hour(_startDate) > 12 and _startDateCopy = _startDate then			
            set _startDate = date_format(_startDate,'%Y-%m-%d 12:00:00');            
			SET _startDate = date_add(_startDate,interval 1 day);
            SET  str = CONCAT(str,_startDate);		 
            insert into dateTable (date,type) value (_startDate,'A');
            SET _startDate = date_add(_startDate,interval 1 day);
			ITERATE  loop_label;	
		end if;       			      
        
        if hour(_startDate) = 12 and minute(_startDate) >= 0 and _startDateCopy = _startDate then			
            set _startDate = date_format(_startDate,'%Y-%m-%d 12:00:00');            
			SET _startDate = date_add(_startDate,interval 1 day);
            SET  str = CONCAT(str,_startDate);		 
            insert into dateTable (date,type) value (_startDate,'A');
            SET _startDate = date_add(_startDate,interval 1 day);
			ITERATE  loop_label;	
		end if;  
        
		SET  str = CONCAT(str,',',_startDate);		
        insert into dateTable (date,type) value (_startDate,'A');
        SET _startDate = date_add(_startDate,interval 1 day);
        ITERATE  loop_label;
	END LOOP;

insert into dateTable (date ,bedType,type)  (select inTime,(select (select group_concat(rate,"|",service_id,"|",service_description) from service_master where service_id=b.bed_type) from com_1_bed b where b.id=h.bed_id),'B' from com_1_bed_history h where patient_id = _pID);    

SELECT * from dateTable order by date asc;


END ;;
DELIMITER ;


drop function getdateTableDateRange1;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `getdateTableDateRange1`(in _pID int)
BEGIN
DECLARE str  text default "";
DECLARE _startDate  VARCHAR(255);
DECLARE _endDate  VARCHAR(255);

DECLARE _startDateCopy  VARCHAR(255);

select admission_date,discharge_date into _startDate,_endDate from com_1_patient where id = _pID;

set _startDateCopy = _startDate;

if _endDate is null then 
set _endDate = now();
end if;

DROP TEMPORARY TABLE IF EXISTS dateTable;
CREATE TEMPORARY TABLE dateTable (
`date` varchar(45) NOT NULL,
`bedType` varchar(45) null,
`type` varchar(255) null,
`bed_final_type` varchar(255) null
) ;

	loop_label:  LOOP
		
        IF date(_startDate) >=date(_endDate) THEN 
			SET  str = CONCAT(str,',',date_format(_startDate,'%Y-%m-%d 12:00:00'));
            insert into dateTable (date,type) value (date_format(_startDate,'%Y-%m-%d 12:00:00'),'A');
            if hour(_endDate) > 12 then
				SET _startDate = date_add(_startDate,interval 1 day);
                SET  str = CONCAT(str,',',_startDate);		
                insert into dateTable (date,type) value (date_format(_startDate,'%Y-%m-%d 12:00:00'),'A');
            end if;
            
            if hour(_endDate) = 12 and minute(_endDate) > 0 then
				SET _startDate = date_add(_startDate,interval 1 day);
                SET  str = CONCAT(str,',',_startDate);		
                insert into dateTable (date,type) value (date_format(_startDate,'%Y-%m-%d 12:00:00'),'A');
            end if;
			LEAVE  loop_label;
		END  IF;
        
        if hour(_startDate) < 12 and _startDateCopy = _startDate then
			SET  str = CONCAT(str,_startDate);		
			insert into dateTable (date,type) value (date_format(_startDate,'%Y-%m-%d 12:00:00'),'A');
            set _startDate = date_format(_startDate,'%Y-%m-%d 12:00:00');
			SET _startDate = date_add(_startDate,interval 1 day);
           
			ITERATE  loop_label;	
		end if;       
        
        if hour(_startDate) > 12 and _startDateCopy = _startDate then			
            set _startDate = date_format(_startDate,'%Y-%m-%d 12:00:00');            
			SET _startDate = date_add(_startDate,interval 1 day);
            SET  str = CONCAT(str,_startDate);		 
            insert into dateTable (date,type) value (_startDate,'A');
            SET _startDate = date_add(_startDate,interval 1 day);
			ITERATE  loop_label;	
		end if;       			      
        
        if hour(_startDate) = 12 and minute(_startDate) >= 0 and _startDateCopy = _startDate then			
            set _startDate = date_format(_startDate,'%Y-%m-%d 12:00:00');            
			SET _startDate = date_add(_startDate,interval 1 day);
            SET  str = CONCAT(str,_startDate);		 
            insert into dateTable (date,type) value (_startDate,'A');
            SET _startDate = date_add(_startDate,interval 1 day);
			ITERATE  loop_label;	
		end if;  
        
		SET  str = CONCAT(str,',',_startDate);		
        insert into dateTable (date,type) value (_startDate,'A');
        SET _startDate = date_add(_startDate,interval 1 day);
        ITERATE  loop_label;
	END LOOP;

insert into dateTable (date ,bedType,type)  (select inTime,(select (select group_concat(rate,"|",service_id,"|",service_description) from service_master where service_id=b.bed_type) from com_1_bed b where b.id=h.bed_id),'B' from com_1_bed_history h where patient_id = _pID);    

SELECT * from dateTable order by date asc;


END ;;
DELIMITER ;


drop function getDateTableDateRangeFunction;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `getDateTableDateRangeFunction`(in _pID int,in _table text,in _bID int)
BEGIN
DECLARE str  text default "";
DECLARE _startDate  VARCHAR(255);
DECLARE _endDate  VARCHAR(255);

DECLARE _startDateCopy  VARCHAR(255);

 SET @sql = CONCAT('SELECT admission_date,discharge_date into ',_startDate,',',_endDate,' FROM ',_table,' where id =',_pID,''); 
    PREPARE stmt from @sql;
    EXECUTE stmt;
   DEALLOCATE PREPARE stmt;
set _startDateCopy = _startDate;

if _endDate is null then 
set _endDate = now();
end if;

DROP TEMPORARY TABLE IF EXISTS dateTable;
CREATE TEMPORARY TABLE dateTable (
`date` varchar(45) NOT NULL,
`bedType` varchar(45) null,
`type` varchar(255) null,
`bed_final_type` varchar(255) null
) ;

	loop_label:  LOOP
		
        IF date(_startDate) >=date(_endDate) THEN 
			SET  str = CONCAT(str,',',date_format(_startDate,'%Y-%m-%d 12:00:00'));
            insert into dateTable (date,type) value (date_format(_startDate,'%Y-%m-%d 12:00:00'),'A');
            if hour(_endDate) > 12 then
				SET _startDate = date_add(_startDate,interval 1 day);
                SET  str = CONCAT(str,',',_startDate);		
                insert into dateTable (date,type) value (date_format(_startDate,'%Y-%m-%d 12:00:00'),'A');
            end if;
            
            if hour(_endDate) = 12 and minute(_endDate) > 0 then
				SET _startDate = date_add(_startDate,interval 1 day);
                SET  str = CONCAT(str,',',_startDate);		
                insert into dateTable (date,type) value (date_format(_startDate,'%Y-%m-%d 12:00:00'),'A');
            end if;
			LEAVE  loop_label;
		END  IF;
        
        if hour(_startDate) < 12 and _startDateCopy = _startDate then
			SET  str = CONCAT(str,_startDate);		
			insert into dateTable (date,type) value (date_format(_startDate,'%Y-%m-%d 12:00:00'),'A');
            set _startDate = date_format(_startDate,'%Y-%m-%d 12:00:00');
			SET _startDate = date_add(_startDate,interval 1 day);
           
			ITERATE  loop_label;	
		end if;       
        
        if hour(_startDate) > 12 and _startDateCopy = _startDate then			
            set _startDate = date_format(_startDate,'%Y-%m-%d 12:00:00');            
			SET _startDate = date_add(_startDate,interval 1 day);
            SET  str = CONCAT(str,_startDate);		 
            insert into dateTable (date,type) value (_startDate,'A');
            SET _startDate = date_add(_startDate,interval 1 day);
			ITERATE  loop_label;	
		end if;       			      
        
        if hour(_startDate) = 12 and minute(_startDate) >= 0 and _startDateCopy = _startDate then			
            set _startDate = date_format(_startDate,'%Y-%m-%d 12:00:00');            
			SET _startDate = date_add(_startDate,interval 1 day);
            SET  str = CONCAT(str,_startDate);		 
            insert into dateTable (date,type) value (_startDate,'A');
            SET _startDate = date_add(_startDate,interval 1 day);
			ITERATE  loop_label;	
		end if;  
        
		SET  str = CONCAT(str,',',_startDate);		
        insert into dateTable (date,type) value (_startDate,'A');
        SET _startDate = date_add(_startDate,interval 1 day);
        ITERATE  loop_label;
	END LOOP;

insert into dateTable (date ,bedType,type)  (select inTime,(select (select group_concat(rate,"|",service_id,"|",service_description) from service_master where service_id=b.bed_type) from com_1_bed b where b.id=h.bed_id),'B' from com_1_bed_history h where patient_id = _pID and branch_id= _bID);    

SELECT * from dateTable order by date asc;


END ;;
DELIMITER ;

drop function getRange;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `getRange`(in _pID int)
BEGIN
DECLARE str  text default "";
DECLARE _startDate  VARCHAR(255);
DECLARE _endDate  VARCHAR(255);

DECLARE _startDateCopy  VARCHAR(255);

select admission_date,discharge_date into _startDate,_endDate from com_1_patient where id = _pID;

set _startDateCopy = _startDate;

if _endDate is null then 
set _endDate = now();
end if;

DROP TEMPORARY TABLE IF EXISTS dateTable;
CREATE TEMPORARY TABLE dateTable (
`date` varchar(45) NOT NULL,
`bedType` varchar(45) null,
`type` varchar(255) null,
`bed_final_type` varchar(255) null
) ;

	loop_label:  LOOP
		
        IF date(_startDate) >=date(_endDate) THEN 
			SET  str = CONCAT(str,',',date_format(_startDate,'%Y-%m-%d 12:00:00'));
            insert into dateTable (date,type) value (date_format(_startDate,'%Y-%m-%d 12:00:00'),'A');
            if hour(_endDate) > 12 and date(_startDate) = date(_endDate) then				
				 SET _startDate = date_add(_startDate,interval 1 day);
                 SET  str = CONCAT(str,',',_startDate);		
                insert into dateTable (date,type) value (date_format(_startDate,'%Y-%m-%d 12:00:00'),'A1');
           end if;
            
            if hour(_endDate) = 12 and minute(_endDate) > 0 and date(_startDate) = date(_endDate) then				
			     SET _startDate = date_add(_startDate,interval 1 day);
                 SET  str = CONCAT(str,',',_startDate);		
                 insert into dateTable (date,type) value (date_format(_startDate,'%Y-%m-%d 12:00:00'),'A2');
            end if;
			LEAVE  loop_label;
		END  IF;
        
        if hour(_startDate) < 12 and _startDateCopy = _startDate then
			SET  str = CONCAT(str,_startDate);		
			insert into dateTable (date,type) value (date_format(_startDate,'%Y-%m-%d 12:00:00'),'A3');
            set _startDate = date_format(_startDate,'%Y-%m-%d 12:00:00');
			SET _startDate = date_add(_startDate,interval 1 day);
           
			ITERATE  loop_label;	
		end if;       
        
        if hour(_startDate) > 12 and _startDateCopy = _startDate then			
            set _startDate = date_format(_startDate,'%Y-%m-%d 12:00:00');            
			SET _startDate = date_add(_startDate,interval 1 day);
            SET  str = CONCAT(str,_startDate);		 
            insert into dateTable (date,type) value (_startDate,'A4');
            SET _startDate = date_add(_startDate,interval 1 day);
			ITERATE  loop_label;	
		end if;       			      
        
        if hour(_startDate) = 12 and minute(_startDate) >= 0 and _startDateCopy = _startDate then			
            set _startDate = date_format(_startDate,'%Y-%m-%d 12:00:00');            
			SET _startDate = date_add(_startDate,interval 1 day);
            SET  str = CONCAT(str,_startDate);		 
            insert into dateTable (date,type) value (_startDate,'A5');
            SET _startDate = date_add(_startDate,interval 1 day);
			ITERATE  loop_label;	
		end if;  
        
		SET  str = CONCAT(str,',',_startDate);		
        insert into dateTable (date,type) value (_startDate,'A6');
        SET _startDate = date_add(_startDate,interval 1 day);
        ITERATE  loop_label;
	END LOOP;

insert into dateTable (date ,bedType,type)  (select inTime,(select (select group_concat(rate,"|",service_id,"|",service_description) from service_master where service_id=b.bed_type) from com_1_bed b where b.id=h.bed_id),'B' from com_1_bed_history h where patient_id = _pID);    

SELECT * from dateTable order by date asc;


END ;;
DELIMITER ;