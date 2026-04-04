# tree-plantation-system

Tree plantation drives are frequently organized by schools, colleges, NGOs, and other
institutions; however, there is often no structured system to manage plantation events,
track volunteer participation, monitor tree growth and survival, and maintain mainte-
nance records effectively. The proposed Tree Plantation and Monitoring System is a
database-based application designed to digitally manage plantation activities by storing
location and event details, recording volunteer information, maintaining individual tree
records, tracking growth measurements, and logging survival status changes. The sys-
tem ensures structured data management and accountability through relational database
concepts such as primary keys, foreign keys, constraints, normalization, and triggers for
automated monitoring. A user-friendly frontend interface enables efficient data entry
and data retrieval, while the backend is implemented using MySQL to ensure secure data
storage, relational integrity, and efficient database management. This system supports
organized environmental monitoring and promotes transparent and systematic plantation
management.


The frontend provides a structured, interactive interface using HTML, CSS, Bootstrap,
and Font Awesome. Users can log in, manage events, add trees, record growth and
maintenance activities, and view dashboards. Different roles such as Admin, Coordinator,
and Volunteer are provided with customized interfaces and functionality.
The backend, implemented using PHP, processes user requests, validates input data, and
performs CRUD operations in the MySQL database. It also handles user authentication,
session management, and role-based access control.
The MySQL database stores all project data in structured tables, maintaining relation-
ships through primary and foreign keys. Queries are executed via PHP scripts using
‘mysql’ functions to ensure secure and efficient data operations.
When a user performs an action, such as adding a tree or updating growth records, the
data is sent to the backend, processed, stored in the database, and then retrieved to
update the frontend dynamically. Dashboards and tables display real-time information
such as total trees, alive/dead counts, events, and volunteer participation.
Overall, the implementation ensures efficient data management, role-based security, seam-
less interaction between frontend and backend, and a user-friendly platform for managing
and monitoring tree plantation activities effectively.
