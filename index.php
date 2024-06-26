<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SETRAM - Home</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #174282;
            color: #fff;
            text-align: center;
            padding: 0 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: background-color 0.3s ease-in-out;
        }

        #logo {
            max-width: 100%;
            height: auto;
        }

        main {
            padding: 20px;
        }

        main h2 {
            color: #174282;
            font-size: 30px;
        }

        main p {
            color: #444;
            font-size: 20px;
        }

        .services {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .service {
            flex: 1;
            background-color: #d4fffd;
            padding: 20px;
            margin: 0 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out;
        }

        .service:hover {
            transform: scale(1.05);
        }

        footer {
            background-color: #174282;
            color: #fff;
            text-align: center;
            padding: 1em 0;
        }

        footer p {
            color: #fff;
            margin: 5px;
        }

        footer a {
            color: #d4fffd;
            text-decoration: none;
        }

        .login-link {
            font-size: 28px;
            color: #d4fffd;
            text-decoration: none;
            padding: 8px 12px;
            margin-right: 10px;
            transition: color 0.1s ease-in-out;
        }

        .login-link:hover {
            color: #05b4ac; 
            text-decoration: underline;
        }


        .signup-button {
            color: #174282;
            font-size: 28px;
            background-color: #d4fffd; 
            border: none;
            padding: 15px 30px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.1s ease-in-out, transform 0.1s ease-in-out;
        }

        .signup-button:hover {
            background-color: #05b4ac; 
            transform: scale(1.05);
        }

        #first , #third {
            padding: 0% 2%;
        }

        td * {
            margin: 1%;
        }

        img {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out;
        }

        img.main:hover {
            transform: scale(1.01);
        }

    </style>
</head>


<body>
    <header>
        <table style="width: 100%;">
            <tr>
                <td id="first" style="width: 20%; text-align: left;">
                    <a href="#" style="text-decoration: none; vertical-align: middle;"><h1 style="color: #05b4ac;">SETRAM</h1>
                    <h4 style="color: #d4fffd; transition: opacity 0.5s ease-in-out;">Acteur de modality</h4></a>
                </td>
                <td id="second" style="width: 60%; text-align: center;">
                    <h1 style="font-size: 38px;">Welcome to SETRAM</h1>
                    <h2>Serving Algeria's Transportation Needs</h2>
                </td>
                <td id="third" style="width: 20%; text-align: right;">
                    <a href="login.php" class="login-link">Login</a>
                    <button onclick="window.location.href='register.php'" class="signup-button">Sign Up</button>
                </td>
            </tr>
        </table>
    </header>

    <main style="padding-top: 10%;">
        <section class="about" style="display: inline-flex;">
            <table>
            <td class="text" style="width: 40%; vertical-align: top; padding: 1% 0;">
                <h2 style="margin-bottom: 20px;">About SETRAM</h2>
                <p>SETRAM (Société d'Exploitation des Transports Automobiles) is a leading transportation organization dedicated to providing efficient and reliable transportation solutions in Algeria. With a commitment to excellence and sustainability, SETRAM has been a cornerstone in connecting communities, businesses, and individuals across the country.</p>
            </td><td style="width: 60%;">
                <img class="main" src="pictures/slogan.jpg" width="100%">
            </td></table>
        </section>

        <section class="services">
            <div class="service">
                    <h2>Public Transportation</h2>
                    <p>Our extensive network of buses and tramways ensures seamless connectivity across major cities, making daily commutes convenient and eco-friendly.</p>
                    <img src="pictures/bus.jpg" width="100%">
            </div>

            <div class="service">
                <h2>Cargo Transport</h2>
                <p>SETRAM offers reliable cargo transport services, facilitating the movement of goods and supporting economic growth.<br><br></p>
                <img src="pictures/metro.jpg" width="100%">
            </div>

            <div class="service">
                <h2>Charter Services</h2>
                <p>Whether for corporate events, school trips, or special occasions, our charter services provide safe and comfortable transportation solutions tailored to your needs.</p>
                <img src="pictures/tram.jpg" width="100%">
            </div>
        </section>

        <section>
            <div class="text">
                <h2>Commitment to Sustainability</h2>
                <p>At SETRAM, we understand the importance of sustainable practices. Our fleet is constantly upgraded to meet the latest environmental standards, reducing our carbon footprint and contributing to a greener Algeria.</p>
            </div>
        </section>

        <section>
            <h2>Latest News and Updates</h2>
            <p>Stay informed about SETRAM's latest developments, route expansions, and community initiatives through our news section. We believe in transparency and keeping our passengers and stakeholders updated.</p>
        </section>

        <section>
            <h2>Join Our Team</h2>
            <p>SETRAM is always looking for talented and passionate individuals to join our team. Explore career opportunities with us and be part of an organization that is driving positive change in Algerian transportation.</p>
        </section>
    </main>

    <footer>
        <p>all rights reserved © 2023 Zakaria, inc</p>
        <p><a href="mailto:bouzara.zakaria.25@gmail.com">Contact Us!</a>
        | Follow us on social media:
        <a href="https://github.com/domenez25" target="_blank">Github</a></p>
    </footer>
    

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var header = document.querySelector("header");

            window.addEventListener("scroll", function () {
                var scrollPercentage = (window.scrollY / window.innerHeight) * 100;

                // Adjust the threshold as needed
                if (scrollPercentage >= 10) {
                    header.style.backgroundColor = "#174282ca";
                    header.style.backdropFilter = "blur(5px)"; 
                } else {
                    header.style.backgroundColor = "";
                    header.style.backdropFilter = "none"; 
                }
            });
        });
    </script>
</body>
</html>
