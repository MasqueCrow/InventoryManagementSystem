<h1>FYP Inventory Management System </h1>

<h2>Description</h2>
<p>This is a small scale web-based inventory system that we have built to suit the needs of our client, Lian Fuat Motor Work, in their stock take of inventory, manage of purchase order and creation of sales  </p>

<h2>Configuration</h2>
<ul>
<li>1.Download and install Easyphp Dev Server 14.1 VC11</li>
2.Import the database file 'final_inventory_management_system.sql' into phpMyAdmin after creating a new database
3.Import the source codes into the Easyphp project folder
4.Configure the phpMyAdmin authentication information
Set username to be 'InvUser01',password 'inventory123' and global priviledges
to 'SELECT,INSERT,UPDATE,DELETE' under Users column in phpMyAdmin
</ul>
Login account:
Username:admin
Password:admin


My contribution of files in this FYP includes the following:

Under Admin Information folder
-Able to create user account with form validation on both client and server side

Admin Information folder 
DisplayUserInfo.php
Serversidevalidation.php
RetrieveUserInfo.php
UpdateUserInfo.php

Under Sales folder
-Store customer information  with form validation on both client and server side under CreateCustomer.php
-Implemented textfield with dropdown combo box under deliverPage.php
-Create Quotation with built-in features:
1) Delete rows ( based on rows that are ticked)
2) Add rows
3) Precalculate line total on individual rows and total in all rows
4) Reset fields
5) Check stock level of order part qty with inventory part qty
6) Validate empty fields
under salesJobsheet.php 


Sales folder (Create customer with form validation and Quotation page
CreateCustomer.php
registerCustomer.php
deliverPage.php
ajaxSearchPlateNo.php
AjaxCarInformation.php
salesJobSheetStyleSheet.css
ajaxServicePart.php
InsertQuotation.php
InsertQuotationItem.php
DecreasePartQuantity.php
GetQuotationNumber.php
salesJobsheet.php 

Under ReportPage folder
-Able to filter vehicle parts based on user selection of dropdown menus.
i.e more dropdown menus selected, less parts shown 
.Helpful to our client as it has at least hundred types of parts
- Display bar graph of part quantity and reorder point
-Built in datatable for ordering of parts from supplier
-Modal dialog box for submitting purchase order
Under reportStockLevel.php 

ReportPage folder
reportStockLevel.php
reportStockStyleSheet.css
RetrievePartSupplierCategoryInfo.php
RetrieveMake.php
RetrieveModel.php
RetrievePartName.php
SupplierInfo.php
InsertPurchaseOrder.php
RetrievePurchaseOrderNo.php
insertPoItem.php

 
