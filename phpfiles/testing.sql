-- check if already cancelled
select is_cancelled from reservation where reservation_id = '';

-- getting cancel info difference of days
select timestampdiff(day, curdate(), departure_date) as time, Day(Departure_Date) as day, Monthname(Departure_Date) as month, Second_Class_Price, First_Class_Price, Reserves.Train_Number, Departs_From, Arrives_At, Class, TRUNCATE(Total_Cost, 2) AS TC, Number_Baggages, Passanger_Name FROM Reserves JOIN Reservation NATURAL JOIN Train_Route NATURAL JOIN Stop WHERE Reserves.Reservation_ID = Reservation.Reservation_ID AND Reserves.Reservation_ID ="12345" AND Reservation.Cust_User = "prav" AND Reserves.Train_Number = Train_Route.Train_Number;

update reserves set total_cost='' where reservation_id='' and train_number ='';

update reservation set is_cancelled='1' where reservation_id='';

-- gets the departing time for every stop
select departure_time, departs_from, reserves.train_number from Stop natural join Station join Reserves where Station.location = Reserves.departs_from



--------------------------------------------------------------------------------------------------------------

-- to get all stations, times, and prices
CREATE VIEW reservStation AS (SELECT Name, Stop.Train_Number, Arrival_Time, Departure_Time, First_Class_Price, Second_Class_Price 
from Stop JOIN Train_Route where Stop.Train_Number = Train_Route.Train_Number)

-- get all the info for the available trains for the user-selected stops
SELECT Arrival_Station.Train_Number, Departure_Station.Departure_Time, Arrival_Station.Arrival_Time, 
Arrival_Station.First_Class_Price, Arrival_Station.Second_Class_Price 
FROM reservStation Arrival_Station JOIN reservStation Departure_Station 
where Arrival_Station.Train_Number = Departure_Station.Train_Number and Arrival_Station.Name != Departure_Station.Name 
and Departure_Station.Name = "Train Crossing" and Arrival_Station.Name = "Burdell Cabin";

-- DATE("g:i A", strtotime("$row[Arrival_Time]"))


SELECT MONTHNAME(Departure_Date) AS Month, TRUNCATE(SUM(Total_Cost), 2) AS Revenue
			FROM (SELECT Total_Cost, Departure_Date FROM Reserves
				WHERE Departure_Date BETWEEN Date_Sub(DATE_FORMAT(NOW() ,'%Y-%m-01'), INTERVAL 2 MONTH) AND CURDATE()) AS a 
			GROUP BY MONTHNAME(Departure_Date)