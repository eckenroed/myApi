# Smartmove API PHP Package

Hello Jeff, I have made this just for you. I have set up the folder structure to 
match the namespaces. This is one I am proud of because there are no existing PHP packages to consume this API, so I had to create both the PHP package as well as a way for my Models to interract with the API. 

 * __Gateway.php__ - This is the main gateway file. It's very abstract to just handle the communication using Guzzle.
 * __Landlord.php__ - This is for the endpoint /landlord. It extends the Gateway package and makes a method for each of the methods available on the endpoint. 
 * __Application.php__ - Similar to Landlord.php except for the /application end point.
 * __Renter.php__ - Accessor for the /renter end point
 * __SmartmoveProperty.php__ - Accessof for the /property end point


I then had to make a way for my models to translate data back to a way the API can use it. So I made a trait for each of the models to return the data in a way that the API can consume. 

* ApplicationHelper.php
* ApplicantHelper.php
* LandlordHelper.php
* PropertyHelper.php

Finally, the credit report is very complicated so I have two files I use to decode the JSON of a credit report. 

* __SmartmoveCodes.php__ - Contains objects that can translate the codes into usable english
* __CreditReport.php__ - The actual class that is loaded when the credit report is retreived from the model so as to be able to have a predictable API to pass to the view.