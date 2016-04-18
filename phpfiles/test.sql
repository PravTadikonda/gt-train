SELECT Second_Class_Price, First_Class_Price, Reserves.Train_Number, Departs_From, Arrives_At, Class, 
TRUNCATE(Total_Cost, 2) AS TC, Number_Baggages, Passanger_Name
FROM Reserves JOIN Reservation NATURAL JOIN Train_Route 
WHERE Reserves.Reservation_ID = Reservation.Reservation_ID AND Reserves.Reservation_ID = "54321" 
AND Reservation.Cust_User = "chhaya" AND Reserves.Train_Number = Train_Route.Train_Number