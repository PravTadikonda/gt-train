-- check if already cancelled
select is_cancelled from reservation where reservation_id = '';

-- getting cancel info difference of days
select timestampdiff(day, curdate(), departure_date) as time, Day(Departure_Date) as day, Monthname(Departure_Date) as month, Second_Class_Price, First_Class_Price, Reserves.Train_Number, Departs_From, Arrives_At, Class, TRUNCATE(Total_Cost, 2) AS TC, Number_Baggages, Passanger_Name FROM Reserves JOIN Reservation NATURAL JOIN Train_Route NATURAL JOIN Stop WHERE Reserves.Reservation_ID = Reservation.Reservation_ID AND Reserves.Reservation_ID ="12345" AND Reservation.Cust_User = "prav" AND Reserves.Train_Number = Train_Route.Train_Number;

update reserves set total_cost='' where reservation_id='' and train_number ='';

update reservation set is_cancelled='1' where reservation_id='';

-- gets the departing time for every stop
select departure_time, departs_from, reserves.train_number from Stop natural join Station join Reserves where Station.location = Reserves.departs_from

