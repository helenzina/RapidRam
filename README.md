<div align="center">
<h3 align="center">RapidRam</h3>
<p align="center">
RAM E-shop
<br/>
<br/>
<a href="https://github.com/helenzina/RapidRam"><strong>Explore the docs</strong></a>
</p>
</div>

 ### Built With

This project was built with the following:
- <a href="https://www.w3schools.com/html/">HTML</a>.
- <a href="https://www.w3schools.com/css/">CSS</a>. 
- <a href="https://getbootstrap.com/docs/5.3/getting-started/introduction/">Bootstrap (Version 5.3.2)</a>.
- <a href="https://www.w3schools.com/js/">JavaScript</a> for client-interactive web pages. 
- <a href="https://www.w3schools.com/php/">PHP</a> for server-side applications.
- <a href="https://www.apachefriends.org/download.html">XAMPP</a> for the web server. 
- <a href="https://code.visualstudio.com/">VS Code</a> for the IDE.

 ## About The Project
 
<p align="center">
<img src="https://github.com/helenzina/RapidRam/blob/main/images/index.jpg"  title="index"/>
</p>

RapidRam is an e-shop that allows users to purchase different types of RAM and in large quantities, if they like. The purpose of this project was for practising CRUD operations in PHP through an administration panel.



## Getting Started
 
 ### Installation
 
<p>Please follow the following steps for successful installation:</p>

1. Install <a href="https://www.apachefriends.org/download.html">XAMPP</a> to gain access to the database **ram_db**.
2. Navigate to the following path, the **htdocs** folder of XAMPP.
   ```sh
   C:\xampp\htdocs
   ```
   
3. **Clone the repo**.
   ```sh
   git clone https://github.com/helenzina/RapidRam
   ```

4. **Connect as a localhost by typing the following command in the URL section of your browser**:
    ```sh
   http://localhost/phpmyadmin/
    ```

5. **Create a NEW database and rename it as ram_db. It has to be the same**.
  
6. **Press the navbar toggle of the database and press Import**.

7. **Select the ram_db database from your folder and press Import**.

 ## Features
### Users can
- View information about different RAM modules from different vendors, including capacity, channel, and speed.
- Purchase RAM through deals or through the products page by adding items in their cart.
- Navigate through products using pagination.
- Change the quantity of the added RAM in cart or remove it.
- Apply filters to search RAM modules based on either capacity, channel, speed or price range.
- Place their order by submitting their credentials.
- Display the added products before submitting their order, as well as the total cost.
- Cancel their order and modify the added products.

### Security & more:
- Responsive web design.
- Validation for credentials in the order checkout.
- Applying filters and adding to cart using AJAX while communicating with the Apache server.
- **Administration panel**:
  - Login using admin credentials.
  - View the dashboard (business sales), products panel and orders panel.
  - In the products panel, information can be displayed for each available product in the website either through search or navigation.
  - Add, edit or delete a product in the products panel (CRUD operations).
  - In the orders panel, orders can be displayed including their information and status.

## How To Run

To run the RapidRam app, follow these steps:

1. **Open XAMPP and start Apache and MySQL services**.

2. **Open the website**.
    ```sh
   http://localhost/RapidRam/main/
    ```
3. **Purchase anything you like considering deals (-20%) in the index page or if you are looking for something specific, try applying filters in the products page till you find it.**

4. **Optional: If you want to try the administration panel, use the following credentials for simplicity:** <br>
   **Username**
    ```sh
    admin
    ```
   **Password**
    ```sh
    1234
    ```


 ## Usage
 
Here are some screenshots of the web application running showing the features mentioned:

<table>
  <tr>
    <td>
    Index page
     <img src="https://github.com/helenzina/RapidRam/blob/main/images/index.jpg" title="index"/>
    </td>
    <td>
    Products page (1)
     <img src="https://github.com/helenzina/RapidRam/blob/main/images/products_1.jpg" title="products_1"/>
    </td>
    <td>
    Products page (2)
     <img src="https://github.com/helenzina/RapidRam/blob/main/images/products_2.jpg" title="products_2"/>
    </td>
  </tr>
  <tr>
    <td>
    Filters
     <img src="https://github.com/helenzina/RapidRam/blob/main/images/filters.jpg" title="filters"/>
    </td>
    <td>
    Shopping cart
     <img src="https://github.com/helenzina/RapidRam/blob/main/images/shopping_cart.jpg" title="shopping_cart"/>
    </td>
    <td>
    Order checkout
     <img src="https://github.com/helenzina/RapidRam/blob/main/images/order_checkout.jpg" title="order_checkout"/>
    </td>
    <td>
    Validation example
     <img src="https://github.com/helenzina/RapidRam/blob/main/images/validation_example.jpg" title="validation_example"/>
    </td>   
    <td>
    Order confirmation
     <img src="https://github.com/helenzina/RapidRam/blob/main/images/order_confirmation.jpg" title="order_confirmation"/>
    </td>      
  </tr>
  <tr>
    <td>
    Admin panel
     <img src="https://github.com/helenzina/RapidRam/blob/main/images/admin_panel.jpg" title="admin_panel"/>
    </td>
    <td>
    Dashboard
     <img src="https://github.com/helenzina/RapidRam/blob/main/images/dashboard.jpg" title="dashboard"/>
    </td>
    <td>
    Products panel
     <img src="https://github.com/helenzina/RapidRam/blob/main/images/products_panel.jpg" title="products_panel"/>
    </td>
    <td>
    Products panel - Add product
     <img src="https://github.com/helenzina/RapidRam/blob/main/images/add_product.jpg" title="add_product"/>
    </td>   
    <td>
    Products panel - Edit product
     <img src="https://github.com/helenzina/RapidRam/blob/main/images/edit_product.jpg" title="edit_product"/>
    </td>      
    <td>
    Products panel - Delete product
     <img src="https://github.com/helenzina/RapidRam/blob/main/images/delete_product.jpg" title="delete_product"/>
    </td>      
    <td>
    Orders panel
     <img src="https://github.com/helenzina/RapidRam/blob/main/images/orders_panel.jpg" title="orders_panel"/>
    </td>      
  </tr> 
</table>

For a closer look, click on the images and open them from the **images** folder.

 
## Collaborators

<p>This project was developed individually for the "Web Programming Applications" course at International Hellenic University.</p>
<table>
<tr>

<td align="center">
<a href="https://github.com/helenzina">
<img src="https://avatars.githubusercontent.com/u/128386591?v=4" width=100 alt="Helen Zina"/><br>
<sub>
<b>Helen Zina (Me)</b>
</sub>
</a>
</td>

</tr>
</table>

 ## License

Distributed under the MIT License. See the LICENSE file for more information.

 ## Contact
 
If you have any questions or suggestions, feel free to reach out to me:
- Helen Zina - helenz1@windowslive.com
- Project Link: https://github.com/helenzina/RapidRam

 ## Acknowledgments

The resources that helped me through this whole process were from the technologies websites I used.
