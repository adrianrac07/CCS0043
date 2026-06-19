<!DOCTYPE html>
<html lang="en">

<head>
    <title>Activity 1</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,400italic,300italic,300,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <?php
    $firstname = "Adrian Rovic";
    $middlename = "A.";
    $lastname = "Corrales";
    $course = "Bachelor of Science in Information Technology with Specialization in Cybersecurity";
    $email = "adrianrovic07@gmail.com";
    $phonenum = "09123456789";
    $facebook = "facebook.com/adrianrovic";
    $linkedin = "linkedin.com/in/adrianrovic";
    ?>

    <div class="wrapper mt-lg-5">
        <div class="sidebar-wrapper">
            <div class="profile-container">
                <img class="profile" src="https://cdn.discordapp.com/attachments/885006358678741043/1371824440001691678/My_project.png?ex=69ff2691&is=69fdd511&hm=94963472ca375dd0ff4c2266597887199d5de153364f1da02fb548b0b836df27&" alt="Profile Image" />
                <h1 class="name"><?php echo "$firstname $middlename $lastname"; ?></h1>
                <h3 class="tagline"><?php echo $course; ?></h3>
            </div>

            <div class="contact-container container-block">
                <ul class="list-unstyled contact-list">
                    <li class="email">
                        <i class="fa-solid fa-envelope"></i>
                        <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                    </li>
                    <li class="phone">
                        <i class="fa-solid fa-phone"></i>
                        <a href="tel:<?php echo $phonenum; ?>"><?php echo $phonenum; ?></a>
                    </li>
                    <li class="facebook">
                        <i class="fa-brands fa-facebook"></i>
                        <a href="https://<?php echo $facebook; ?>" target="_blank"><?php echo $facebook; ?></a>
                    </li>
                    <li class="linkedin">
                        <i class="fa-brands fa-linkedin-in"></i>
                        <a href="https://<?php echo $linkedin; ?>" target="_blank"><?php echo $linkedin; ?></a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main-wrapper">
            <section class="section education-section">
                <h2 class="section-title">
                    <span class="icon-holder"><i class="fa-solid fa-graduation-cap"></i></span>Education
                </h2>
                <div class="education-container container-block">
                    <div class="item">
                        <h4 class="degree">Kindergarten</h4>
                        <h5 class="meta">Far Eastern Private School</h5>
                        <div class="time">2011 - 2013</div>
                    </div>
                    <div class="item">
                        <h4 class="degree">Elementary</h4>
                        <h5 class="meta">Far Eastern Private School</h5>
                        <div class="time">2013 - 2018</div>
                    </div>
                    <div class="item">
                        <h4 class="degree">Junior High School</h4>
                        <h5 class="meta">FEU Roosevelt Marikina</h5>
                        <div class="time">2018 - 2022</div>
                    </div>
                    <div class="item">
                        <h4 class="degree">Senior High School</h4>
                        <h5 class="meta">FEU Roosevelt Marikina</h5>
                        <div class="time">2022 - 2024</div>
                    </div>
                    <div class="item">
                        <h4 class="degree">College</h4>
                        <h5 class="meta">FEU Institute of Technology</h5>
                        <div class="time">2024 - Present</div>
                    </div>
                </div>
            </section>

            <section class="section summary-section">
                <h2 class="section-title">
                    <span class="icon-holder"><i class="fa-solid fa-user"></i></span>Career Profile
                </h2>
                <div class="summary">
                    <p>A passionate software developer with experience in building dynamic web applications. Proficient in various programming languages and frameworks, with a strong focus on delivering high-quality code and user experiences.</p>
                </div>
            </section>

            <section class="section experiences-section">
                <h2 class="section-title">
                    <span class="icon-holder"><i class="fa-solid fa-briefcase"></i></span>Experience
                </h2>

                <div class="item">
                    <div class="meta">
                        <div class="upper-row">
                            <h3 class="job-title">HTML/CSS Developer</h3>
                            <div class="time">2022 - Present</div>
                        </div>
                        <div class="company">FEU Institute of Technology</div>
                    </div>
                    <div class="details">
                        <p>I learned basic HTML when I was in high school. I have since developed my skills through various projects and coursework, including responsive design and accessibility.</p>
                    </div>
                </div>

                <div class="item">
                    <div class="meta">
                        <div class="upper-row">
                            <h3 class="job-title">Java Developer</h3>
                            <div class="time">2024 - Present</div>
                        </div>
                        <div class="company">FEU Institute of Technology</div>
                    </div>
                    <div class="details">
                        <p>I learned Java programming fundamentals and applied them in various projects.</p>
                    </div>
                </div>
            </section>

            <section class="skills-section section">
                <h2 class="section-title">
                    <span class="icon-holder"><i class="fa-solid fa-rocket"></i></span>Skills &amp; Proficiency
                </h2>
                <div class="skillset">
                    <div class="item">
                        <h3 class="level-title">Python</h3>
                        <div class="progress level-bar">
                            <div class="progress-bar theme-progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="item">
                        <h3 class="level-title">Javascript</h3>
                        <div class="progress level-bar">
                            <div class="progress-bar theme-progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="item">
                        <h3 class="level-title">HTML5 &amp; CSS</h3>
                        <div class="progress level-bar">
                            <div class="progress-bar theme-progress-bar" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="item">
                        <h3 class="level-title">C++</h3>
                        <div class="progress level-bar">
                            <div class="progress-bar theme-progress-bar" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="item">
                        <h3 class="level-title">Photoshop</h3>
                        <div class="progress level-bar">
                            <div class="progress-bar theme-progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>