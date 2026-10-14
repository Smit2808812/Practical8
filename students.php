<?php
require_once "db.php";

$stmt = $pdo->prepare(
    "SELECT student_id, name, email, course
     FROM students
     ORDER BY student_id ASC"
);
$stmt->execute();
$students = $stmt->fetchAll();

$totalStudents = count($students);
$totalCourses = count(array_unique(array_column($students, "course")));

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>StudentHub | Dashboard</title>

<style>
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f4f5fb;
    color: #20213a;
}

.layout {
    display: flex;
    min-height: 100vh;
}

.sidebar {
    width: 235px;
    background: #17172e;
    color: white;
    padding: 30px 20px;
    flex-shrink: 0;
}

.logo {
    font-size: 25px;
    font-weight: bold;
    margin-bottom: 45px;
}

.logo span {
    color: #a78bfa;
}

.nav-label {
    color: #9696b5;
    font-size: 12px;
    margin-bottom: 18px;
    letter-spacing: 2px;
}

.nav-item {
    padding: 14px;
    margin: 8px 0;
    border-radius: 10px;
    color: #d6d5e8;
}

.nav-item.active {
    background: #6d55dc;
    color: white;
}

.main {
    flex: 1;
    min-width: 0;
    padding: 32px;
}

.topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 28px;
}

.topbar h1 {
    margin: 0;
    font-size: 28px;
}

.topbar p {
    color: #85869c;
    margin-bottom: 0;
}

.profile {
    background: white;
    padding: 12px 17px;
    border-radius: 12px;
    font-weight: bold;
}

.hero {
    background: linear-gradient(120deg, #6954dc, #9874ef);
    color: white;
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 25px;
}

.hero h2 {
    font-size: 27px;
    margin: 0 0 10px;
}

.hero p {
    margin: 0;
    line-height: 1.6;
    color: #eee8ff;
}

.stats {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 18px;
    margin-bottom: 28px;
}

.stat {
    background: white;
    padding: 23px;
    border-radius: 16px;
    box-shadow: 0 5px 20px #24244a08;
}

.stat-label {
    color: #88899e;
    font-size: 14px;
}

.stat h2 {
    margin: 13px 0 0;
    font-size: 29px;
}

.panel {
    background: white;
    border-radius: 18px;
    padding: 24px;
    box-shadow: 0 5px 20px #24244a08;
}

.panel-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
    margin-bottom: 22px;
}

.panel-head h2 {
    margin: 0;
}

.search {
    padding: 12px 15px;
    border: 1px solid #e2e2ed;
    border-radius: 10px;
    width: min(100%, 280px);
    outline-color: #8065e8;
}

.table-wrap {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
    white-space: nowrap;
}

th {
    background: #f7f6fc;
    color: #77788e;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: .7px;
}

th, td {
    padding: 17px 14px;
    border-bottom: 1px solid #eeeeF5;
}

tbody tr:hover {
    background: #faf9ff;
}

.avatar {
    display: inline-flex;
    width: 37px;
    height: 37px;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: #eee9ff;
    color: #674ad0;
    font-weight: bold;
    margin-right: 10px;
}

.course {
    background: #f0ecff;
    color: #674ad0;
    padding: 7px 10px;
    border-radius: 20px;
    font-size: 12px;
}

.empty {
    text-align: center;
    padding: 30px;
    color: #88899e;
}

.footer {
    margin-top: 25px;
    color: #9696a9;
    font-size: 13px;
    text-align: center;
}

@media (max-width: 850px) {
    .sidebar {
        width: 175px;
        padding: 25px 12px;
    }

    .main {
        padding: 22px;
    }

    .stats {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 560px) {
    .layout {
        display: block;
    }

    .sidebar {
        width: 100%;
        padding: 18px;
    }

    .logo {
        margin-bottom: 18px;
    }

    .nav-label {
        margin-bottom: 8px;
    }

    .main {
        padding: 16px;
    }

    .topbar h1 {
        font-size: 23px;
    }

    .hero {
        padding: 22px;
    }
}
</style>
</head>

<body>
<div class="layout">

    <aside class="sidebar">
        <div class="logo">Student<span>Hub.</span></div>
        <div class="nav-label">WORKSPACE</div>
        <div class="nav-item active">▦ &nbsp; Dashboard</div>
        <div class="nav-item">♙ &nbsp; Students</div>
        <div class="nav-item">▤ &nbsp; Courses</div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div>
                <h1>Dashboard</h1>
                <p>Student database overview</p>
            </div>
            <div class="profile">Admin Panel</div>
        </header>

        <section class="hero">
            <h2>Welcome to StudentHub 👋</h2>
            <p>Manage student records and explore your
               academic database in one place.</p>
        </section>

        <section class="stats">
            <div class="stat">
                <div class="stat-label">Total Students</div>
                <h2><?= $totalStudents ?></h2>
            </div>

            <div class="stat">
                <div class="stat-label">Available Courses</div>
                <h2><?= $totalCourses ?></h2>
            </div>

            <div class="stat">
                <div class="stat-label">Database Status</div>
                <h2 style="color:#16a085;font-size:22px">Connected</h2>
            </div>
        </section>

        <section class="panel">
            <div class="panel-head">
                <h2>Student Directory</h2>
                <input
                    type="search"
                    id="search"
                    class="search"
                    placeholder="Search students..."
                    aria-label="Search students"
                >
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student</th>
                            <th>Email Address</th>
                            <th>Course</th>
                        </tr>
                    </thead>

                    <tbody id="studentRows">
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td>#<?= e($student["student_id"]) ?></td>
                            <td>
                                <span class="avatar">
                                    <?= e(strtoupper(substr($student["name"], 0, 1))) ?>
                                </span>
                                <?= e($student["name"]) ?>
                            </td>
                            <td><?= e($student["email"]) ?></td>
                            <td>
                                <span class="course">
                                    <?= e($student["course"]) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <div id="emptyMessage" class="empty"
                    style="display:<?= $totalStudents ? 'none' : 'block' ?>">
                    No student records found.
                </div>
            </div>
        </section>

        <div class="footer">
            StudentHub · Web Development Frameworks · Practical 8
        </div>
    </main>
</div>

<script>
const search = document.getElementById("search");
const rows = [...document.querySelectorAll("#studentRows tr")];
const emptyMessage = document.getElementById("emptyMessage");

search.addEventListener("input", function () {
    const query = this.value.toLowerCase();
    let visible = 0;

    rows.forEach(row => {
        const matches = row.textContent.toLowerCase().includes(query);
        row.style.display = matches ? "" : "none";
        if (matches) visible++;
    });

    emptyMessage.style.display = visible ? "none" : "block";
});
</script>
</body>
</html>
