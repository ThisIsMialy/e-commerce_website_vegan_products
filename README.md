# e-commerce_website_vegan_products
## Description

This project is an e-commerce website for the purchase of vegan food products.
The front end, or rather the visual elements and designs of the website is created using a
variety of languages, including HTML, CSS, and JavaScript.

In order to give the clients the greatest experience possible, we have focused on factors such
as accessibility and efficiency.

Hence, specific libraries have been used to alter the layouts of each page to become
smoother and more well-rounded to users.

Moving on the technical aspect of the website, the functionalities of the latter require a
proper back-end connection to the front end so as to provide a reliable and quick responses
to the users.

The back-end part of the website will focus on the management of data for products, orders
and users, through interactions between main website and a non-relational database based
off MongoDB.

To further improve upon the back-end and front-end design of the project, AJAX
(Asynchronous JavaScript and XML) will used to improve the communication between each
page, providing live updates from the main website to the database without having the need
to refresh the page.

The back-end is intended on being as dynamic and responsive as the front end.

<img width="1362" height="914" alt="schema-2" src="https://github.com/user-attachments/assets/63307d96-f066-4b91-8e31-1a50a33c5a0a" />



## Features
### Main Website
The main website is where the customers can purchase items from.
It consists of 4 individual pages:

the homepage (home.html), the login/register page (login.html), the shopping cart page
(cart.html) and the profile page(profile.html)

All of the 4 pages consist of a navigation bar as the header to link other webpages and to view
one’s login username and a footer for social media links and contact email.

On the header, the user can view their username and when clicked they can either:
• change user, which will redirect to the login page
• view order, redirect to cart page
• log out, logs user out of a session

#### Homepage:
This is where the customers will start from and be able to browse through all available
products on the shop. This is directly loaded from the database via AJAX.
Moreover, it also has a search bar that allow users explore and look for any products they
want. The products are sectioned into different categories.

A logged user will also be able to find a recommendations section in the homepage. These
recommendations are based on the categories of items they bought in their last order. A new
user with no past orders will not see this yet.

In the Homepage, the user can search for items. The search input will only accept 3 or more
characters. These characters are used as regular expressions to find the best matches from
product names and categories name. Search results can be sorted in different ways:
Ascending / Descending Price or Name or divided into categories.

#### Login/Register:
The page starts with login option where user can log in if they have an account continue with
their purchase. All fields must be filled out. An error will appear if user is not registered.

To register, there is a button on the side that starts the registration form with several inputs
with placeholders inserted to capture the user personal information and validated to check
that all fields were filled. Validations are done in HTML and in JavaScript.

Every time a user is logged in; PHP session starts and stores their username to use for other
PHP functionalities.

#### Shopping Cart:
Separated into 2 sections to view the customer’s current basket and their past orders.
In the current basket section, customer can see the items they have added to an order and
they can choose to cancel or checkout the order. It also shows the total price of all items.
The past orders is a table viewing of the all orders made by the currently logged customer and
their totals. These are directly pulled from the database.
All items added to cart are directly stored into the HTML localStorage so the data persists in
all pages of the website. This data is cleared out when the user checks out their order or
decide to cancel their order.

Only logged user can proceed with the checkout of the order.

The past orders tab and button will only be visible to logged user.

#### Profile:
Only logged user can access this page. User can edit any information except their username. A
validation is set when passwords match and database is updated accordingly.

### Contents Management System (CMS) website
The content management system website is another platform that will allow an
administrative user/staff to view and manipulate the data records of the collections of
products and orders.

The layout of the CMS platform is made up of a vertical navigation bar that allow smooth
transition between each CMS features.
Its main functionalities are as follows:

#### Login:
- Allow admin users/staff access to the content management system platform
- Can swap out administrative accounts / users
#### View / Add / Edit Products:
- Allow admin users to have an overview of a list of all products.
- Option to add up new item to the database.
- Option to manipulate data of an existing product.
#### View / Delete Orders:
- Allow admin users to have a summary of all customer orders.
- To remove a specific order if needed.



### Security, Privacy and Legal issues
This is not a real website, only a prototype for one as part of university project so there are bound to be security issues

#### Security issues
• Lack of security protocols: The customer send their private data but the URL is not secured,
these sensitive information are susceptible to Man-in-the-middle attacks where hackers listen
to the communication between the website and user and access them. (E-commerce security
threats and their solutions 2022). Best way to secure it is to add a secure socket layer (SSL)
certificate. SSL encrypts data communication so hackers won’t decrypt easily, SSL also
provides authentication to filter out attackers with ill intentions. HTTPS is also required for a
secure website as well.

• Unhashed passwords: The customer’s passwords are not stored in their hashed version and
therefore can be used by attackers to pose as regular customers to attack the server such as
Denial of Service (DoS) Attack by flooding and crashing the website server. It is better to hash
stored passwords and encrypt data into the Cloud as certain service provide higher security.

• Database: Since the database is not secured by a passcode, it will be very easy for hackers to
do NoSQL query injections to get all data, completely erase everything or modify part of the
database. One way of adding security to this is to add a firewall for the backend to protect
against malicious requests. (Thompson, 2021) Another way to secure the database as well is
to upload it on the cloud.

#### Privacy issues
• Customer data: Information about the customer is stored in an unprotected database, these
are: full name, address, telephone number, date of birth, email address and password. These
data are not hashed and therefore can be seen by the employees by accessing the CMS. They
can also be stolen and misused by hackers.

• Cookies: There is no cookies information provided to the customer as they enter the website
and customers then don’t have any knowledge of what kind of data the website will store
before and after their session. Next time, a proper information popup for cookies should be
available on the website.

• Session: When a user opens a website, a localstorage opens for them to use as storage for the
basket, however, the localstorage will not automatically closes or clear when they leave so
there might be information that other people can easily access to. A server-side based storage
like PHP session are encrypted and will not show information about the user as well as being
cleared when the window closes.

#### Legal issues
• Employee misconduct: damage and theft of customer data from database. Some employees
may steal information for harmful reasons from the database.

• Upload: Customers will not be able to upload contents but employees with the right privileges
to the database can choose to upload harmful content to the website which can damage the
reputation of the website. It is important to reinforce the employee policies and train
employee properly before granting privileges to the CMS.

• Copyright: Most of the products and images are not owned by us in any way but will pose
legal problems if ever used in a real ecommerce setting. (EUROLOGO, 2016) In the future, we
can use royalty free contents and use contents created by the team on the website.

• Escalated Privacy issues: If there is any leakage of confidential customer information, the
website may face legal problems because of the privacy laws of a country. 

### References
Thompson, K. (2021) 12 essential ways to improve your website security, AT&T Cybersecurity. Available at:
https://cybersecurity.att.com/blogs/security-essentials/12-essential-ways-to-improve-your-websitesecurity (Accessed: February 21, 2023).

E-commerce security threats and their solutions (2022) Business Class: Trends and Insights | American
Express. Available at: https://www.americanexpress.com/en-ca/business/trends-andinsights/articles/ecommerce-security-threats-and-their-solutions/ (Accessed: February 20, 2023).

EUROLOGO (2016) Common legal issues faced by e-commerce businesses, Common Legal Issues Faced By
E-Commerce BusinessesEi. Available at: https://www.eurologo.org/common-legal-issues-faced-by-ecommerce-businesses/ (Accessed: February 20, 2023).
