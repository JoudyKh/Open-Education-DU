Open Education DU Platform 🎓🏛️

Open Education DU is a specialized Academic Management System (AMS) developed with the Laravel framework, specifically tailored for the Open Education department at Damascus University. The platform serves as a digital hub for students and faculty, streamlining the delivery of academic materials and administrative services.

✨ Key Features

Academic Content Delivery: A structured repository for lectures, course materials, and official university publications.

Student Information System (SIS): Dedicated student portals to track academic progress and manage personal university records.

Examination & Results Management: Tools for organizing exam schedules and facilitating the digital release of student grades.

Departmental Administration: An integrated backend for university staff to manage departments, majors, and curriculum updates.

Automated Announcements: Real-time news feed and notification system for critical university updates and deadlines.

Resource Search Engine: Advanced filtering to find academic files by year, semester, or specific major.

🛠 Technical Stack

Backend: Laravel 10.x

Database: MySQL

Frontend: Blade Templates, JavaScript, Tailwind CSS.

Architecture: Enterprise-level MVC (Model-View-Controller) structure.

Security: CSRF protection and role-based access control (RBAC) to separate student and administrative functions.

🚀 Installation & Setup

To run this project locally for development or testing:

Clone the Repository:

git clone [https://github.com/JoudyKh/Open-Education-DU.git](https://github.com/JoudyKh/Open-Education-DU.git)
cd Open-Education-DU


Install Dependencies:

composer install
npm install && npm run dev


Configuration:

Copy .env.example to .env.

Configure your local database and university-specific settings.

php artisan key:generate


Database Migration:

php artisan migrate --seed


Start Application:

php artisan serve


📂 Engineering Highlights

Scalable Database Design: Engineered to handle high traffic during results publication periods.

File Management: Efficient storage and retrieval logic for large academic PDF and media files.

User-Centric UI: Designed with a focus on accessibility for students with varying levels of technical proficiency.

👩‍💻 Developer

Joudy Alkhatib

GitHub: @JoudyKh

LinkedIn: Joudy Alkhatib

Email: joudyalkhatib38@gmail.com

Open Education DU - Modernizing the academic experience for Damascus University students.
